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
?>

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" <?php language_attributes(); ?> > <!--<![endif]-->
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php
            if ( is_home() || is_front_page() ) {
              bloginfo( 'name' ); echo ' | '; bloginfo( 'description' );
            }  elseif ( is_404() ) {
              echo 'Error 404 | '; bloginfo( 'name' );
            } elseif ( is_single() ) {
              wp_title('');
            } else {
              echo wp_title( ' | ', 'false', 'right' ); bloginfo( 'name' );
        } ?></title>
        <meta name="description" content="">
        <!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/normalize.css">
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/js/jquery.bxslider/jquery.bxslider.css">
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,400italic,600,700' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/style.css">
        <script src="<?php bloginfo('template_url'); ?>/js/vendor/modernizr-2.6.2.min.js"></script>
            <?php wp_head(); ?>
    </head>
    <body class="custom-background">
        <header>
            <div id="header_menu" class="clearfix">
                <div class="logo_wrapper">
                    <a title="Accueil" href="<?php bloginfo('url'); ?>">
						<img src="<?php header_image(); ?>" height="<?php echo get_custom_header()->height; ?>" width="<?php echo get_custom_header()->width; ?>" alt="" />
                    </a>
                </div>
				<?php wp_nav_menu( array( 'theme_location' => 'header-menu' ) ); ?>
            </div>
			
        </header>
        <div id="container">
