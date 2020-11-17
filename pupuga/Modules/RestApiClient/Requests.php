<?php

namespace Pupuga\Modules\RestApiClient;

use Pupuga\Libs\Curl\Curl;

class Requests {

	private $urls;
	private static $instance;

	public static function app($urls, $json): self
	{
		if ( self::$instance === null ) {
			self::$instance = new self($urls, $json);
		}

		return self::$instance;
	}

	private function __construct($urls, $json)
	{
		$this->urls = $urls;
		$this->run($json);
	}

	private function run($json)
	{
		if (count($this->urls)) {
			foreach ($this->urls as $url) {
				$responseObjects = (new Curl())->get($url);
				new SaveToDb($responseObjects);
				if ($json) {
					$response = array(
						'errors' => 'no'
					);
					header('Access-Control-Allow-Origin: *');
					header("Content-Type: application/json");
					echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
				}
			}
			Options::app()->saveUpdatingDate();
		}
	}
}