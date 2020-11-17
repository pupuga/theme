<?php

namespace Pupuga\Modules\RestApiClient;

use Pupuga\Libs\Files;
use Pupuga\Core\Options\OptionPage;

class AddFields {

	public static $instance;
	private $config;

	static public function app()
	{
		if (self::$instance === null) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	private function __construct()
	{
		$this->setConfig();
		$this->addOptionPage(array(
			'parent' => 'options-general.php',
			'title' => $this->config->title,
			'slug' => $this->config->slug
		));
	}

	private function setConfig()
	{
		$this->config = Params::app()->getConfig();
	}

	private function addOptionPage($config)
	{
		$htmlFields = Files\Files::getTemplate(__DIR__."/templates/admin/fields-config.php", false, array(
			'slug' => $this->config->slug,
			'fields' => array(
				'config' => array (
					'type' => 'xml',
					'title' => 'Config'
				),
			)
		));

		new OptionPage($config, __DIR__.'/templates/admin/option-page.php', array(
			'html-fields' => $htmlFields
		));
	}

}