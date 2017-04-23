<?php

namespace Raptor\Server\Responses;

class Json
{
	private $data;

	public function __construct(array $data)
	{
		$this->data = $data;
	}

	public function render()
	{
		header('Content-Type: application/json');
		echo json_encode($this->data);
	}
}