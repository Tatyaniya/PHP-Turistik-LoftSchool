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

function my_sidebar(){
	register_sidebar(
        array(
            'id' => 'main-side',
            'name' => 'Главный сайдбар'
        )
    );
}
 
add_action('widgets_init', 'my_sidebar');



/**
 * Альтернатива wp_pagenavi. Создает ссылки пагинации на страницах архивов.
 *
 * @param array  $args      Аргументы функции
 * @param object $wp_query  Объект WP_Query на основе которого строится пагинация. По умолчанию глобальная переменная $wp_query
 *
 * @version 2.7
 * @author  Тимур Камаев
 * @link    Ссылка на страницу функции: http://wp-kama.ru/?p=8
 */
function kama_pagenavi( $args = array(), $wp_query = null ){

	// параметры по умолчанию
	$default = array(
		'before'          => '',   // Текст до навигации.
		'after'           => '',   // Текст после навигации.
		'echo'            => true, // Возвращать или выводить результат.

		'text_num_page'   => '',           // Текст перед пагинацией.
		// {current} - текущая.
		// {last} - последняя (пр: 'Страница {current} из {last}' получим: "Страница 4 из 60").
		'num_pages'       => 10,           // Сколько ссылок показывать.
		'step_link'       => 10,           // Ссылки с шагом (если 10, то: 1,2,3...10,20,30. Ставим 0, если такие ссылки не нужны.
		'dotright_text'   => '…',          // Промежуточный текст "до".
		'dotright_text2'  => '…',          // Промежуточный текст "после".
		'back_text'       => '<',    // Текст "перейти на предыдущую страницу". Ставим 0, если эта ссылка не нужна.
		'next_text'       => '>',   // Текст "перейти на следующую страницу".  Ставим 0, если эта ссылка не нужна.
		'first_page_text' => '0', // Текст "к первой странице".    Ставим 0, если вместо текста нужно показать номер страницы.
		'last_page_text'  => '0',  // Текст "к последней странице". Ставим 0, если вместо текста нужно показать номер страницы.
	);

	// Cовместимость с v2.5: kama_pagenavi( $before = '', $after = '', $echo = true, $args = array() )
	if( ($fargs = func_get_args()) && is_string( $fargs[0] ) ){
		$default['before'] = isset($fargs[0]) ? $fargs[0] : '';
		$default['after']  = isset($fargs[1]) ? $fargs[1] : '';
		$default['echo']   = isset($fargs[2]) ? $fargs[2] : true;
		$args              = isset($fargs[3]) ? $fargs[3] : array();
		$wp_query = $GLOBALS['wp_query']; // после определения $default!
	}

	if( ! $wp_query ){
		wp_reset_query();
		global $wp_query;
	}

	if( ! $args ) $args = array();
	if( $args instanceof WP_Query ){
		$wp_query = $args;
		$args     = array();
	}

	$default = apply_filters( 'kama_pagenavi_args', $default ); // чтобы можно было установить свои значения по умолчанию

	$rg = (object) array_merge( $default, $args );

	//$posts_per_page = (int) $wp_query->get('posts_per_page');
	$paged          = (int) $wp_query->get('paged');
	$max_page       = $wp_query->max_num_pages;

	// проверка на надобность в навигации
	if( $max_page <= 1 )
		return false;

	if( empty( $paged ) || $paged == 0 )
		$paged = 1;

	$pages_to_show = intval( $rg->num_pages );
	$pages_to_show_minus_1 = $pages_to_show-1;

	$half_page_start = floor( $pages_to_show_minus_1/2 ); // сколько ссылок до текущей страницы
	$half_page_end   = ceil(  $pages_to_show_minus_1/2 ); // сколько ссылок после текущей страницы

	$start_page = $paged - $half_page_start; // первая страница
	$end_page   = $paged + $half_page_end;   // последняя страница (условно)

	if( $start_page <= 0 )
		$start_page = 1;
	if( ($end_page - $start_page) != $pages_to_show_minus_1 )
		$end_page = $start_page + $pages_to_show_minus_1;
	if( $end_page > $max_page ) {
		$start_page = $max_page - $pages_to_show_minus_1;
		$end_page = (int) $max_page;
	}

	if( $start_page <= 0 )
		$start_page = 1;

	// создаем базу чтобы вызвать get_pagenum_link один раз
	$link_base = str_replace( 99999999, '___', get_pagenum_link( 99999999 ) );
	$first_url = get_pagenum_link( 1 );
	if( false === strpos( $first_url, '?') )
		$first_url = user_trailingslashit( $first_url );

	// собираем елементы
	$els = array();

	if( $rg->text_num_page ){
		$rg->text_num_page = preg_replace( '!{current}|{last}!', '%s', $rg->text_num_page );
		$els['pages'] = sprintf( '<span class="pages">'. $rg->text_num_page .'</span>', $paged, $max_page );
	}
	// назад
	if ( $rg->back_text && $paged != 1 )
		$els['prev'] = '<a class="prev" href="'. ( ($paged-1)==1 ? $first_url : str_replace( '___', ($paged-1), $link_base ) ) .'">'. $rg->back_text .'</a>';
	// в начало
	if ( $start_page >= 2 && $pages_to_show < $max_page ) {
		$els['first'] = '<a class="first" href="'. $first_url .'">'. ( $rg->first_page_text ?: 1 ) .'</a>';
		if( $rg->dotright_text && $start_page != 2 )
			$els[] = '<span class="extend">'. $rg->dotright_text .'</span>';
	}
	// пагинация
	for( $i = $start_page; $i <= $end_page; $i++ ) {
		if( $i == $paged )
			$els['current'] = '<span class="current">'. $i .'</span>';
		elseif( $i == 1 )
			$els[] = '<a href="'. $first_url .'">1</a>';
		else
			$els[] = '<a href="'. str_replace( '___', $i, $link_base ) .'">'. $i .'</a>';
	}

	// ссылки с шагом
	$dd = 0;
	if ( $rg->step_link && $end_page < $max_page ){
		for( $i = $end_page + 1; $i <= $max_page; $i++ ){
			if( $i % $rg->step_link == 0 && $i !== $rg->num_pages ) {
				if ( ++$dd == 1 )
					$els[] = '<span class="extend">'. $rg->dotright_text2 .'</span>';
				$els[] = '<a href="'. str_replace( '___', $i, $link_base ) .'">'. $i .'</a>';
			}
		}
	}
	// в конец
	if ( $end_page < $max_page ) {
		if( $rg->dotright_text && $end_page != ($max_page-1) )
			$els[] = '<span class="extend">'. $rg->dotright_text2 .'</span>';
		$els['last'] = '<a class="last" href="'. str_replace( '___', $max_page, $link_base ) .'">'. ( $rg->last_page_text ?: $max_page ) .'</a>';
	}
	// вперед
	if ( $rg->next_text && $paged != $end_page )
		$els['next'] = '<a class="next" href="'. str_replace( '___', ($paged+1), $link_base ) .'">'. $rg->next_text .'</a>';

	$els = apply_filters( 'kama_pagenavi_elements', $els );

	$out = $rg->before . '<div class="wp-pagenavi">'. implode( ' ', $els ) .'</div>'. $rg->after;

	$out = apply_filters( 'kama_pagenavi', $out );

	if( $rg->echo ) echo $out;
	else return $out;
}
/**
 * 2.7 (02.11.2018) - В $args можно указать второй параметр $wp_query, когда $args можно оставить пустым.
 *                  - Правки кода - исправил баги, переделал сбор элементов в массив.
 *                  - Новый хук `kama_pagenavi_elements`.
 * 2.6 (20.10.2018) - Убрал extract().
 *                  - Перенес параметры $before, $after, $echo в $args (старый вариант будет работать).
 * 2.5 - 2.5.1      - Автоматический сброс основного запроса.
 */