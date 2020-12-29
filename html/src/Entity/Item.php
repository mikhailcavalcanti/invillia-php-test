<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @author Mikhail Cavalcanti <mikhailcavalcanti@gmail.com>
 * @ORM\Entity
 * @ORM\Table(name="item")
 */
class Item
{

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="ShipOrder")
     * @ORM\JoinColumn(name="id_shiporder", referencedColumnName="id", nullable=false)
     * @var ShipOrder
     */
    private $shipOrder;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank()
     * @var string
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @var string
     */
    private $note;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     * @var int
     */
    private $quantity;

    /**
     * @ORM\Column(type="decimal", precision=7, scale=2))
     * @Assert\NotBlank()
     * @var float
     */
    private $price;

    /**
     * Assign the entity with the array data
     * @param array $data The entity information data do be filled
     * @return Item
     */
    public function assign(array $data)
    {
        $this->shipOrder = $data['shipOrder'];
        $this->title = $data['title'];
        $this->note = $data['note'];
        $this->quantity = $data['quantity'];
        $this->price = $data['price'];
        return $this;
    }
}
