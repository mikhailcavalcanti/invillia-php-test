<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @author Mikhail Cavalcanti <mikhailcavalcanti@gmail.com>
 * @ORM\Entity
 * @ORM\Table(name="person")
 */
final class Person
{

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     *
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="Phone", mappedBy="person")
     * @var Phone
     */
    private $phones;

    /**
     *
     * @param string $name The person name
     * @param array $phones The person's phones
     * @param int $id The person identification in the database
     */
    public function __construct(string $name, array $phones = [], int $id = 0)
    {
        $this->name = $name;
        $phonesEntity = [];
        foreach ($phones as $phone) {
            array_push($phonesEntity, new Phone($phone, $this));
        }
        $this->phones = new ArrayCollection($phonesEntity);
        $this->id = $id;
    }

    /**
     *
     * @param EntityManager $entityManager
     */
    public function persist(EntityManager $entityManager)
    {
        $entityManager->persist($this);
        foreach ($this->phones as $phone) {
            $entityManager->persist($phone);
        }
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName():string
    {
        return $this->name;
    }

    /**
     * @return ArrayCollection
     */
    public function getPhones()
    {
        return $this->phones;
    }
}
