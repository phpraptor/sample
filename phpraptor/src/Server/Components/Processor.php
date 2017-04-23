<?php

namespace Raptor\Server\Components;

use Raptor\Server\Components\Input;
use Raptor\Server\Components\Output;
use Raptor\Server\Exceptions\InvalidProcessorClassException;
use Raptor\Server\Exceptions\InvalidProcessorMethodException;

class Processor
{
	/**
	 * Process the given input.
	 *
	 * @param  \Raptor\Server\Components\Input $input
	 * @return \Raptor\Server\Components\Output
	 */
	public function process(Input $input)
	{
		$class = $input->class();
		$method = $input->method();

		if (!realpath(server()->paths()->get('processors').'/'.$class.'.php')) {
			throw new InvalidProcessorClassException('The processor class ('.$input->class().') cannot be found.');
		}

		$class = '\Server\Processors\\'.$class;
		$process = new $class;
		
		if (!method_exists($process, $input->method())) {
			throw new InvalidProcessorMethodException('The processor method '.$input->method().' cannot be found.');
		}

		return new Output(
			$process->{$method}()
		);
	}
}