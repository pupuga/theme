<?php get_header() ?>
    <div class="skeleton general-section">
	    <?php echo apply_filters( 'the_content', get_post(get_option( 'page_on_front' ))->post_content ); ?>
    </div>
<?php get_footer() ?>