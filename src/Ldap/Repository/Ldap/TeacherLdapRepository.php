<?php

namespace App\Ldap\Repository\Ldap;

use App\Ldap\Collection\TeacherCollection;
use App\Ldap\Entity\Teacher;
use App\Ldap\Repository\TeacherRepositoryInterface;
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
     * TeacherLdapRepository constructor.
     * @param Ldap $ldap
     * @param array $parameters
     * @param string|null $bindDn
     * @param string|null $bindPassword
     * @throws \Exception
     */
    public function __construct(Ldap $ldap, array $parameters, string $bindDn=null, string $bindPassword=null)
    {
        $this->ldap = $ldap;
        $this->parameters = $parameters;
        $this->bindDn = $bindDn;
        $this->bindPassword = $bindPassword;
        if(!is_array($this->parameters)){
            throw new \Exception('Parameter ldap_uns_repositories must be an array');
        }
        if(!array_key_exists('teacher', $this->parameters)){
            throw new \Exception('Parameter teacher not found in ldap_uns_repositories');
        }
        if(!is_array($this->parameters)){
            throw new \Exception('Parameter teacher must be an array in ldap_uns_repositories');
        }
        if(!array_key_exists('base_dn', $this->parameters['teacher'])){
            throw new \Exception('Parameter base_dn not found in ldap_uns_repositories.teacher');
        }
        if(!array_key_exists('queries', $this->parameters['teacher'])){
            throw new \Exception('Parameter queries not found in ldap_uns_repositories.teacher');
        }
        if(!is_array($this->parameters['teacher']['queries'])){
            throw new \Exception('Parameter queries must be an array in ldap_uns_repositories.teacher');
        }
    }

    /**
     * @param $id
     * @return Teacher|null
     * @throws \Exception
     */
    public function find($id): ?Teacher
    {
        $teacher = null;
        try{
            if(!array_key_exists('find', $this->parameters['teacher']['queries'])){
                throw new \Exception('Parameter find not found in ldap_uns_repositories.teacher.query');
            }
            $this->ldap->bind($this->bindDn, $this->bindPassword);
            $id = $this->ldap->escape($id, '', LdapInterface::ESCAPE_FILTER);
            $query = str_replace('{id}', $id, $this->parameters['teacher']['queries']['find']);
            $entries = $this->ldap->query($this->parameters['teacher']['base_dn'], $query)->execute();
            $teacher = null;
            if(count($entries) > 0){
                $teacher = $this->setTeacherAttributes($entries[0]);

            }
        }catch (\Exception $e){
            throw $e;
        }
        return $teacher;
    }

    /**
     * @param $term
     * @return TeacherCollection
     * @throws \Exception
     */
    public function search($term): TeacherCollection
    {
        if(!array_key_exists('search', $this->parameters['teacher']['queries'])){
            throw new \Exception('Parameter search not found in ldap_uns_repositories.teacher.query');
        }
        $teachers = new TeacherCollection();
        try {
            // Ldap connexion
            $this->ldap->bind($this->bindDn, $this->bindPassword);
            $term = $this->ldap->escape($term, '', LdapInterface::ESCAPE_FILTER);
            $query = str_replace('{term}', $term, $this->parameters['teacher']['queries']['search']);
            $entries = $this->ldap->query($this->parameters['teacher']['base_dn'], $query)->execute();
            foreach ($entries as $entry) {
                $teacher = $this->setTeacherAttributes($entry);

                if (
                    !is_null($teacher->getId()) &&
                    !is_null($teacher->getFirstname()) &&
                    !is_null($teacher->getLastname())
                ) {
                    $teachers->append($teacher);
                }
            }
        }catch (\Exception $e){
            throw $e;
        }
        $teachers = $teachers->toArray();
        usort($teachers, function($a, $b){
            $str1 = "{$a->getLastname()} {$a->getFirstname()}";
            $str2 = "{$b->getLastname()} {$b->getFirstname()}";
            return strcasecmp($str1, $str2);
        });
        return new TeacherCollection($teachers);
    }

    /**
     * @param Entry $entry
     * @param Teacher|null $teacher
     * @return Teacher
     * @throws \Exception
     */
    private function setTeacherAttributes(Entry $entry, Teacher $teacher=null): Teacher
    {
        try {
            if (is_null($teacher)) {
                $teacher = new Teacher();
            }
            $propertyAccessor = PropertyAccess::createPropertyAccessor();
            $mapping = $this->parameters['teacher']['mapping'];
            foreach ($mapping as $map => $attribute) {
                $attribute = $entry->getAttribute($attribute);
                if (is_array($attribute) && count($attribute) > 0) {
                    $propertyAccessor->setValue($teacher, $map, $attribute[0]);
                }
            }
        }catch (\Exception $e){
            throw $e;
        }
        return $teacher;
    }
}