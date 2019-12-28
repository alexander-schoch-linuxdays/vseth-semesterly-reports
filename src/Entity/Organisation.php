<?php

/*
 * This file is part of the feedback project.
 *
 * (c) Florian Moser <git@famoser.ch>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Entity;

use App\Entity\Base\BaseEntity;
use App\Entity\Traits\IdTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * an event determines how the questionnaire looks like.
 *
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks
 */
class Organisation extends BaseEntity
{
    use IdTrait;

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
     * @var Event[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Event", mappedBy="organisation")
     * @ORM\OrderBy({"date" = "DESC", "semester" = "DESC", "startDateTime" = "DESC", "endDateTime" = "DESC"})
     */
    private $events;

    public function __construct()
    {
        $this->events = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return int
     */
    public function getRelationSinceSemester(): int
    {
        return $this->relationSinceSemester;
    }

    /**
     * @param int $relationSinceSemester
     */
    public function setRelationSinceSemester(int $relationSinceSemester): void
    {
        $this->relationSinceSemester = $relationSinceSemester;
    }

    /**
     * @return Event[]|ArrayCollection
     */
    public function getEvents()
    {
        return $this->events;
    }
}
