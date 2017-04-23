<?php

namespace Raptor\Request\Collections;

use Raptor\Components\Collection;

class QueryCollection extends Collection
{
    /**
     * Constructor.
     */
	public function __construct()
	{
		$this->collection = $_GET;
	}
}