<?php

namespace Pupuga\Modules\RestApiClient;

use Pupuga\Core\Db\GetData;

class SaveToDb {

	private $data;
	private $existingIds = null;
	private $object;

	public function __construct( $objects )
	{
		$this->setData( $objects );
	}

	private function setData( $objects )
	{
		if (count($objects)) {
			foreach ( $objects as $object ) {
				$this->object      = $object;
				$this->existingIds = is_null($this->existingIds)
					? ( new ExistingIds( $this->object->post_type ) )->get()
					: $this->existingIds;
				$this->action();
			}
		} else {
			$this->existingIds = (new ExistingIds())->get();
			$this->action();
		}
		$this->delete();
	}

	private function setPostData()
	{
		return array(
			'post_date'    => $this->object->post_date,
			'post_author'  => $this->object->post_author,
			'post_status'  => $this->object->post_status,
			'post_type'    => $this->object->post_type,
			'menu_order'   => $this->object->menu_order,
			'post_name'    => $this->object->post_name,
			'post_title'   => $this->object->post_title,
			'post_content' => $this->object->post_content,
			'post_excerpt' => $this->object->post_excerpt,
		);
	}

	private function deleteMetaData($id)
	{
		$sql = "DELETE FROM table.postmeta 
                WHERE post_id = {$id}
                AND meta_key <> 'server_thumbnail_id' 
                AND meta_key <> 'server_id' 
                AND meta_key <> '_thumbnail_id'";
		GetData::app()->query( $sql );
	}

	private function setMetaData()
	{
		$data = array(
			'server_id' => $this->object->id
		);
		foreach ( $this->object->meta as $key => $value ) {
			if ( $key == '_thumbnail_id' ) {
				$data['server_thumbnail_id'] = $value;
			} else {
				$data[ $key ] = $value;
			}
		}

		return $data;
	}

	private function action(): void
	{
		if ( ! isset( $this->existingIds[ $this->object->id ] ) ) {
			$this->insert();
		} elseif ( $this->object->post_modified != $this->existingIds[ $this->object->id ]->modified
		           || $this->object->menu_order != $this->existingIds[ $this->object->id ]->menuOrder) {
			$this->update();
		}
		if (isset( $this->existingIds[ $this->object->id ] )) {
			unset($this->existingIds[ $this->object->id ] );
		}
	}

	private function updateModified( $id ): void
	{
		$sql = "
		UPDATE table.posts 
		SET post_modified = '{$this->object->post_modified}', post_modified_gmt = '{$this->object->post_modified}' 
		WHERE ID = {$id}";
		GetData::app()->query( $sql );
	}

	private function insert(): void
	{
		$this->data               = $this->setPostData();
		$this->data['meta_input'] = $this->setMetaData();
		$id                       = wp_insert_post( $this->data );
		$this->updateModified( $id );
		if ( $id && $this->object->thumbnail ) {
			new Image( $id, $this->object );
		}
	}

	private function update(): void
	{
		$this->data = $this->setPostData();
		$id         = $this->existingIds[ $this->object->id ]->idClient;
		$this->data = $this->data + array( 'ID' => $id );
		wp_update_post( $this->data );
		$this->updateModified($id);
		$this->deleteMetaData($id);
		foreach ( $this->object->meta as $key => $value ) {
			$key = ( $key == '_thumbnail_id' ) ? 'server_thumbnail_id' : $key;
			update_post_meta( $id, $key, $value );
		}
		if ( $id && $this->object->thumbnail && $this->existingIds[ $this->object->id ]->thumbnailId != $this->object->meta->_thumbnail_id ) {
			wp_delete_attachment(get_post_thumbnail_id($id));
			new Image( $id, $this->object );
		}
	}

	private function delete(): void
	{
		if (count($this->existingIds)) {
			foreach ( $this->existingIds as $existingObject ) {
				wp_delete_attachment(get_post_thumbnail_id($existingObject->idClient));
				wp_delete_post( $existingObject->idClient, true );
			}
		};
	}

}