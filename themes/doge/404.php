<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */

get_header(); ?>
<div id="stats_page">
    <div class="main single clearfix">
        <div class="col70">
	        <div class="post">
	            <h1 class="post-title">Vous êtes tombé sur un os !</h1>
	            <div class="post-content">Aucune page n'existe sur cette adresse !
				<img src="<?php bloginfo('template_url'); ?>/img/bone404.jpg" alt="" style="width:100%;">
	            </div>
	        </div>
        </div>
        <div class="col30 sidebar"><?php get_sidebar(); ?></div>
    </div>
</div>
<?php get_footer(); ?>