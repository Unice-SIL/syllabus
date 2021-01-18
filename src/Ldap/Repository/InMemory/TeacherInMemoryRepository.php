<?php

namespace App\Ldap\Repository\InMemory;

use App\Ldap\Collection\TeacherCollection;
use App\Ldap\Entity\Teacher;
use App\Ldap\Repository\TeacherRepositoryInterface;

/**
 * Class TeacherInMemoryRepository
 * @package LdapBundle\Repository\InMemory
 */
class TeacherInMemoryRepository implements TeacherRepositoryInterface
{
    private $teachers;

    /**
     * TeacherInMemoryRepository constructor.
     */
    public function __construct()
    {
        $this->teachers = new TeacherCollection();
        // Alexis Massé
        $teacher = new Teacher();
        $teacher->setId('jmasse')
            ->setUsername('jmasse')
            ->setFirstname('Alexis')
            ->setLastname('Massé')
            ->setEmail('Alexis.Masse@unice.fr');
        $this->teachers->append($teacher);
        // William Lafrenière
        $teacher = new Teacher();
        $teacher->setId('wlafreniere')
            ->setUsername('wlafreniere')
            ->setFirstname('William')
            ->setLastname('Lafrenière')
            ->setEmail('William.Lafreniere@unice.fr');
        $this->teachers->append($teacher);
        // Marcelle Bousquet
        $teacher = new Teacher();
        $teacher->setId('mbousquet')
            ->setUsername('mbousquet')
            ->setFirstname('Marcelle')
            ->setLastname('Bousquet')
            ->setEmail('Marcelle.Bousquet@unice.fr');
        $this->teachers->append($teacher);
        // Jacques Lazure
        $teacher = new Teacher();
        $teacher->setId('jlazure')
            ->setUsername('jlazure')
            ->setFirstname('Jacques')
            ->setLastname('Lazure')
            ->setEmail('Jacques.Lazure@unice.fr');
        $this->teachers->append($teacher);
    }

    /**
     * @param $id
     * @return Teacher|null
     */
    public function find($id): ?Teacher
    {
        foreach ($this->teachers as $teacher){
            if($teacher->getId() == $id){
                return $teacher;
            }
        }
        return null;
    }

    /**
     * @param $term
     * @return TeacherCollection
     */
    public function search($term): TeacherCollection
    {
        $teachers = new TeacherCollection();
        foreach ($this->teachers as $teacher){
            if(
                preg_match("/{$term}/i", $teacher->getFirstname()) === 1 ||
                preg_match("/{$term}/i", $teacher->getLastname()) === 1 ||
                preg_match("/{$term}/i", $teacher->getUsername()) === 1 ||
                preg_match("/{$term}/i", $teacher->getEmail()) === 1
            ){
                $teachers->append($teacher);
            }
        }
        return $teachers;
    }
}