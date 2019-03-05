<?php

namespace test\LdapBundle\Collection;

use LdapBundle\Collection\TeacherCollection;
use LdapBundle\Entity\Teacher;
use PHPUnit\Framework\TestCase;

class TeacherCollectionTest extends TestCase
{
    /**
     * @var Teacher
     */
    private $teacher;

    /**
     *
     */
    public function setUp(){
        $this->teacher = new Teacher();
        $this->teacher->setId('id')
            ->setUsername('username')
            ->setCivilite('civilite')
            ->setFirstname('firstname')
            ->setLastname('lastname')
            ->setEmail('email');
    }

    /**
     * @test
     */
    public function offsetGet(){
        $teacherCollection = new TeacherCollection();
        $teacherCollection->offsetSet(0, $this->teacher);
        $this->assertEquals($this->teacher, $teacherCollection->offsetGet(0));
    }

    /**
     * @test
     */
    public function offsetGetNull(){
        $teacherCollection = new TeacherCollection();
        $this->assertNull($teacherCollection->offsetGet(1));
    }

    /**
     * @test
     */
    public function offsetExist(){
        $teacherCollection = new TeacherCollection();
        $teacherCollection->offsetSet(0, $this->teacher);
        $this->assertTrue($teacherCollection->offsetExists(0));
    }

    /**
     * @test
     */
    public function offsetNotExist(){
        $teacherCollection = new TeacherCollection();
        $this->assertFalse($teacherCollection->offsetExists(1));
    }

    /**
     * @test
     */
    public function offsetSet(){
        $teacherCollection = new TeacherCollection();
        $teacherCollection->offsetSet(10, $this->teacher);
        $this->assertEquals($this->teacher, $teacherCollection->offsetGet(10));
    }

    /**
     * @test
     */
    public function offsetSetUnexpectedValueException(){
        $this->expectException(\UnexpectedValueException::class);
        $teacherCollection = new TeacherCollection();
        $teacherCollection->offsetSet(10, new \stdClass());
        $this->assertCount(0, $teacherCollection);
    }

    /**
     * @test
     */
    public function append(){
        $teacherCollection = new TeacherCollection();
        $teacherCollection->append($this->teacher);
        $this->assertCount(1, $teacherCollection);
    }

    /**
     * @test
     */
    public function appendUnexpectedValueException(){
        $this->expectException(\UnexpectedValueException::class);
        $teacherCollection = new TeacherCollection();
        $teacherCollection->append( new \stdClass());
        $this->assertCount(0, $teacherCollection);
    }

    /**
     * @test
     */
    public function remove(){
        $teacherCollection = new TeacherCollection();
        $teacherCollection->offsetSet(0, $this->teacher);
        $teacherCollection->remove($this->teacher);
        $this->assertCount(0, $teacherCollection);
    }

    /**
     * @test
     */
    public function removeUnexpectedValueException(){
        $this->expectException(\UnexpectedValueException::class);
        $teacherCollection = new TeacherCollection();
        $teacherCollection->remove( new \stdClass());
        $this->assertCount(0, $teacherCollection);
    }
}