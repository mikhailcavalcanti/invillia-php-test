<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @author Mikhail Cavalcanti <mikhailcavalcanti@gmail.com>
 * @ORM\Entity
 * @ORM\Table(name="shipto")
 */
final class ShipTo
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
     *
     * @param \App\Entity\ShipOrder $shipOrder
     * @param string $name
     * @param string $address
     * @param string $city
     * @param string $country
     */
    public function __construct(ShipOrder $shipOrder, string $name, string $address, string $city, string $country)
    {
        $this->shipOrder = $shipOrder;
        $this->name = $name;
        $this->address = $address;
        $this->city = $city;
        $this->country = $country;
    }
}
