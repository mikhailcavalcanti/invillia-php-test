<?php

namespace App\Controller;

/**
 * Description of UploadController
 *
 * @author Mikhail Cavalcanti <mikhailcavalcanti@gmail.com>
 */

use App\Service\UploadService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Description of UploadController
 *
 * @author Mikhail Cavalcanti <mikhailcavalcanti@gmail.com>
 */
class UploadController extends AbstractController
{

    /**
     * @Route("/upload", name="upload", methods={"GET"})
     */
    public function show()
    {
        return $this->render('upload/index.html.twig');
    }

    /**
     * @Route("/upload", methods={"POST"})
     */
    public function upload(Request $request)
    {
        $output = ['uploaded' => true];
        $output['fileName'] = (new UploadService())->upload(
            $request->files->get('file'),
            $this->getParameter('kernel.project_dir')
        );
        return new JsonResponse($output);
    }
}
