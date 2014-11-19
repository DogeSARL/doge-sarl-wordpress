<?php
/*
  Template Name: Template widget left
  Description: Une page classique contenu gauche widget à droite
*/
 get_header(); ?>
<div id="single_event_page" class="clearfix">
    <div class="main single clearfix">
		<div class="col30 sidebar"><?php get_sidebar(); ?></div>
        <div class="col70B">
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



