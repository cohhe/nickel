<?php
$layouts = array(
	'left',
	'full',
	'right'
);

$selected = get_option($id, $default);
?>

<div class="row-container">
	<h4><?php echo $name; ?></h4>
	<div class="content layouts">
		<?php foreach($layouts as $layout) { ?>
			<input type="radio" name="<?php echo esc_attr($id); ?>" id="<?php echo esc_attr($id . '-' . $layout); ?>" style="display: none;" value="<?php echo esc_attr($layout); ?>" <?php checked($selected, $layout); ?>/>
			<label for="<?php echo esc_attr($id . '-' . $layout); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/layout/layout-<?php echo $layout; ?>.png" alt="" class="<?php if($selected == $layout) { echo 'selected'; } ?>" /></label>
		<?php } ?>
	</div>
</div>