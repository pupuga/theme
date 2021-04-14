<?php
/**
 * @var array $params
 */
?>
<?php
    $marker = '';
    $tabs = array();
?>
<?php foreach ($params['fields'] as $key => $field) : ?>
    <?php if(isset($field['marker']) && !empty($field['marker']) && $field['marker'] != $marker) : ?>
        <?php if(!empty($marker)) : ?></div><?php endif ?>
        <div class = "tab exit-popup-config__tab-content exit-popup-config__tab-content--<?php echo $field['marker'] ?> <?php if(!empty($marker)) : ?>display-none<?php endif ?>">
        <?php
            $marker = $field['marker'];
            $tabs[$marker] = ($field['type'] == 'bool') ? $field['value'] : false;
        ?>
    <?php endif ?>
        <?php Pupuga\Libs\Files\Files::getTemplate(__DIR__ . '/field', true, array('key' => $key, 'field' => $field, 'type' => $params['type'])) ?>
<?php endforeach ?>
<?php if(!empty($field['marker'])) : ?></div><?php endif ?>
<?php if($tabs) : ?>
<?php endif ?>
<?php if($tabs) : ?>
    <div class="tab-titles exit-popup-config__tab-titles">
        <?php $i = 0; foreach ($tabs as $tab => $value) : ?>
            <div class="exit-popup-config__tab-title exit-popup-config__tab-title--<?php echo $tab ?> <?php if(++$i === 1) : ?>exit-popup-config__tab-title--active<?php endif ?> <?php if($value !== false && $value == 0) : ?>exit-popup-config__tab-title--disable<?php endif ?>" data-slug="<?php echo $tab ?>">
                <?php echo ucfirst($tab) ?>
            </div>
        <?php endforeach ?>
    </div>
<?php endif ?>
