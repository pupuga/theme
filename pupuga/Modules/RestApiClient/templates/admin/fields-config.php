<div class="option-fields rest-api-server">
    <?php if (count($params['fields'])) : ?>
        <?php foreach ($params['fields'] as $name => $field) : ?>
            <div class="option-fields__row rest-api-server__row">
                <?php if (count($params['fields']) > 1) : ?>
                    <div class="option-fields__title rest-api-server__title"><strong><?php echo $field['title'] ?></strong></div>
                <?php endif ?>
                <div class="option-fields__field rest-api-server__field">
                    <textarea name="<?php echo $params['slug'] . '[' . $name . ']' ?>" data-type="<?php echo $field['type'] ?>" class="option-fields__form rest-api-server__form code-mirror-field"><?php echo esc_attr(get_option($params['slug'])[$name]) ?></textarea>
                    <?php if(!empty($field['description'])) : ?>
                        <div class="option-fields__description"><i><?php echo $field['description'] ?></i></div>
                    <?php endif ?>
                </div>
            </div>
        <?php endforeach ?>
    <?php endif ?>
</div>