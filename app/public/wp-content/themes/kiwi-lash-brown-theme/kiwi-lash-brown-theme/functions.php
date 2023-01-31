<?php
function kiwi_lash_brown_files() {
    wp_enqueue_script('googleMap', '//maps.googleapis.com/maps/api/js?key=AIzaSyDin3iGCdZ7RPomFLyb2yqFERhs55dmfTI', NULL, '1.0', true);
    wp_enqueue_script('main-university-js', get_theme_file_uri('/build/index.js'), array('jquery'), '1.0', true);
    wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0');
    wp_enqueue_style('questrial-google-fonts', 'https://fonts.googleapis.com/css2?family=Questrial&display=swap');
    wp_enqueue_style('index', get_theme_file_uri('/css/style-index.css'));
    wp_enqueue_style('slide-show', get_theme_file_uri('/css/slide-show.css'));
    wp_enqueue_style('menu', get_theme_file_uri('/css/menu.css'));
	wp_enqueue_script( 'bootstrap-js', get_template_directory_uri() . '/inc/bootstrap.min.js', array( 'jquery' ), '4.3.1', true );
	wp_enqueue_style( 'bootstrap-css', get_template_directory_uri() . '/inc/bootstrap.min.css', array(), '4.3.1', 'all' );
}

add_action('wp_enqueue_scripts', 'kiwi_lash_brown_files');
/* add_theme_support( 'admin-bar', array( 'callback' => '__return_false' ) ); */

function admin_bar(){

	if(is_user_logged_in()){
		add_filter( 'show_admin_bar', '__return_true' , 1000 );
	}
}
add_action('init', 'admin_bar' );

function kiwi_lash_brown_config() {
	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus(
		array(
			'fancy_lab_main_menu' 	=> 'Fancy Lab Main Menu',
			'fancy_lab_footer_menu' => 'Fancy Lab Footer Menu',
		)
	);

	// This theme is WooCommerce compatible, so we're adding support to WooCommerce
	add_theme_support( 'woocommerce', array(
		'thumbnail_image_width' => 255,
		'single_image_width'	=> 255,
		'product_grid' 			=> array(
			'default_rows'    => 10,
			'min_rows'        => 5,
			'max_rows'        => 10,
			'default_columns' => 1,
			'min_columns'     => 1,
			'max_columns'     => 1,
		)
	) );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );


	add_theme_support( 'custom-logo', array(
		'height' 		=> 180,
		'width'			=> 300,
		'flex_height'	=> true,
		'flex_width'	=> true,
	) );
}

add_action( 'after_setup_theme', 'kiwi_lash_brown_config', 0 );

$menu_name = "fancy_lab_main_menu";
// Check if the menu exists
$menu_exists = wp_get_nav_menu_object( $menu_name );

// If it doesn't exist, let's create it.
if( $menu_exists) {
	wp_delete_nav_menu( $menu_exists );
}
	$menu_id = wp_create_nav_menu($menu_name);

	// Set up default menu items
	$parent_menu = wp_update_nav_menu_item($menu_id, 0, array(
		'menu-item-title' =>  __('Home'. '&lt;img src="http://yoursite.com/wp-content/themes/yourtheme/images/image.jpg"&gt;'),
		'menu-item-classes' => 'home',
		'menu-item-url' => home_url( '/' ),
		'menu-item-classes' => 'has-mega-menu',
		'menu-item-status' => 'publish'));

	wp_update_nav_menu_item($menu_id, 0, array(
		'menu-item-title' =>  __('Custom Page'),
		'menu-item-url' => home_url( '/custom/' ),
		'menu-item-status' => 'publish',
		'menu-item-parent-id' => $parent_menu));

	wp_update_nav_menu_item($menu_id, 0, array(
		'menu-item-title' =>  __('ALLOOOO'),
		'menu-item-url' => home_url( '/custom/' ),
		'menu-item-status' => 'publish',
		'menu-item-parent-id' => $parent_menu));




function get_url_img($title) {
        $args =  new WP_Query(array(
            'post_type' => 'img',
            'title'     => $title,
        ));

        if($args->have_posts()) {
            $first_post = $args->posts[0];
            $id_img = $first_post->ID;
            return get_field('img', $id_img);
        }
}

function  query_group_by_filter($groupby){
    global $wpdb;
    return $wpdb->postmeta . '.meta_value ';
}

function get_list_customer_fields($field, $post_type) {
    add_filter('posts_groupby', 'query_group_by_filter');

    $field_query = new WP_Query(array(
        'post_type' => $post_type,
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'meta_key' => $field,
    ));

    remove_filter('posts_groupby', 'query_group_by_filter');
    while ( $field_query->have_posts() ) : $field_query->the_post();
        echo "<p style='font-size: 14px'>".get_field($field)."<p>";
    endwhile;
}

function get_menu_content($title, $field, $post_type, $class_colum, $image_name = null) { ?>
    <div class=<?php echo $class_colum ?>>
        <div style="width: 90%; margin: auto">
            <p style="font-weight: bold"><?php echo $title ?></p>
            <hr style="padding-left: 2px;">
            <?php if(get_url_img($image_name) && $image_name != null){?>
            <img src="<?php echo get_url_img($image_name)?>" style="object-fit: contain; max-width: 250px; max-height: 220px; margin: auto">
            <?php } ?>

            <?php if($field && $post_type) {
            get_list_customer_fields($field,$post_type);}
            ?>
        </div>
    </div>
<?php }

function get_menu_image_content($image_name = null) { ?>
    <div class="column-4">
        <div style="width: 90%; margin: auto">
			<?php if(get_url_img($image_name) && $image_name != null){?>
                <img src="<?php echo get_url_img($image_name)?>" style="object-fit: contain; max-width: 300px; max-height: 220px; margin: auto">
			<?php } ?>
            <p style="font-weight: bold; text-align: center"><?php echo $image_name ?></p>
        </div>
    </div>
<?php }

function drop_down_menu_lashes(){ ?>
  <div class="dropdown-content">
      <div class="row" style="width: 90%; margin: auto; font-size: 16px">
          <?php get_menu_content("Technique","technique", "lashes", "column-5", "lashes-technique");
                get_menu_content("Thickness",  "thickness", "lashes", "column-5", "lashes-thickness");
                get_menu_content("Collection", "collection", "lashes", "column-5", "lashes-collection");
                get_menu_content("Special","special", "lashes", "column-5", "lashes-special");
                get_menu_content("Shop More",  "special", "lashes", "column-5", "lashes-shopmore") ?>
      </div>
</div>
<?php }

function drop_down_menu_tweezers (){ ?>
    <div class="dropdown-content">
        <div class="row" style="width: 90%; margin: auto; font-size: 16px">
			<?php
			get_menu_image_content("City Collection");
			get_menu_image_content("Classic Tweezers");
			get_menu_image_content("Gold Collection");
			get_menu_image_content("Isolation Tweezers");
			get_menu_image_content("Master Pro Tweezers");
			get_menu_image_content("Mega Volume Tweezers");
			get_menu_image_content("Platinum Collection");
			get_menu_image_content("	Volume Tweezers");
            ?>
        </div>
    </div>
<?php }

function drop_down_menu_adhesive (){ ?>
    <div class="dropdown-content">
        <div class="row" style="width: 90%; margin: auto; font-size: 16px">
			<?php get_menu_content("Technique","technique", "adhesives","column-5");
			get_menu_content("Type", "type", "adhesives","column-5");
			get_menu_content("Shop All", "shop_all", "adhesives","column-5"); ?>
            <div style = "width: 40%; float: left;">
                <div style="width: 90%; margin: auto">
                    <img src="<?php echo get_url_img("adhesives")?>" style="object-fit: contain; max-width: 500px; max-height: 500px; margin: auto; display: inline-block">
                </div>
            </div>
        </div>
    </div>
<?php }


function my_wp_content_function($content) {
    return strip_tags($content,"<br><h2>"); //add any tags here you want to preserve
}

add_filter('the_content', 'my_wp_content_function');

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

	// lashes
	register_post_type('adhesives', array(
		'show_in_rest' => true,
		'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'custom-fields'),
		'rewrite' => array('slug' => 'adhesives'),
		'has_archive' => true,
		'public' => true,
		'labels' => array(
			'name' => 'adhesives',
			'add_new_item' => 'Add New Adhesives',
			'edit_item' => 'Edit Adhesives',
			'all_items' => 'All Adhesives',
			'singular_name' => 'Adhesives'
		),
		'menu_icon' => 'dashicons-filter'
	));
}

add_action('init', 'klb_posts_types');

