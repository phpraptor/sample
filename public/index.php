<?php

/**
 * Raptor - A PHP Framework For Web Artisans
 *
 * @package  Raptor
 * @author   Mujtaba Alvi <mushti@outlook.com>
 * @author   Jawad Sheikh <jawad.sheikh@outlook.com>
 */

define('LARAVEL_START', microtime(true));

/*
|--------------------------------------------------------------------------
| Register The Composer Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader
| for our application. We just need to utilize it! We'll require it
| into the script here so that we do not have to worry about the
| loading of any of our classes "manually". Feels great to relax.
|
*/

require __DIR__.'/../vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Turn On The Server
|--------------------------------------------------------------------------
|
| We need to turn on the server, so that it can process the request.
| This bootstraps the framework and gets it ready for use.
|
*/

$server = new Raptor\Server(
	__DIR__.'/../'
);

/*
|--------------------------------------------------------------------------
| Process The Request
|--------------------------------------------------------------------------
|
| We need to illuminate PHP development, so let us turn on the lights.
| This bootstraps the framework and gets it ready for use, then it
| will load up this application so that we can run it and send
| the responses back to the browser and delight our users.
|
*/

$server->process(
	$request = new Raptor\Request
);

/*
|--------------------------------------------------------------------------
| Send The Response
|--------------------------------------------------------------------------
|
| We need to illuminate PHP development, so let us turn on the lights.
| This bootstraps the framework and gets it ready for use, then it
| will load up this application so that we can run it and send
| the responses back to the browser and delight our users.
|
*/

$server->respond();
