<?php
function kiwi_lash_brown_files() {
    wp_enqueue_script('googleMap', '//maps.googleapis.com/maps/api/js?key=AIzaSyDin3iGCdZ7RPomFLyb2yqFERhs55dmfTI', NULL, '1.0', true);
    wp_enqueue_script('main-university-js', get_theme_file_uri('/build/index.js'), array('jquery'), '1.0', true);
    wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0');
    wp_enqueue_style('questrial-google-fonts', 'https://fonts.googleapis.com/css2?family=Questrial&display=swap');
    wp_enqueue_style('index', get_theme_file_uri('/css/style-index.css'));
    wp_enqueue_style('slide-show', get_theme_file_uri('/css/slide-show.css'));
    wp_enqueue_style('menu', get_theme_file_uri('/css/menu.css'));
}

add_action('wp_enqueue_scripts', 'kiwi_lash_brown_files');

function klb_post_types() {
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
}

add_action('init', 'klb_post_types');

function img_types() {
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
}

add_action('init', 'img_types');

function lashes() {
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

add_action('init', 'lashes');

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

function get_list_customer_fields($field) {
    add_filter('posts_groupby', 'query_group_by_filter');

    $field_query = new WP_Query(array(
        'post_type' => 'lashes',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'meta_key' => $field,
    ));

    remove_filter('posts_groupby', 'query_group_by_filter');
    while ( $field_query->have_posts() ) : $field_query->the_post();
        echo "<p style='font-size: 14px'>".get_field($field)."<p>";
    endwhile;
}

function get_lashes_menu_content($image_name, $field) { ?>
    <div class="column-5" style="padding-left: 3px; padding-right: 3px">
        <p style="font-weight: bold">Technique</p>
        <hr style="padding-left: 2px;">
        <img src="<?php echo get_url_img($image_name)?>" style="max-width: 250px; max-height: 220px; margin: auto">
        <?php get_list_customer_fields($field); ?>
    </div>
<?php }

function drop_down_menu_lashes(){ ?>
  <div class="dropdown-content">
      <div class="row" style="width: 90%; margin: auto; font-size: 16px">
          <?php get_lashes_menu_content("lashes-technique", "technique");
                get_lashes_menu_content("lashes-thickness", "thickness");
                get_lashes_menu_content("lashes-collection", "collection");
                get_lashes_menu_content("lashes-special", "special");
                get_lashes_menu_content("lashes-shopmore", "special") ?>
      </div>
</div>
<?php }

function my_wp_content_function($content) {

    return strip_tags($content,"<br><h2>"); //add any tags here you want to preserve

}

add_filter('the_content', 'my_wp_content_function');



