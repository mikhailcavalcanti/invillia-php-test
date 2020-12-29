<?php

namespace App\Service;

use App\Service\PersonService;
use App\Service\ShipOrderService;

/**
 * ProcessXmlService is the class responsible for the business logic of the ProcessXmlService domain
 *
 * @author Mikhail Cavalcanti <mikhailcavalcanti@gmail.com>
 */
class ProcessXmlService
{

    /**
     *
     * @var PersonService
     */
    private $personService = null;

    /**
     *
     * @var ShipOrderService
     */
    private $shipOrderService = null;

    /**
     * @param PersonService $personService
     * @param ShipOrderService $shipOrderService
     */
    public function __construct(PersonService $personService, ShipOrderService $shipOrderService)
    {
        $this->personService = $personService;
        $this->shipOrderService = $shipOrderService;
    }

    /**
     *
     * @param string $xmlFilePath
     * @throws Exception
     */
    public function processXml(string $xmlFilePath)
    {
        $xmlObject = simplexml_load_file($xmlFilePath);
        $services = [
            'people' => ['service' => $this->personService, 'method' => 'addPeopleFromXml'],
            'shiporders' => ['service' => $this->shipOrderService, 'method' => 'addShipOrdersFromXml']
        ];
        $service = $services[$xmlObject->getName()]['service'];
        $methodName = $services[$xmlObject->getName()]['method'];
        call_user_func([$service, $methodName], $xmlFilePath);
    }
}
