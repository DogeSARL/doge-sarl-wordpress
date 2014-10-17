<?php

include_once('MyWidget.php');

$prefix = "evenement";
$custom_meta_fields = array(
    array(
        'label'=> 'Date Evénement',
        'desc'  => 'Date de l\'Evénement',
        'id'    => $prefix . '_date',
        'type'  => 'text'
    )
);

add_filter( 'pre_get_posts', 'get_my_events' );

function get_my_events( $query ) {
    if ( is_home() )
        $query->set( 'post_type', array( 'evenement' ) );

    return $query;
}

add_action( 'init', 'create_post_type' );

function create_post_type() {
    register_post_type(
        'evenement',
        array(
            'labels' => array(
                'name'                => __( 'Evénements', THEMENAME ),
                'singular_name'       => __( 'Evénement', THEMENAME ),
                'add_new'             => __( 'Ajouter', THEMENAME ),
                'add_new_item'        => __( 'Ajouter un Evénement', THEMENAME ),
                'edit_item'           => __( 'Modifier un Evénement', THEMENAME ),
                'new_item'            => __( 'Nouvel Evénement', THEMENAME ),
                'all_items'           => __( 'Tous les Evénements', THEMENAME ),
                'view_item'           => __( 'Voir un Evénement', THEMENAME ),
                'search_items'        => __( 'Chercher un Evénement', THEMENAME ),
                'not_found'           => __( 'Aucun Evénement trouvé', THEMENAME ),
                'not_found_in_trash'  => __( 'Aucun Evénement dans la corbeille', THEMENAME ),
                'menu_name'           => __( 'Evénements', THEMENAME ),
            ),
            'public' => true,
            'rewrite' => [ 'slug' => 'evenements' ]
        )
    );
}

add_filter('manage_evenement_posts_columns', 'evenement_posts_heads');
function evenement_posts_heads( $defaults ) {
    $new = array();
    foreach($defaults as $key => $title) {
        if ($key=='date') // Put the Thumbnail column before the Author column
            $new['date_evenement'] = 'Date Evénement';
        $new[$key] = $title;
    }
    return $new;
}

add_filter( 'manage_edit-evenement_sortable_columns', 'evenement_table_sorting' );
function evenement_table_sorting( $columns ) {
    $columns['date_evenement'] = 'date_evenement';
    return $columns;
}

add_filter( 'request', 'evenement_date_column_orderby' );
function evenement_date_column_orderby( $vars ) {
    global $prefix;

    if ( isset( $vars['orderby'] ) && 'evenement_date' == $vars['orderby'] ) {
        $vars = array_merge( $vars, array(
            'meta_key' => $prefix . '_date',
            'orderby' => 'meta_value'
        ) );
    }

    return $vars;
}



add_action( 'restrict_manage_posts', 'evenement_table_filtering' );
function evenement_table_filtering() {
    global $wpdb, $post;

    $months = [
        1 => __('Janvier'),
        2 => __('Février'),
        3 => __('Mars'),
        4 => __('Avril'),
        5 => __('Mai'),
        6 => __('Juin'),
        7 => __('Juillet'),
        8 => __('Août'),
        9 => __('Septembre'),
        10 => __('Octobre'),
        11 => __('Novembre'),
        12 => __('Décembre'),
    ];

    if ( $post->post_type == 'evenement' ) {
        global $prefix;
        $dates = $wpdb->get_results(
            "SELECT EXTRACT(YEAR FROM meta_value) as year,
            EXTRACT( MONTH FROM meta_value ) as month
            FROM $wpdb->postmeta WHERE meta_key = '{$prefix}_date'
                AND post_id IN ( SELECT ID FROM $wpdb->posts
                    WHERE post_type = 'evenement' AND post_status != 'trash' )
                GROUP BY year, month " );

        echo '<select name="date_evenement">';
        echo '<option value="">' . __( 'Toutes les dates d\'événement', 'textdomain' ) . '</option>';
        foreach( $dates as $date ) {
            $month = $months[$date->month];
            $value = $date->year . '-' . ($month > 10 ? 0 . $date->month : $date->month ) . '-' . '01 00:00:00';
            $name = $month . ' ' . $date->year;

            $selected = ( !empty( $_GET['date_evenement'] ) AND $_GET['date_evenement'] == $value ) ? 'selected="select"' : '';
            echo '<option value="'.$value.'"'.$selected.'>' . $name . '</option>';
        }
        echo '</select>';
    }
}
add_filter( 'parse_query','evenement_table_filter' );
function evenement_table_filter( $query ) {
    global $prefix;

    if( is_admin() AND $query->query['post_type'] == 'evenement' ) {
        $qv = &$query->query_vars;
        $qv['meta_query'] = array();


        if( !empty( $_GET['date_evenement'] ) ) {
            $start_time = strtotime( $_GET['date_evenement'] );
            $end_time = mktime( 0, 0, 0, date( 'n', $start_time ) + 1, date( 'j', $start_time ), date( 'Y', $start_time ) );

            $end_date = date( 'Y-m-d H:i:s', $end_time );

            $qv['meta_query'][] = array(
                'field' => $prefix . 'date',
                'value' => array( $_GET['date_evenement'], $end_date ),
                'compare' => 'BETWEEN',
                'type' => 'DATETIME'
            );

        }

        if( !empty( $_GET['orderby'] ) AND $_GET['orderby'] == 'date_evenement' ) {
            $qv['orderby'] = 'meta_value';
            $qv['meta_key'] = $prefix . 'date';
            $qv['order'] = strtoupper( $_GET['order'] );
        }
    }
}

function add_admin_scripts( $hook ) {
    global $post;

    if ( $hook == 'post-new.php' || $hook == 'post.php' ) {
        if ( $post->post_type == 'evenement' ) {
            wp_enqueue_script(  'jquery', get_template_directory_uri().'/js/jquery.min.js' );
            wp_enqueue_script(  'bootstrap', get_template_directory_uri().'/js/bootstrap.js' );
            wp_enqueue_script(  'datetimepicker', get_template_directory_uri().'/js/bootstrap-datetimepicker.js' );
            wp_enqueue_script(  'datetimepicker-locale', get_template_directory_uri().'/js/locales/bootstrap-datetimepicker.fr.js', [], false, true );
            wp_enqueue_script(  'app', get_template_directory_uri().'/js/admin_datetimepicker.js', [], false, true );
            wp_enqueue_style(  'bootstrap', get_template_directory_uri().'/css/bootstrap.css' );
            wp_enqueue_style(  'bootstrap-datetime', get_template_directory_uri().'/css/bootstrap-datetimepicker.css' );
        }
    }
}

add_action( 'admin_enqueue_scripts', 'add_admin_scripts', 10, 1 );

add_action( 'manage_evenement_posts_custom_column', 'evenenement_table_content', 10, 2 );

function evenenement_table_content( $column_name, $post_id ) {
    global $prefix;
    if ($column_name == 'date_evenement') {
        $event_date = DateTime::createFromFormat( 'Y-m-d H:i', get_post_meta( $post_id, $prefix . '_date', true ) );
        echo $event_date->format('d/m/Y H:i');
    }
}


add_action('add_meta_boxes', 'create_meta_box');
function create_meta_box(){
    add_meta_box(
        'evenement_date_box', // $id
        'Date Evénement', // $title
        'show_evenement_date', // $callback
        'evenement', // $page
        'normal', // $context
        'high'); // $priority
}

function show_evenement_date() {
    global $custom_meta_fields, $post;


    // Use nonce for verification
    echo '<input type="hidden" name="custom_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';

    // Begin the field table and loop
    echo '<table class="form-table">';
    foreach ($custom_meta_fields as $field) {
        // get value of this field if it exists for this post
        $meta = get_post_meta($post->ID, $field['id'], true);
        // begin a table row with
        echo '<tr>

                <th><label for="'.$field['id'].'">'.$field['label'].'</label></th>
                <td>';
        echo '<div class="form-group">
                        <div class="input-group date" id="datetimepicker5">
                            <input data-date-format="dd/mm/yyyy hh:ii" type="text" class="form-control" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="30" />
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                        <span class="description">'.$field['desc'].'</span>
                    </div>';
        echo '</td></tr>';
    } // end foreach
    echo '</table>'; // end table
}

function save_evenement_date($post_id) {
    global $prefix;


    // verify nonce
    if (!wp_verify_nonce($_POST['custom_meta_box_nonce'], basename(__FILE__)))
        return $post_id;
    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return $post_id;
    // check permissions
    if ('evenement' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id))
            return $post_id;
    } elseif (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }

    if( !empty($_POST[$prefix . '_date']) ) {
        $old = DateTime::createFromFormat('Y-m-d H:i', get_post_meta($post_id, $prefix . '_date', true));
        $new = DateTime::createFromFormat('d/m/Y H:i', $_POST[$prefix . '_date']); ;

        if ($new && $new != $old) {
            update_post_meta($post_id,  $prefix . '_date', $new->format('Y-m-d H:i'));
        } elseif ('' == $new && $old) {
            delete_post_meta($post_id, $prefix . '_date', $old->format('Y-m-d H:i'));
        }
    }
}
add_action('save_post', 'save_evenement_date');

// register Foo_Widget widget
function register_my_widget() {
    register_widget( 'MyWidget' );
}
add_action( 'widgets_init', 'register_my_widget' );

function arphabet_widgets_init() {
    register_sidebar( array(
        'name' => 'Home right sidebar',
        'id' => 'home_right_1',
        'before_widget' => '<div>',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="rounded">',
        'after_title' => '</h2>',
    ) );
}
add_action( 'widgets_init', 'arphabet_widgets_init' );

add_action( 'wp_ajax_get_events', 'getEvents' );

function getEvents() {
    global $wpdb; // this is how you get access to the database

    $start_time = $_REQUEST['from'] / 1000;
    $end_time   = $_REQUEST['to'] / 1000;

    $start_date = date('Y-m-d H:i:s', $start_time);
    $end_date = date( 'Y-m-d H:i:s', $end_time );

    $results = $wpdb->get_results(
            "SELECT *
            FROM $wpdb->postmeta WHERE meta_key = '{$prefix}_date'
                AND post_id IN ( SELECT ID FROM $wpdb->posts
                    WHERE post_type = 'evenement' AND post_status != 'trash' )
                GROUP BY year, month " );

        new WP_Query( [
        'post_type' => 'evenement',
        'meta_key' => 'date_evenement'
    ] );

    echo "<pre>";
    var_dump("");
    echo "</pre>";

    die(); // this is required to terminate immediately and return a proper response
}

add_action('wp_enqueue_scripts','calendar_script');
function calendar_script(){
    if(is_page_template('calendar.php')){
        $data = [
            "template_directory_uri" => get_template_directory_uri(),
            "ajax_link" => admin_url( 'admin-ajax.php' )
        ];

        wp_deregister_script( 'jquery' );
        wp_enqueue_script('custom_jquery', get_template_directory_uri().'/js/jquery.min.js');
        wp_enqueue_script('bootstrap',get_template_directory_uri().'/js/bootstrap.js', [], false, true);
        wp_enqueue_script('underscore',get_template_directory_uri().'/js/components/underscore/underscore.min.js', [], false, true);
        wp_enqueue_script('calendar',get_template_directory_uri().'/js/calendar.js', [], false, true);
        wp_enqueue_script('calendar_fr',get_template_directory_uri().'/js/language/fr-FR.js', [], false, true);
        wp_enqueue_script('calendar_app',get_template_directory_uri().'/js/custom_app.js', [], false, true);

        wp_localize_script('calendar_app', 'calendar_options', $data);

    }
}
?>