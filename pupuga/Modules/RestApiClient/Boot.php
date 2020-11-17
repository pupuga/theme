<?php

namespace Pupuga\Modules\RestApiClient;

class Boot
{
	private static $instance;

	static public function app()
	{
		if (self::$instance === null) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	private function __construct()
	{
		define('CONSOLE_LOAD_REST_API_CLIENT', true);
		$dir = explode('wp-content', __DIR__)[0];
		require "{$dir}index.php";
	}
}

Boot::app();