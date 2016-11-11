<?php
/*
 * Layout options
 */

$nickel_config = array(
	'id'       => 'vh_layouts',
	'title'    => __('Layouts', 'nickel'),
	'pages'    => array('page', 'post'),
	'context'  => 'normal',
	'priority' => 'high',
);

$nickel_options = array(array(
	'name'    => __('Layout type', 'nickel'),
	'id'      => 'layouts',
	'type'    => 'layouts',
	'only'    => 'page,post',
	'default' => get_option('default-layout'),
));

require_once(get_template_directory() . '/inc/metaboxes/add_metaboxes.php');
new nickel_create_meta_boxes($nickel_config, $nickel_options);