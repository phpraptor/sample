<?php

namespace Raptor\Server\Components;

class Input
{
	/**
	 * @var string
	 */
	protected $class;

	/**
	 * @var string
	 */
	protected $method;

	/**
	 * Contructor
	 */
	public function __construct(string $class, string $method = 'index')
	{
		$this->class = $class;
		$this->method = $method;
	}

	/**
	 * Get class.
	 *
	 * @return string
	 */
	public function class()
	{
		return $this->class;
	}

	/**
	 * Get method.
	 *
	 * @return string
	 */
	public function method()
	{
		return $this->method;
	}
}