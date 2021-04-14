<?php

namespace Pupuga\Modules\ExitPopup;

final class Config
{
    private $title = 'Exit popup';
    private $prefix = 'exit_popup_';
    private $main = '';
    private static $instance = null;

    private function __construct()
    {
        $this->setMain();
    }

    public static function app(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getPrefix(): string
    {
        return $this->prefix;
    }

    public function getMain(): string
    {
        return $this->main;
    }
    private function setMain()
    {
        $this->main = $this->prefix . 'main';
    }
}