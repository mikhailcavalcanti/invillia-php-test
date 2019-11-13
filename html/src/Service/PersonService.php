<?php

namespace App\Service;

/**
 * PersonService is the class responsible for the business logic of the Person domain
 *
 * @author Mikhail Cavalcanti <mikhailcavalcanti@gmail.com>
 */
class PersonService
{

    /**
     *
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * 
     * @param \Doctrine\ORM\EntityManager $entityManager
     */
    public function __construct(\Doctrine\ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Reads a xml file and add the people in it on the database
     * @param string $xmlFilePath The file path to be read
     * @todo Test if file exists
     */
    public function addPeopleFromXml($xmlFilePath)
    {
        if (!is_file($xmlFilePath)) {
            throw new DomainException("Xml file doesn't exists in '${$xmlFilePath}'");
        }
        $xmlObject = simplexml_load_file($xmlFilePath);
        foreach ($xmlObject->children() as $person) {
            $personEntity = new \App\Entity\Person(
                strval($person->personname),
                (array) $person->phones->phone,
                intval($person->personid)
            );
            $personEntity->persist($this->entityManager);
        }
        $this->entityManager->flush();
    }

    /**
     *
     * @return array Array of people entity to the database
     */
    public function findAll()
    {
        return $this->entityManager->getRepository(\App\Entity\Person::class)->findall();
    }

}
