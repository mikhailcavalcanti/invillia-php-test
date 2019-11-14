<?php

namespace App\Controller;

use App\Entity\ShipOrder;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Mikhail Cavalcanti <mikhailcavalcanti@gmail.com>
 * Ship Order controller.
 * @Route("/api", name="api_")
 */
final class ShipOrderController extends AbstractFOSRestController
{

    /**
     * Lists all People.
     * @Rest\Get("/shiporders")
     *
     * @return Response
     */
    public function list()
    {
        $repository = $this->getDoctrine()->getRepository(ShipOrder::class);
        return $this->handleView($this->view($repository->findall()));
    }

    /**
     * Lists one ship order by id.
     * @Rest\Get("/shiporders/{id}")
     *
     * @return Response
     */
    public function find($id)
    {
        $repository = $this->getDoctrine()->getRepository(ShipOrder::class);
        return $this->handleView($this->view($repository->find($id)));
    }
}
