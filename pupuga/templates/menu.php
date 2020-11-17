<ul class="listing-items <?php echo (isset($params['class']) && !empty($params['class'])) ? ' listing-items--' . $params['class'] : '' ?>">
	<?php foreach ($params['items'] as $item) : ?>
	<li class="listing-items__item<?php echo (isset($params['class']) && !empty($params['class'])) ? ' listing-items__item--' . $params['class'] : '' ?>">
		<a class="listing-items__link<?php echo (isset($params['class']) && !empty($params['class'])) ? ' listing-items__link--' . $params['class'] : '' ?>" href="<?php echo $item->meta['_menu_item_url'] ?>">
			<?php if(array_search('image', $params['displayed']) !== false && isset($item->meta['_general_menu_image']) && !empty($item->meta['_general_menu_image'])) : ?>
				<div class="listing-items__image<?php echo (isset($params['class']) && !empty($params['class'])) ? ' listing-items__image--' . $params['class'] : '' ?>"><?php echo wp_get_attachment_image( $item->meta['_general_menu_image'], 'full'); ?></div>
			<?php endif ?>
			<?php if(array_search('title', $params['displayed']) !== false && isset($item->post_title) && !empty($item->post_title)) : ?>
				<div class="listing-items__text<?php echo (isset($params['class']) && !empty($params['class'])) ? ' listing-items__text--' . $params['class'] : '' ?>"><?php echo $item->post_title ?></div>
			<?php endif ?>
		</a>
	</li>
	<?php endforeach ?>
</ul>