<?php

namespace Raptor\Server\Responses;

class Html
{
	private $data;
	private $file;

	public function __construct(array $data, string $file)
	{
		$this->data = $data;
		$this->file = $file;
	}

	public function render()
	{
		foreach ($this->data as $name => $value) {
			${$name} = $value;
		}
		include $this->file;
	}
}