<?php

get_header(); ?>



                <?php
                    $args = [
                        'prev_text' => __('<i class="icon icon-angle-double-left"></i>', 'turistik'),
                        'next_text' => __('<i class="icon icon-angle-double-right"></i>', 'turistik'),
                        ];
                    the_posts_pagination($args);
                ?>



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


<?php get_footer(); ?>
