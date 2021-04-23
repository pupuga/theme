<?php global $post; ?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <?php Pupuga\Libs\Files\Files::getTemplate(DIR_TEMPLATES . 'meta', true) ?>
    <?php wp_head() ?>
    <?php //Pupuga\Libs\Files\Files::getCss(DIR_ASSETS . 'skeleton.css', true) ?>
    <script>let globalData = <?php echo Pupuga\Core\Base\Common::app()->getJs() ?></script>
</head>
<body <?php body_class() ?>>
<header class="general__header">
    <div class="block-columns">
        <div class="block-columns__left">
            <?php Pupuga\Libs\Files\Files::getTemplate(DIR_TEMPLATES . 'logo', true, array('class' => 'general__logo')) ?>
        </div>
        <div class="block-columns__right">
            <nav class="lang-list">
                <?php echo Pupuga\Custom\Lang\Languages::app()->getList('select') ?>
            </nav>
            <nav class="menu menu--line">
                <ul>
                    <?php Pupuga\Core\Load\Menu::app()->menuStandard('Main')->action() ?>
                </ul>
            </nav>
        </div>
    </div>
</header>