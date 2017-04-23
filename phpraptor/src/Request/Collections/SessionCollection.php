<?php

namespace Raptor\Request\Collections;

use Raptor\Components\Collection;

class SessionCollection extends Collection
{
    /**
     * Constructor.
     */
	public function __construct()
	{
		if (!session_id() && PHP_SAPI !== 'cli') {
			session_start();
			$this->collection = $_SESSION;
		} else {
			$this->collection = [];
		}
	}
}