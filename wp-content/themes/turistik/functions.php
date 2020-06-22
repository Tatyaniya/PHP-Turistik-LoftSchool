<?php

add_action('wp_enqueue_scripts', 'tanya_script');

function tanya_script() {
    wp_enqueue_style('libs', get_template_directory_uri() . '/css/libs.min.css');
    wp_enqueue_style('main', get_template_directory_uri() . '/css/main.css', array(), time());
    wp_enqueue_style('media', get_template_directory_uri() . '/css/media.css');

    // Deregister core jQuery
    wp_deregister_script('jquery');

    // Register
    wp_register_script('jquery','https://code.jquery.com/jquery-2.2.4.min.js', array(), '2.2.4', true);
    wp_enqueue_script( 'jquery');
    wp_register_script('main-js', get_template_directory_uri() . '/js/main.js', 'jquery');
}

register_nav_menus( array(
	'header_menu' => 'header-menu',
	'footer_menu' => 'footer-menu'
) );

add_theme_support('post-thumbnails');

// размеры для картинок на главной
add_image_size( 'home-post-image', 270, 190, true );
// размеры для картинок на странице поста
add_image_size( 'post-image', 793, 318, true );
// размеры для картинок в предыдущей и следующей статье
add_image_size( 'other-articles-image', 160, 108, true );
// размеры для картинок в полезной информации
add_image_size( 'useful-information-image', 380, 300, true );

add_filter('excerpt_more', function($more) {
	return '...';
});

function do_excerpt($string, $word_limit) {
	$words = explode(' ', $string, ($word_limit + 1));
	if (count($words) > $word_limit) {
        array_pop($words);
	echo implode(' ', $words).' ...';
    }
}

/*
function turistik_register_custom_post_type() {

    register_post_type( 'news', array(
        'labels'             => array(
            'name'                  => 'Новости',
            'singular_name'         => 'СтатНовостиьи',
            'menu_name'             => 'Новости',
            'add_new'               => 'Добавить новость',
            'all_items'             => 'Все новости',
            'not_found'             => 'Новостей не найдено',
        ),
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'news' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'exclude_from_search'=> false,
        'show_in_nav_menus'  => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'menu_icon'			 => 'dashicons-format-aside',
        'supports'           => array( 'title', 'editor','thumbnail' ),
    ) );
 
    register_post_type( 'stocks', array(
        'labels'             => array(
            'name'                  => 'Акции',
            'singular_name'         => 'Акция',
            'menu_name'             => 'Акции',
            'add_new'               => 'Добавить акцию',
            'all_items'             => 'Все акции',
            'not_found'             => 'Акций не найдено',
        ),
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'stocks' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'exclude_from_search'=> false,
        'show_in_nav_menus'  => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'menu_icon'			 => 'dashicons-smiley',
        'supports'           => array( 'title', 'editor','thumbnail' ),
    ) );
}
 
add_action( 'init', 'turistik_register_custom_post_type' );
*/

function my_sidebar(){
	register_sidebar(
        array(
            'id' => 'main-side',
            'name' => 'Главный сайдбар'
        )
    );
}
 
add_action('widgets_init', 'my_sidebar');
