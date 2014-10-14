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
    <title><?php wp_title( '|', true, 'right' ); ?></title>:
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <!--[if lt IE 9]>
    <script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
    <![endif]-->
    <?php wp_head(); ?>
    <link href="<?php echo bloginfo("template_url"); ?>/css/bootstrap.css" rel="stylesheet" />
    <link href="<?php echo bloginfo("template_url"); ?>/css/calendar.css" rel="stylesheet" />
</head>

<body>
    <div class="container">
        <header>
            <div class="row">
                <div class="col-sm-12">
                    Bloc header
                </div>
            </div>
        </header>

        <div class="slideshow">
            Bloc Visuel / Slideshow
        </div>


