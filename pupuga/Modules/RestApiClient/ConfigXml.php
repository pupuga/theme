<?php

namespace Pupuga\Modules\RestApiClient;

use Pupuga\Libs\{Db\Connect, Data\Xml};
use Pupuga\Core\Db\GetData;

class ConfigXml {
	private static $instance;
	/** @var ParamsStdClass */
	private $config;
	private $sql;
	private $configXml;

	private function __construct()
	{
		$this->setConfig();
		$this->setSql();
		$this->set();
		$this->setConfigServer();
	}

	public static function app(): self
	{
		if ( self::$instance === null ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function getToken()
	{
		return strval( $this->configXml->token );
	}

	public function getRequests()
	{
		return $this->configXml->requests->request;
	}

	private function setConfig(): void
	{
		$this->config = Params::app()->getConfig();
	}

	private function setConfigServer(): void
	{
		Params::app()->server = strval($this->configXml->server);
	}

	private function setSql(): void
	{
		$this->sql = "
            SELECT option_value 
            FROM table.options 
            WHERE option_name = '{$this->config->slug}'
        ";
	}

	private function set(): void
	{
		//$this->configXml = Xml::xmlToObjects( Connect::app()->getDataFromQuery( $this->sql )[0] );
		$this->configXml = Xml::xmlToObjects( GetData::app()->getResults( $this->sql )[0]->option_value );
	}
}