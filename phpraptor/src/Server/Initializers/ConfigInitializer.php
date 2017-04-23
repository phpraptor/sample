<?php

namespace Raptor\Server\Initializers;

use Raptor\Interfaces\InitializerInterface;
use Raptor\Server\Collections\ConfigCollection;

class ConfigInitializer implements InitializerInterface
{
	/**
	 * Initializes the server configuration.
	 *
	 * @return void
	 */
	public static function init($path = null)
	{
		$config = new ConfigCollection;
		$config->replace(
			require realpath($path.'/server.php')
		);
		return $config;
	}
}