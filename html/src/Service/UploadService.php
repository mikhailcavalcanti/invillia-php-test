<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Description of UploadService
 *
 * @author Mikhail Cavalcanti <mikhailcavalcanti@gmail.com
 */
class UploadService
{

    /**
     *
     * @param UploadedFile $file
     * @param string $baseDir
     * @return string
     * @throws \DomainException
     */
    public function upload(UploadedFile $file, string $baseDir)
    {
        $fileName =  sprintf(
            '%s %s.%s',
            (new \DateTime())->format("Y-m-d H:i:s"),
            $file->getClientOriginalName(),
            $file->guessExtension()
        );
        $uploadDir =  $baseDir . '/uploads/';
        if (!file_exists($uploadDir) && !is_dir($uploadDir)) {
            mkdir($uploadDir, 0775, true);
        }
        if (! $file->move($uploadDir, $fileName)) {
            throw new \DomainException('Upload fail');
        }
        return $fileName;
    }
}
