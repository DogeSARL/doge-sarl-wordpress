<?php

//Menu back end
add_action( 'init', 'doge_register_theme_menu' );

function doge_register_theme_menu() {
    register_nav_menu( 'primary', 'Menu Principal' );
}
//-Menu back end

//side bars
register_sidebars();
register_sidebars(2, array('name'=>'Foobar %d'));
register_sidebars(2, array('before_title'=>'<h1>','after_title'=>'</h1>'));

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

//-side bars




























?>

