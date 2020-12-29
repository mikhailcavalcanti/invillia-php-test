<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @author Mikhail Cavalcanti <mikhailcavalcanti@gmail.com>
 * @ORM\Entity
 * @ORM\Table(name="shiporder")
 */
class ShipOrder
{

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @var int
     */
    private $id = null;

    /**
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="id_person", referencedColumnName="id", nullable=false)
     * @var Person
     */
    private $person = null;

    /**
     * @ORM\OneToOne(targetEntity="ShipTo", mappedBy="shipOrder")
     * @var ShipTo
     */
    private $shipTo = null;

    /**
     * @ORM\OneToMany(targetEntity="Item", mappedBy="shipOrder")
     * @var Item[]
     */
    private $items = [];

    /**
     *
     */
    public function __construct(
    ) {
        $this->items = new ArrayCollection([]);
    }

    /**
     * Assign the entity with the array data
     * @param array $data The entity information data do be filled
     * @param EntityManagerInterface $entityManager
     */
    public function assign(array $data, EntityManagerInterface $entityManager)
    {
        $data['shipTo']['shipOrder'] = $this;
        $this->id = $data['id'] ?? $this->id;
        $this->person = $entityManager->getRepository(Person::class)->find($data['person']);
        $shipTo = $entityManager->getRepository(ShipTo::class)->findOneBy(array('shipOrder' => $this));
        $this->shipTo = ($shipTo ? : new ShipTo())->assign($data['shipTo']);
        
        $this->items->clear();
        foreach ($data['items'] as $item) {
            $itemDb = $entityManager->getRepository(Item::class)->findOneBy(array('shipOrder' => $this));
            $itemEntity = ($itemDb ?: new Item())->assign([
                'shipOrder' => $this,
                'title' => $item['title'],
                'note' => $item['note'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
            $this->items->add($itemEntity);
        }
    }

    /**
     *
     * @param EntityManagerInterface $entityManager
     */
    public function persist(EntityManagerInterface $entityManager)
    {
        $entityManager->persist($this);
        $entityManager->persist($this->shipTo);
        foreach ($this->items as $item) {
            $entityManager->persist($item);
        }
    }
}
