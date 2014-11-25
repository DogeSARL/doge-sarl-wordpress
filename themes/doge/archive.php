<?php
/**
	Afficher les articles
 */

get_header(); ?>

	<section id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

			<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="page-title">
					<?php
						if ( is_day() ) :
							printf( __( 'Daily Archives: %s', 'doge' ), get_the_date() );

						elseif ( is_month() ) :
							printf( __( 'Monthly Archives: %s', 'doge' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'doge' ) ) );

						elseif ( is_year() ) :
							printf( __( 'Yearly Archives: %s', 'doge' ), get_the_date( _x( 'Y', 'yearly archives date format', 'doge' ) ) );

						else :
							_e( 'Archives', 'doge' );

						endif;
					?>
				</h1>
			</header><!-- .page-header -->

			<?php
					// Start the Loop.
					while ( have_posts() ) : the_post();

						/*
						 * Include the post format-specific template for the content. If you want to
						 * use this in a child theme, then include a file called called content-___.php
						 * (where ___ is the post format) and that will be used instead.
						 */
						get_template_part( 'content', get_post_format() );

					endwhile;
					// Previous/next page navigation.
//					doge_paging_nav();

				else :
					// If no content, include the "No posts found" template.
					get_template_part( 'content', 'none' );

				endif;
			?>
		</div><!-- #content -->
	</section><!-- #primary -->

<?php
get_sidebar( 'content' );
get_sidebar();
get_footer();
