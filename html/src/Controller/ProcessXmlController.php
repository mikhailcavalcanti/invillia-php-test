<?php

namespace App\Controller;

/**
 * Description of ProcessXmlController
 *
 * @author Mikhail Cavalcanti <mikhailcavalcanti@gmail.com>
 */

use App\Service\ProcessXmlService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ProcessXmlController extends AbstractController
{

    /**
     *
     * @var ProcessXmlService
     */
    private $processXmlService = null;

    /**
     * @param ProcessXmlService $processXmlService
     */
    public function __construct(ProcessXmlService $processXmlService)
    {
        $this->processXmlService = $processXmlService;
    }

    /**
     * @Route("/process-xml/{xmlFileName}", name="processXml", methods={"GET"})
     */
    public function processXml($xmlFileName)
    {
        $output = [ 'success' => false, 'error' => null];
        try {
            $xmlFilePath = $this->getParameter('kernel.project_dir') . "/uploads/{$xmlFileName}";
            $this->processXmlService->processXml($xmlFilePath);
            $output['success'] = true;
        } catch (\Exception $exception) {
            $output['error'] = $exception->getMessage();
        }
        return new JsonResponse($output);
    }
}
