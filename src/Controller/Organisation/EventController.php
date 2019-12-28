<?php

/*
 * This file is part of the vseth-semesterly-reports project.
 *
 * (c) Florian Moser <git@famoser.ch>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller\Organisation;

use App\Controller\Administration\Base\BaseController;
use App\Entity\Event;
use App\Entity\Organisation;
use App\Form\Type\SemesterType;
use App\Model\Breadcrumb;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @Route("/event")
 */
class EventController extends BaseController
{
    /**
     * @var Organisation
     */
    private $organisation;

    /**
     * @Route("/new", name="organisation_event_new")
     *
     * @return Response
     */
    public function newAction(Organisation $organisation, Request $request, TranslatorInterface $translator)
    {
        //create the event
        $event = new Event();
        $event->setSemester(SemesterType::getCurrentSemester());
        $event->setOrganisation($organisation);

        //process form
        $myForm = $this->handleCreateForm(
            $request,
            $event,
            function () use ($event, $translator) {
                return $this->validateEvent($event, $translator);
            }
        );
        if ($myForm instanceof Response) {
            return $myForm;
        }

        $this->organisation = $organisation;
        return $this->render('administration/organisation/new.html.twig', ['form' => $myForm->createView()]);
    }

    /**
     * @Route("/{event}/edit", name="organisation_event_edit")
     *
     * @return Response
     */
    public function editAction(Organisation $organisation, Request $request, Event $event, TranslatorInterface $translator)
    {
        //process form
        $myForm = $this->handleUpdateForm(
            $request,
            $event,
            function () use ($event, $translator) {
                return $this->validateEvent($event, $translator);
            }
        );

        if ($myForm instanceof Response) {
            return $myForm;
        }

        $this->organisation = $organisation;
        return $this->render('administration/organisation/edit.html.twig', ['form' => $myForm->createView(), 'event' => $event]);
    }

    /**     *
     * @Route("/{event}/remove", name="organisation_event_remove")
     *
     * @return Response
     */
    public function removeAction(Organisation $organisation, Request $request, Event $event)
    {
        //process form
        $form = $this->handleDeleteForm($request, $event);
        if ($form === null) {
            return $this->redirectToRoute('organisation_events');
        }

        $this->organisation = $organisation;
        return $this->render('administration/organisation/remove.html.twig', ['form' => $form->createView(), 'event' => $event]);
    }

    private function validateEvent(Event $event, TranslatorInterface $translator): bool
    {
        if (strlen($event->getNameDe()) === 0 && strlen($event->getNameEn()) === 0) {
            $this->displayError($translator->trans("new.error.no_name", [], "organisation_event"));
            return false;
        }

        return true;
    }

    /**
     * get the breadcrumbs leading to this controller.
     *
     * @return Breadcrumb[]
     */
    protected function getIndexBreadcrumbs()
    {
        // TODO: fix routes
        // test in frontend
        return array_merge(parent::getIndexBreadcrumbs(), [
            new Breadcrumb(
                $this->generateUrl('organisation_view', ["organisation" => $this->organisation->getId()]),
                $this->getTranslator()->trans('view.title', [], 'organisation')
            ),
        ]);
    }
}
