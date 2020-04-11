<?php

/*
 * This file is part of the vseth-semesterly-reports project.
 *
 * (c) Florian Moser <git@famoser.ch>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Service;

use App\Entity\Event;
use App\Entity\Organisation;
use App\Entity\SemesterReport;
use App\Form\Type\SemesterType;
use App\Model\SemesterEvaluation;
use App\Model\SemesterEvaluation\OrganisationEvaluation;
use App\Service\Interfaces\EvaluationServiceInterface;
use Doctrine\Persistence\ManagerRegistry;

class EvaluationService implements EvaluationServiceInterface
{
    /**
     * @var ManagerRegistry
     */
    private $doctrine;

    /**
     * EvaluationService constructor.
     */
    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * {@inheritdoc}
     */
    public function getActiveSemesterEvaluation()
    {
        $organisationEvaluations = $this->getOrganisationEvaluationsForSemester(SemesterType::getCurrentSemester());

        /** @var Organisation[] $organisations */
        $organisations = $this->doctrine->getRepository(Organisation::class)->findActive();
        $orderedEvaluations = [];
        $missingOrganisations = [];
        foreach ($organisations as $organisation) {
            if (!isset($organisationEvaluations[$organisation->getId()])) {
                $missingOrganisations[] = $organisation;
            } else {
                $orderedEvaluations[] = $organisationEvaluations[$organisation->getId()];
            }
        }

        return new SemesterEvaluation($orderedEvaluations, $missingOrganisations);
    }

    /**
     * {@inheritdoc}
     */
    public function getSemesterEvaluation(int $semester)
    {
        $organisationEvaluations = $this->getOrganisationEvaluationsForSemester($semester);

        return new SemesterEvaluation($organisationEvaluations, []);
    }

    private function getOrganisationEvaluationsForSemester(int $semester)
    {
        $events = $this->doctrine->getRepository(Event::class)->findBy(['semester' => $semester]);
        $eventsByOrganisation = [];
        foreach ($events as $event) {
            $id = $event->getOrganisation()->getId();
            if (!isset($eventsByOrganisation[$id])) {
                $eventsByOrganisation[$id] = [];
            }

            $eventsByOrganisation[$id][] = $event;
        }

        /** @var SemesterReport[] $semesterReports */
        $semesterReports = $this->doctrine->getRepository(SemesterReport::class)->findBy(['semester' => $semester]);
        $organisationEvaluations = [];
        foreach ($semesterReports as $semesterReport) {
            $organisationId = $semesterReport->getOrganisation()->getId();
            $events = isset($eventsByOrganisation[$organisationId]) ? $eventsByOrganisation[$organisationId] : [];
            $organisationEvaluation = new OrganisationEvaluation($semesterReport->getOrganisation(), $semesterReport, $events);
            $organisationEvaluations[$organisationId] = $organisationEvaluation;
        }

        return $organisationEvaluations;
    }
}
