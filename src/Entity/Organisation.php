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
use App\Entity\Traits\HideTrait;
use App\Entity\Traits\IdTrait;
use App\Entity\Traits\TimeTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * an event determines how the questionnaire looks like.
 *
 * @ORM\Entity(repositoryClass="App\Repository\OrganisationRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Organisation extends BaseEntity
{
    use IdTrait;
    use TimeTrait;
    use HideTrait;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    private $email;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $relationSinceSemester;

    /**
     * @var string|null
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $comments;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $authenticationCode;

    /**
     * @var Event[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Event", mappedBy="organisation")
     * @ORM\OrderBy({"semester" = "DESC", "startDate" = "DESC", "endDate" = "DESC"})
     */
    private $events;

    /**
     * @var SemesterReport[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="SemesterReport", mappedBy="organisation")
     * @ORM\OrderBy({"semester" = "DESC"})
     */
    private $semesterReports;

    public function __construct()
    {
        $this->events = new ArrayCollection();
        $this->semesterReports = new ArrayCollection();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getRelationSinceSemester(): int
    {
        return $this->relationSinceSemester;
    }

    public function setRelationSinceSemester(int $relationSinceSemester): void
    {
        $this->relationSinceSemester = $relationSinceSemester;
    }

    public function getAuthenticationCode(): string
    {
        return $this->authenticationCode;
    }

    public function getComments(): ?string
    {
        return $this->comments;
    }

    public function setComments(?string $comments): void
    {
        $this->comments = $comments;
    }

    /**
     * @throws \Exception
     */
    public function setAuthenticationCode(string $authenticationCode)
    {
        $this->authenticationCode = $authenticationCode;
    }

    /**
     * @throws \Exception
     */
    public function generateAuthenticationCode()
    {
        $this->authenticationCode = Uuid::uuid4();
    }

    /**
     * @return Event[]|ArrayCollection
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * @return SemesterReport[]|ArrayCollection
     */
    public function getSemesterReports()
    {
        return $this->semesterReports;
    }
}
