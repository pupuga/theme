<?php
/**
 * @var array $params
 */


?>
<div class="exit-popup-config">
    <div class="exit-popup-config__message"></div>
    <?php if ($params['fields']) : ?>
        <form action="/" class="exit-popup-config__config-fields" method="post" enctype="multipart/form-data">
        <?php foreach ($params['fields'] as $type => $fields) : ?>
            <?php if ($fields) : ?>
                <div class="exit-popup-config__fields-type exit-popup-config__fields-type--<?php echo strtolower($type) ?> exit-popup-config__fields-type--<?php echo $params['types'][$type] ?> display-none">
                    <?php echo Pupuga\Libs\Files\Files::getTemplate(__DIR__ . '/fields', true, array('fields' => $fields, 'type' => $params['types'][$type])) ?>
                </div>
            <?php endif ?>
        <?php endforeach ?>
        </form>
    <?php endif ?>
    <div class="exit-popup-config__generated-data">
        <textarea class="exit-popup-config__code" readonly></textarea>
        <button class="pupuga-button exit-popup-config__button-copy display-none"><?php _e('Copy') ?> code</button>
    </div>
    <div class="exit-popup-config__buttons">
        <button class="pupuga-button exit-popup-config__button-save"><?php _e('Save') ?> config</button>
        <button class="pupuga-button exit-popup-config__button-generate"><?php _e('Generate') ?> & <?php _e('Copy') ?> code</button>
        <button class="pupuga-button exit-popup-config__button-download"><?php _e('Download') ?> data.js</button>
        <button class="pupuga-button exit-popup-config__button-reset"><?php _e('Reset to default') ?></button>
    </div>
    <script>const popUpConfig = {
                'server': '<?php echo carbon_get_theme_option(Pupuga\Modules\ExitPopup\Config::app()->getPrefix() . 'popup_server') ?>',
                'page': '<?php echo Pupuga\Modules\Woocommerce\AccountPage::app()->get()->url ?>',
                'points': <?php echo Pupuga\Modules\Woocommerce\Account::app()->getCustomItemsJs() ?>}
    </script>
</div>