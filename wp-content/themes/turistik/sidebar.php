<div class="sidebar">

    <?php if ( is_active_sidebar( 'main-side' ) ) : ?>

        <?php dynamic_sidebar('main-side'); ?>

    <?php endif; ?>

    <?php if ( $tags = get_terms( array('taxonomy' => 'post_tag', 'hide_empty' => false )) ) : ?>

        <div class="sidebar__sidebar-item">
            <div class="sidebar-item__title">Теги</div>
            <div class="sidebar-item__content">
                <ul class="tags-list">

                    <?php foreach($tags as $tag) : ?>

                        <li class="tags-list__item">
                            <a href="<?php echo get_term_link( $tag );?>" class="tags-list__item__link">
                                <?php echo $tag->name; ?>
                            </a>
                        </li>

                    <?php endforeach; ?>

                </ul>
            </div>
        </div>

    <?php endif; ?>

    <div class="sidebar__sidebar-item">
        <div class="sidebar-item__title">Категории</div>
        <div class="sidebar-item__content">
            <ul class="category-list">

                <?php if ( $cats = get_terms( array('taxonomy' => 'category', 'parent' => 0 )) ) : ?>
                    <?php foreach($cats as $cat) : ?>

                        <li class="category-list__item">

                            <a href="<?php echo get_term_link( $cat );?>" class="category-list__item__link">
                                <?php echo $cat->name; ?>
                            </a>

                            <?php $cat_data = get_categories( array( 'parent' => $cat->term_id, 'exclude' => [10,13], 'hide_empty' => 1 ) );
                                if ( $cat_data ) :
                                    foreach ( $cat_data as $one_cat_data) : ?>

                                        <ul class="category-list__inner">
                                            <li class="category-list__item">
                                                <a href="<?php echo get_term_link( $one_cat_data );?>" class="category-list__item__link">
                                                    <?php echo $one_cat_data->name; ?>
                                                </a>
                                            </li>
                                        </ul>
                                        
                                    <?php endforeach; ?>
                                <?php endif; ?>
                        </li>

                    <?php endforeach; ?>
                <?php endif; ?>

            </ul>
        </div>
    </div>
</div>