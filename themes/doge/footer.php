	<footer>
		<div id="insidefooter">
			<?php wp_nav_menu( array( 'theme_location' => 'secondary-menu' ) ); ?>
		</div>
	</footer>
</div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="js/vendor/jquery-1.10.2.min.js"><\/script>')</script>
<script src="<?php bloginfo('template_url'); ?>/js/plugins.js"></script>
<script src="<?php bloginfo('template_url'); ?>/js/jquery.bxslider/jquery.bxslider.min.js"></script>
<script src="<?php bloginfo('template_url'); ?>/js/main.js"></script>
<?php wp_footer(); ?>
</body>
</html>