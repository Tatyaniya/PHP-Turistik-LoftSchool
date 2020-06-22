<?php
/**
 * Template name: Главная
 */
get_header();
//global $wp_query;
//var_dump($wp_query);

//$args = array('post_type' => ['post','news', 'stocks']); 
//query_posts($args);

?>

    <div class="main-content">
        <div class="content-wrapper">
            <div class="content">

                <?php if( is_search()) : ?>
                    <h1 class="title-page">Результаты поиска:</h1>
                <?php elseif( is_tag() ): ?>
                    <h1 class="title-page"><?php single_tag_title(); ?></h1>
                <?php elseif( is_category() ): ?>
                    <h1 class="title-page"><?php single_cat_title(); ?></h1>
                <?php elseif( is_day() ): ?>
                    <h1 class="title-page">В этот день:</h1>
                <?php else: ?>
                    <h1 class="title-page">Последние новости и акции из мира туризма</h1>
                <?php endif; ?>

                <div class="posts-list">

                <?php
                    $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
                    $args = array(
                        'post_type'      => ['post','news', 'stocks'],
                        'orderby'        => 'date',
                        'order'          => 'DESC',
                        'paged'          => $paged
                    );
                    $q = new WP_Query($args);
                    //echo '<pre>';
                    //var_dump($args['post_type']);
                ?>

                <?php if ( $q->have_posts() ) : ?>
                    <?php while ( $q->have_posts() ) : $q->the_post(); ?>

                        <div class="post-wrap">
                            <div class="post-thumbnail"><?php the_post_thumbnail('home-post-image'); ?></div>
                                <div class="post-content">
                                <div class="post-content__post-info">
                                    <div class="post-date"><?php the_time('d.m.Y'); ?></div>
                                </div>
                                <div class="post-content__post-text">
                                    <div class="post-title">
                                        <?php the_title(); ?>
                                    </div>
                                    <?php echo do_excerpt(get_the_excerpt(), 21); ?>
                                </div>
                                <div class="post-content__post-control">
                                    <a href="<?php the_permalink(); ?>" class="btn-read-post">
                                        Читать далее >>
                                    </a>
                                </div>
                            </div>
                        </div>
                       
                    <?php endwhile;
                else: ?>
                    <p>
                        Ничего не найдено.
                    </p>
                <?php endif; ?>

                <?php wp_reset_postdata(); ?>

            </div>

            <div class="pagenavi-post-wrap">
           
                <?php if($q->max_num_pages > 1) { ?>
                    
                    <div class="pagenavi-post-wrap">
                        <?php if( get_query_var('paged') == 0) { ?>
                                <i class="icon icon-angle-double-left"></i>
                        <?php } ?>

                        <?php $big = 999999999;
                            echo paginate_links( array(
                                'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                                'format' => '?paged=%#%',
                                'current' => max( 1, get_query_var('paged') ),
                                'prev_text'          => '',
                                'next_text'          => '',
                                'total' => $q->max_num_pages
                            ) );
                        ?>

                        <?php if( get_query_var('paged') == $q->max_num_pages) { ?>
                                <i class="icon icon-angle-double-right"></i>
                        <?php } ?>
                    </div>
                <?php } ?>
                
                
            </div>
        </div>

        <?php get_sidebar() ?>
          
    </div>
</div>

<?php get_footer(); ?>