<?php

namespace Raptor\Server\Collections;

use Raptor\Components\Collection;

class ConfigCollection extends Collection
{
    /**
     * Constructor.
     */
	public function __construct()
	{
		$this->collection = [];
	}
}