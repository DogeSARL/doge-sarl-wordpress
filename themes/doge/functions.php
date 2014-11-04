<?php


function doge_setup() {


	load_theme_textdomain( 'doge', get_template_directory() . '/languages' );
	
	// Add RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );

	// Image à la une
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 672, 372, true );
	add_image_size( 'doge-full-width', 1038, 576, true );

	// Affichage de 2 menus
	register_nav_menus( array(
		'primary'   => __( 'Menu Principal', 'doge' ),
		'secondary' => __( 'Menu Secondaire', 'doge' ),
	) );

	// font customisé
	add_theme_support( 'custom-background');

	// affichage de contenu à la une
	add_theme_support( 'featured-content', array(
		'featured_content_filter' => 'doge_get_featured_posts',
		'max_posts' => 6,
	) );
}
add_action( 'after_setup_theme', 'doge_setup' );

function doge_content_width() {
	if ( is_attachment() && wp_attachment_is_image() ) {
		$GLOBALS['content_width'] = 600;
	}
}
add_action( 'template_redirect', 'doge_content_width' );

function doge_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() ) {
		return $title;
	}

	// affiche le nom du blog 
	$title .= get_bloginfo( 'name', 'display' );

	// affiche la description du blog
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title = "$title $sep $site_description";
	}

	// affiche n° de la page si nécessaire
	if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
		$title = "$title $sep " . sprintf( __( 'Page %s', 'doge' ), max( $paged, $page ) );
	}

	return $title;
}
add_filter( 'wp_title', 'doge_wp_title', 10, 2 );

//ajoute une image en header
function doge_custom_header_setup() {

	add_theme_support( 'custom-header', apply_filters( 'doge_custom_header_args', array(
		'default-text-color'     => 'fff',
		'width'                  => 1060,
		'height'                 => 240,
		'flex-height'            => true,

	) ) );
}
add_action( 'after_setup_theme', 'doge_custom_header_setup' );

if ( ! function_exists( 'doge_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @see doge_custom_header_setup().
 *
 */
function doge_header_style() {
	$text_color = get_header_textcolor();

	// If no custom color for text is set, let's bail.
	if ( display_header_text() && $text_color === get_theme_support( 'custom-header', 'default-text-color' ) )
		return;

	// If we get this far, we have custom styles.
	?>
	<style type="text/css" id="doge-header-css">
	<?php
		// Has the text been hidden?
		if ( ! display_header_text() ) :
	?>
		.site-title,
		.site-description {
			clip: rect(1px 1px 1px 1px); /* IE7 */
			clip: rect(1px, 1px, 1px, 1px);
			position: absolute;
		}
	<?php
		// If the user has set a custom color for the text, use that.
		elseif ( $text_color != get_theme_support( 'custom-header', 'default-text-color' ) ) :
	?>
		.site-title a {
			color: #<?php echo esc_attr( $text_color ); ?>;
		}
	<?php endif; ?>
	</style>
	<?php
}
endif; // doge_header_style


if ( ! function_exists( 'doge_admin_header_style' ) ) :
/**
 * Style the header image displayed on the Appearance > Header screen.
 *
 * @see doge_custom_header_setup()
 *
 * @since Twenty Fourteen 1.0
 */
function doge_admin_header_style() {
?>
	<style type="text/css" id="doge-admin-header-css">
	.appearance_page_custom-header #headimg {
		background-color: #000;
		border: none;
		max-width: 1260px;
		min-height: 48px;
	}
	#headimg h1 {
		font-family: Lato, sans-serif;
		font-size: 18px;
		line-height: 48px;
		margin: 0 0 0 30px;
	}
	.rtl #headimg h1  {
		margin: 0 30px 0 0;
	}
	#headimg h1 a {
		color: #fff;
		text-decoration: none;
	}
	#headimg img {
		vertical-align: middle;
	}
	</style>
<?php
}
endif; // doge_admin_header_style

if ( ! function_exists( 'doge_admin_header_image' ) ) :
/**
 * Create the custom header image markup displayed on the Appearance > Header screen.
 *
 * @see doge_custom_header_setup()
 *
 * @since Twenty Fourteen 1.0
 */
function doge_admin_header_image() {
?>
	<div id="headimg">
		<?php if ( get_header_image() ) : ?>
		<img src="<?php header_image(); ?>" alt="">
		<?php endif; ?>
		<h1 class="displaying-header-text"><a id="name"<?php echo sprintf( ' style="color:#%s;"', get_header_textcolor() ); ?> onclick="return false;" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
	</div>
<?php
}
endif; // doge_admin_header_image
?>

