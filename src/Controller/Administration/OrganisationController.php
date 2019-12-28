<?php

/*
 * This file is part of the feedback project.
 *
 * (c) Florian Moser <git@famoser.ch>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller\Administration;

use App\Controller\Administration\Base\BaseController;
use App\Entity\Organisation;
use App\Form\Type\SemesterType;
use App\Model\Breadcrumb;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/organisation")
 */
class OrganisationController extends BaseController
{
    /**
     * @Route("", name="administration_organisations")
     *
     * @return Response
     */
    public function indexAction()
    {
        //get all existing semesters
        /** @var Organisation[] $organisations */
        $organisations = $this->getDoctrine()->getRepository(Organisation::class)->findBy([], ['name' => 'DESC']);

        return $this->render('administration/organisations.html.twig', ['organisations' => $organisations]);
    }

    /**
     * @Route("/new", name="administration_organisation_new")
     *
     * @return Response
     */
    public function newAction(Request $request)
    {
        //create the event
        $event = new Organisation();
        $event->setName('');
        $event->setEmail('');
        $event->setRelationSinceSemester(SemesterType::getCurrentSemester());

        //process form
        $myForm = $this->handleCreateForm(
            $request,
            $event
        );
        if ($myForm instanceof Response) {
            return $myForm;
        }

        return $this->render('administration/organisation/new.html.twig', ['form' => $myForm->createView()]);
    }

    /**
     * @Route("/{event}/edit", name="administration_organisation_edit")
     *
     * @return Response
     */
    public function editAction(Request $request, Organisation $organisation)
    {
        //process form
        $myForm = $this->handleUpdateForm($request, $organisation);
        if ($myForm instanceof Response) {
            return $myForm;
        }

        return $this->render('administration/organisation/edit.html.twig', ['form' => $myForm->createView(), 'organisation' => $organisation]);
    }

    /**     *
     * @Route("/{event}/remove", name="administration_organisation_remove")
     *
     * @return Response
     */
    public function removeAction(Request $request, Organisation $organisation)
    {
        //process form
        $form = $this->handleDeleteForm($request, $organisation);
        if ($form === null) {
            return $this->redirectToRoute('administration_organisations');
        }

        return $this->render('administration/organisation/remove.html.twig', ['form' => $form->createView(), 'organisation' => $organisation]);
    }

    /**
     * get the breadcrumbs leading to this controller.
     *
     * @return Breadcrumb[]
     */
    protected function getIndexBreadcrumbs()
    {
        return array_merge(parent::getIndexBreadcrumbs(), [
            new Breadcrumb(
                $this->generateUrl('administration_organisations'),
                $this->getTranslator()->trans('index.title', [], 'administration_organisation')
            ),
        ]);
    }
}
