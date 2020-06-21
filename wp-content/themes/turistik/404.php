<?php 
get_header();
?>

    <div class="main-content">
        <div class="content-wrapper">
            <div class="content content-404">
               
	            <p class="content-404__text">
                    Такой страницы у нас нет, зато есть много других страиц:
                </p>
                <div class="content-404__menu">
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
        </div>
    </div>

<?php get_footer();