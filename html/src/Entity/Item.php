<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @author Mikhail Cavalcanti <mikhailcavalcanti@gmail.com>
 * @ORM\Entity
 * @ORM\Table(name="item")
 */
final class Item
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
     *
     * @param \App\Entity\ShipOrder $shipOrder
     * @param string $title
     * @param string $note
     * @param int $quantity
     * @param float $price
     */
    public function __construct(ShipOrder $shipOrder, string $title, string $note, int $quantity, float $price)
    {
        $this->shipOrder = $shipOrder;
        $this->title = $title;
        $this->note = $note;
        $this->quantity = $quantity;
        $this->price = $price;
    }
}
