<?php

namespace LdapBundle\Repository\InMemory;

use LdapBundle\Collection\PeopleCollection;
use LdapBundle\Entity\People;
use LdapBundle\Repository\PeopleRepositoryInterface;

/**
 * Class PeopleInMemoryRepository
 * @package LdapBundle\Repository\Ldap
 */
class PeopleInMemoryRepository implements PeopleRepositoryInterface
{
    private $peoples;

    /**
     * PeopleLdapRepository constructor.
     */
    public function __construct()
    {
        $this->peoples = new PeopleCollection();
        $people = new People();
        $people->setId('jmasse')
            ->setUsername('jmasse')
            ->setFirstname('Alexis')
            ->setLastname('Massé')
            ->setEmail('Alexis.Masse@unice.fr');
        $this->peoples->append($people);
        $people = new People();
        $people->setId('wlafreniere')
            ->setUsername('wlafreniere')
            ->setFirstname('William')
            ->setLastname('Lafrenière')
            ->setEmail('William.Lafreniere@unice.fr');
        $this->peoples->append($people);
        $people->setId('mbousquet')
            ->setUsername('mbousquet')
            ->setFirstname('Marcelle')
            ->setLastname('Bousquet')
            ->setEmail('Marcelle.Bousquet@unice.fr');
        $this->peoples->append($people);
        $people->setId('jlazure')
            ->setUsername('jlazure')
            ->setFirstname('Jacques')
            ->setLastname('Lazure')
            ->setEmail('Jacques.Lazure@unice.fr');
        $this->peoples->append($people);
    }

    /**
     * @param $term
     * @return mixed
     */
    public function search($term): PeopleCollection
    {
        $peoples = new PeopleCollection();
        foreach ($this->peoples as $people){
            if(
                preg_match("/{$term}/i", $people->getFirstname()) === 1 ||
                preg_match("/{$term}/i", $people->getLastname()) === 1 ||
                preg_match("/{$term}/i", $people->getUsername()) === 1 ||
                preg_match("/{$term}/i", $people->getEmail()) === 1
            ){
                $peoples->append($people);
            }
        }
        return $peoples;
    }
}