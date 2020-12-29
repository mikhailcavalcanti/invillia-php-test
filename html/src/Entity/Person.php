<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @author Mikhail Cavalcanti <mikhailcavalcanti@gmail.com>
 * @ORM\Entity
 * @ORM\Table(name="person")
 */
class Person
{

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $id = null;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank()
     *
     */
    private $name = null;

    /**
     * @ORM\OneToMany(targetEntity="Phone", mappedBy="person")
     * @var Phone
     */
    private $phones = [];

    public function __construct()
    {
        $this->phones = new ArrayCollection([]);
    }

    /**
     * Assign the entity with the array data
     * @param array $data The entity information data do be filled
     * @param EntityManagerInterface $entityManager
     * @return Person
     */
    public function assign(array $data, EntityManagerInterface $entityManager)
    {
        $this->id = $data['id'] ?? $this->id;
        $this->name = $data['name'] ?? $this->name;

        $this->phones->clear();
        foreach ($data['phones'] as $number) {
            $phone = $entityManager->getRepository(Phone::class)->findOneBy(array('number' => $number));
            $this->phones->add($phone ? : new Phone($number, $this));
        }
        return $this;
    }

    /**
     *
     * @param EntityManagerInterface $entityManager
     */
    public function persist(EntityManagerInterface $entityManager)
    {
        $entityManager->persist($this);
        foreach ($this->phones as $phone) {
            $entityManager->persist($phone);
        }
    }
}
