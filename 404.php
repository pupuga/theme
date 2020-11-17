<?php get_header(); ?>
<!--section not-found-->
<section class="not-found">
	<div class="not-found__wrapper">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<h1 class="not-found__title">
						404
					</h1>
					<div class="not-found__description">
						Error! Page not found!
					</div>
					<div class="not-found__text">
						Sorry! We can’t find this page.
					</div>
					<a href="<?php echo home_url() ?>" class="btn orange-btn">
						Go home
					</a>
				</div>
			</div>
		</div>
	</div>
</section>
<!--End section not-found-->
<?php get_footer(); ?>