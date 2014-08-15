<?php namespace Ahir\Bookcase\Security;

use ZipArchive, Exception;

class FileSecurity implements SecurityInterface {

    /**
    * Control
    *
    * @return null
    */
    public static function control($file, $tempName)
    {

        try {

            // New Zip Archive
            $zip = new ZipArchive();

            // Creating zip file
            if ($zip->open($tempName, ZipArchive::CREATE)!==TRUE) {
                throw new Exception('Dosya yüklenirken bir hata meydana geldi.');
            }   

            // Adding files
            $zip->addFile($file->getRealPath(), $file->getClientOriginalName());
            $zip->close();
            
        } catch (Exception $e) {
            throw new Exception('Dosya yüklenirken bir hata meydana geldi.');           
        }

    }

}