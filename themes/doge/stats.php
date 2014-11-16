<?php
/*
Template Name: Statistiques
*/
?>
<?php get_header(); ?>
<div id="stats_page">
    <div class="main single clearfix">
        <div class="col70">
            <?php if (have_posts()) : ?>
                <?php while (have_posts()) : the_post(); ?>
                    <div class="post">
                        <h1 class="post-title"><?php the_title(); ?></h1>
                        <div class="post-content">
                            <?php the_content(); ?>
                            <p>Nombre de Posts : <strong><?php echo wp_count_posts()->publish; ?></strong></p>
                            <p>Nombre de Pages : <strong><?php echo wp_count_posts('page')->publish; ?></strong></p>
                            <p>Nombre de commentaires publiés : <strong><?php echo wp_count_comments()->approved; ?></strong></p>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
        <div class="col30 sidebar"><?php get_sidebar(); ?></div>
    </div>
</div>
<?php get_footer(); ?>