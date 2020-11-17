<?php

namespace Pupuga\Core\Customizer;

use Pupuga;

class Init
{
	private $customize;
	private $removeSection = array();
	private $addSection = array();
	private $addSetting = array();
	private $addControl = array();

	public function __construct()
	{
	}

	public function setRemoveSection(array $slug = array())
	{
		return $this;
	}

	public function addSlugSection()
	{
		return $this;
	}

	public function addSlugSetting()
	{
		return $this;
	}

	public function setAddSection()
	{
		return $this;
	}

	public function setAddSetting()
	{
		return $this;
	}

	public function setAddControl()
	{
		return $this;
	}

	public function action()
	{
		add_action( 'customize_register', array($this, 'addAction'));
	}

	public function addAction($customize)
	{
		$this->customize = $customize;
		$this->removeSection();
		$this->addSection();
		$this->addSetting();
		$this->addControl();
	}

	private function removeSection(array $slugs = array())
	{
		if (count($slugs)) {
			foreach ($slugs as $slug) {
				$this->customize->remove_section($slug);
			}
		}
	}

	private function addSection()
	{
		$title = $slug = $priority = 1000;
		$this->customize->add_section( $slug , array(
			'title'      => $title,
			'priority'   => $priority,
		) );
	}

	private function addSetting()
	{
		$this->customize->add_setting( 'background_color' , array(
			'default'     => '#43C6E4',
			'transport'   => 'refresh',
		) );

	}

	private function addControl()
	{
		$this->customize->add_control( new \WP_Customize_Color_Control( $this->customize, 'background_color', array(
			'label'        => 'Background Color',
			'section'    => 'cd_colors',
			'settings'   => 'background_color',
		)));
	}
}