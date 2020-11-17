<?php

namespace Pupuga\Modules\RestApiClient;

class Init {

	private $json = false;

	public function __construct()
	{
		if ( is_admin() ) {
			$this->addFields();
		}
		$this->consoleClientRun();
		$this->requestClientRun();
	}

	public function run()
	{
		Requests::app(Urls::app()->get(), $this->json);
		exit;
	}

	private function addFields()
	{
		AddFields::app();
		Options::app()->echoIntoAdminBar();
	}

	private function consoleClientRun()
	{
		if (defined('CONSOLE_LOAD_REST_API_CLIENT') && CONSOLE_LOAD_REST_API_CLIENT) {
			$this->json = false;
			add_action( 'init',  array($this, 'run'), 1000);
		}
	}

	private function requestClientRun()
	{
		if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'update-client') {
			if (isset($_REQUEST['token']) && $_REQUEST['token'] === ConfigXml::app()->getToken()) {
				$this->json = true;
				add_action( 'init',  array($this, 'run'), 1000);
			} else {
				wp_redirect(home_url('404'));
				exit();
			}
		}
	}

}