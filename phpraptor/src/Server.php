<?php

namespace Raptor;

use Raptor\Server\Initializers\PathsInitializer;
use Raptor\Server\Initializers\DotEnvInitializer;
use Raptor\Server\Initializers\ConfigInitializer;
use Raptor\Server\Initializers\HandlerInitializer;
use Raptor\Server\Initializers\ProcessorInitializer;

use Raptor\Request;
use Raptor\Response;

use Raptor\Server\Exceptions\InvalidRequestMethodException;
use Raptor\Server\Exceptions\InvalidRequestPathException;
use Raptor\Server\Exceptions\InvalidProcessorClassException;
use Raptor\Server\Exceptions\InvalidProcessorMethodException;

class Server
{
	/**
	 * @var string
	 */
	protected $version = '1.0';

	/**
	 * @var \Raptor\Server\Collections\PathsCollection
	 */
	protected $paths;

	/**
	 * @var \Raptor\Server\Components\Handler
	 */
	protected $handler;

	/**
	 * @var \Raptor\Server\Components\Processor
	 */
	protected $processor;

	/**
	 * @var \Raptor\Server\Components\Output
	 */
	protected $output;
	
	/**
	 * Constructor.
	 */
	function __construct(string $root)
	{
		$this->init($root);
	}

	/**
	 * Initializes the server.
	 *
	 * @return void
	 */
	protected function init(string $root)
	{
		// Initialize .env variables.
		(new \Dotenv\Dotenv($root))->load();

		// Always initialize server paths before anything.
		$this->paths = PathsInitializer::init($root);
		$this->config = ConfigInitializer::init($this->paths->get('config'));
		$this->handler = HandlerInitializer::init($this->paths->get('handlers'));
		$this->processor = ProcessorInitializer::init();
	}

	/**
	 * Get server paths.
	 *
	 * @return \Raptor\Server\Collections\PathsCollection
	 */
	public function paths()
	{
		return $this->paths;
	}

	/**
	 * Get server version.
	 *
	 * @return string
	 */
	public function version()
	{
		return $this->version;
	}

	/**
	 * Processes the request.
	 *
	 * @return void
	 */
	public function process(Request $request)
	{
		try {
			$this->output = $this->processor->process(
				$this->handler->parse($request)
			);
		} catch (InvalidRequestMethodException $e) {
			echo $e->getMessage();
		} catch (InvalidRequestPathException $e) {
			echo $e->getMessage();
		} catch (InvalidProcessorClassException $e) {
			echo $e->getMessage();
		} catch (InvalidProcessorMethodException $e) {
			echo $e->getMessage();
		}
	}

	/**
	 * Sends back the response.
	 *
	 * @return void
	 */
	public function respond()
	{
		if (!$this->output) return false;

		$this->output->render();
	}
}