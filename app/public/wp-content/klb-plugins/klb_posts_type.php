<?php
function klb_posts_types() {
	// Running text Post Type
	register_post_type('running-texts', array(
		'show_in_rest' => true,
		'supports' => array('title', 'editor', 'excerpt'),
		'rewrite' => array('slug' => 'running-texts'),
		'has_archive' => true,
		'public' => true,
		'labels' => array(
			'name' => 'Running-texts',
			'add_new_item' => 'Add New Running Text',
			'edit_item' => 'Edit Running Text',
			'all_items' => 'All Running Text',
			'singular_name' => 'running-texts'
		),
		'menu_icon' => 'dashicons-arrow-left-alt'
	));

	// img
	register_post_type('img', array(
		'show_in_rest' => true,
		'supports' => array('title', 'editor', 'excerpt'),
		'rewrite' => array('slug' => 'img'),
		'has_archive' => true,
		'public' => true,
		'labels' => array(
			'name' => 'img',
			'add_new_item' => 'Add New Img',
			'edit_item' => 'Edit Img',
			'all_items' => 'All Img',
			'singular_name' => 'img'
		),
		'menu_icon' => 'dashicons-images-alt'
	));

	// lashes
	register_post_type('lashes', array(
		'show_in_rest' => true,
		'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'custom-fields'),
		'rewrite' => array('slug' => 'lashes'),
		'has_archive' => true,
		'public' => true,
		'labels' => array(
			'name' => 'lashes',
			'add_new_item' => 'Add New Lashes',
			'edit_item' => 'Edit Lashes',
			'all_items' => 'All Lashes',
			'singular_name' => 'lashes'
		),
		'menu_icon' => 'dashicons-visibility'
	));
}

add_action('init', 'klb_posts_types');