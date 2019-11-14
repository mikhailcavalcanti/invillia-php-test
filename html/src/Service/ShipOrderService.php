<?php

namespace App\Service;

use App\Entity\Person;
use App\Entity\ShipOrder;
use Doctrine\ORM\EntityManager;
use DomainException;

/**
 * ShipOrderService is the class responsible for the business logic of the Person domain
 *
 * @author Mikhail Cavalcanti <mikhailcavalcanti@gmail.com>
 */
class ShipOrderService
{

    /**
     *
     * @var EntityManager
     */
    private $entityManager;

    /**
     *
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
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
            $personEntity = $this->entityManager->getRepository(Person::class)->find(intval($shipOrder['orderperson']));
            $shipOrderEntity = new ShipOrder($personEntity, $shipOrder['shipto'], $items, $shipOrder['orderid']);
            $shipOrderEntity->persist($this->entityManager);
        }
        $this->entityManager->flush();
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
