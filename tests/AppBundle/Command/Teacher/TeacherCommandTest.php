<?php

namespace tests\Command\User;

use AppBundle\Command\Teacher\TeacherCommand;
use AppBundle\Entity\CourseInfo;
use AppBundle\Entity\CourseTeacher;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

/**
 * Class TeacherCommandTest
 * @package tests\Command\User
 */
class TeacherCommandTest extends TestCase
{

    /**
     * @var CourseTeacher
     */
    private $courseTeacher;

    /**
     * @var CourseInfo
     */
    private $courseInfo;

    /**
     * @var TeacherCommand
     */
    private $teacherCommand1;

    /**
     * @var TeacherCommand
     */
    private $teacherCommand2;

    /**
     *
     */
    protected function setUp(): void
    {
        // CourseInfo
        $this->courseInfo = new CourseInfo();
        $this->courseInfo->setId(Uuid::uuid4());

        // CourseTeacher
        $this->courseTeacher = new CourseTeacher();
        $this->courseTeacher->setId(Uuid::uuid4())
            ->setCourseInfo($this->courseInfo)
            ->setFirstname('firstname')
            ->setLastname('lastname')
            ->setEmail('email')
            ->setManager(true);

        // Command 1
        $this->teacherCommand1 = new TeacherCommand();
        $this->teacherCommand1->setCourseInfo($this->courseInfo)
            ->setFirstname('firstname')
            ->setLastname('lastname')
            ->setEmail('email');

        // Command 2
        $this->teacherCommand2 = new TeacherCommand($this->courseTeacher);
    }

    /**
     * @test
     */
    public function getId(){
        $this->assertEquals(strlen(Uuid::uuid4()), strlen($this->teacherCommand1->getId()));
        $this->assertEquals(strlen(Uuid::uuid4()), strlen($this->teacherCommand2->getId()));
    }

    /**
     * @test
     */
    public function getFirstname(){
        $this->assertEquals('firstname', $this->teacherCommand1->getFirstname());
        $this->assertEquals('firstname', $this->teacherCommand2->getFirstname());
    }

    /**
     * @test
     */
    public function getLastname(){
        $this->assertEquals('lastname', $this->teacherCommand1->getLastname());
        $this->assertEquals('lastname', $this->teacherCommand2->getLastname());
    }

    /**
     * @test
     */
    public function getEmail(){
        $this->assertEquals('email', $this->teacherCommand1->getEmail());
        $this->assertEquals('email', $this->teacherCommand2->getEmail());
    }

    /**
     * @test
     */
    public function isManager(){
        $this->assertFalse($this->teacherCommand1->isManager());
        $this->assertTrue($this->teacherCommand2->isManager());
    }

    /**
     * @test
     */
    public function getCourseInfo(){
        $this->assertEquals($this->courseInfo, $this->teacherCommand1->getCourseInfo());
        $this->assertEquals($this->courseInfo, $this->teacherCommand2->getCourseInfo());
    }

    /**
     * @test
     */
    public function filledEntity(){
        $courseTeacher = new CourseTeacher();
        $courseTeacher->setId($this->teacherCommand1->getId())
            ->setCourseInfo($this->courseInfo)
            ->setFirstname($this->teacherCommand1->getFirstname())
            ->setLastname($this->teacherCommand1->getLastname())
            ->setEmail($this->teacherCommand1->getEmail())
            ->setManager($this->teacherCommand1->isManager());
        $this->assertEquals($courseTeacher, $this->teacherCommand1->filledEntity($courseTeacher));
        $this->assertEquals($this->courseTeacher, $this->teacherCommand2->filledEntity($this->courseTeacher));
    }

    /**
     *
     */
    protected function tearDown(): void
    {
        unset($this->createUserCommand);
    }
}