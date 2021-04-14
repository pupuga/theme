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
        $response = $this->save($_POST, $_FILES);
        echo json_encode(array(
            'done' => 1,
            'error' => $response['error'],
            'message' => ($response['error']) ? 'Something went wrong. Please try again in a few minutes.' : 'Config is saved',
        ));
        exit;
    }

    private function save($valueFields, $valueFiles): array
    {
        $error = 0;
        $fields = array();
        foreach (Fields::app()->get() as $items) {
            $fields = array_merge($fields, $items);
        }
        $count = count($fields);
        if ($count) {
            foreach ($fields as $key => $field) {
                if (!isset($valueFields[$key]) && !isset($valueFiles[$key])) {
                    $error = 1;
                    break;
                }
            }

            if ($error === 0) {
                foreach ($fields as $key => $field) {
                    $value = '';
                    if($field['type'] == 'image') {
                        if(isset($valueFiles[$key])) {
                            $ext = explode('.', $valueFiles[$key]['name'])[1];
                            $dir = wp_upload_dir();
                            $file = md5(time() . rand()) . '.' . $ext;
                            $full = $dir['path'] . '/' . $file;
                            $value = $dir['subdir'] . '/' . $file;
                            if(strpos($valueFiles[$key]['type'], 'svg') === false) {
                                $image = wp_get_image_editor($valueFiles[$key]['tmp_name']);
                                $image->resize( 200, 100, false);
                                $resize = $image->save();
                                $tmp = $resize['path'];
                                rename($tmp, $full);
                            } else {
                                move_uploaded_file($valueFiles[$key]['tmp_name'], $full);
                            }
                            if (is_file($tmp)) {
                                unlink($tmp);
                            }
                            $old = carbon_get_user_meta(Account::app()->get()->ID, Config::app()->getPrefix() . $key );
                            if(!empty($dir['basedir']) && is_file($oldFile = $dir['basedir'] . '/' . $old)) {
                                unlink($oldFile);
                            }
                        }
                    } else {
                        $value = htmlspecialchars(mb_substr($valueFields[$key], 0, 200));
                    }
                    if ($value !== '' || !empty($valueFields[$key])) {
                        update_user_meta(Account::app()->get()->ID, '_' . Config::app()->getPrefix() . $key, $value);
                    }
                }
            }
        }

        return array(
            'error' => $error === 0 ? 0 : $error,
        );
    }
}