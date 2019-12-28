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
use App\Form\Type\SemesterType;
use Doctrine\ORM\Mapping as ORM;

/**
 * an event determines how the questionnaire looks like.
 *
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks
 */
class Event extends BaseEntity
{
    use IdTrait;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $semester;

    /**
     * @var string|null
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $nameDe;

    /**
     * @var string|null
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $nameEn;

    /**
     * @var string|null
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $descriptionDe;

    /**
     * @var string|null
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $descriptionEn;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    private $location;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $startDate;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $endDate;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $budget;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $needFinancialSupport;

    /**
     * @var Organisation
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Organisation", inversedBy="events")
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
     * @return int
     */
    public function getSemesterName(): string
    {
        return SemesterType::semesterToString($this->getSemester());
    }

    /**
     * @param int $semester
     */
    public function setSemester(int $semester): void
    {
        $this->semester = $semester;
    }

    /**
     * @return string|null
     */
    public function getName()
    {
        return $this->getNameDe() !== null ? $this->getNameDe() : $this->getNameEn();
    }

    /**
     * @return string|null
     */
    public function getNameDe(): ?string
    {
        return $this->nameDe;
    }

    /**
     * @param string|null $nameDe
     */
    public function setNameDe(?string $nameDe): void
    {
        $this->nameDe = $nameDe;
    }

    /**
     * @return string|null
     */
    public function getNameEn(): ?string
    {
        return $this->nameEn;
    }

    /**
     * @param string|null $nameEn
     */
    public function setNameEn(?string $nameEn): void
    {
        $this->nameEn = $nameEn;
    }

    /**
     * @return string|null
     */
    public function getDescriptionDe(): ?string
    {
        return $this->descriptionDe;
    }

    /**
     * @param string|null $descriptionDe
     */
    public function setDescriptionDe(?string $descriptionDe): void
    {
        $this->descriptionDe = $descriptionDe;
    }

    /**
     * @return string|null
     */
    public function getDescriptionEn(): ?string
    {
        return $this->descriptionEn;
    }

    /**
     * @param string|null $descriptionEn
     */
    public function setDescriptionEn(?string $descriptionEn): void
    {
        $this->descriptionEn = $descriptionEn;
    }

    /**
     * @return string
     */
    public function getLocation(): string
    {
        return $this->location;
    }

    /**
     * @param string $location
     */
    public function setLocation(string $location): void
    {
        $this->location = $location;
    }

    /**
     * @return \DateTime|null
     */
    public function getStartDate(): ?\DateTime
    {
        return $this->startDate;
    }

    /**
     * @param \DateTime|null $startDate
     */
    public function setStartDate(?\DateTime $startDate): void
    {
        $this->startDate = $startDate;
    }

    /**
     * @return \DateTime|null
     */
    public function getEndDate(): ?\DateTime
    {
        return $this->endDate;
    }

    /**
     * @param \DateTime|null $endDate
     */
    public function setEndDate(?\DateTime $endDate): void
    {
        $this->endDate = $endDate;
    }

    /**
     * @return int
     */
    public function getBudget(): int
    {
        return $this->budget;
    }

    /**
     * @param int $budget
     */
    public function setBudget(int $budget): void
    {
        $this->budget = $budget;
    }

    /**
     * @return bool
     */
    public function isNeedFinancialSupport(): bool
    {
        return $this->needFinancialSupport;
    }

    /**
     * @param bool $needFinancialSupport
     */
    public function setNeedFinancialSupport(bool $needFinancialSupport): void
    {
        $this->needFinancialSupport = $needFinancialSupport;
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
