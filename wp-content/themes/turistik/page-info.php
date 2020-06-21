<?php 
get_header();
the_post();
?>

    <div class="main-content">
        <div class="content-wrapper">
            <div class="content">
               
	            <?php the_content(); ?>

            </div>

            <?php get_sidebar() ?>

        </div>
    </div>

<?php get_footer();