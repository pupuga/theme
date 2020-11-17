<?php

namespace Pupuga\Core\Base;

use Pupuga\Libs\Files;
use Pupuga\Libs\Data\Html;

/**
 * If template name is empty, template will be equal slug
 *
 * Method boot returns data array. If you want to use loop, you can use in main template - $params->getLoop()
 * Loop template is named like {main template name}-one. In the template use var $params.
 *
 */

abstract class Controller
{
    public $alias;
    public $atts;
    public $content;
    public $data;
    public $pathTemplates;
    public $template;

    abstract protected function boot();

    public function __construct($pathTemplates = null)
    {
        $this->pathTemplates = $pathTemplates;
        $this->init();
    }

    public function init()
    {
        $this->setVars();
        $this->hook();
    }

    protected function setVars()
    {
        $aliasArray = explode('\\', strtolower(get_class($this)));
        $aliasArrayCount = count($aliasArray);
        $this->alias = strval($aliasArray[$aliasArrayCount - 2]);
        $dir = constant('DIR_' . strtoupper($aliasArray[$aliasArrayCount - 3]));
        $this->pathTemplates = $this->pathTemplates ?: $dir . ucfirst($this->alias) . '/templates/';
    }

    protected function hook()
    {
        add_shortcode($this->alias, array($this, 'shortCode'));
    }

    public function shortCode($atts, $content = null)
    {
        $html = $this->getHtml($atts, $content);

        return $html;
    }

    public function getHtml($atts = array(), $content = null)
    {
        $this->atts = $atts;
        $this->content = $content;
        $this->data = $this->boot();

        $this->template = (isset($this->atts['template']) && $this->atts['template']) ? $this->atts['template'] : $this->alias;
        $html = Files\Files::getTemplate($this->pathTemplates . $this->template, false, $this);
        $html .= $content ?? '';

        return $html;
    }

    public function getShortCodeContent()
    {
        $content = (isset($this->content) && !empty($this->content)) ? Html::transformHtml($this->content) : '';

        return $content;
    }

    public function getLoop($dataParams = null, $template = null)
    {
        $html = '';
        if (is_null($template)) {
            $template = $this->template . '-one';
        }
        $dataParams = $dataParams ?: $this->data;
        foreach ($dataParams as $data) {
            $html .= Html::transformHtml(Files\Files::getTemplate($this->pathTemplates . $template, false, $data));
        }

        return $html;
    }
}