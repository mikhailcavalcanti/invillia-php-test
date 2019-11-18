<?php

namespace App\Tests\Service;

use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * ShiporderServiceTest is the test class for the ShiporderService Class
 *
 * @author Mikhail Cavalcanti <mikhailcavalcanti@gmail.com>
 */
final class ShiporderServiceTest extends KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    protected function setUp()
    {
        $kernel = self::bootKernel();
        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    protected function tearDown()
    {
        parent::tearDown();
        // doing this is recommended to avoid memory leaks
        $this->entityManager->close();
        $this->entityManager = null;
    }
    
    public function testProcessShipOrderXml()
    {
        $service = new \App\Service\ShipOrderService($this->entityManager);
        $shipOrdersTotalBeforeOperation = $service->findAll();
        $xmlFilePath = realpath(implode(DIRECTORY_SEPARATOR, [__DIR__, 'Assets', 'shiporders.xml']));
        $service->addShipOrdersFromXml($xmlFilePath);
        $shipOrdersTotalAfterOperation = $service->findAll();

        $this->assertCount(0, $shipOrdersTotalBeforeOperation);
        $this->assertCount(3, $shipOrdersTotalAfterOperation);
    }
}
