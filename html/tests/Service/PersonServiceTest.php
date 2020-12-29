<?php

namespace App\Tests\Service;

use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * PersonServiceTest is the test class for the PersonService Class
 *
 * @author Mikhail Cavalcanti <mikhailcavalcanti@gmail.com>
 */
final class PersonServiceTest extends KernelTestCase
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
    
    public function testProcessPeopleXml()
    {
        $service = new \App\Service\PersonService($this->entityManager, self::bootKernel()->getContainer());
        $peopleBeforeOperation = $service->findAll();
        $xmlFilePath = realpath(implode(DIRECTORY_SEPARATOR, [__DIR__, 'Assets', 'people.xml']));
        $service->addPeopleFromXml($xmlFilePath);
        $peopleAfterOperation = $service->findAll();

        $this->assertCount(3, $peopleBeforeOperation);
        $this->assertCount(3, $peopleAfterOperation);
    }
}
