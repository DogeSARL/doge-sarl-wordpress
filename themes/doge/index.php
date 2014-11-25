<?php get_header(); ?>
	<div id="home">
		<div class="slide_wrapper">
			<ul class="slide_home">
				<li><img alt="" src="<?php bloginfo('template_url'); ?>/img/slide01.jpg"></li>
				<li><img alt="" src="<?php bloginfo('template_url'); ?>/img/slide02.jpg"></li>
			</ul>
		</div>
	    <div class="content_wrapper clearfix">
	    	<div class="col_50 wrapper_50_home">
	    		<div class="block_home_title">
    				<h2>Tendances swag du moment</h2>
	    			<p class="subtitle">Nice</p>
	    		</div>
	    		<hr>
	    		<div class="wrapper_blocks">
                    <?php $i = 1; ?>
                    <?php while( have_posts() && $i <= 2 ) : the_post() ?>
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
                    <?php if( more_posts() ) : ?>
                        <hr class="betweenposts">
                    <?php endif; ?>
                    <?php $i++; ?>
                    <?php endwhile; ?>
	    		</div>
	    	</div>
	    	<div class="col_50 wrapper_50_home">
	    		<div class="block_home_title">
	    			<h2>événements canins / rencontrer une star</h2>
	    			<p class="subtitle">Nice</p>
	    		</div>
	    		<hr>
	    		<div class="wrapper_blocks">
                    <?php $posts = get_my_events(); ?>
                    <?php $i = 1; ?>
                    <?php if( $posts->have_posts() ) : ?>
                        <?php while( $posts->have_posts() && $i <= 2 ) : $posts->the_post(); ?>
                            <a class="border_animate" title="<?php echo the_title(); ?>" href="<?php the_permalink(); ?>">
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

                            <?php if( $posts->current_post + 1 != $posts->post_count && $i != 2 ) : ?>
                                <hr class="betweenposts">
                            <?php endif; ?>
                            <?php $i++; ?>
                        <?php endwhile; ?>
                    <?php else: ?>
                        Wouf wouf wouf... Wouf !
                    <?php endif; ?>
	    		</div>
	    	</div>
	    </div>
	</div>
<?php get_footer(); ?>