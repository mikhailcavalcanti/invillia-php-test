<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use App\Entity\Person;
use App\Form\MovieType;

/**
 * @author Mikhail Cavalcanti <mikhailcavalcanti@gmail.com>
 * Person controller.
 * @Route("/api", name="api_")
 */
class PersonController extends FOSRestController
{

    /**
     * Lists all People.
     * @Rest\Get("/people")
     *
     * @return Response
     */
    public function getMovieAction()
    {
        $repository = $this->getDoctrine()->getRepository(Person::class);
        $people = $repository->findall();
        return $this->handleView($this->view($people));
    }
}
