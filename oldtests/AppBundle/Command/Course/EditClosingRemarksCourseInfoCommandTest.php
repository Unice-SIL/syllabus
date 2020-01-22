<?php

namespace tests\AppBundle\Command\Course;

use AppBundle\Command\Course\EditClosingRemarksCourseInfoCommand;
use AppBundle\Entity\CourseInfo;
use AppBundle\Entity\Year;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

/**
 * Class EditClosingRemarksCourseInfoCommandTest
 * @package tests\AppBundle\Command\Course
 */
class EditClosingRemarksCourseInfoCommandTest extends TestCase
{
    /**
     * @var CourseInfo
     */
    private $courseInfo;

    /**
     * @var EditClosingRemarksCourseInfoCommand
     */
    private $editClosingRemarksCourseInfoCommand;

    /**
     *
     */
    protected function setUp(): void
    {

        // CourseInfo
        $this->courseInfo = new CourseInfo();
        $this->courseInfo->setId(Uuid::uuid4())
            ->setClosingRemarks('closingRemarks')
            ->setClosingVideo('closingVideo');

        // Year
        $year = new Year();
        $year->setId('2018')
            ->setLabel('2018-2019')
            ->setCurrent(true);
        $this->courseInfo->setYear($year);

        // EditPresentationCourseInfoCommand
        $this->editClosingRemarksCourseInfoCommand = new EditClosingRemarksCourseInfoCommand($this->courseInfo);

    }

    /**
     * @test
     */
    public function getId(){
        $this->assertTrue(is_string($this->editClosingRemarksCourseInfoCommand->getId()));
        $this->assertEquals(strlen(Uuid::uuid4()), strlen($this->editClosingRemarksCourseInfoCommand->getId()));
    }

    /**
     * @test
     */
    public function getClosingRemarks(){
        $this->assertEquals('closingRemarks', $this->editClosingRemarksCourseInfoCommand->getClosingRemarks());
    }

    /**
     * @test
     */
    public function getClosingVideo(){
        $this->assertEquals('closingVideo', $this->editClosingRemarksCourseInfoCommand->getClosingVideo());
    }

    /**
     * @test
     */
    public function filledEntity(){
        $courseInfo = new CourseInfo();
        $courseInfo->setId($this->editClosingRemarksCourseInfoCommand->getId())
            ->setClosingRemarks($this->editClosingRemarksCourseInfoCommand->getClosingRemarks())
            ->setClosingVideo($this->editClosingRemarksCourseInfoCommand->getClosingVideo());
        $this->assertEquals($courseInfo, $this->editClosingRemarksCourseInfoCommand->filledEntity($courseInfo));
    }

    /**
     *
     */
    protected function tearDown(): void
    {
        unset($this->courseInfo);
        unset($this->editClosingRemarksCourseInfoCommand);
    }
}