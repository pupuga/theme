<?php

namespace Pupuga\Modules\Woocommerce;

use Pupuga\Libs\Files\Files;

class Account
{
    private static $instance;
    /*
    'dashboard' => 'Dashboard'
    'orders' => 'Orders'
    'subscriptions' => 'Subscriptions'
    'downloads' => 'Downloads'
    'edit-address' => 'Addresses'
    'edit-account' => 'Account details'
    'customer-logout' => 'Logout'
    */
    private $unsetItems = array('downloads', 'edit-address');
    private $beforeItems = array(
        'dashboard' => array(
            'name' => 'Config',
            'point' => false
        ),
        'styles' => array(
            'name' => 'Styles',
            'point' => false
        ),
        'languages' => array(
            'name' => 'Languages',
            'point' => false
        )
    );
    private $afterItems = array();
    private $currentItem;
    private $customItems = array();

    static public function app(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getCustomMenuItems(): array
    {
        return array_map(function ($value) {
            return strtolower($value['name']);
        }, $this->customItems);
    }

    public function getCustomItemsJs(): string
    {
        return '["' . (($this->customItems) ? implode('","', array_keys($this->customItems)) : '') . '"]';
    }

    private function __construct()
    {
        $this->setCustomMenuItems();
        $this->setMenuItems();
        $this->addPointAndPage();
    }

    private function setCustomMenuItems()
    {
        $this->customItems = $this->beforeItems + $this->afterItems;
    }

    private function setMenuItems(): void
    {
        add_filter('woocommerce_account_menu_items', array($this, 'removeMenuItems'));
        add_filter('woocommerce_account_menu_items', array($this, 'addMenuItems'));
    }

    private function addPointAndPage(): void
    {
        if ($this->customItems) {
            foreach ($this->customItems as $key => $value) {
                $this->currentItem = $key;
                if ($value['point']) {
                    add_action('init', array($this, 'addPoint'));
                    add_action("woocommerce_account_{$this->currentItem}_endpoint", array($this, 'addPage'));
                }
            }
        }
    }

    public function removeMenuItems($items): array
    {
        if (count($this->unsetItems) && count($items)) {
            foreach ($this->unsetItems as $item) {
                if (isset($items[$item])) {
                    unset($items[$item]);
                }
            }
        }

        return $items;
    }

    public function addMenuItems($items): array
    {
        return $this->convertMultiArrayToLineArray($this->beforeItems) + $items + $this->convertMultiArrayToLineArray($this->afterItems);
    }

    private function convertMultiArrayToLineArray(array $multiArray): array
    {
        $lineArray = array();

        if($multiArray) {
            foreach ($multiArray as $key => $value) {
                $lineArray[$key] = $value['name'];
            }
        }
        return $lineArray;
    }

    public function addPoint(): void
    {
        add_rewrite_endpoint( $this->currentItem, EP_ROOT | EP_PAGES );
    }

    public function addPage(): void
    {
        Files::getTemplate(__DIR__ . '/templates/' . $this->currentItem, true, array());
    }
}