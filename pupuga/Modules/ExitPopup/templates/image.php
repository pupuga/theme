<?php //print_r($params) ?>
<div class="custom-image">
    <div class="custom-image__preview-file">
        <div class="custom-image__preview-image"><img src="<?php echo ($params['field']['value'] ? $params['field']['value'] : $params['field']['default']) ?>" ></div>
        <div class="custom-image__preview-name"><?php //echo basename($image) ?></div>
    </div>
    <label class="custom-image__download">
        <span class="custom-image__download-button"><?php _e('Choose file') ?></span>
        <input class="custom-image__input input-field input-field--image" type="file" name="<?php echo $params['key'] ?>"
            <?php if($params['field']['required']):?> required="required"<?php endif ?>
            <?php if($params['field']['message']):?> data-message="<?php echo $params['field']['message'] ?>"<?php endif ?>
               data-default="<?php echo $params['field']['default'] ?>"
               data-type="<?php echo $params['type'] ?>">
    </label>
</div>