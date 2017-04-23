<?php

namespace Raptor\Server\Initializers;

use Raptor\Interfaces\InitializerInterface;
use Raptor\Server\Components\Processor;

class ProcessorInitializer implements InitializerInterface
{
	/**
	 * Initializes the handler.
	 *
	 * @return void
	 */
	public static function init($config = null)
	{
		return new Processor;
	}
}