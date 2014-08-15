<?php namespace Ahir\Bookcase\Security;

use Exception;

class ImageSecurity implements SecurityInterface {

	/**
	 * Control 
	 *
	 * @param  string 	$file
	 * @param  string 	$tempName
	 * @return null
	 */
	public static function control($file, $tempName)
	{
        // Ger Image Sizes
        list($width, $height) = getimagesize($file->getRealPath());
        try {
	        // Create destination image widt standard sizes
	        $destination = imagecreatetruecolor($width, $height);
	        // Create strem data of uploaded file
	        $stream = imagecreatefromstring(file_get_contents($file->getRealPath()));
	        // Copy and save
	        imagecopy($destination, $stream, 0, 0, 0, 0, $width, $height);
	        imagejpeg($destination, $tempName, 100);            	
        } catch (Exception $e) {
			throw new Exception('Dosya yüklenirken bir hata meydana geldi.');			
        }

	}

}