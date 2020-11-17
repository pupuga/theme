<?php

namespace Pupuga\Modules\ExitPopup;

final class SaveFields
{
    private static $instance = null;

    public static function app(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct()
    {
        add_action('wp_ajax_account_config', array($this, 'ajax'));
        add_action('wp_ajax_nopriv_account_config', array($this, 'ajax'));
    }

    public function ajax(): void
    {
        $response = $this->save($_POST);
        echo json_encode(array(
            'done' => 1,
            'error' => $response['error'],
            'message' => ($response['error']) ? 'Something went wrong. Please try again in a few minutes.' : 'Config is saved',
        ));
        exit;
    }

    private function save($valueFields): array
    {
        $error = 0;
        $fields = Fields::app()->setSimple()->get();
        $count = count($fields);
        if ($count) {
            foreach ($fields as $key => $field) {
                if (isset($valueFields[$key])) {
                    if (!empty($field['required']) && $valueFields[$key] == '') {
                        $error = 1;
                        break;
                    }
                } else {
                    $error = 1;
                    break;
                }
            }

            if ($error === 0) {
                foreach ($fields as $key => $field) {
                    update_user_meta(Account::app()->get()->ID, '_' . Config::app()->getPrefix() . $key, htmlspecialchars(mb_substr($valueFields[$key], 0, 200)));
                }
            }
        }

        return array(
            'error' => $error === 0 ? 0 : $count,
        );
    }
}