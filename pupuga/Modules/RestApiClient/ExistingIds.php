<?php

namespace Pupuga\Modules\RestApiClient;

use Pupuga\Core\Db\GetData;

final class ExistingIds {

	private $sql = "
	    SELECT p.ID AS idClient, mo.meta_value AS idServer, p.post_modified as modified, p.menu_order as menuOrder, mt.meta_value as thumbnailId
	    FROM table.posts as p 
	    INNER JOIN table.postmeta as mo ON p.ID = mo.post_id
	    INNER JOIN table.postmeta as mt ON p.ID = mt.post_id
	    WHERE 1=1
	    AND mo.meta_key = 'server_id'
	    AND mt.meta_key = 'server_thumbnail_id'
	";
	private $postType;
	private $existingIds = array();

	public function __construct($postType = '')
	{
		$this->postType = $postType;
		$this->setSql();
		$this->getData();
	}

	public function get()
	{
		return $this->existingIds;
	}

	private function setSql()
	{
		$this->sql .= (!empty($this->postType)) ? " AND post_type = '{{postType}}'" : '';
		$patterns = array(
			'{{postType}}' => $this->postType
		);
		$this->sql = str_replace(array_keys($patterns), array_values($patterns), $this->sql);
	}

	private function getData()
	{
		foreach (GetData::app()->getResults($this->sql) as $post) {
			$this->existingIds[$post->idServer] = $post;
		};
	}

}