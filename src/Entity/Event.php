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
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $nameDe;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $nameEn;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $descriptionDe;

    /**
     * @var string
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

    public function getSemester(): int
    {
        return $this->semester;
    }

    public function setSemester(int $semester): void
    {
        $this->semester = $semester;
    }

    public function getNameDe(): string
    {
        return $this->nameDe;
    }

    public function setNameDe(string $nameDe): void
    {
        $this->nameDe = $nameDe;
    }

    public function getNameEn(): string
    {
        return $this->nameEn;
    }

    public function setNameEn(string $nameEn): void
    {
        $this->nameEn = $nameEn;
    }

    public function getDescriptionDe(): string
    {
        return $this->descriptionDe;
    }

    public function setDescriptionDe(string $descriptionDe): void
    {
        $this->descriptionDe = $descriptionDe;
    }

    public function getDescriptionEn(): string
    {
        return $this->descriptionEn;
    }

    public function setDescriptionEn(string $descriptionEn): void
    {
        $this->descriptionEn = $descriptionEn;
    }

    public function getLocation(): string
    {
        return $this->location;
    }

    public function setLocation(string $location): void
    {
        $this->location = $location;
    }

    public function getStartDate(): ?\DateTime
    {
        return $this->startDate;
    }

    public function setStartDate(?\DateTime $startDate): void
    {
        $this->startDate = $startDate;
    }

    public function getEndDate(): ?\DateTime
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTime $endDate): void
    {
        $this->endDate = $endDate;
    }

    public function getBudget(): int
    {
        return $this->budget;
    }

    public function setBudget(int $budget): void
    {
        $this->budget = $budget;
    }

    public function isNeedFinancialSupport(): bool
    {
        return $this->needFinancialSupport;
    }

    public function setNeedFinancialSupport(bool $needFinancialSupport): void
    {
        $this->needFinancialSupport = $needFinancialSupport;
    }

    public function getOrganisation(): Organisation
    {
        return $this->organisation;
    }

    public function setOrganisation(Organisation $organisation): void
    {
        $this->organisation = $organisation;
    }
}
