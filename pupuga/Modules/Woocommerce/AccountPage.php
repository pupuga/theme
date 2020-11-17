<?php

namespace Pupuga\Modules\Woocommerce;

class AccountPage
{
    private static $instance;
    private $page;

    static public function app()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function get()
    {
        return $this->page;
    }

    private function __construct()
    {
        $this->setPage()
            ->setAccountUrl();
        add_action('parse_query', array($this, 'AccountPage'));
    }

    public function AccountPage(): void
    {
        $queryObjects = get_queried_object();
        $currentId = (isset($queryObjects->ID)) ? $queryObjects->ID : '';
        if ($currentId == $this->page->ID && !empty($currentId) && !empty($this->page->ID)) {
            Assets::app();
        }
    }

    private function setPage(): self
    {
        $this->page = get_post(get_option('woocommerce_myaccount_page_id'));

        return $this;
    }

    private function setAccountUrl(): self
    {
        $this->page->url = get_permalink($this->page->ID);

        return $this;
    }

}