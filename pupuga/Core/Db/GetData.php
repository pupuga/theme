<?php

namespace Pupuga\Core\Db;

use Pupuga;

class GetData
{
	protected $sql;
	private $wpdb;
	private static $instance;

    private function __construct()
    {
		global $wpdb;
		$this->wpdb = $wpdb;
	}

    public static function app(): self
    {
        self::$instance = new self();
        return self::$instance;
    }

	public function query($sql)
	{
		return $this->wpdb->query($this->setSql($sql));
	}

    public function getResults($sql)
    {
		return $this->wpdb->get_results($this->setSql($sql));
	}

	public function getSql($sql)
    {
        return $this->setSql($sql);
    }

	private function getParams()
	{
		return array (
			'table.options' => $this->wpdb->options,
			'table.posts' => $this->wpdb->posts,
			'table.postmeta' => $this->wpdb->postmeta,
			'table.terms' => $this->wpdb->terms,
			'table.taxonomy' => $this->wpdb->term_taxonomy,
			'table.relationships' => $this->wpdb->term_relationships,
                        'table.usermeta' => $this->wpdb->usermeta
		);
	}

	private function setSql($sql)
	{
		$params = $this->getParams();
		$this->sql = str_replace(array_keys($params), array_values($params), $sql);

		return $this->sql;
	}


}