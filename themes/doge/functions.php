<?php


    if (function_exists('register_sidebar')) {

    register_sidebar(array(

    'name' => 'HomeLeft Widgets',

    'id'   => 'homeleft-widgets',

    'description'   => 'Widget Area',

    'before_widget' => '<div id="one" class="two">',

    'after_widget' => '</div>',

    'before_title' => '<h2>',

    'after_title'   => '</h2>'

    ));

    }


    /*CUSTOM POST TYPE PANAPANORAMA*/
/*add_action('init', 'my_custom_init');
function my_custom_init(){
	register_post_type('jour_pana', array(
	  'label' => __('Jours Panapanorama'),
	  'singular_label' => __('Jours Panapanorama'),
	  'public' => true,
	  'show_ui' => true,
	  'capability_type' => 'post',
	  'hierarchical' => false,
	  'supports' => array('title')
	));
}*/




class MyNewWidget extends WP_Widget {

	function MyNewWidget() {
		// Instantiate the parent object
		parent::__construct( 'MyNewWidget', 'My New Widget Title' );
	}

	function widget( $args, $instance ) {
		// Widget output
	}

	function update( $new_instance, $old_instance ) {
		// Save widget options
	}

	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'New title', 'text_domain' );
		}
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<?php 
	}
}

function myplugin_register_widgets() {
	register_widget( 'MyNewWidget' );
}

add_action( 'widgets_init', 'myplugin_register_widgets' );