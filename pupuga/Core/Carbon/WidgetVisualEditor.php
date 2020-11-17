<?php

// add widget with visual editor
use Carbon_Fields\Widget;
use Carbon_Fields\Field;

class WidgetVisualEditor extends Widget {

	public function __construct() {
		$this->setup(
			'widget_visual_editor',
			'Visual Editor',
			'Displays a block with visual editor',
			array( Field::make( 'rich_text', 'content', 'Content' ) )
		);
	}

	public function front_end( $args, $instance ) {
		echo $instance['content'];
	}

	public static function register() {
		register_widget( 'WidgetVisualEditor' );
	}

}

add_action( 'widgets_init', 'WidgetVisualEditor::register' );