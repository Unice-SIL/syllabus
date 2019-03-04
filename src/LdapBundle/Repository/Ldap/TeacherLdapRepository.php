<?php

namespace LdapBundle\Repository\Ldap;

use LdapBundle\Collection\TeacherCollection;
use LdapBundle\Entity\Teacher;
use LdapBundle\Repository\TeacherRepositoryInterface;
use Symfony\Component\Ldap\Entry;
use Symfony\Component\Ldap\Ldap;
use Symfony\Component\Ldap\LdapInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * Class teacherLdapRepository
 * @package LdapBundle\Repository\Ldap
 */
class TeacherLdapRepository implements TeacherRepositoryInterface
{
    /**
     * @var Ldap
     */
    private $ldap;

    /**
     * @var array
     */
    private  $parameters = [];

    /**
     * @var string
     */
    private $bindDn;

    /**
     * @var string
     */
    private $bindPassword;

    /**
     * teacherLdapRepository constructor.
     * @param Ldap $ldap
     */
    public function __construct(Ldap $ldap, array $parameters, string $bindDn=null, string $bindPassword=null)
    {
        $this->ldap = $ldap;
        $this->parameters = $parameters;
        $this->bindDn = $bindDn;
        $this->bindPassword = $bindPassword;
    }

    /**
     * Find a teacher with id
     * @param $id
     * @return mixed
     */
    public function find($id): ?Teacher
    {
        // Ldap connexion
        $this->ldap->bind($this->bindDn, $this->bindPassword);
        $id = $this->ldap->escape($id, '', LdapInterface::ESCAPE_FILTER);
        $query = str_replace('{id}', $id, $this->parameters['teacher']['find_query']);
        $entries = $this->ldap->query($this->parameters['teacher']['base_dn'], $query)->execute();
        $teacher = null;
        if(count($entries) > 0){
            $teacher = $this->setTeacherAttributes($entries[0]);

        }
        return $teacher;
    }

    /**
     * Search teachers by term
     * @param $term
     * @return mixed
     */
    public function search($term): TeacherCollection
    {
        // Ldap connexion
        $this->ldap->bind($this->bindDn, $this->bindPassword);
        $term = $this->ldap->escape($term, '', LdapInterface::ESCAPE_FILTER);
        $query = str_replace('{term}', $term, $this->parameters['teacher']['search_query']);
        $entries = $this->ldap->query($this->parameters['teacher']['base_dn'], $query)->execute();
        $teachers = new TeacherCollection();
        foreach ($entries as $entry){
            $teacher = $this->setTeacherAttributes($entry);
            if(
                !is_null($teacher->getId()) &&
                !is_null($teacher->getFirstname()) &&
                !is_null($teacher->getLastname())
            )
            {
                $teachers->append($teacher);
            }
        }
        return $teachers;
    }

    /**
     * @param Teacher $teacher
     * @return Teacher
     */
    private function setTeacherAttributes(Entry $entry, Teacher $teacher=null): Teacher
    {
        if(is_null($teacher)){
            $teacher = new Teacher();
        }
        $propertyAccessor = PropertyAccess::createPropertyAccessor();
        $mapping = $this->parameters['teacher']['mapping'];
        foreach ($mapping as $map => $attribute){
            $attribute = $entry->getAttribute($attribute);
            if(is_array($attribute) && count($attribute) > 0){
                $propertyAccessor->setValue($teacher, $map, $attribute[0]);
            }
        }
        return $teacher;
    }
}