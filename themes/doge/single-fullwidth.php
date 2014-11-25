<?php
/*
  Template Name: Template full width
  Description: Une page classique full width
*/
 get_header(); ?>
<div id="single_event_page" class="clearfix">
    <div class="main single clearfix">
        <div class="colfull">
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



