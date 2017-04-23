<?php

use Raptor\Server\Components\Handler;

Handler::get('/', 'Home@index');

Handler::get('/about', 'Home@about');