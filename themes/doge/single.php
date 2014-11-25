<?php
/*
 * Template Name: single-evenement
 */
?>

<?php get_header(); ?>
    <div id="single_event_page" class="clearfix">
        <div class="main single clearfix">
            <div class="col70">
                <?php if (have_posts()) : ?>
                    <?php while (have_posts()) : the_post(); ?>
                        <div class="post clearfix">
                            <h1 class="post-title"><?php the_title(); ?></h1>
                            <p class="post-info">
                                Posté le <?php the_date(); ?> dans <?php the_category(', '); ?> par <?php the_author(); ?>.
                            </p>
                            <!-- TODO TRANSLATE -->
                            <div class="post-content">
                                <?php if( !has_post_thumbnail() ) : ?>
                                    <img alt="" src="<?php bloginfo('template_url'); ?>/img/postpreview.jpg">
                                <?php else : ?>
                                    <?php the_post_thumbnail(); ?>
                                <?php endif; ?>
                                <?php the_content(); ?>
                            </div>
                            <hr>
                            <div class="post-comments">
                                <?php comments_template(); ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php endif; ?>
            </div>
            <div class="col30 sidebar"><?php get_sidebar(); ?></div>
        </div>
    </div>
<?php get_footer(); ?>