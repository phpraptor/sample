<?php

namespace Raptor\Request\Collections;

use Raptor\Components\Collection;

class FilesCollection extends Collection
{
    /**
     * Constructor.
     */
	public function __construct()
	{
		$this->collection = $_FILES;
	}
}