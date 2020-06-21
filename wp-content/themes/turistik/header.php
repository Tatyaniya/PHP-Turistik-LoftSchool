<!DOCTYPE html>
<html lang="<?php language_attributes(); ?>">
  <head>
    <title><?php echo wp_get_document_title(); ?></title>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <?php wp_head(); ?>

  </head>
  <body>
    <div class="wrapper">
      <header class="main-header">
        <div class="top-header">
            <div class="top-header__wrap">
                <div class="logotype-block">
                <div class="logo-wrap">
                    <a href="<?php echo site_url(); ?>">
                        <img src="<?php echo get_template_directory_uri() ?>/img/logo.svg" alt="Логотип" class="logo-wrap__logo-img">
                        </a>
                    </div>
                </div>
                <?php 
                    wp_nav_menu( [
                        'theme_location'  => 'header_menu',
                        'menu'            => 'header-menu', 
                        'container'       => 'nav', 
                        'container_class' => 'main-navigation',
                        'menu_class'      => 'nav-list',
                        'echo'            => true,
                        'fallback_cb'     => 'wp_page_menu',
                        'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                        'depth'           => 0,
                        'walker'          => '',
                    ] );
                ?>
            </div>
        </div>
        <div class="bottom-header">
            <div class="search-form-wrap">
                <form class="search-form" action="<?php echo site_url(); ?>">
                    <input type="text" name="s" placeholder="Поиск..." class="search-form__input" value="<?php the_search_query() ?>">
                    <button class="search-form__btn-search"><i class="icon icon-search"></i></button>
                </form>
            </div>
        </div>
      </header>
      <!-- header_end-->