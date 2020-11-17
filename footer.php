<footer class="footer">
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <div class="col-12 col-xl">
                    <div class="logo-block"><?php echo carbon_get_theme_option( 'common_pupuga_titles_and_text_logo') ?></div>
                    <ul class="social-block d-none d-xl-block">
                        <?php if($link = carbon_get_theme_option( 'common_pupuga_configuration_facebook')):?>
                            <li><a href="<?php echo $link ?>" target="_blank"><i class="icon-facebook"></i></a></li>
                        <?php endif ?>
                        <?php if($link = carbon_get_theme_option( 'common_pupuga_configuration_twitter')):?>
                            <li><a href="<?php echo $link ?>" target="_blank"><i class="icon-twitter"></i></a></li>
                        <?php endif ?>
                        <?php if($link = carbon_get_theme_option( 'common_pupuga_configuration_linkedin')):?>
                            <li><a href="<?php echo $link ?>" target="_blank"><i class="icon-linkedin"></i></a></li>
                        <?php endif ?>
                    </ul>
                </div>
                <div class="col-6 col-md">
                    <div class="footer-block">
                        <h3 class="footer-title"><?php echo carbon_get_theme_option( 'common_pupuga_titles_and_text_travel_menu_title') ?></h3>
                        <ul><?php Pupuga\Core\Load\Menu::app()->menuStandard('Travel')->action() ?></ul>
                    </div>
                </div>
                <div class="col-6 col-md order-md-3 pl_xl_0">
                    <div class="footer-block">
                        <h3 class="footer-title"><?php echo carbon_get_theme_option( 'common_pupuga_titles_and_text_talk_menu_title') ?></h3>
                        <ul><?php Pupuga\Core\Load\Menu::app()->menuStandard('Talk')->action() ?></ul>
                    </div>
                </div>
                <div class="col-6 col-md order-md-2">
                    <div class="footer-block">
                        <h3 class="footer-title"><?php echo carbon_get_theme_option( 'common_pupuga_titles_and_text_events_menu_title') ?></h3>
                        <ul><?php Pupuga\Core\Load\Menu::app()->menuStandard('Events')->action() ?></ul>
                    </div>
                </div>

                <div class="col-6 col-md-auto pl_xl_0 order-md-4">
                    <div class="footer-block">
                        <h3 class="footer-title"><?php echo carbon_get_theme_option( 'common_pupuga_titles_and_text_contacts_title') ?></h3>
                        <ul>
                            <?php if($phone = carbon_get_theme_option( 'common_pupuga_titles_and_text_phone')) : ?>
                            <li>
                                <span class="color_green"><?php echo carbon_get_theme_option( 'common_pupuga_titles_and_text_phone_title') ?></span>
                                <a href="tel:<?php echo $phone ?>"><?php echo $phone ?></a>
                            </li>
                            <?php endif ?>
                            <?php if($email = carbon_get_theme_option( 'common_pupuga_titles_and_text_email')) : ?>
                            <li>
                                <span class="color_green"><?php echo carbon_get_theme_option( 'common_pupuga_titles_and_text_email_title') ?></span>
                                <a href="mailto:<?php echo $email ?>"><?php echo $email ?></a>
                            </li>
                            <?php endif ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row d-xl-none">
                <div class="col-12">
                    <ul class="social-block">
                        <?php if ($facebook = carbon_get_theme_option( 'common_pupuga_titles_and_text_facebook_link')) : ?>
                            <li><a href="<?php echo $facebook ?>" target="_blank"><i class="icon-facebook"></i></a></li>
                        <?php endif ?>
                        <?php if ($twitter = carbon_get_theme_option( 'common_pupuga_titles_and_text_twitter_link')) : ?>
                            <li><a href="<?php echo $twitter ?>" target="_blank"><i class="icon-twitter"></i></a></li>
                        <?php endif ?>
                        <?php if ($linkedin = carbon_get_theme_option( 'common_pupuga_titles_and_text_linkedin_link')) : ?>
                            <li><a href="<?php echo $linkedin ?>" target="_blank"><i class="icon-linkedin"></i></a></li>
                        <?php endif ?>
                    </ul>
                    <button class="backtotop d-md-none"><i class="icon-angle-up"></i></button>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="d-inline-block footer-rights">
                        <?php if ($copyright = carbon_get_theme_option( 'common_pupuga_titles_and_text_copy_text')) : ?>
                            <span><?php echo Pupuga\Libs\Data\Html::replaceTemplates($copyright) ?></span>
                        <?php endif ?>
                    </div>
                    <ul class="footer-bottom-list d-inline-block list-inline">
                        <?php Pupuga\Core\Load\Menu::app()->menuStandard('Help')->action() ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
<?php wp_footer() ?>
<script src="<?php echo get_stylesheet_directory_uri() ?>/js/moment.min.js?ver=<?php echo RELEASE_VERSION ?>"></script>
<script src="<?php echo get_stylesheet_directory_uri() ?>/js/lightpick.js?ver=<?php echo RELEASE_VERSION ?>"></script>
<script src="<?php echo get_stylesheet_directory_uri() ?>/js/bootstrap.min.js?ver=<?php echo RELEASE_VERSION ?>"></script>
<script type='text/javascript' src="<?php echo get_stylesheet_directory_uri() ?>/js/jquery.nicescroll.min.js?ver=<?php echo RELEASE_VERSION ?>"></script>
<script type='text/javascript' src="<?php echo get_stylesheet_directory_uri() ?>/js/jquery.sticky-kit.min.js?ver=<?php echo RELEASE_VERSION ?>"></script>
<script type='text/javascript' src="<?php echo get_stylesheet_directory_uri() ?>/js/jquery.mask.js?ver=<?php echo RELEASE_VERSION ?>"></script>
<script type='text/javascript' src="<?php echo get_stylesheet_directory_uri() ?>/js/script.js?ver=<?php echo RELEASE_VERSION ?>"></script>
</body>
</html>