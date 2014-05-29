<?php namespace Ahir\Bookcase\Facades;

use Illuminate\Support\Facades\Facade;

class SecurityInterface extends Facade {

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor() { return 'securityinterface'; }

}