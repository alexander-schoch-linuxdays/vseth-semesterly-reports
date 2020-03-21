<?php

/*
 * This file is part of the vseth-semesterly-reports project.
 *
 * (c) Florian Moser <git@famoser.ch>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller;

use App\Controller\Administration\Base\BaseController;
use App\Entity\Reminder;
use App\Form\Reminder\ReminderType;
use App\Form\Type\SemesterType;
use App\Service\Interfaces\EmailServiceInterface;
use App\Service\Interfaces\EvaluationServiceInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @Route("/administration")
 */
class AdministrationController extends BaseController
{
    /**
     * @Route("", name="administration")
     *
     * @return Response
     */
    public function indexAction(EvaluationServiceInterface $evaluationService)
    {
        $semesterEvaluation = $evaluationService->getActiveSemesterEvaluation();
        $currentSemester = SemesterType::getCurrentSemester();

        return $this->render('administration.html.twig', ['semesterEvaluation' => $semesterEvaluation, 'currentSemester' => $currentSemester]);
    }

    /**
     * @Route("/send_reminder", name="administration_send_reminder")
     *
     * @return Response
     */
    public function sendReminder(Request $request, EmailServiceInterface $emailService, TranslatorInterface $translator, EvaluationServiceInterface $evaluationService)
    {
        $reminderEMail = $this->getOrCreateReminder($translator);

        $myOnSuccessCallable = function ($form) use ($reminderEMail, $emailService, $translator, $evaluationService, &$saved) {
            $this->fastSave($reminderEMail);

            if (mb_strpos($reminderEMail->getBody(), '(url)') === false) {
                $error = $this->getTranslator()->trans('send_reminder.error.no_url_placeholder', [], 'administration');
                $this->displayError($error);

                return $form;
            }

            if (mb_strpos($reminderEMail->getBody(), '(name)') === false) {
                $error = $this->getTranslator()->trans('send_reminder.error.no_name_placeholder', [], 'administration');
                $this->displayError($error);

                return $form;
            }

            $missingOrganisations = $evaluationService->getActiveSemesterEvaluation()->getMissingOrganisations();
            foreach ($missingOrganisations as $organisation) {
                $url = $this->generateUrl('login_code', ['code' => $organisation->getAuthenticationCode()], UrlGeneratorInterface::ABSOLUTE_URL);
                $body = str_replace('(url)', $url, $reminderEMail->getBody());
                $body = str_replace('(name)', $organisation->getName(), $body);

                $emailService->sendEmail($organisation->getEmail(), $reminderEMail->getSubject(), $body);
            }

            $success = $translator->trans('send_reminder.success.sent', ['%count%' => \count($missingOrganisations)], 'administration');
            $this->displaySuccess($success);

            return $this->redirectToRoute('administration');
        };

        $buttonLabel = $translator->trans('send_reminder.send', [], 'administration');
        $myForm = $this->handleForm(
            $this->createForm(ReminderType::class, $reminderEMail)
                ->add('submit', SubmitType::class, ['label' => $buttonLabel, 'translation_domain' => false]),
            $request,
            $myOnSuccessCallable
        );

        if ($myForm instanceof Response) {
            return $myForm;
        }

        return $this->render('administration/send_reminder.html.twig', ['form' => $myForm->createView()]);
    }

    public function getOrCreateReminder(TranslatorInterface $translator): Reminder
    {
        /** @var Reminder|null $reminderEMail */
        $reminderEMail = $this->getDoctrine()->getRepository(Reminder::class)->findOneBy([]);
        if ($reminderEMail !== null) {
            return $reminderEMail;
        }

        $reminderEMail = new Reminder();

        $subject = $translator->trans('send_reminder.default.subject', [], 'administration');
        $reminderEMail->setSubject($subject);

        $body = $translator->trans('send_reminder.default.body', [], 'administration');
        $reminderEMail->setBody($body);

        $this->fastSave($reminderEMail);

        return $reminderEMail;
    }
}
