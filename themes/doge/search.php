<?php
/*
Template Name: Search Page
*/
get_header(); ?>
<div id="home">
<div class="content_wrapper clearfix" style="margin:95px auto 0;">
    <h1 class="resultat">Résultats de recherche</h1>
    <?php if ( have_posts() ) :
    while ( have_posts() ) : the_post(); ?>
        <a class="border_animate" title="<?php the_title(); ?>" href="<?php the_permalink(); ?>">
            <div class="post_block">
                <div class="preview_text">
                    <h3><?php the_title(); ?></h3>
                    <p><?php the_excerpt(); ?></p>
                </div>
                <div class="knowmore">Tu peux cliquer, so amazing -></div>
            </div>
        </a>
        <?php if( more_posts() ) : ?>
                        <hr class="betweenposts">
                    <?php endif; ?>
    <?php endwhile; ?>
<?php endif; ?>
</div>
</div>
<?php get_footer(); ?>