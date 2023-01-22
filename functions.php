<?php
require_once get_template_directory() . '/inc/class-wp-bootstrap-navwalker.php';

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

  wp_enqueue_script('main-university-js', get_theme_file_uri('/build/index.js'), array('jquery'), '1.0', true);
  wp_enqueue_style('university_main_styles', get_theme_file_uri('/build/style-index.css'));
  wp_enqueue_style('university_extra_styles', get_theme_file_uri('/build/index.css'));


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

function setLabels($singular, $plural,$masculi){
        $todos="Todos Los";
        if(!$masculi){
            $todos="Todas Las";
        }
       $labels=array(
        'name' => $plural,
        'singular_name' => $singular,
        'menu_name' => $plural,
        'add_new_item' => 'Añadir nuevo '.$singular,
        'edit_item' => 'Editar '.$singular,
        'all_items' => $todos.' '.$plural
    );
    return $labels;
}

function tutoriales_type(){
    $labels=setLabels('Tutorial', 'Tutoriales',true);
    $args = array(
        'label' =>  'Tutoriales',
        'description' => 'Tutoriales Varios',
        'labels' => $labels,
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


function cursos_type(){
    $lables=setLabels('Curso', 'Cursos',true);
    $args = array(
        'label' =>  'Cursos',
        'description' => 'Cursos Varios',
        'labels' => $lables,
        'hierarchical' => true,
        'supports' => array('title', 'editor','thumbnail', 'revisions','page-attributes'),
        'public' => true,
        'show_in_menu' => true,
        'menu_position' => 6,
        'menu_icon' => 'dashicons-welcome-learn-more',
        'can_export' => true,
        'publicy_queryable' => true,
        'rewrite' => true,
        'show_in_rest' => true
    );
    register_post_type( 'curso', $args);
}
add_action( 'init', 'cursos_type' );

function lecciones_type(){
    $lables=setLabels('Lección', 'Lecciones',false);
    $args = array(
        'label' =>  'Lecciones',
        'description' => 'Lecciones Varias',
        'labels' => $lables,
        'hierarchical' => false,
        'supports' => array('title', 'editor','thumbnail', 'revisions','page-attributes'),
        'public' => true,
        'show_in_menu' => true,
        'menu_position' => 7,
        'menu_icon' => 'dashicons-welcome-learn-more',
        'can_export' => true,
        'publicy_queryable' => true,
        'rewrite' => true,
        'show_in_rest' => true
    );
    register_post_type( 'leccion', $args);
}
add_action( 'init', 'lecciones_type' );

//relacionar ctp
function cpt_parent_meta_box() {
	add_meta_box( 'lesson-parent', 'Curso', 'cpt_lesson_parent_meta_box', 'leccion', 'side', 'high' );
}
add_action( 'add_meta_boxes', 'cpt_parent_meta_box' );
function cpt_lesson_parent_meta_box( $post ) {
	$post_type_object = get_post_type_object( $post->post_type );
	$pages = wp_dropdown_pages( array( 'post_type' => 'curso', 'selected' => $post->post_parent, 'name' => 'parent_id',
                                 'show_option_none' => __( '(no parent)' ), 'sort_column'=> 'menu_order, post_title', 'echo' => 0 ) );
if ( ! empty( $pages ) ) {
		echo $pages;
	}
}


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
            'editor_script' => 'pgb-js',
            'render_callback' => 'pgRenderDynamicBlock'
        )
    );
}

function pgRenderDynamicBlock($attributes, $content)
{
    return '<h2>'.$attributes['content'].'</h2>';
}