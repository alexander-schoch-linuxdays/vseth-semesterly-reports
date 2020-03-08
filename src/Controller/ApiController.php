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

use App\Controller\Base\BaseApiController;
use App\Entity\Organisation;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api")
 */
class ApiController extends BaseApiController
{
    /**
     * @Route("/organisations", name="api_organisations")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function organisationsAction()
    {
        /** @var Organisation[] $organisations */
        $organisations = $this->getDoctrine()->getRepository(Organisation::class)->findActive();

        return $this->returnOrganisations($organisations);
    }
}
