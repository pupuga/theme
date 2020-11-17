<?php

namespace Pupuga\Modules\RestApiClient;

class Urls {

	private $urls = array();
	private static $instance;

	static public function app()
	{
		if (self::$instance === null) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function get() : array
	{
		return $this->urls;
	}

	private function __construct()
	{
		$this->set();
	}

	private function set() : void
	{
		$configXml = ConfigXml::app();
		$requests = $configXml->getRequests();
		if (count(get_object_vars($requests))) {
			$config = Params::app()->getConfig();
			$server = $config->server;
			$point = $config->serverPoint;
			$version = $config->serverVersion;
			$url = "{$server}/{$point}/{$version}/?";
			foreach ($requests as $request) {
				$params = $this->getParams($request);
				if($params['post_modified'] >= date('Y-m-d')) {
					$params['token'] = $configXml->getToken();
					$this->urls[] = $url . http_build_query($params);
				};
			}
		}
	}

	private function getParams($request) : array
	{
		$params = array();
		foreach ($request as $paramsXml) {
			$attributes = strval($paramsXml->attributes());
			$params[$attributes] = strval($paramsXml);
		}

		return $params;
	}

}