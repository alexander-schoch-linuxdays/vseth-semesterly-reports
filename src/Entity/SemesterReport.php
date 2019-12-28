<?php

/*
 * This file is part of the vseth-semesterly-reports project.
 *
 * (c) Florian Moser <git@famoser.ch>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Entity;

use App\Entity\Base\BaseEntity;
use App\Entity\Traits\IdTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * an event determines how the questionnaire looks like.
 *
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks
 */
class SemesterReport extends BaseEntity
{
    use IdTrait;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $semester;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    private $submittedDateTime;

    /**
     * @var string|null
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $politicalEventsDescription;

    /**
     * @var string|null
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $comments;

    /**
     * @var Organisation
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Organisation", inversedBy="semesterReports")
     */
    private $organisation;

    /**
     * @return int
     */
    public function getSemester(): int
    {
        return $this->semester;
    }

    /**
     * @param int $semester
     */
    public function setSemester(int $semester): void
    {
        $this->semester = $semester;
    }

    /**
     * @return \DateTime
     */
    public function getSubmittedDateTime(): \DateTime
    {
        return $this->submittedDateTime;
    }

    /**
     * @param \DateTime $submittedDateTime
     */
    public function setSubmittedDateTime(\DateTime $submittedDateTime): void
    {
        $this->submittedDateTime = $submittedDateTime;
    }

    /**
     * @return string|null
     */
    public function getPoliticalEventsDescription(): ?string
    {
        return $this->politicalEventsDescription;
    }

    /**
     * @param string|null $politicalEventsDescription
     */
    public function setPoliticalEventsDescription(?string $politicalEventsDescription): void
    {
        $this->politicalEventsDescription = $politicalEventsDescription;
    }

    /**
     * @return string|null
     */
    public function getComments(): ?string
    {
        return $this->comments;
    }

    /**
     * @param string|null $comments
     */
    public function setComments(?string $comments): void
    {
        $this->comments = $comments;
    }

    /**
     * @return Organisation
     */
    public function getOrganisation(): Organisation
    {
        return $this->organisation;
    }

    /**
     * @param Organisation $organisation
     */
    public function setOrganisation(Organisation $organisation): void
    {
        $this->organisation = $organisation;
    }
}
