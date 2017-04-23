<?php

namespace Raptor\Server\Components;

class Output
{
	/**
	 * @var mixed
	 */
	protected $payload;

	/**
	 * Contructor
	 */
	public function __construct($payload)
	{
		$this->payload = $payload;
	}

	/**
	 * Get payload.
	 *
	 * @return string
	 */
	public function render()
	{
		if (is_object($this->payload))
			$this->payload->render(); 
		elseif (is_array($this->payload))
			echo json_encode($this->payload);
		else echo $this->payload;
	}
}