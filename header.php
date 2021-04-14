<?php global $post; ?>
<!doctype html>
<html <?php language_attributes() ?>>
<head>
    <?php Pupuga\Libs\Files\Files::getTemplatePupuga('meta', true) ?>
    <?php wp_head() ?>
    <?php //Pupuga\Libs\Files\Files::getCss(DIR_ASSETS . 'skeleton.css', true) ?>
    <script>let globalData = <?php echo Pupuga\Core\Base\Common::app()->getJs() ?></script>
</head>
<body class="<?php if ($frontPage = is_front_page()) : ?>home-page<?php else : ?>not-home-page<?php endif ?>">
    <header class="general__header <?php if ($frontPage) : ?>general__header--home<?php else : ?>general__header--not-home<?php endif ?>">
       <div class="block-columns">
           <div class="block-columns__left">
               <?php Pupuga\Libs\Files\Files::getTemplatePupuga('logo', true, array('class' => 'general__logo')) ?>
	   </div>
           <div class="block-columns__right">
               <nav class="menu menu--line">
	           <ul>
                       <?php Pupuga\Core\Load\Menu::app()->menuStandard('Main')->action() ?>
	           </ul>
	       </nav>
           </div>
       </div>
    </header>