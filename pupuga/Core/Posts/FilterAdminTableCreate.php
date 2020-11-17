<?php

namespace Pupuga\Core\Posts;

abstract class FilterAdminTableCreate
{
    protected static $instance;
    protected $postType = '';
    protected $data;
    protected $placeholder = '';
    protected $identifierSelect = '';
    protected $namePlus = '';

    abstract protected function setData();

    public function __construct()
    {
    }

    public function action()
    {
        add_action('restrict_manage_posts', array($this, 'actionHook'));
    }

    public function actionHook()
    {
        global $post_type;
        if ($this->postType == $post_type) {
            $this->setData();
            $this->echoFilter();
        }
    }

    public function setPostType($postType)
    {
        $this->postType = $postType;

        return $this;
    }

    public function setPlaceholder($placeholder)
    {
        $this->placeholder = $placeholder;

        return $this;
    }

    public function setIdentifierSelect($identifier)
    {
        $this->identifierSelect = $identifier;

        return $this;
    }

    public function setNamePlus($name)
    {
        $this->namePlus = $name;

        return $this;
    }

    protected function getData()
    {
        return $this->data;
    }

    protected function getPlaceholder()
    {
        return $this->placeholder;
    }

    protected function getIdentifierSelect()
    {
        return $this->identifierSelect;
    }

    protected function getGetParameter()
    {
        $get = (isset($_GET[$this->identifierSelect]) && !empty($_GET[$this->identifierSelect])) ? strval($_GET[$this->identifierSelect]) : '';

        return $get;
    }

    protected function getNamePlus()
    {
        return $this->namePlus;
    }

    protected function echoFilter()
    {
        $get = $this->getGetParameter();
        $options = '<option value="">' . $this->placeholder . '</option>';
        foreach ($this->getData() as $id => $name) {
            $selected = ($get == $id) ? 'selected' : '';
            $options .= '<option value="' . $id . '" ' . $selected . '>' . $name . $this->getNamePlus() . '</option>';
        }
        $html = '<select name="' . $this->getIdentifierSelect() . '" class="filter-by-' . $this->getIdentifierSelect() . '">' . $options . '</select>';

        echo $html;
    }
}