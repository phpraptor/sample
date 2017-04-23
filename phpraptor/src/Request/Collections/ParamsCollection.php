<?php

namespace Raptor\Request\Collections;

use Raptor\Components\Collection;

class ParamsCollection extends Collection
{
    /**
     * Constructor.
     */
	public function __construct()
	{
		if (
			isset($_SERVER['REQUEST_METHOD']) && 
			$_SERVER['REQUEST_METHOD'] === 'POST' && 
			!empty($_POST['_method'])
		) {
			$this->collection = $_POST;
			$this->remove('_method');
		} elseif (
			isset($_SERVER['CONTENT_TYPE']) && 
			$_SERVER['CONTENT_TYPE'] === 'application/x-www-form-urlencoded'
		) parse_str(file_get_contents("php://input"), $this->collection);
			// var_dump(file_get_contents("php://input")); die();
		else $this->collection = $_POST;
	}
}