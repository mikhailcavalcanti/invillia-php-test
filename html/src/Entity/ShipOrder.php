<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping as ORM;

/**
 * @author Mikhail Cavalcanti <mikhailcavalcanti@gmail.com>
 * @ORM\Entity
 * @ORM\Table(name="shiporder")
 */
final class ShipOrder
{

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @var int
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="id_person", referencedColumnName="id", nullable=false)
     * @var Person
     */
    private $person;

    /**
     * @ORM\OneToOne(targetEntity="ShipTo", mappedBy="shipOrder")
     * @var ShipTo
     */
    private $shipTo;

    /**
     * @ORM\OneToMany(targetEntity="Item", mappedBy="shiporder")
     * @var Item[]
     */
    private $items;

    /**
     *
     * @param Person $person The person who owns the ship order
     * @param array $shipTo The ship order destiny data
     * @param Item[] $items The ship order items
     * @param int $id
     */
    public function __construct(
        Person $person,
        array $shipTo,
        array $items,
        int $id = 0
    ) {
        $this->person = $person;
        $this->shipTo = new ShipTo(
            $this,
            $shipTo['name'],
            $shipTo['address'],
            $shipTo['city'],
            $shipTo['country']
        );
        $itemsEntity = [];
        foreach ($items as $item) {
            array_push($itemsEntity, new Item($this, $item['title'], $item['note'], $item['quantity'], $item['price']));
        }
        $this->items = new ArrayCollection($itemsEntity);
        $this->id = $id;
    }

    /**
     *
     * @param EntityManager $entityManager
     */
    public function persist(EntityManager $entityManager)
    {
        $entityManager->persist($this);
        $entityManager->persist($this->shipTo);
        foreach ($this->items as $item) {
            $entityManager->persist($item);
        }
    }
    
    public function getShipTo()
    {
        return $this->shipTo;
    }
    
    public function getItems()
    {
        return $this->getItems();
    }
}
