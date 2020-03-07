<?php

/*
 * This file is part of the vseth-semesterly-reports project.
 *
 * (c) Florian Moser <git@famoser.ch>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Model;

use App\Entity\Organisation;
use App\Model\SemesterEvaluation\OrganisationEvaluation;

class SemesterEvaluation
{
    /**
     * @var OrganisationEvaluation[]
     */
    private $organisationEvaluations;

    /**
     * @var Organisation[]
     */
    private $missingOrganisations;

    /**
     * SemesterEvaluation constructor.
     *
     * @param OrganisationEvaluation[] $organisationEvaluations
     * @param Organisation[] $missingOrganisations
     */
    public function __construct(array $organisationEvaluations, array $missingOrganisations)
    {
        $this->organisationEvaluations = $organisationEvaluations;
        $this->missingOrganisations = $missingOrganisations;
    }

    /**
     * @return OrganisationEvaluation[]
     */
    public function getOrganisationEvaluations(): array
    {
        return $this->organisationEvaluations;
    }

    /**
     * @return Organisation[]
     */
    public function getMissingOrganisations(): array
    {
        return $this->missingOrganisations;
    }
}
