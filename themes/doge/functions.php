<?php

    /*if (function_exists('register_sidebar')) {

    register_sidebar(array(

    'name' => 'HomeLeft Widgets',

    'id'   => 'homeleft-widgets',

    'description'   => 'Widget Area',

    'before_widget' => '<div id="one" class="two">',

    'after_widget' => '</div>',

    'before_title' => '<h2>',

    'after_title'   => '</h2>'

    ));

    }*/

//Menu back end
add_action( 'init', 'doge_register_theme_menu' );

function doge_register_theme_menu() {
    register_nav_menu( 'primary', 'Menu Principal' );
}