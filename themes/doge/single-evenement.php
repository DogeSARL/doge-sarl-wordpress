<?php
/*
 * Template Name: single-evenement
 */
?>


<?php get_header(); ?>
    <div class="main single">
        <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); ?>
                <div class="post">
                    <h1 class="post-title"><?php the_title(); ?></h1>
                    <p class="post-info">
                        Posté le <?php the_date(); ?> dans <?php the_category(', '); ?> par <?php the_author(); ?>.
                    </p>
                    <!-- TODO TRANSLATE -->

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
                    <div class="post-content">
                        <?php the_content(); ?>
                    </div>
                    <div class="post-comments">
                        <?php comments_template(); ?>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>