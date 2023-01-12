<?php


function init_template() {
    add_theme_support('post-thumbnails');
    add_theme_support( 'title-tag' );

    register_nav_menus( 
        array(
            'top_menu' => 'Menú Principal'
        )

    );

    //problema tamany imatges
    add_filter( 'big_image_size_threshold', '__return_false' );


}

add_action( 'after_setup_theme', 'init_template');

function assets(){
    wp_register_style('bootstrap','https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css',false,'4.4.1','all');
    wp_register_style('montserrat','https://fonts.googleapis.com/css?family=Montserrat&display=swap',false,'','all');
    wp_enqueue_style('main-style', get_stylesheet_uri(), array('bootstrap','montserrat'),'1.0','all');

    wp_register_script( 'popper', 'https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js', false, true );
    wp_enqueue_script( 'bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js', array('jquery','popper'), true);

    wp_enqueue_script( 'custom', get_template_directory_uri()."/assets/js/custom.js", false,"1.1", true );

    //ajax
    //wp_localize_script('custom', 'pg', array('ajaxurl' => admin_url('admin-ajax.php')));

    wp_localize_script( 'custom', 'pg', array(
        'ajaxurl'    => admin_url( 'admin-ajax.php' ),
        'apiurl'    =>home_url( 'wp-json/pg/v1')
    ) );

}

add_action( 'wp_enqueue_scripts', 'assets' );

function sidebar(){
    register_sidebar(
        array(
            'name' => 'Pie de página',
            'id' => 'footer',
            'description' =>'Zona de widgets para pie de página',
            'before_title' =>'<p>',
            'after_title' =>'</p>',
            'before_widget' =>'<div id="%1$s" class="%2$s">',
            'after_widget' =>'</div>'
        )
    );
}
add_action( 'widgets_init', 'sidebar');

function tutoriales_type(){
    $lables=array(
        'name' => 'Tutoriales',
        'singular_name' => 'Tutorial',
        'manu_name' => 'Tutoriales',
    );
    $args = array(
        'label' =>  'Tutoriales',
        'description' => 'Tutoriales Varios',
        'labels' => $lables,
        'supports' => array('title', 'editor','thumbnail', 'revisions'),
        'public' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-welcome-learn-more',
        'can_export' => true,
        'publicy_queryable' => true,
        'rewrite' => true,
        'show_in_rest' => true
    );
    register_post_type( 'tutorial', $args);
}
add_action( 'init', 'tutoriales_type' );

//taxonomy

function pgRegisterTax(){
    $args=array(
        'hierarchical' => true,
        'labels' => array(
            'name' => 'Categorias de Tutoriales',
            'singular_name' => 'Categoria de Tutoriales'
        ),
        'show_in_nav_menu' => true,
        'show_admin_column' => true,
        'rewrite' => array('slug'=>'categoria-tutoriales')
    );

    register_taxonomy( 'categoria-tutoriales', array('tutorial'), $args );
}

add_action( 'init', 'pgRegisterTax' );

function filtreTutorials(){
    $args=array(
        'post_type' => 'tutorial',
        'posts_per_page' => -1,
        'order' => 'ASC',
        'orderby' =>'title'
    );
    if ($_POST['categoria']){
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'categoria-tutoriales',
                'field' =>'slug',
                'terms' => $_POST['categoria']
            )
        );
    }
    $tutoriales=new WP_Query($args);
    if($tutoriales->have_posts()){
        $return=array();
        while($tutoriales->have_posts()){
            $tutoriales->the_post();
            $return[] = array(
                'imagen' => get_the_post_thumbnail(get_the_ID(), 'large'),
                'link' => get_permalink(),
                'titulo' => get_the_title()
            );
        }
        wp_send_json( $return );
    }


}
add_action('wp_ajax_nopriv_filtreTutorials','filtreTutorials');
add_action('wp_ajax_filtreTutorials','filtreTutorials');

function novedadesAPI(){
    register_rest_route(
        'pg/v1',
        '/novedades/(?P<cantidad>\d+)',
        array(
            'methods'=>'GET',
            'callback'=>'pedidoNovedades',
        )
    );
}

function pedidoNovedades($data){
    $args=array(
        'post_type' => 'post',
        'posts_per_page' => $data['cantidad'],
        'order' => 'ASC',
        'orderby' =>'title'
    );
    
    $novedades=new WP_Query($args);
    if($novedades->have_posts()){
        $return=array();
        while($novedades->have_posts()){
            $novedades->the_post();
            $return[] = array(
                'imagen' => get_the_post_thumbnail(get_the_ID(), 'large'),
                'link' => get_permalink(),
                'titulo' => get_the_title()
            );
        }
        return $return;
    }


}

add_action( 'rest_api_init', 'novedadesAPI' );


add_action('init', 'pgRegisterBlock');
function pgRegisterBlock()
{
    // Requiere los parámetros generados automaticamente por WP Scripts
    $asset_file = include_once get_template_directory().'/blocks/build/index.asset.php';
    //Registra el script
    wp_register_script(
        'pgb-js',
        get_template_directory_uri().'/blocks/build/index.js',
        $asset_file['dependencies'],
        $asset_file['version']
    );

    register_block_type(
        'pgb/basic-block',
        array(
            'editor_script' => 'pgb-js'
        )
    );
}