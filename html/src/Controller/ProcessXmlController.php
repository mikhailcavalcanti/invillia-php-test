<?php

namespace App\Controller;

/**
 * Description of ProcessXmlController
 *
 * @author Mikhail Cavalcanti <mikhailcavalcanti@gmail.com>
 */

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ProcessXmlController extends AbstractController
{

    /**
     * @Route("/process-xml/{xmlFileName}", name="processXml", methods={"GET"})
     */
    public function processXml($xmlFileName)
    {
        $output = [ 'success' => false, 'error' => null];
        try {
            $xmlFilePath = $this->getParameter('kernel.project_dir') . "/uploads/{$xmlFileName}";
            (new \App\Service\ProcessXmlService($this->getDoctrine()->getManager()))->processXml($xmlFilePath);
            $output['success'] = true;
        } catch (\Exception $exception) {
            $output['error'] = $exception->getMessage();
        }
        return new JsonResponse($output);
    }
}
