<?php

namespace Pupuga\Core\Options;

use Pupuga\Libs\Files;

class OptionPage
{
    protected $template;
    protected $attributes;
    protected $params;
    protected $function;

    /**
     * @param array $attributes [title, position]
     * @param string $template
     * @param array $params
     *
     * FOR SUBMENU
     * index.php - Dashboard
     * edit.php - Posts
     * upload.php - Media
     * link-manager.php - Links
     * edit.php?post_type=page - Pages
     * edit.php?post_type=your_post_type
     * edit-comments.php - Comments
     * themes.php - Appearance
     * plugins.php - Plugins
     * users.php - Users
     * tools.php - Tools
     * options-general.php - Settings
     * settings.php - Settings
     *
     * FOR MENU
     * 2 – Dashboard
     * 4 – Separator
     * 5 – Posts
     * 10 – Media
     * 15 – Links
     * 20 – Pages
     * 25 – Comments
     * 59 – Separator
     * 60 – Appearance
     * 65 – Plugins
     * 70 – Users
     * 75 – Tools
     * 80 – Settings
     * 99 – Separator
     *
     */
    public function __construct(array $attributes, $template, array $params = array())
    {
        $this->attributes = $attributes;
        $this->attributes['type'] = (isset($attributes['parent'])) ? 'submenu' : 'menu' ;
        $this->attributes['key'] = (isset($this->attributes['slug'])) ? $this->attributes['slug'] : sanitize_title($this->attributes['title']);
        $this->function = 'add_' . $this->attributes['type'] . '_page';
        $this->template = $template;
        $this->params = $params;
        $this->params['settings'] = $this->attributes['key'];
        $this->hooks();
    }

    /**
     * Initiate our hooks
     */
    protected function hooks()
    {
        add_action('admin_init', array($this, 'init'));
        $methodAddItem = 'add' . ucfirst($this->attributes['type']) . 'Item';
        add_action('admin_menu', array($this, $methodAddItem));
    }

    /**
     * Register our setting to WP
     */
    public function init()
    {
        register_setting($this->attributes['key'], $this->attributes['key']);
    }

    public function addMenuItem()
    {
        $function = $this->function;
        $function($this->attributes['title'], $this->attributes['title'], 'manage_options', $this->attributes['key'], array($this, 'getItemPage'), $this->attributes['icon'], $this->attributes['parent']);
    }

    public function addSubmenuItem()
    {
        $function = $this->function;
        $function($this->attributes['parent'], $this->attributes['title'], $this->attributes['title'], 'manage_options', $this->attributes['key'], array($this, 'getItemPage'));
    }

    /**
     * Admin page markup.
     */
    public function getItemPage()
    {
        Files\Files::getTemplate($this->template, true, $this->params);
    }
}