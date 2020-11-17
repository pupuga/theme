<?php

namespace Pupuga\Modules\RestApiClient;

final class Image {

	private $postId;
	private $object;
	private $id;

	public function __construct($postId, $object)
	{
		$this->postId = $postId;
		$this->object = $object;
		$this->requireFiles();
		$this->upload();
	}

	private function requireFiles()
	{
		require_once ABSPATH . 'wp-admin/includes/file.php';
		require_once ABSPATH . 'wp-admin/includes/media.php';
		require_once ABSPATH . 'wp-admin/includes/image.php';
	}

	private function upload()
	{
		$this->id = media_sideload_image(
			$this->object->thumbnail,
			$this->postId,
			$this->object->post_title,
			'id'
		);

		if( !is_wp_error($this->id) ){
			update_post_meta( $this->postId, '_thumbnail_id', $this->id );
		}
	}

}
