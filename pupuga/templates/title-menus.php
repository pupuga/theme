<div class="menu-blocks">
	<?php foreach ($params['menu'] as $menu) : ?>
		<div class="menu-blocks__item<?php echo (isset($params['class']) && !empty($params['class'])) ? ' menu-blocks__item--' . $params['class'] : '' ?>">
			<div class="menu-block<?php echo (isset($params['class']) && !empty($params['class'])) ? ' menu-block--' . $params['class'] : '' ?>">
				<h3 class="menu-block__title<?php echo (isset($params['class']) && !empty($params['class'])) ? ' menu-block__title--' . $params['class'] : '' ?>"><?php echo $menu->post_title ?></h3>
				<?php if (isset($menu->items) && is_array($menu->items)) : ?>
				<nav class="menu-block__listing<?php echo (isset($params['class']) && !empty($params['class'])) ? ' menu-block__listing--' . $params['class'] : '' ?>">
					<?php Pupuga\Libs\Files\Files::getTemplate(DIR_TEMPLATES . 'menu', true,
						array('items' => $menu->items, 'class' => (isset($params['class']) && !empty($params['class'])) ? $params['class'] : '', 'displayed' => $params['displayed']))
					?>
				</nav>
				<?php endif ?>
			</div>
		</div>
	<?php endforeach ?>
</div>