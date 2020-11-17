<?php

namespace Pupuga\Core\Posts;

use Pupuga\Libs\Files;

class GetPosts
{
    /**
     * @var GetPosts
     */
    private static $instance;
    private $args = array();
	private $thumbnailSize;

    public function __construct()
    {
    }

    /**
     * @return $this
     */
    public static function app()
    {
        self::$instance = new self();
        return self::$instance;
    }

    /**
     * @param $arguments
     * @return $this
     */
    public function __call($name, $arguments)
    {
        $this->args[$name] = $arguments;
        return $this;
    }

    /**
     * @param $arguments
     * @return $this
     */
    public function numberPosts($arguments)
    {
        $this->args['numberposts'] = $arguments;
        return $this;
    }

    /**
     * @param $arguments
     * @return $this
     */
    public function offset($arguments)
    {
        $this->args['offset'] = $arguments;
        return $this;
    }

    /**
     * @param $arguments
     * @return $this
     */
    public function category($arguments)
    {
        $this->args = $arguments;
        return $this;
    }

    /**
     * @param $arguments
     * @return $this
     */
    public function taxonomy($arguments)
    {
        foreach ($arguments as $key => $value) {
            $this->args[$key] = $value;
        }
        return $this;
    }

    /**
     * @param $arguments
     * @return $this
     */
    public function taxQuery($arguments)
    {
        $this->args['tax_query'] = $arguments;
        return $this;
    }

    /**
     * @param $arguments
     * @return $this
     */
    public function categoryName($arguments)
    {
        $this->args['category_name'] = $arguments;
        return $this;
    }

    /**
     * @param $arguments
     * @return $this
     */
    public function tag($arguments)
    {
        $this->args['tag'] = $arguments;
        return $this;
    }

    /**
     * @param $arguments
     * @return $this
     */
    public function name($arguments)
    {
        $this->args['name'] = $arguments;
        return $this;
    }

    /**
     * @param $arguments
     * @return $this
     */
    public function orderBy($arguments)
    {
        $this->args['orderby'] = $arguments;
        return $this;
    }

    /**
     * @param $arguments
     * @return $this
     */
    public function order($arguments)
    {
        $this->args['order'] = $arguments;
        return $this;
    }

    /**
     * @param $arguments
     * @return $this
     */
    public function includeWP($arguments)
    {
        $this->args['include'] = $arguments;
        return $this;
    }

    /**
     * @param $arguments
     * @return $this
     */
    public function exclude($arguments)
    {
        $this->args['exclude'] = $arguments;
        return $this;
    }

    /**
     * @param $arguments
     * @return $this
     */
    public function metaKey($arguments)
    {
        $this->args['meta_key'] = $arguments;
        return $this;
    }

    /**
     * @param $arguments
     * @return $this
     */
    public function metaValue($arguments)
    {
        $this->args['meta_value'] = $arguments;
        return $this;
    }

    /**
     * @param $arguments
     * @return $this
     */
    public function metaQuery($arguments)
    {
        $this->args['meta_query'] = $arguments;
        return $this;
    }

    /**
     * @param $arguments
     * @return $this
     */
    public function postType($arguments)
    {
        $this->args['post_type'] = $arguments;
        return $this;
    }

    /**
     * @param $arguments
     * @return $this
     */
    public function postMimeType($arguments)
    {
        $this->args['post_mime_type'] = $arguments;
        return $this;
    }

    /**
     * @param $arguments
     * @return $this
     */
    public function postParent($arguments)
    {
        $this->args['post_parent'] = $arguments;
        return $this;
    }

    /**
     * @param $arguments
     * @return $this
     */
    public function postStatus($arguments)
    {
        $this->args['post_status'] = $arguments;
        return $this;
    }

    /**
     * @param $arguments
     * @return $this
     */
    public function postIn($arguments)
    {
        $this->args['post__in'] = $arguments;
        return $this;
    }

    /**
     * @param $arguments
     * @return $this
     */
    public function noPaging($arguments)
    {
        $this->args['nopaging'] = $arguments;
        return $this;
    }

	/**
	 * @param $size
	 * @return $this
	 */
	public function setThumbnailSize($size = 'full')
	{
		$this->thumbnailSize = $size;
		return $this;
	}

    /**
     *  return array of Objects args
     */
    public function doAction()
    {
        $args = $this->args;
        return get_posts($args);
    }

	/**
	 * include Template
	 */
	public function postsTemplate($posts = null, $template = false, $echo = false, $params = array(), $dir = '')
	{
		$html = '';
		$result = array();

		if (is_null($posts)) {
			$posts = $this->doAction();
		}

		if (count($posts)) {
			$i = 0;
			global $post;
			foreach ($posts as $post) {
				setup_postdata($post);
				$id = $post->ID;
				$params['id'] = $id;
				$params['post'] = $post;
				$params['meta'] = array_map(
					function($value) {
						return (is_array($value) && count($value) === 1) ? $value[0] : $value;
					}, get_post_meta($id));
				$params['thumbnail'] = get_the_post_thumbnail_url($id, $this->thumbnailSize);
				$params['index'] = $i++;
				if ($template === false) {
					$result[] = $params;
				} else {
					$html .= Files\Files::getTemplate($dir . $template, $echo, $params);
				}
			}
		}
		wp_reset_postdata();

		return ($template) ? $html : $result;
	}
}