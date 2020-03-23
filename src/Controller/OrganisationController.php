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
use App\Entity\Organisation;
use App\Entity\SemesterReport;
use App\Form\Type\SemesterType;
use App\Security\Voter\Base\BaseVoter;
use App\Service\Interfaces\EmailServiceInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @Route("/organisation")
 */
class OrganisationController extends BaseController
{
    /**
     * @Route("/{organisation}", name="organisation_view")
     *
     * @return Response
     */
    public function viewAction(Request $request, Organisation $organisation, EmailServiceInterface $emailService, TranslatorInterface $translator)
    {
        $this->ensureAccessGranted($organisation);

        // remember last visit
        if (\in_array('ROLE_ORGANISATION', $this->getUser()->getRoles(), true)) {
            $organisation->setVisitOccurred();
            $this->fastSave($organisation);
        }

        $output = [];

        $hasSemesterReport = $this->getDoctrine()->getRepository(SemesterReport::class)->findOneBy(['organisation' => $organisation->getId(), 'semester' => SemesterType::getCurrentSemester()]);
        if (!$hasSemesterReport) {
            //allow semester creation
            $semester = new SemesterReport();
            $semester->setSubmittedDateTime(new \DateTime());
            $semester->setOrganisation($organisation);
            $semester->setSemester(SemesterType::getCurrentSemester());
            $hasSaved = false;
            $form = $this->handleCreateForm($request, $semester, function () use (&$hasSaved) {
                $hasSaved = true;

                return true;
            });

            if (!$hasSaved) {
                $output['submit_semester_report'] = $form->createView();
            } else {
                $subject = $translator->trans('report_submitted_email.subject', ['%organisation%' => $organisation->getName()], 'organisation');
                $body = $translator->trans(
                    'report_submitted_email.body',
                    [
                        '%event_count%' => $organisation->getEvents()->count(),
                        '%report_comment%' => $semester->getComments(),
                        '%report_political_events_description%' => $semester->getPoliticalEventsDescription(),
                        '%organisation_email%' => $organisation->getEmail(),
                        '%organisation_comment%' => $organisation->getComments(),
                        '%link%' => $this->generateUrl('administration', [], UrlGeneratorInterface::ABSOLUTE_URL),
                    ],
                    'organisation'
                );

                $emailService->sendEmailToAdministrator($subject, $body);
            }
        }

        $output['organisation'] = $organisation;

        return $this->render('organisation/view.html.twig', $output);
    }

    private function ensureAccessGranted(Organisation $organisation)
    {
        $this->denyAccessUnlessGranted(BaseVoter::VIEW, $organisation);
    }
}
