<?php

namespace tests\AppBundle\Command\Course;

use AppBundle\Command\Course\EditPresentationCourseInfoCommand;
use AppBundle\Command\CourseTeacher\CourseTeacherCommand;
use AppBundle\Entity\CourseInfo;
use AppBundle\Entity\CourseTeacher;
use AppBundle\Entity\Year;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

/**
 * Class EditPresentationCourseInfoCommandTest
 * @package tests\Command\User
 */
class EditPresentationCourseInfoCommandTest extends TestCase
{
    /**
     * @var CourseInfo
     */
    private $courseInfo;

    /**
     * @var ArrayCollection
     */
    private $courseTeachers;

    /**
     * @var Year
     */
    private $year;

    /**
     * @var EditPresentationCourseInfoCommand
     */
    private $editPresentationCourseInfoCommand;

    /**
     * @var ArrayCollection
     */
    private $teachersCommands;

    /**
     *
     */
    protected function setUp(): void
    {

        // CourseInfo
        $this->courseInfo = new CourseInfo();
        $this->courseInfo->setId(Uuid::uuid4())
            ->setPeriod('period')
            ->setSummary('summary')
            ->setMediaType('image')
            ->setImage('image.jpg')
            ->setVideo('https://domaine.com/video')
            ->setTeachingMode('class')
            ->setTeachingCmClass(2)
            ->setTeachingTdClass(4)
            ->setTeachingTpClass(6)
            ->setTeachingOtherClass(8)
            ->setTeachingCmHybridClass(10)
            ->setTeachingTdHybridClass(12)
            ->setTeachingTpHybridClass(14)
            ->setTeachingOtherHybridClass(16)
            ->setTeachingCmHybridDist(18)
            ->setTeachingTdHybridDist(20)
            ->setTeachingOtherHybridDist(22);

        // Year
        $this->year = new Year();
        $this->year->setId('2018')
            ->setLabel('2018-2019')
            ->setCurrent(true);
        $this->courseInfo->setYear($this->year);

        // CourseTeachers
        $courseTeacher = new CourseTeacher();
        $courseTeacher->setId(Uuid::uuid4())
            ->setCourseInfo($this->courseInfo)
            ->setFirstname('firstname')
            ->setLastname('lastname')
            ->setEmail('email')
            ->setManager(true);
        $this->courseTeachers = new ArrayCollection();
        $this->courseTeachers->add($courseTeacher);
        $this->courseInfo->setCourseTeachers($this->courseTeachers);

        // EditPresentationCourseInfoCommand
        $this->editPresentationCourseInfoCommand = new EditPresentationCourseInfoCommand($this->courseInfo);

        // TeachersCommands
        $this->teachersCommands = new ArrayCollection();
        foreach ($this->courseTeachers as $courseTeacher){
            $teacher = new CourseTeacherCommand($courseTeacher);
            $this->teachersCommands->add($teacher);
        }
    }

    /**
     * @test
     */
    public function getId(){
        $this->assertTrue(is_string($this->editPresentationCourseInfoCommand->getId()));
        $this->assertEquals(strlen(Uuid::uuid4()), strlen($this->editPresentationCourseInfoCommand->getId()));
    }

    /**
     * @test
     */
    public function getPeriod(){
        $this->assertEquals('period', $this->editPresentationCourseInfoCommand->getPeriod());
    }

    /**
     * @test
     */
    public function getSummary(){
        $this->assertEquals('summary', $this->editPresentationCourseInfoCommand->getSummary());
    }

    /**
     * @test
     */
    public function getMediaType(){
        $this->assertEquals('image', $this->editPresentationCourseInfoCommand->getMediaType());
    }

    /**
     * @test
     */
    public function getImage(){
        $this->assertEquals('image.jpg', $this->editPresentationCourseInfoCommand->getImage());
    }

    /**
     * @test
     */
    public function getVideo(){
        $this->assertEquals('https://domaine.com/video', $this->editPresentationCourseInfoCommand->getVideo());
    }

    /**
     * @test
     */
    public function getTeachingMode(){
       $this->assertEquals('class', $this->editPresentationCourseInfoCommand->getTeachingMode());
    }

    /**
     * @test
     */
    public function getTeachingCmClass(){
        $this->assertEquals(2, $this->editPresentationCourseInfoCommand->getTeachingCmClass());
    }

    /**
     * @test
     */
    public function getTeachingTdClass(){
        $this->assertEquals(4, $this->editPresentationCourseInfoCommand->getTeachingTdClass());
    }

    /**
     * @test
     */
    public function getTeachingTpClass(){
        $this->assertEquals(6, $this->editPresentationCourseInfoCommand->getTeachingTpClass());
    }

    /**
     * @test
     */
    public function getTeachingOtherClass(){
        $this->assertEquals(8, $this->editPresentationCourseInfoCommand->getTeachingOtherClass());
    }

    /**
     * @test
     */
    public function getTeachingCmHybridClass(){
        $this->assertEquals(10, $this->editPresentationCourseInfoCommand->getTeachingCmHybridClass());
    }

    /**
     * @test
     */
    public function getTeachingTdHybridClass(){
        $this->assertEquals(12, $this->editPresentationCourseInfoCommand->getTeachingTdHybridClass());
    }

    /**
     * @test
     */
    public function getTeachingTpHybridClass(){
        $this->assertEquals(14, $this->editPresentationCourseInfoCommand->getTeachingTpHybridClass());
    }

    /**
     * @test
     */
    public function getTeachingOtherHybridClass(){
        $this->assertEquals(16, $this->editPresentationCourseInfoCommand->getTeachingOtherHybridClass());
    }

    /**
     * @test
     */
    public function getTeachingCmHybridDist(){
        $this->assertEquals(18, $this->editPresentationCourseInfoCommand->getTeachingCmHybridDist());
    }

    /**
     * @test
     */
    public function getTeachingTdHybridDist(){
        $this->assertEquals(20, $this->editPresentationCourseInfoCommand->getTeachingTdHybridDist());
    }

    /**
     * @test
     */
    public function getTeachingOtherHybridDist(){
        $this->assertEquals(22, $this->editPresentationCourseInfoCommand->getTeachingOtherHybridDist());
    }

    /**
     * @test
     */
    public function getTeachers(){
        $this->assertEquals($this->teachersCommands, $this->editPresentationCourseInfoCommand->getTeachers());
    }

    /**
     * @test
     */
    public function filledEntity(){
        $courseInfo = new CourseInfo();
        $courseInfo->setId($this->editPresentationCourseInfoCommand->getId())
            ->setPeriod($this->editPresentationCourseInfoCommand->getPeriod())
            ->setSummary($this->editPresentationCourseInfoCommand->getSummary())
            ->setMediaType($this->editPresentationCourseInfoCommand->getMediaType())
            ->setImage($this->editPresentationCourseInfoCommand->getImage())
            ->setVideo($this->editPresentationCourseInfoCommand->getVideo())
            ->setTeachingMode($this->editPresentationCourseInfoCommand->getTeachingMode())
            ->setTeachingCmClass($this->editPresentationCourseInfoCommand->getTeachingCmClass())
            ->setTeachingTdClass($this->editPresentationCourseInfoCommand->getTeachingTdClass())
            ->setTeachingTpClass($this->editPresentationCourseInfoCommand->getTeachingTpClass())
            ->setTeachingOtherClass($this->editPresentationCourseInfoCommand->getTeachingOtherClass())
            ->setTeachingCmHybridClass($this->editPresentationCourseInfoCommand->getTeachingCmHybridClass())
            ->setTeachingTdHybridClass($this->editPresentationCourseInfoCommand->getTeachingTdHybridClass())
            ->setTeachingTpHybridClass($this->editPresentationCourseInfoCommand->getTeachingTpHybridClass())
            ->setTeachingOtherHybridClass($this->editPresentationCourseInfoCommand->getTeachingOtherHybridClass())
            ->setTeachingCmHybridDist($this->editPresentationCourseInfoCommand->getTeachingCmHybridDist())
            ->setTeachingTdHybridDist($this->editPresentationCourseInfoCommand->getTeachingTdHybridDist())
            ->setTeachingOtherHybridDist($this->editPresentationCourseInfoCommand->getTeachingOtherHybridDist())
            ->setCourseTeachers($this->courseTeachers);
        $this->assertEquals($courseInfo, $this->editPresentationCourseInfoCommand->filledEntity($courseInfo));
    }

    /**
     *
     */
    protected function tearDown(): void
    {
        unset($this->editUserCommand);
    }
}