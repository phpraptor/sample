<?php

namespace Raptor\Request\Collections;

use Raptor\Components\Collection;

class CookiesCollection extends Collection
{
    /**
     * Constructor.
     */
	public function __construct()
	{
		$this->collection = $_COOKIE;
	}
}