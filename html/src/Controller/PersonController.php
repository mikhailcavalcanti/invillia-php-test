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
    public function getPeopleAction()
    {
        $repository = $this->getDoctrine()->getRepository(Person::class);
        $people = $repository->findall();
        return $this->handleView($this->view($people));
    }
}
