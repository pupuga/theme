<?php if($params['field']['options']) : ?>
<select class="input-field input-field--select" name="<?php echo $params['key'] ?>" data-default="<?php echo $params['field']['default'] ?>">
    <?php foreach ($params['field']['options'] as $value) : ?>
        <option value="<?php echo $value ?>" <?php if($params['field']['value'] == $value) :?>selected<?php endif ?>><?php echo ucfirst($value) ?></option>
    <?php endforeach ?>
</select>
<?php endif ?>