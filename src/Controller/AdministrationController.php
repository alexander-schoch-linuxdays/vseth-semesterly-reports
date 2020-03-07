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
use App\Service\Interfaces\CsvServiceInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

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
    public function indexAction()
    {
        //get all existing semesters
        /** @var Organisation[] $organisations */
        $organisations = $this->getDoctrine()->getRepository(Organisation::class)->findActive();

        return $this->render('administration.html.twig', ['organisations' => $organisations]);
    }

    /**
     * @Route("/export_authentication_links", name="administration_export_authentication_links")
     *
     * @return Response
     */
    public function exportAuthenticationLinksAction(CsvServiceInterface $csvService)
    {
        //get all existing semesters
        /** @var Organisation[] $organisations */
        $organisations = $this->getDoctrine()->getRepository(Organisation::class)->findActive();

        $organisationArray = [];
        foreach ($organisations as $organisation) {
            $entry = [];
            $entry[] = $organisation->getName();
            $entry[] = $organisation->getEmail();
            $entry[] = $this->generateUrl('login_code', ['code' => $organisation->getAuthenticationCode()], UrlGeneratorInterface::ABSOLUTE_URL);

            $organisationArray[] = $entry;
        }

        return $csvService->streamCsv('authentication_links.csv', $organisationArray);
    }
}
