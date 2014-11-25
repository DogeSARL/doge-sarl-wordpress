<?php
/**
	Afficher les articles
 */

get_header(); ?>
		<div id="single_event_page">

			<?php if ( have_posts() ) : ?>

			<div class="main single clearfix">
				<div class="col70">
					<div class="post clearfix">
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
					</div>
				
			<?php
					// Start the Loop.
					while ( have_posts() ) : the_post(); ?>
						<a class="border_animate" title="<?php the_title(); ?>" href="<?php the_permalink(); ?>">
						<div class="post_block">
							<div class="post_image_preview border_container">
								<div class="border_left"></div>
								<div class="border_top"></div>
								<div class="border_right"></div>
								<div class="border_bottom"></div>
                                <?php if( !has_post_thumbnail() ) : ?>
                                    <img alt="" src="<?php bloginfo('template_url'); ?>/img/postpreview.jpg">
                                <?php else : ?>
                                    <?php the_post_thumbnail(); ?>
                                <?php endif; ?>
							</div>
							<div class="preview_text">
                                <h3><?php the_title(); ?></h3>
                                <p><?php the_excerpt(); ?></p>
							</div>
							<div class="knowmore">Tu peux cliquer, so amazing -></div>
						</div>
					</a>
					

					<?php endwhile; ?>
					</div>
			</div>
			?>
		</div><!-- #content -->
<?php get_footer(); ?>