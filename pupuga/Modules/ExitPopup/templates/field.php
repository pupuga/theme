<?php
/**
 * @var array $params
 */
?>
<?php $template = ($params['field']['type'] == 'number' || $params['field']['type'] == 'text' || $params['field']['type'] == 'color')
    ? 'input' : $params['field']['type'] ?>
<div class="exit-popup-config__field exit-popup-config__field--<?php echo $params['key'] ?> exit-popup-config__field--<?php echo $template ?>">
    <label for="<?php echo $params['key'] ?>"><?php echo $params['field']['title'] ?></label>
    <?php Pupuga\Libs\Files\Files::getTemplate(__DIR__ . '/' . $template, true,
        array('key' => $params['key'], 'field' => $params['field'], 'type' => $params['type'])) ?>
</div>