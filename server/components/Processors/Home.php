<?php

namespace Server\Processors;

class Home
{
	public function index()
	{
		// Return HTML.
		return html('index', [
			'text' => 'Welcome mushti'
		]);
	}

	public function about()
	{
		// Return JSON.
		return json([
			'text' => 'Welcome'
		]);
	}
}