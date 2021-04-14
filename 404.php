<?php get_header(); ?>
<section>
    <h2><?php _e('The page cannot be found') ?></h2>
    <div>
        <p><?php _e('The page you are looking might have been removed, had its name changed, or is temporarily unavailable.') ?></p>
        <p><?php _e('Please try the following:') ?></p>
    </div>
    <div>
        <p><?php _e('If you typed the page address in the Address bar make sure it is spelled correctly.') ?></p>
        <p><a href="<?php bloginfo('url') ?>"><?php _e('Click here') ?></a> <?php _e('to open the home page and then look for links to the information you want.') ?></p>
        <p><?php _e('Click the Back button in your browser to try another link.') ?></p>
    </div>
</section>
<?php get_footer(); ?>