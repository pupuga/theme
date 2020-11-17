<?php

namespace Pupuga\Core\Load;

use Pupuga\Libs\Data;

class Widget
{
    /**
     * get Widget
     *
     * @return string $html
     */
    public static function getWidget($name, $echo = false, $params = array())
    {
        global $wp_registered_sidebars;

        $options = array(
            'name' => $name,
            'id' => 'default',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>'
        );

        $name = sanitize_title($name);
        $sidebar = $wp_registered_sidebars[$name];
        $wp_registered_sidebars[$name] = wp_parse_args($options, $sidebar);

        ob_start();
        dynamic_sidebar($name);
        $html = ob_get_clean();
        $html = Data\Html::transformHtml($html);
        if (isset($params['class'])) {
            $class = $params['class'];
        } else {
            $class = '';
        }
        $html = '<div class="' . $class . '">' . $html . '</div>';

        if ($echo) {
            echo $html;
        }

        return $html;
    }
}