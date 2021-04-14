<input class="input-field input-field--default" type="<?php echo $params['field']['type'] ?>" name="<?php echo $params['key'] ?>" value="<?php echo htmlspecialchars_decode($params['field']['value']) ?>"
    <?php if(!empty($params['field']['required'])):?> required="required"<?php endif ?>
    <?php if(!empty($params['field']['message'])):?> data-message="<?php echo $params['field']['message'] ?>"<?php endif ?>
    <?php if(!empty($params['field']['default'])):?> data-default="<?php echo $params['field']['default'] ?>"<?php endif ?>
    data-type="<?php echo $params['type'] ?>">