<?php
/*
  Template Name: Template no widget
  Description: Une page classique contenu gauche sans widget à droite
*/
 get_header(); ?>
<div id="single_event_page" class="clearfix">
    <div class="main single clearfix">
        <div class="col70">
            <?php if (have_posts()) : ?>
                <?php while (have_posts()) : the_post(); ?>
                    <div class="post">
                    <h1 class="post-title"><?php the_title(); ?></h1>
                    <div class="post-content">
                        <?php the_content(); ?>
                    </div>
                    </div>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php get_footer(); ?>



