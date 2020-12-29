<?php

namespace App\Service;

use App\Entity\Person;
use App\Entity\ShipOrder;
use Doctrine\ORM\EntityManagerInterface;
use DomainException;

/**
 * ShipOrderService is the class responsible for the business logic of the ShipOrder domain
 *
 * @author Mikhail Cavalcanti <mikhailcavalcanti@gmail.com>
 */
class ShipOrderService
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
     * Reads a xml file and add the ship orders in it on the database
     * @param string $xmlFilePath The file path to be read
     * @todo Test if file exists
     */
    public function addShipOrdersFromXml($xmlFilePath)
    {
        if (!is_file($xmlFilePath)) {
            throw new DomainException("Xml file doesn't exists in '{$xmlFilePath}'");
        }
        $xmlObject = simplexml_load_file($xmlFilePath);
        $data = json_decode(json_encode($xmlObject), true)['shiporder'];
        foreach ($data as $key => $shipOrder) {
            $items = $shipOrder['items'];
            if ($xmlObject->shiporder->$key->items->item->count() > 1) {
                $items = $shipOrder['items']['item'];
            }
            $shipOrderEntity = $this->find($shipOrder['orderid']) ?? new ShipOrder();
            $shipOrderEntity->assign([
                'id' => $shipOrder['orderid'],
                'person' => $shipOrder['orderperson'],
                'shipTo' => $shipOrder['shipto'],
                'items' => $items,
            ], $this->entityManager);
            $shipOrderEntity->persist($this->entityManager);
        }
        $this->entityManager->flush();
    }

    /**
     *
     * @return ShipOrder ShipOrder entity on the database
     */
    public function find($id)
    {
        return $this->entityManager->getRepository(ShipOrder::class)->find($id);
    }

    /**
     *
     * @return array Array of ship orders entity in the database
     */
    public function findAll()
    {
        return $this->entityManager->getRepository(ShipOrder::class)->findall();
    }
}
