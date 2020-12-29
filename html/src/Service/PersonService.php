<?php

namespace App\Service;

use App\Entity\Person;
use Doctrine\ORM\EntityManagerInterface;
use DomainException;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * PersonService is the class responsible for the business logic of the Person domain
 *
 * @author Mikhail Cavalcanti <mikhailcavalcanti@gmail.com>
 */
class PersonService
{

    /**
     *
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
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
            throw new DomainException("Xml file doesn't exists in '{$xmlFilePath}'");
        }
        $xmlObject = simplexml_load_file($xmlFilePath);
        foreach ($xmlObject->children() as $person) {
            $personEntity = $this->find($person->personid) ?? new Person();
            $personEntity->assign([
                'name' => $person->personname,
                'phones' => (array) $person->phones->phone,
                'id' => $person->personid
            ], $this->entityManager);
            $personEntity->persist($this->entityManager);
        }
        $this->entityManager->flush();
    }

    /**
     *
     * @return Person Person entity on the database
     */
    public function find($id)
    {
        return $this->entityManager->getRepository(Person::class)->find($id);
    }

    /**
     *
     * @return array Array of people entity on the database
     */
    public function findAll()
    {
        return $this->entityManager->getRepository(Person::class)->findall();
    }
}
