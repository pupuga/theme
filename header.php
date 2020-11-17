<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <?php Pupuga\Libs\Files\Files::getTemplate(DIR_TEMPLATES . 'meta', true) ?>
    <meta name="format-detection" content="telephone=no">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,900;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri() ?>/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri() ?>/css/style.css"/>
    <?php wp_head() ?>
    <script>let globalData = <?php echo Pupuga\Core\Base\Common::app()->getJs() ?></script>
</head>
<body<?php if (is_single()): ?> class="page_section"<?php endif ?>>
<header class="header">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div>
                    <a href="<?php echo home_url() ?>" class="logo-block"><?php echo carbon_get_theme_option( 'common_pupuga_titles_and_text_logo') ?></a>
                    <?php if (is_single()): ?>
                    <ul class="main-menu d-md-inline active">
                        <?php Pupuga\Core\Load\Menu::app()->menuStandard('Main')->action() ?>
                    </ul>
                    <?php endif ?>
                    <button class="open_main_menu d-md-none">
                        <span class="lines"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</header>