<?php
add_action("after_switch_theme", "init_doge_theme");
add_theme_support( 'post-thumbnails' );

function init_doge_theme(){
    global $wpdb;

    $table = "create table  if not exists {$wpdb->prefix}doge_events(
                post_id bigint(20) unsigned not null,
                user_id bigint(20) unsigned not null,
                UNIQUE (post_id, user_id),
                foreign key(post_id) references {$wpdb->posts} ( ID ),
                foreign key(user_id) references {$wpdb->users} ( ID )
    );";

    $wpdb->query( $table );
}

include_once('MyWidget.php');

$prefix = "evenement";
$custom_meta_fields = array(
    array(
        'label'=> 'Date Début Evénement',
        'desc'  => 'Date de début l\'Evénement',
        'id'    => $prefix . '_date_debut',
        'type'  => 'datetime'
    ),
    array(
        'label'=> 'Date Fin Evénement',
        'desc'  => 'Date de fin l\'Evénement',
        'id'    => $prefix . '_date_fin',
        'type'  => 'datetime'
    ),
    array(
        'label' => 'Couleur' ,
        'desc' => 'Couleur de la pastille sur le calendrier',
        'id' => $prefix . '_color',
        'type' => 'select',
        'options' => array( 'event-important' => __('Rouge'), 'event-success' => __('Vert'), 'event-warning' => __('Jaune'), 'event-info' => __('Bleu'), 'event-inverse' => __('Noir'), 'event-special' => "Violet" )
    )
);

/*add_filter( 'pre_get_posts', 'get_my_events' );*/

function get_my_events() {
    global $custom_meta_fields;

    $date = new DateTime();
    $args = array(
        'post_type' => 'evenement',
        'meta_key' => $custom_meta_fields[0]['id'],
        'meta_value' => $date->format("Y-m-d H:i:s"),
        'meta_compare' => '>'
    );

    $query = new WP_Query( $args );

    return $query;
}

function more_posts( $posts = null ) {
    global $wp_query;

    return $posts->current_post + 1 < $posts->post_count;
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
            'supports' => array( 'title', 'editor', 'comments', 'thumbnail' ),
            'rewrite' => [ 'slug' => 'evenements' ]
        )
    );
}

add_filter('manage_evenement_posts_columns', 'evenement_posts_heads');
function evenement_posts_heads( $defaults ) {
    $new = array();
    foreach($defaults as $key => $title) {
        if ($key=='date'){ // Put the Thumbnail column before the Author column
            $new['date_evenement_debut'] = 'Date Début Evénement';
            $new['date_evenement_fin'] = 'Date Fin Evénement';
            $new['evenement_couleur'] = 'Couleur';
        }
        $new[$key] = $title;
    }
    return $new;
}

add_filter( 'manage_edit-evenement_sortable_columns', 'evenement_table_sorting' );
function evenement_table_sorting( $columns ) {
    $columns['date_evenement_debut'] = 'date_evenement_debut';
    $columns['date_evenement_fin'] = 'date_evenement_fin';
    return $columns;
}

add_filter( 'request', 'evenement_date_column_orderby' );
function evenement_date_column_orderby( $vars ) {
    global $prefix;

    if ( isset( $vars['orderby'] ) && 'evenement_date_debut' == $vars['orderby'] ) {
        $vars = array_merge( $vars, array(
            'meta_key' => $prefix . '_date_debut',
            'orderby' => 'meta_value'
        ) );
    }

    if ( isset( $vars['orderby'] ) && 'evenement_date_fin' == $vars['orderby'] ) {
        $vars = array_merge( $vars, array(
            'meta_key' => $prefix . '_date_fin',
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
            FROM $wpdb->postmeta WHERE meta_key = '{$prefix}_date_fin'
                AND post_id IN ( SELECT ID FROM $wpdb->posts
                    WHERE post_type = 'evenement' AND post_status != 'trash' )
                GROUP BY year, month " );

        echo '<select name="date_evenement_debut">';
        echo '<option value="">' . __( 'Toutes les dates de début d\'événement', 'textdomain' ) . '</option>';
        foreach( $dates as $date ) {
            $month = $months[$date->month];
            $value = $date->year . '-' . ($month > 10 ? 0 . $date->month : $date->month ) . '-' . '01 00:00:00';
            $name = $month . ' ' . $date->year;

            $selected = ( !empty( $_GET['date_evenement_debut'] ) AND $_GET['date_evenement_debut'] == $value ) ? 'selected="select"' : '';
            echo '<option value="'.$value.'"'.$selected.'>' . $name . '</option>';
        }
        echo '</select>';

        echo '<select name="date_evenement_fin">';
        echo '<option value="">' . __( 'Toutes les dates de fin d\'événement', 'textdomain' ) . '</option>';
        foreach( $dates as $date ) {
            $month = $months[$date->month];
            $value = $date->year . '-' . ($month > 10 ? 0 . $date->month : $date->month ) . '-' . '01 00:00:00';
            $name = $month . ' ' . $date->year;

            $selected = ( !empty( $_GET['date_evenement_fin'] ) AND $_GET['date_evenement_fin'] == $value ) ? 'selected' : '';
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


        if( !empty( $_GET['date_evenement_debut'] ) ) {
            $debut_start_time = strtotime( $_GET['date_evenement_debut'] );
            $debut_end_time = mktime( 0, 0, 0, date( 'n', $debut_start_time ) + 1, date( 'j', $debut_start_time ), date( 'Y', $debut_start_time ) );
        } else {
            $debut_start_time = '1990-01-01 00:00:00';
        }

        if( !empty( $_GET['date_evenement_fin'] ) ) {
            $fin_start_time = strtotime( $_GET['date_evenement_fin'] );
            $fin_end_time = mktime( 0, 0, 0, date( 'n', $fin_start_time ) + 1, date( 'j', $fin_start_time ), date( 'Y', $fin_start_time ) );
        } else {
            $fin_start_time = new DateTime();
            $fin_start_time->modify('+5 year');
            $fin_start_time = $fin_start_time->format('Y-m-d H:i:s');
        }

        if( !empty( $_GET['date_evenement_debut'] ) ) {
            $end_date = date( 'Y-m-d H:i:s', $debut_end_time );

            $qv['meta_query'][] = array(
                'field' => $prefix . 'date_debut',
                'value' => array( $_GET['date_evenement_debut'], $end_date ),
                'compare' => 'BETWEEN',
                'type' => 'DATETIME'
            );
        }

        if( !empty( $_GET['date_evenement_fin'] ) ){
            $end_date = date( 'Y-m-d H:i:s', $fin_end_time );

            $qv['meta_query'][] = array(
                'field' => $prefix . 'date_fin',
                'value' => array( $_GET['date_evenement_fin'], $end_date ),
                'compare' => 'BETWEEN',
                'type' => 'DATETIME'
            );
        }

        if( !empty( $_GET['orderby'] ) AND $_GET['orderby'] == 'date_evenement_debut' ) {
            $qv['orderby'] = 'meta_value';
            $qv['meta_key'] = $prefix . 'date';
            $qv['order'] = strtoupper( $_GET['order'] );
        }


        if( !empty( $_GET['orderby'] ) AND $_GET['orderby'] == 'date_evenement_debut' ) {
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

            wp_enqueue_style(  'bootstrap', get_template_directory_uri().'/components/bootstrap3/css/bootstrap.css' );
            wp_enqueue_style(  'bootstrap-datetime', get_template_directory_uri().'/css/bootstrap-datetimepicker.css' );
        }
    }
}

add_action( 'admin_enqueue_scripts', 'add_admin_scripts', 10, 1 );

add_action( 'manage_evenement_posts_custom_column', 'evenenement_table_content', 10, 2 );

function evenenement_table_content( $column_name, $post_id ) {
    global $prefix, $custom_meta_fields;

    if ($column_name == 'date_evenement_debut') {
        $event_date = DateTime::createFromFormat( 'Y-m-d H:i', get_post_meta( $post_id, $prefix . '_date_debut', true ) );
        if( $event_date ) {
            echo $event_date->format('d/m/Y H:i');
        }
    }
    if ($column_name == 'date_evenement_fin') {
        $event_date = DateTime::createFromFormat( 'Y-m-d H:i', get_post_meta( $post_id, $prefix . '_date_fin', true ) );
        if( $event_date ){
            echo $event_date->format('d/m/Y H:i');
        }
    }
    if ($column_name == 'evenement_couleur') {
        echo $custom_meta_fields[2]['options'][get_post_meta( $post_id, $prefix . '_color', true )];
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
        if( $field['type'] == 'datetime'){
            // get value of this field if it exists for this post
            $meta = get_post_meta($post->ID, $field['id'], true);
            if( $meta ){
                $meta = DateTime::createFromFormat("Y-m-d H:i", $meta);
            }

            // begin a table row with
            echo '<tr>

                <th><label for="'.$field['id'].'">'.$field['label'].'</label></th>
                <td>';
            echo '<div class="form-group">
                        <div class="input-group date">
                            <input required data-date-format="dd/mm/yyyy hh:ii" type="text" class="form-control" name="'.$field['id'].'" id="'.$field['id'].'" value="'.( $meta instanceof DateTime ? $meta->format("d/m/Y h:i") : '').'" size="30" />
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>                        </div>
                        <span class="description">'.$field['desc'].'</span>
                    </div>';
            echo '</td></tr>';
        }
        else if( $field['type'] == 'select' ){
            $meta = get_post_meta($post->ID, $field['id'], true);
            // begin a table row with
            echo '<tr>

                <th><label for="'.$field['id'].'">'.$field['label'].'</label></th>
                <td>';
            echo '<div class="form-group">
                        <div class="input-group">
                            <select class="form-control" name="'.$field['id'].'" id="'.$field['id'].'" />';

            foreach( $field['options'] as $key => $value ) {
                $selected = $meta == $key ? 'selected' : '';
                echo "<option value=\"{$key}\" {$selected}>" . $value . "</option>";
            }
            echo '           </select></div>
                        <span class="description">'.$field['desc'].'</span>
                    </div>';
            echo '</td></tr>';
        }

    } // end foreach
    echo '</table>'; // end table
}

function save_evenement_date($post_id) {
    global $custom_meta_fields,$prefix;

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

    foreach( $custom_meta_fields as $field ) {
        if( !empty($_POST[$field['id']]) ) {
            if( $field['type'] == 'datetime' ){
                $old = DateTime::createFromFormat('Y-m-d H:i', get_post_meta($post_id, $field['id'], true));
                $new = DateTime::createFromFormat('d/m/Y H:i', $_POST[$field['id']]); ;

                if ($new && $new != $old) {
                    update_post_meta($post_id,  $field['id'], $new->format('Y-m-d H:i'));
                } else if ('' == $new && $old) {
                    delete_post_meta($post_id, $field['id'], $old->format('Y-m-d H:i'));
                }
            }

            else if( $field['type'] == 'select' ){
                $old = get_post_meta($post_id, $field['id']);
                $new = $_POST[$field['id']];

                if ($new && $new != $old) {
                    update_post_meta($post_id,  $field['id'], $new);
                } else if ('' == $new && $old) {
                    delete_post_meta($post_id, $field['id'], $old);
                }
            }
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
    global $prefix,$wpdb; // this is how you get access to the database

    $start_time = $_REQUEST['from'] / 1000;
    $end_time   = $_REQUEST['to'] / 1000;

    $start_time = date( 'Y-m-d H:i:s', $start_time );
    $end_time = date( 'Y-m-d H:i:s', $end_time );

    $finLabel = $prefix . '_date_fin';
    $debutLabel = $prefix . '_date_debut';
    $colorLabel = $prefix . '_color';

    $results = $wpdb->get_results(
        "SELECT posts.*, GROUP_CONCAT(meta_value) as meta_values
            FROM $wpdb->posts as posts , $wpdb->postmeta as postmetas
                WHERE post_type = 'evenement' AND post_status != 'trash'
                AND posts.ID = postmetas.post_id
                AND ( meta_key = '$finLabel' OR meta_key = '$debutLabel' OR meta_key = '$colorLabel'  )
                GROUP BY posts.ID"
    );

    $resultsArray = [];
    foreach( $results as $result ) {
        $values = explode( ',', $result->meta_values );

        foreach( $values as $key => $value ){
            if( substr( $value, 0, 5 ) == "event" ){
                $class = $value;
                unset($values[$key]);
            }
        }

        $dateArray = [];
        foreach( $values as $value ){
            $dateArray[] = $value;
        }

        $start = strtotime( $dateArray[0] ) * 1000 ;
        $end = strtotime( $dateArray[1] ) * 1000 ;

        $resultsArray[] = [
            "id" => $result->ID,
            "title" => $result->post_title,
            "url" => get_permalink($result->ID),
            "class" => $class,
            "start" => $start,
            "end" => $end
        ];
    }

    $jsonResults['success'] = 1;
    $jsonResults['result'] = $resultsArray;
    $jsonResults = json_encode( $jsonResults );

    echo $jsonResults;
    die(); // this is required to terminate immediately and return a proper response
}

$ajaxData = [
    "template_directory_uri" => get_template_directory_uri(),
    "ajax_link" => admin_url( 'admin-ajax.php' )
];

add_action( 'wp_enqueue_scripts', "event_front_script" );
function event_front_script(){
    global $ajaxData;

    $ajaxData['user_id'] = get_current_user_id();
    $ajaxData['post_id'] = get_the_ID();

    wp_enqueue_script('custom_jquery', get_template_directory_uri().'/js/jquery.min.js');
    wp_enqueue_script('event_button_script', get_template_directory_uri().'/js/event_button_script.js', [], false, true);

    wp_localize_script('event_button_script', 'ajax_options', $ajaxData);
}

add_action( 'wp_ajax_subscribe', 'subscribe' );
function subscribe(){
    global $wpdb;

    if( $wpdb->insert( $wpdb->prefix."doge_events", [ "post_id" => $_REQUEST['post_id'], "user_id" => $_REQUEST['user_id'] ] ) ){
        echo 1;
    }
    else {
        echo 0;
    }

    die;
}

add_action( 'wp_ajax_unsubscribe', 'unsubscribe');
function unsubscribe(){
    global $wpdb;

    if( $wpdb->delete( $wpdb->prefix.'doge_events', array( 'user_id' => $_POST['user_id'], 'post_id' => $_POST['post_id'] ) ) )
        echo 1;
    else
        echo 0;

    die;
}

function isSubscribed( $userId, $postID ){
    global $wpdb;

    $count = $wpdb->get_var(
                $wpdb->prepare( " SELECT count(*) FROM {$wpdb->prefix}doge_events
                  WHERE post_id = %d
                  AND   user_id = %d ",
                $postID, $userId )
             );

    return $count > 0;
}

add_action('wp_enqueue_scripts','calendar_script');
function calendar_script(){
    global $ajaxData;
    if(is_page_template('calendar.php')){

        wp_deregister_script( 'jquery' );
        wp_enqueue_script('custom_jquery', get_template_directory_uri().'/js/jquery.min.js');
        wp_enqueue_script('bootstrap',get_template_directory_uri().'/js/bootstrap.js', [], false, true);
        wp_enqueue_script('underscore',get_template_directory_uri().'/js/components/underscore/underscore.min.js', [], false, true);
        wp_enqueue_script('calendar',get_template_directory_uri().'/js/calendar.js', [], false, true);
        wp_enqueue_script('calendar_fr',get_template_directory_uri().'/js/language/fr-FR.js', [], false, true);
        wp_enqueue_script('calendar_app',get_template_directory_uri().'/js/custom_app.js', [], false, true);

        wp_localize_script('calendar_app', 'ajax_options', $ajaxData);

        wp_enqueue_style('bootstrap_css', get_template_directory_uri().'/components/bootstrap3/css/bootstrap.css');
        wp_enqueue_style('calendar_css', get_template_directory_uri().'/css/calendar.css');
    }
}

add_action( 'after_setup_theme', 'register_my_menus' );
function register_my_menus() {
  register_nav_menus(
    array(
      'header-menu' => __( 'Menu Principal' ),
      'secondary-menu' => __( 'Menu Secondaire' )
    )
  );
}
add_action( 'init', 'register_my_menus' );

add_theme_support( 'custom-header' );

$args = array(
	'width'         => 80,
	'height'        => 50,
	'default-image' => get_template_directory_uri() . '/img/header.jpg',
);
add_theme_support( 'custom-header', $args );



/*add_filter('show_admin_bar', '__return_false');*/