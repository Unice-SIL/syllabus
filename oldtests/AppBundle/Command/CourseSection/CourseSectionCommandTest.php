<?php

namespace tests\AppBundle\Command\CourseSection;

use AppBundle\Command\CourseSection\CourseSectionCommand;
use AppBundle\Entity\CourseInfo;
use AppBundle\Entity\CourseSection;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

/**
 * Class CourseSectionCommandTest
 * @package tests\AppBundle\Command\CourseSection
 */
class CourseSectionCommandTest extends TestCase
{
    /**
     * @var CourseSection
     */
    private $courseSection;

    /**
     * @var ArrayCollection
     */
    private $activities;

    /**
     * @var CourseInfo
     */
    private $courseInfo;

    /**
     * @var CourseSectionCommand
     */
    private $courseSectionCommand1;

    /**
     * @var CourseSectionCommand
     */
    private $courseSectionCommand2;

    /**
     *
     */
    protected function setUp(): void
    {
        // CourseInfo
        $this->courseInfo = new CourseInfo();
        $this->courseInfo->setId(Uuid::uuid4());


        // Activities
        $this->activities = new ArrayCollection();

        // CourseSection
        $this->courseSection = new CourseSection();
        $this->courseSection->setId(Uuid::uuid4())
            ->setTitle('title')
            ->setDescription('description')
            ->setOrder(1)
            ->setCourseInfo($this->courseInfo)
            ->setCourseSectionActivities($this->activities);

        // Command 1
        $this->courseSectionCommand1 = new CourseSectionCommand();

        // Command 2
        $this->courseSectionCommand2 = new CourseSectionCommand($this->courseSection);
    }

    /**
     * @test
     */
    public function getId(){
        $this->assertEquals(strlen(Uuid::uuid4()), strlen($this->courseSectionCommand1->getId()));
        $this->assertEquals(strlen(Uuid::uuid4()), strlen($this->courseSectionCommand2->getId()));
    }

    /**
     * @test
     */
    public function getTitle(){
        $this->assertNull($this->courseSectionCommand1->getTitle());
        $this->assertEquals('title', $this->courseSectionCommand2->getTitle());
    }

    /**
     * @test
     */
    public function getDescription(){
        $this->assertNull($this->courseSectionCommand1->getDescription());
        $this->assertEquals('description', $this->courseSectionCommand2->getDescription());
    }

    /**
     * @test
     */
    public function getOrder(){
        $this->assertEquals(0, $this->courseSectionCommand1->getOrder());
        $this->assertEquals(1, $this->courseSectionCommand2->getOrder());
    }

    /**
     * @test
     */
    public function getCourseInfo(){
        $this->assertNull($this->courseSectionCommand1->getCourseInfo());
        $this->assertEquals($this->courseInfo, $this->courseSectionCommand2->getCourseInfo());
    }

    /**
     * @test
     */
    public function getActivities(){
        $this->assertEquals(new ArrayCollection(), $this->courseSectionCommand1->getActivities());
        $this->assertEquals($this->activities, $this->courseSectionCommand2->getActivities());
    }

    /**
     * @test
     */
    public function filledEntity(){
        $courseSection = new CourseSection();
        $courseSection->setId($this->courseSectionCommand1->getId())
            ->setCourseSectionActivities(new ArrayCollection())
            ->setOrder(0);
        $this->assertEquals($courseSection, $this->courseSectionCommand1->filledEntity(new CourseSection()));
        $this->assertEquals($this->courseSection, $this->courseSectionCommand2->filledEntity($this->courseSection));
    }

    /**
     *
     */
    protected function tearDown(): void
    {
        unset($this->createUserCommand);
    }
}