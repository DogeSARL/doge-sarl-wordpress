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
                                <?php the_content(); ?>
                            </div>
                            <div class="subscribeBox">
                                <?php if( is_user_logged_in() ) : ?>
                                    <?php if( isSubscribed( get_current_user_id(), get_the_ID() ) ) : ?>
                                        <a href="#" id="desinscrire">Je me désinscris</a>
                                    <?php else : ?>
                                        <a href="#" id="participer">Je participe</a>
                                    <?php endif ?>
                                <?php else : ?>
                                    <a href="<?php echo wp_login_url( $redirect ); ?>">Se connecter</a>
                                <?php endif; ?>
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