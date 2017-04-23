<?php

namespace Raptor\Server\Initializers;

use Raptor\Interfaces\InitializerInterface;
use Dotenv\Dotenv;

class DotEnvInitializer implements InitializerInterface
{
	/**
	 * Initializes the server configuration.
	 *
	 * @return void
	 */
	public static function init($path = null)
	{
		$dotenv = new Dotenv($path);
		$dotenv->load();
	}
}