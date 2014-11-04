<?php

add_filter( 'enlightenment_the_author_posts_link_wrap_args', 'enlightenment_glyphicons_the_author_posts_link_wrap_args' );

function enlightenment_glyphicons_the_author_posts_link_wrap_args( $args ) {
	$args['before'] .= '<span class="glyphicon glyphicon-user"></span> ';
	return $args;
}

add_filter( 'enlightenment_the_time_wrap_args', 'enlightenment_glyphicons_the_time_wrap_args' );

function enlightenment_glyphicons_the_time_wrap_args( $args ) {
	$args['before'] .= '<span class="glyphicon glyphicon-time"></span> ';
	return $args;
}

add_filter( 'enlightenment_the_category_wrap_args', 'enlightenment_glyphicons_the_category_wrap_args' );

function enlightenment_glyphicons_the_category_wrap_args( $args ) {
	$args['before'] .= '<span class="glyphicon glyphicon-bookmark"></span> ';
	return $args;
}

add_filter( 'enlightenment_meta_image_size_args', 'enlightenment_glyphicons_meta_image_size_args' );

function enlightenment_glyphicons_meta_image_size_args( $args ) {
	$args['before'] .= '<span class="glyphicon glyphicon-picture"></span> ';
	return $args;
}

add_filter( 'comments_number', 'enlightenment_glyphicons_comments_number', 10, 2 );

function enlightenment_glyphicons_comments_number( $output, $number ) {
	global $wp_current_filter;
	if( in_array( 'enlightenment_entry_meta', $wp_current_filter ) )
		$output = '<span class="glyphicon glyphicon-comment"></span> ' . $output;
	return $output;
}

add_filter( 'enlightenment_edit_post_link_wrap_args', 'enlightenment_glyphicons_edit_post_link_wrap_args' );

function enlightenment_glyphicons_edit_post_link_wrap_args( $args ) {
	$args['before'] .= '<span class="glyphicon glyphicon-edit"></span> ';
	return $args;
}

add_filter( 'enlightenment_comment_form_fields_args', 'enlightenment_glyphicons_comment_form_fields_args' );

function enlightenment_glyphicons_comment_form_fields_args( $args ) {
	$args['before_author_label'] .= '<span class="glyphicon glyphicon-user"></span> ';
	$args['before_email_label'] .= '<span class="glyphicon glyphicon-envelope"></span> ';
	$args['before_url_label'] .= '<span class="glyphicon glyphicon-globe"></span> ';
	return $args;
}

add_filter( 'enlightenment_comment_form_defaults_args', 'enlightenment_glyphicons_comment_form_defaults_args' );

function enlightenment_glyphicons_comment_form_defaults_args( $args ) {
	$args['before_label'] .= '<span class="glyphicon glyphicon-edit"></span> ';
	return $args;
}