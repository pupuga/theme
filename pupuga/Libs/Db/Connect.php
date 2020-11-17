<?php

namespace Pupuga\Libs\Db;

class Connect
{
    private $host = DB_HOST;
    private $db = DB_NAME;
    private $user = DB_USER;
    private $password = DB_PASSWORD;
	private $prefix;
    private $connect;
    private static $instance;

    private function __construct()
    {
        $this->connect = new \mysqli($this->host, $this->user, $this->password, $this->db);
        if ($this->connect->connect_errno) {
            die('Mysqli connect error');
        } else {
            $this->connect->set_charset('utf8');
        }
    }

    public function __destruct()
    {
        $this->connect->close();
    }

    public static function app() : self
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getDataFromQuery($sql, $key = false)
    {
	    return $this->data($sql, $key);
    }

	private function data($sql, $key = false)
	{
		$data = array();
		$result = $this->query($sql);
		while ($row = $result->fetch_assoc()) {
			$row = (is_array($row) && count($row) == 1) ? array_shift($row) : $row;
			if ($key) {
				$data[$row[$key]] = $row;
			} else {
				$data[] = $row;
			}
		}
		$result->free();

		return $data;
	}

	private function query($sql)
	{
		return $this->connect->query($this->replacePatterns($sql));
	}

	private function replacePatterns($sql) : string
	{
		$this->prefix = ((defined('PREFIX')) ? PREFIX : 'wp') . '_';

		$prepareArray = array(
			'table.options' => "{$this->prefix}options",
			'table.posts' => "{$this->prefix}post",
			'table.postmeta' => "{$this->prefix}postmeta"
		);

		return str_replace(array_keys($prepareArray), array_values($prepareArray), $sql);
	}
}