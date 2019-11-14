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
    public function getShipOrdesAction()
    {
        $repository = $this->getDoctrine()->getRepository(ShipOrder::class);
        $data = $repository->findall();
        return $this->handleView($this->view($data));
    }
}
