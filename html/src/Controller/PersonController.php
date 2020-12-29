<?php

namespace App\Controller;

use App\Entity\Person;
use App\Service\PersonService;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Mikhail Cavalcanti <mikhailcavalcanti@gmail.com>
 * Person controller.
 * @Route("/api", name="api_")
 */
final class PersonController extends AbstractFOSRestController
{

    /**
     *
     * @var PersonService
     */
    private $service = null;

    /**
     * 
     */
    public function __construct(PersonService $service)
    {
        $this->service = $service;
    }

    /**
     * Lists all People.
     * @Rest\Get("/people")
     *
     * @return Response
     */
    public function list(): Response
    {
        return $this->handleView($this->view($this->service->findall()));
    }

    /**
     * Lists one person by id.
     * @Rest\Get("/people/{id}")
     *
     * @return Response
     */
    public function find($id): Response
    {
        return $this->handleView($this->view($this->service->find($id)));
    }
}
