<?php
/**
 * Created by PhpStorm.
 * User: Guillaume
 * Date: 15/10/14
 * Time: 10:48
 */

class MyWidget extends WP_Widget {
    /**
     * Sets up the widgets name etc
     */
    public function __construct() {
        parent::__construct( 'MyWidget', 'My Link Widget',
            array( 'description' => 'A Link Widget' , 'before_widget' => "<p>",
                'after_widget' => "</p>") ); //
    }

    /**
     * Outputs the content of the widget
     *
     * @param array $args
     * @param array $instance
     */
    public function widget( $args, $instance ) {
        if( isset($instance['link']) && isset($instance['title']) )
            echo "<a href='".$instance['link']."'>" . $instance['title'] . "</a>";
        else
            echo "Pas de lien";
    }

    /**
     * Outputs the options form on admin
     *
     * @param array $instance The widget options
     */
    public function form( $instance ) {
        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        }
        else {
            $title = __( 'New title', 'text_domain' );
        }

        if ( isset( $instance[ 'link' ] ) ) {
            $link = $instance[ 'link' ];
        }
        else {
            $link = __( 'New link', 'text_domain' );
        }
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'link' ); ?>"><?php _e( 'Link:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'link' ); ?>" name="<?php echo $this->get_field_name( 'link' ); ?>" type="text" value="<?php echo esc_attr( $link ); ?>">
        </p>
    <?php
    }

    /**
     * Processing widget options on save
     *
     * @param array $new_instance The new options
     * @param array $old_instance The previous options
     */
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['link'] = ( ! empty( $new_instance['link'] ) ) ? strip_tags( $new_instance['link'] ) : '';

        return $instance;
    }
}