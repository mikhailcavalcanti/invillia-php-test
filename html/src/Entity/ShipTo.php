<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @author Mikhail Cavalcanti <mikhailcavalcanti@gmail.com>
 * @ORM\Entity
 * @ORM\Table(name="shipto")
 */
class ShipTo
{

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="ShipOrder", inversedBy="shipTo")
     * @ORM\JoinColumn(name="id_shiptorder", referencedColumnName="id", nullable=false)
     * @var ShipOrder
     */
    private $shipOrder;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank()
     * @var string
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank()
     * @var string
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank()
     * @var string
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=30)
     * @Assert\NotBlank()
     * @var string
     */
    private $country;

    /**
     * Assign the entity with the array data
     * @param array $data The entity information data do be filled
     * @return ShipTo
     */
    public function assign(array $data)
    {
        $this->shipOrder = $data['shipOrder'];
        $this->name = $data['name'];
        $this->address = $data['address'];
        $this->city = $data['city'];
        $this->country = $data['country'];
        return $this;
    }
}
