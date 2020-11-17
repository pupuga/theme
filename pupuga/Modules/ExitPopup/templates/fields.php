<?php
/**
 * @var array $params
 */
?>

<div class="exit-popup-config">
    <div class="exit-popup-config__message"></div>
    <?php if ($params['fields']) : ?>
        <div class="exit-popup-config__config-fields">
        <?php foreach ($params['fields'] as $type => $fields) : ?>
            <?php if ($fields) : ?>
                <div class="exit-popup-config__fields-type exit-popup-config__fields-type--<?php echo strtolower($type) ?> exit-popup-config__fields-type--<?php echo $params['types'][$type] ?> display-none">
                    <?php foreach ($fields as $key => $field) : ?>
                        <div class="exit-popup-config__field exit-popup-config__field--<?php echo $key ?>">
                            <label for="<?php echo $key ?>"><?php echo $field['title'] ?></label>
                            <?php if($field['type'] == 'bool') : ?>
                                <input type="checkbox" name="<?php echo $key ?>"<?php if($field['value'] == 'on'): ?> checked<?php endif ?>>
                            <?php else : ?>
                                <input type="<?php echo $field['type'] ?>" name="<?php echo $key ?>" value="<?php echo htmlspecialchars_decode($field['value']) ?>"
                                    <?php if($field['required']):?> required="required"<?php endif ?>
                                    <?php if($field['message']):?> data-message="<?php echo $field['message'] ?>"<?php endif ?>
                                    <?php if($field['default']):?> data-default="<?php echo $field['default'] ?>"<?php endif ?>>
                            <?php endif ?>
                        </div>
                    <?php endforeach ?>
                </div>
            <?php endif ?>
        <?php endforeach ?>
        </div>
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
                'server': '<?php echo carbon_get_theme_option('common_pupuga_configuration_popup_server') ?>',
                'page': '<?php echo Pupuga\Modules\Woocommerce\AccountPage::app()->get()->url ?>',
                'points': <?php echo Pupuga\Modules\Woocommerce\Account::app()->getCustomItemsJs() ?>}
    </script>
</div>