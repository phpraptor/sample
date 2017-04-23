<?php

namespace Raptor\Server\Initializers;

use Raptor\Interfaces\InitializerInterface;
use Raptor\Server\Components\Handler;

class HandlerInitializer implements InitializerInterface
{
	/**
	 * Initializes the handler.
	 *
	 * @return void
	 */
	public static function init($path = null)
	{
		return new Handler($path);
	}
}