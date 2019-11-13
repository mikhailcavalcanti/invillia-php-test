<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @author Mikhail Cavalcanti <mikhailcavalcanti@gmail.com>
 * @ORM\Entity
 * @ORM\Table(name="phone")
 */
final class Phone
{

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     * @Assert\NotBlank()
     *
     */
    private $number;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Person")
     * @ORM\JoinColumn(name="id_person", referencedColumnName="id", nullable=false)
     * @var Person
     */
    private $person;

    /**
     *
     * @param string $number The phone number
     * @param Person $person The owner's phone
     */
    public function __construct(string $number, Person $person)
    {
        $this->number = $number;
        $this->person = $person;
    }

    /**
     * @return mixed
     */
    public function getId():int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getNumber():string
    {
        return $this->number;
    }
}
