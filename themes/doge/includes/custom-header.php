<?php 

function enlightenment_header_style() {
	if( '' != get_header_image() ) {
		add_filter( 'enlightenment_archive_location', 'enlightenment_custom_header_archive_location', 10, 2 );
	}
	
	if( '' != get_header_image() || 'blank' == get_header_textcolor() || get_header_textcolor() != get_theme_support( 'custom-header', 'default-text-color' ) ) : ?>
	<style type="text/css">
	<?php if( '' != get_header_image() ) : ?>
	.archive-header {
		position: relative;
		padding: 74px 0;
		background-image: url(<?php header_image(); ?>);
		background-position: center;
		background-size: cover;
		border: none;
	}
	.grid-active .archive-header {
		padding-bottom: 74px;
		margin-bottom: 30px;
	}
	.archive-title {
		position: relative;
		z-index: 1;
		margin: 0;
		text-align: center;
	}
	.archive-description {
		margin-bottom: 0;
	}
	<?php endif; ?>
	<?php if( 'blank' == get_header_textcolor() ) : ?>
		.archive-title {
			position: absolute !important;
			clip: rect(1px, 1px, 1px, 1px);
		}
	<?php elseif( get_header_textcolor() != get_theme_support( 'custom-header', 'default-text-color' ) ) : ?>
		.archive-title {
			color: #<?php header_textcolor(); ?>;
		}
	<?php elseif( is_singular() && has_post_thumbnail() ) : ?>
		.archive-title {
			color: #fff; ?>;
		}
	<?php endif; ?>
	</style>
	<?php endif;
}

function enlightenment_admin_header_style() { ?>
	<style type="text/css">
	/*@import url("<?php echo ( is_ssl() ? 'https' : 'http' ); ?>://fonts.googleapis.com/css?family=Open+Sans:300,regular&subset=latin");*/
	.appearance_page_custom-header #headimg {
		width: auto;
		border: none;
	}
	#headimg {
		position: relative;
		padding: <?php if( '' != get_header_image() ) : ?>60px<?php else : ?>22px<?php endif; ?> 30px;
		background: #fff<?php if( '' != get_header_image() ) : ?> url("<?php echo get_header_image(); ?>") center<?php endif; ?>;
		background-position: center;
		background-size: cover;
		font-family: "Open Sans", sans-serif;
		font-weight: 300;
	}
	#headimg .overlay {
		<?php if( '' == get_header_image() ) : ?>
		display: none;
		<?php endif; ?>
		position: absolute;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		background: rgba(0, 0, 0, .4);
	}
	#headimg h1 {
		<?php if ( 'blank' == get_header_textcolor() || '' == get_header_textcolor() ) : ?>
		display: none;
		<?php endif; ?>
		position: relative;
		z-index: 1;
		/*float: left;*/
		margin: 8px 0;
		
		/*border-radius: 4px;*/
		color: #<?php header_textcolor() ?>;
		font-size: 40px;
		font-weight: 300;
		line-height: 1.1;
		<?php if( '' != get_header_image() ) : ?>
		text-align: center;
		<?php endif; ?>
	}
	</style>
	<?php
}

function enlightenment_custom_header_archive_location( $output, $args ) {
	$title_tag = enlightenment_open_tag( $args['title_tag'], $args['title_class'] );
	$overlay = enlightenment_open_tag( 'div', 'slide-overlay' ) . enlightenment_close_tag( 'div' );
	$output = str_replace( $title_tag, $overlay . $title_tag, $output );
	return $output;
}

function enlightenment_admin_header_image() { ?>
	<div id="headimg">
		<div class="overlay"></div>
		<h1>From the Blog</h1>
	</div>
	<?php
}