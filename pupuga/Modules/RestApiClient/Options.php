<?php

namespace Pupuga\Modules\RestApiClient;

class Options
{
	public static $instance;
	private $updatingDateName = 'client_updating_date';

	private function __construct()
	{
	}

	static public function app() : self
	{
		if (self::$instance === null) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function saveUpdatingDate()
	{
		update_option($this->updatingDateName, current_time('d-m-Y H:i:s'));
	}

	public function echoIntoAdminBar()
	{
		add_action( 'admin_bar_menu', array($this, 'echoUpdatingDate'), 100);
	}

	function echoUpdatingDate( $adminBar ) {
		$htmlDate = 'Обновление МФО: ' . get_option($this->updatingDateName, '');
		$args = array(
			'title' => $htmlDate,
			'meta' => array(
				'class' => 'admin-bar-text',
			),
		);
		$adminBar->add_node( $args );
	}
}