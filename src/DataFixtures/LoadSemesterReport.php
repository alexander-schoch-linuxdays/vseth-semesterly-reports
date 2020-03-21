<?php

/*
 * This file is part of the vseth-semesterly-reports project.
 *
 * (c) Florian Moser <git@famoser.ch>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\DataFixtures;

use App\DataFixtures\Base\BaseFixture;
use App\Entity\Event;
use App\Entity\Organisation;
use App\Entity\SemesterReport;
use App\Form\Type\SemesterType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Serializer\SerializerInterface;

class LoadSemesterReport extends BaseFixture
{
    const ORDER = LoadOrganisations::ORDER + 1;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * LoadEvent constructor.
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * Load data fixtures with the passed EntityManager.
     */
    public function load(ObjectManager $manager)
    {
        //fill semester with events
        /** @var Organisation[] $organisations */
        $organisations = $manager->getRepository(Organisation::class)->findAll();

        $organisationCount = \count($organisations);
        for ($i = 0; $i < $organisationCount; ++$i) {
            if ($i % 3 === 0) {
                continue;
            }

            $semesterReport = $this->getRandomInstance();
            $semesterReport->setOrganisation($organisations[$i]);
            $manager->persist($semesterReport);
        }

        $manager->flush();
    }

    protected function getRandomInstance()
    {
        $faker = $this->getFaker();

        $semesterReport = new SemesterReport();
        $semesterReport->setSemester(SemesterType::getCurrentSemester());
        $semesterReport->setComments($faker->text(200));
        $semesterReport->setPoliticalEventsDescription($faker->text(200));
        $semesterReport->setSubmittedDateTime($faker->dateTimeInInterval('-1 years', '1 years'));

        return $semesterReport;
    }

    private function fillWithPremadeEvents(ObjectManager $manager, Organisation $organisation)
    {
        //prepare resources
        $json = file_get_contents(__DIR__ . '/Resources/events.json');
        /** @var Event[] $events */
        $events = $this->serializer->deserialize($json, Event::class . '[]', 'json');

        $startDate = new \DateTime('today 18:00');
        $endDate = new \DateTime('today 20:00');
        foreach ($events as $event) {
            $event->setOrganisation($organisation);
            $event->setSemester(SemesterType::getCurrentSemester());
            $event->setStartDate($startDate);
            $event->setEndDate($endDate);
            $manager->persist($event);

            $startDate = $startDate->add(new \DateInterval('P10D'));
            $endDate = $endDate->add(new \DateInterval('P10D'));
        }

        $manager->flush();
    }

    /**
     * Get the order of this fixture.
     *
     * @return int
     */
    public function getOrder()
    {
        return static::ORDER;
    }
}
