<?php

/*
 * This file is part of the vseth-semesterly-reports project.
 *
 * (c) Florian Moser <git@famoser.ch>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Model\SemesterEvaluation;

use App\Entity\Event;
use App\Entity\Organisation;
use App\Entity\SemesterReport;

class OrganisationEvaluation
{
    /**
     * @var Organisation
     */
    private $organisation;

    /**
     * @var SemesterReport
     */
    private $semesterReport;

    /**
     * @var Event[]
     */
    private $events;

    /**
     * OrganisationEvaluation constructor.
     *
     * @param Event[] $events
     */
    public function __construct(Organisation $organisation, SemesterReport $semesterReport, array $events)
    {
        $this->organisation = $organisation;
        $this->semesterReport = $semesterReport;
        $this->events = $events;
    }

    public function getOrganisation(): Organisation
    {
        return $this->organisation;
    }

    public function getSemesterReport(): SemesterReport
    {
        return $this->semesterReport;
    }

    public function getRevenueSum(): int
    {
        $revenueSum = 0;
        foreach ($this->events as $futureEvent) {
            $revenueSum += $futureEvent->getRevenue();
        }

        return $revenueSum;
    }

    public function getExpenditureSum(): int
    {
        $expenditureSum = 0;
        foreach ($this->events as $futureEvent) {
            $expenditureSum += $futureEvent->getExpenditure();
        }

        return $expenditureSum;
    }

    /**
     * @return Event[]
     */
    public function getEvents(): array
    {
        return $this->events;
    }
}
