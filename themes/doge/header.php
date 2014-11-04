<?php
/**
 * The Header for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Doge_wordpress
 * @since Doge wordpress 1.0
 */
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) & !(IE 8)]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width">
    <title><?php wp_title( '|', true, 'right' ); ?></title>
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <!--[if lt IE 9]>
    <script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
    <![endif]-->
    <?php wp_head(); ?>
    <link href="<?php echo bloginfo("template_url"); ?>/css/bootstrap.min.css" rel="stylesheet" />
	<link href="<?php echo bloginfo("template_url"); ?>style.css" rel="stylesheet" />
	
</head>
<body <?php body_class(); ?>>
	<div id="menu" role="navigation">
	</div>
    <div class="container">
        <header>
			<?php if ( get_header_image() ) : ?>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
					<img src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height;   ?>" alt=""  <?php $blog_title = get_bloginfo(); ?>>
				</a>
			<?php endif; ?>
            <div class="row">
                <div class="col-sm-12">
					<?php wp_nav_menu( array( 'container_class' => 'main-nav', 'theme_location' => 'primary' ) ); ?>
                </div>
            </div>
        </header>

        <div class="slideshow">
            Bloc Visuel / Slideshow

        </div>


