<?php

namespace Pupuga\Core\Carbon;

use Carbon_Fields\Container;
use Carbon_Fields\Field;

class Register {
	private $title;
	private $slug;
	private $fieldsData;

	public function __construct( $title, $slug, $fieldsData )
	{
		$this->title      = $title;
		$this->slug       = $slug;
		$this->fieldsData = $fieldsData;
	}

	public function hook( $object = '', $method = 'register' )
	{
		$object = $object ?: $this;
		add_action( 'carbon_fields_register_fields', array( $object, $method ) );
	}

	public function register()
	{
		if ( count( $this->fieldsData ) ) {
			$fields = array();
			foreach ( $this->fieldsData as $key => $fieldData ) {
				$fieldDataAdmin = $fieldData['admin'];
				if ( is_array( $fieldDataAdmin ) && count( $fieldDataAdmin ) ) {
					$field = Field::make( $fieldData['type'], "{$this->slug}_{$key}", "{$fieldDataAdmin['title']} -- {$key}" );
					if ( isset( $fieldData['options'] ) && is_array( $fieldData['options'] ) ) {
						$field->add_options( $fieldData['options'] );
					}
					if ( isset( $fieldDataAdmin['class'] ) ) {
						$field->set_classes( $fieldDataAdmin['class'] );
					};
					if ( isset( $fieldDataAdmin['default'] ) ) {
						$field->set_default_value( $fieldDataAdmin['default'] );
					};
					$fields[] = $field;
				}
			}
			if ( count( $fields ) ) {
				Container::make( 'post_meta', $this->title )
				         ->where( 'post_type', '=', $this->slug )
				         ->add_fields( $fields );
			}
		}
	}
}