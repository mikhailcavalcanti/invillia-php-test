<?php

namespace App\Controller;

use App\Entity\Person;
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
     * Lists all People.
     * @Rest\Get("/people")
     *
     * @return Response
     */
    public function list()
    {
        $repository = $this->getDoctrine()->getRepository(Person::class);
        return $this->handleView($this->view($repository->findall()));
    }

    /**
     * Lists one person by id.
     * @Rest\Get("/people/{id}")
     *
     * @return Response
     */
    public function find($id)
    {
        $repository = $this->getDoctrine()->getRepository(Person::class);
        return $this->handleView($this->view($repository->find($id)));
    }
}
