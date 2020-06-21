<?php get_header();
$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
?>

    <div class="main-content">
        <div class="content-wrapper content-wrapper-news">
            <div class="content">
                <h1 class="title-page">Последние новости</h1>

                <?php $news = new WP_Query( array(
                        'post_type'    => 'news',
                        'orderby'      => 'date',
                        'order'        => 'DESC',
                        'paged'        => $paged
                    ));

                        while ( $news->have_posts() ) :  $news->the_post(); ?>

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
                                <div class="post-content__post-control"><a href="<?php the_permalink(); ?>" class="btn-read-post">Читать далее >></a></div>
                                </div>
                            </div>
                        
                        <?php endwhile; 

                    wp_reset_postdata(); 

                ?>
                <div class="pagenavi-post-wrap">
                    <?php echo paginate_links(); ?>
                </div>
            </div>
            

          <?php get_sidebar() ?>

      </div>
    </div>

<?php get_footer(); ?>