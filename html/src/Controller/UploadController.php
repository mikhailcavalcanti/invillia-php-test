<?php

namespace App\Controller;

/**
 * Description of DefaultController
 *
 * @author Mikhail Cavalcanti <mikhailcavalcanti@gmail.com>
 */
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use \FOS\RestBundle\Controller\AbstractFOSRestController;

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
    public function upload()
    {
        $fieldInformations = [
            'people' => [
                'fieldName' => 'peopleXmlFile',
                'uploadedFilePath' => null
                ],
            'shipOrders' => [
                'fieldName' => 'shipOrdersXmlFile',
                'uploadedFilePath' => null
            ]
        ];
        $isEverythingOk = true;
        foreach ($fieldInformations as &$fieldInformation) {
            $uploadDir = '/var/www/html/uploads/';
            $basename = basename($_FILES[$fieldInformation['fieldName']]['name']);
            $uploadFile = $uploadDir . $basename;
            if (move_uploaded_file($_FILES[$fieldInformation['fieldName']]['tmp_name'], $uploadFile)) {
                $fieldInformation['uploadedFilePath'] = $uploadFile;
                $this->addFlash('success', "File '{$basename}' uploaded successfully");
            } else {
                $isEverythingOk = false;
                $this->addFlash('success', "Sorry, something went wrong with '{$basename}' file");
            }
        }
        if ($isEverythingOk) {
            $personService = new \App\Service\PersonService($this->getDoctrine()->getManager());
            $shipOrderService = new \App\Service\ShipOrderService($this->getDoctrine()->getManager());
            $personService->addPeopleFromXml($fieldInformations['people']['uploadedFilePath']);
            $shipOrderService->addShipOrdersFromXml($fieldInformations['shipOrders']['uploadedFilePath']);
        }
        return $this->redirect($this->generateUrl('upload'));
    }
}
