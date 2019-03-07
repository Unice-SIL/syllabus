<?php

namespace tests\AppBundle\Command\CourseSectionActivity;

use AppBundle\Command\CourseSection\CourseSectionCommand;
use AppBundle\Command\CourseSectionActivity\CourseSectionActivityCommand;
use AppBundle\Entity\Activity;
use AppBundle\Entity\CourseSection;
use AppBundle\Entity\CourseSectionActivity;
use AppBundle\Entity\SectionType;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

/**
 * Class CourseSectionActivityCommandTest
 * @package tests\AppBundle\Command\CourseSectionActivity
 */
class CourseSectionActivityCommandTest extends TestCase
{

    /**
     * @var CourseSectionActivity
     */
    private $courseSectionActivity;

    /**
     * @var SectionType
     */
    private $activity;

    /**
     * @var CourseSection
     */
    private $courseSection;

    /**
     * @var CourseSectionActivityCommand
     */
    private $courseSectionActivityCommand1;

    /**
     * @var CourseSectionActivityCommand
     */
    private $courseSectionActivityCommand2;

    /**
     *
     */
    protected function setUp(): void
    {
        // CourseSection
        $this->courseSection = new CourseSection();
        $this->courseSection->setId(Uuid::uuid4());

        // Activity
        $this->activity = new Activity();
        $this->activity->setId(Uuid::uuid4());

        // CourseSectionActivity
        $this->courseSectionActivity = new CourseSectionActivity();
        $this->courseSectionActivity->setId(Uuid::uuid4())
            ->setDescription('description')
            ->setOrder(1)
            ->setActivity($this->activity)
            ->setCourseSection($this->courseSection);

        // Command 1
        $this->courseSectionActivityCommand1 = new CourseSectionActivityCommand();

        // Command 2
        $this->courseSectionActivityCommand2 = new CourseSectionActivityCommand($this->courseSectionActivity);
    }

    /**
     * @test
     */
    public function getId(){
        $this->assertEquals(strlen(Uuid::uuid4()), strlen($this->courseSectionActivityCommand1->getId()));
        $this->assertEquals(strlen(Uuid::uuid4()), strlen($this->courseSectionActivityCommand2->getId()));
    }

    /**
     * @test
     */
    public function getDescription(){
        $this->assertNull($this->courseSectionActivityCommand1->getDescription());
        $this->assertEquals('description', $this->courseSectionActivityCommand2->getDescription());
    }

    /**
     * @test
     */
    public function getOrder(){
        $this->assertEquals(0, $this->courseSectionActivityCommand1->getOrder());
        $this->assertEquals(1, $this->courseSectionActivityCommand2->getOrder());
    }

    /**
     * @test
     */
    public function getCourseSection(){
        $this->assertNull($this->courseSectionActivityCommand1->getCourseSection());
        $this->assertEquals($this->courseSection, $this->courseSectionActivityCommand2->getCourseSection());
    }

    /**
     * @test
     */
    public function getActivity(){
        $this->assertNull($this->courseSectionActivityCommand1->getActivity());
        $this->assertEquals($this->activity, $this->courseSectionActivityCommand2->getActivity());
    }

    /**
     * @test
     */
    public function filledEntity(){
        $courseSectionActivity = new CourseSectionActivity();
        $courseSectionActivity->setId($this->courseSectionActivityCommand1->getId())
            ->setOrder(0);
        $this->assertEquals($courseSectionActivity, $this->courseSectionActivityCommand1->filledEntity(new CourseSectionActivity()));
        $this->assertEquals($this->courseSectionActivity, $this->courseSectionActivityCommand2->filledEntity($this->courseSectionActivity));
    }

    /**
     *
     */
    protected function tearDown(): void
    {
        unset($this->createUserCommand);
    }
}