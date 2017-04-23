<?php

namespace Raptor\Server\Components;

use Raptor\Request;
use Raptor\Server\Components\Input;
use Raptor\Server\Collections\HandlersCollection;
use Raptor\Server\Exceptions\InvalidRequestMethodException;
use Raptor\Server\Exceptions\InvalidRequestPathException;

class Handler
{
	/**
	 * @var \Raptor\Request\Collections\HandlersCollection
	 */
	private static $GET;

	/**
	 * @var \Raptor\Request\Collections\HandlersCollection
	 */
	private static $POST;
	
	/**
	 * @var \Raptor\Request\Collections\HandlersCollection
	 */
	private static $PUT;
	
	/**
	 * @var \Raptor\Request\Collections\HandlersCollection
	 */
	private static $PATCH;
	
	/**
	 * @var \Raptor\Request\Collections\HandlersCollection
	 */
	private static $DELETE;
	
	/**
	 * @var \Raptor\Request\Collections\HandlersCollection
	 */
	private static $CLI;
	
	/**
	 * @var string
	 */
	private $path;
	
	/**
	 * Constructor.
	 */
	function __construct($path)
	{
		$this->path = $path;

		$this->init();
	}

	/**
	 * Initializes the handler.
	 *
	 * @return void
	 */
	protected function init()
	{
		self::$GET = new HandlersCollection;
		self::$POST = new HandlersCollection;
		self::$PUT = new HandlersCollection;
		self::$PATCH = new HandlersCollection;
		self::$DELETE = new HandlersCollection;
		self::$CLI = new HandlersCollection;
	}

	/**
	 * Register GET request handler.
	 *
	 * @return void
	 */
	public static function get($path, $processor, $validator = null)
	{
		$path = '/'.trim($path, '/');
		self::$GET->add([
			$path => [
				'path' => $path,
				'processor' => $processor,
				'validator' => $validator,
			]
		]);
	}

	/**
	 * Register POST request handler.
	 *
	 * @return void
	 */
	public static function post($path, $processor, $validator = null)
	{
		$path = '/'.trim($path, '/');
		self::$POST->add([
			$path => [
				'path' => $path,
				'processor' => $processor,
				'validator' => $validator,
			]
		]);
	}

	/**
	 * Register PUT request handler.
	 *
	 * @return void
	 */
	public static function put($path, $processor, $validator = null)
	{
		$path = '/'.trim($path, '/');
		self::$PUT->add([
			$path => [
				'path' => $path,
				'processor' => $processor,
				'validator' => $validator,
			]
		]);
	}

	/**
	 * Register PATCH request handler.
	 *
	 * @return void
	 */
	public static function patch($path, $processor, $validator = null)
	{
		$path = '/'.trim($path, '/');
		self::$PUT->add([
			$path => [
				'path' => $path,
				'processor' => $processor,
				'validator' => $validator,
			]
		]);
	}

	/**
	 * Register DELETE request handler.
	 *
	 * @return void
	 */
	public static function delete($path, $processor, $validator = null)
	{
		$path = '/'.trim($path, '/');
		self::$DELETE->add([
			$path => [
				'path' => $path,
				'processor' => $processor,
				'validator' => $validator,
			]
		]);
	}

	/**
	 * Register CLI request handler.
	 *
	 * @return void
	 */
	public static function command($path, $processor, $validator = null)
	{
		$path = '/'.trim($path, '/');
		self::$CLI->add([
			$path => [
				'path' => $path,
				'processor' => $processor,
				'validator' => $validator,
			]
		]);
	}

	/**
	 * Parses the given request.
	 *
	 * @param  \Raptor\Request $request
	 * @return \Raptor\Server\Components\Input
	 */
	public function parse(Request $request)
	{
		if ($request->cli()) {
			include realpath($this->path.'/console.php');
		} else {
			require realpath($this->path.'/web.php');
		}

		$path = $request->path();
		$method = $request->method();

		if (!isset(self::${$method})) {
			throw new InvalidRequestMethodException('The request method '.$method.' is not supported by Raptor Handler.');
		} elseif (self::${$method}->get($path) === null) {
			throw new InvalidRequestPathException('The resource '.$path.' you are looking for cannot be found.');
		}

		$parsed = explode('@', self::${$request->method()}->get($path)['processor']);
		return isset($parsed[1]) ? new Input($parsed[0], $parsed[1]) : new Input($parsed[0]);
	}
}