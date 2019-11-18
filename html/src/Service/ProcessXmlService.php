<?php

namespace App\Service;

use Doctrine\ORM\EntityManager;

/**
 * Description of ProcessXmlService
 *
 * @author mikha
 */
class ProcessXmlService
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
     *
     * @param string $xmlFilePath
     * @throws Exception
     */
    public function processXml(string $xmlFilePath)
    {
        $xmlObject = simplexml_load_file($xmlFilePath);
        $servicesNames = [
            'people' => ['service' => 'PersonService', 'method' => 'addPeopleFromXml'],
            'shiporders' => ['service' => 'ShipOrderService', 'method' => 'addShipOrdersFromXml']
        ];

        $serviceClassName = "App\\Service\\{$servicesNames[$xmlObject->getName()]['service']}";
        $methodName = $servicesNames[$xmlObject->getName()]['method'];

        if (! class_exists($serviceClassName)) {
            throw new Exception("Don't know how to handle this Xml");
        }

        $serviceInstance = new $serviceClassName($this->entityManager);
        $serviceInstance->$methodName($xmlFilePath);
    }
}
