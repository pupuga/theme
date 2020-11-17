<?php

namespace Pupuga\Core\Load;

use Pupuga\Core\Db\GetData;
use Pupuga\Libs\Files\Files;

class Menus
{
	private $sql;
	private $menu;
	private $name;

	public function __construct($name)
	{
		$this->name = $name;
		$this->setSqlAll();
		$this->set();
	}

	public function get()
	{
		return $this->menu;
	}

	public function getTemplate($template, $class = '', $displayed = array('image', 'title'), $echo = true)
	{
		return Files::getTemplate($template, $echo, array('menu' => $this->get(), 'class' => $class, 'displayed' => $displayed));
	}

	private function setSqlAll()
	{
		$this->sql = "
		SELECT p.ID, p.post_name, p.post_title, pm.meta_value as order_id
		FROM table.posts AS p
		INNER JOIN table.postmeta pm ON p.ID = pm.post_id
		WHERE p.post_type = 'nav_menu_item'
		AND p.post_status = 'publish'
		AND pm.meta_key = '_menu_item_menu_item_parent'
		AND p.ID IN (
				SELECT tr.object_id
				FROM table.taxonomy tt
				INNER JOIN table.terms t ON tt.term_id = t.term_id
				INNER JOIN table.relationships tr ON tt.term_id = tr.term_taxonomy_id
				WHERE tt.taxonomy = 'nav_menu'
				AND t.name = '{$this->name}'
		)
		ORDER BY p.menu_order";
	}

	private function getMeta($id)
	{
		$meta = array();
		$sql = "
		SELECT pm.meta_key, pm.meta_value 
		FROM table.postmeta AS pm
		WHERE pm.post_id = {$id}";
		$items = GetData::app()->getResults($sql);
		if (count($items)) {
			foreach ($items as $item) {
				$meta[$item->meta_key] = $item->meta_value;
			}
		}

		return $meta;
	}

	private function set()
	{
		$menus = array();
		$this->menu = GetData::app()->getResults($this->sql);
		$key = 0;
		foreach ($this->menu as $menu) {
			if ($menu->order_id == 0) {
				$key = $menu->ID;
				$menus[$key] = $menu;
				$menus[$key]->meta = $this->getMeta($menu->ID);
			} else {
				$menus[$key]->items[$menu->ID] = $menu;
				$menus[$key]->items[$menu->ID]->meta = $this->getMeta($menu->ID);
			}
		}
		$this->menu = $menus;
	}
}