<?php

namespace Raptor\Server\Initializers;

use Raptor\Interfaces\InitializerInterface;
use Raptor\Server\Collections\PathsCollection;

class PathsInitializer implements InitializerInterface
{
	/**
	 * Initializes the sever paths.
	 *
	 * @return \Raptor\Server\Collections\PathsCollection
	 */
	public static function init($root = null)
	{
		$paths = new PathsCollection;
		$paths->replace([
			'root' => realpath($root),
			'config' => realpath($root.'/server/config'),
			'handlers' => realpath($root.'/server/handlers'),
			'processors' => realpath($root.'/server/components/Processors'),
			'middlewares' => realpath($root.'/server/components/Middlewares'),
			'validators' => realpath($root.'/server/components/Validators'),
			'resources' => realpath($root.'/server/resources'),
		]);
		return $paths;
	}
}