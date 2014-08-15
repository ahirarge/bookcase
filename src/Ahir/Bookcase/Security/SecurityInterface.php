<?php namespace Ahir\Bookcase\Security;

interface SecurityInterface {

	/**
	 * Control 
	 *
	 * @param  string 	$file
	 * @param  string 	$tempName
	 * @return null
	 */
	public static function control($file, $tempName);

}