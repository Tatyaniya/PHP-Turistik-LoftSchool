<?php
/**
 * Template name: Главная
 */
get_header();
global $wp_query;

$args = array('post_type' => ['post','news', 'stocks']); 
query_posts($args);

$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
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
                <?php else: ?>
                    <h1 class="title-page">Последние новости и акции из мира туризма</h1>
                <?php endif; ?>

                <div class="posts-list">

                <?php
                    $args = array(
                        'post_type'      => ['post','news', 'stocks'],
                        'orderby'        => 'date',
                        'order'          => 'DESC',
                        'paged'          => $paged
                    );
                    $q = new WP_Query($args);
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

            <?php // kama_pagenavi($before = '', $after = '', $echo = true, $args = array(), $wp_query = $q);
                 echo paginate_links();
            ?>
                
            </div>
        </div>

        <?php get_sidebar() ?>
          
    </div>
</div>

<?php get_footer(); ?>