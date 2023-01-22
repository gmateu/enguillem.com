<?php get_header(  );?>

<main class="container">
    <?php if ( have_posts(  )){
        while ( have_posts( ) ){
            the_post(  );
    ?>
            <h1 class="my-3"><?php the_title( );?></h1>
            
            <?php the_content(  );?>
    <?php
        } 
    }
    ?>
    <div class="lista-tutoriales">
        <h2 class="text-center">Tutoriales</h2>
        <div class="row my-3">
            <div class="col-12">
                    <?php
                    $terms = get_terms('categoria-tutoriales',array('hide_empty'=>true));
                    //echo "Aaaa".var_dump($terms);
                    ?>
                <select class="form-control" name="categoria-tutoriales" id="categoria-tutoriales">
                    <option value="">Todas las categorias</option>
                    <?php
                        
                    ?>
                    <?php
                        foreach ($terms as $term){
                            ?>
                                <option value="<?=$term->slug?>"><?=$term->name?></option>
                            <?php
                        }
                    ?>
                </select>
            </div>
        </div>
        <div id="resultado" class="row">
        <?php
            $args = array( 
                'post_type' => 'tutorial',
                'posts_per_page' => 4,
                'order' => 'DESC',
                'order_by' => 'date'

            );
            $tutoriales = new WP_Query($args);
            if($tutoriales->have_posts(  )){
                while($tutoriales->have_posts()) {
                    $tutoriales->the_post();
                ?>
                <div class="col-md-3">
                        <?php the_post_thumbnail('large');?>
                    <h4 class='my-3 text-center'>
                        <a href="<?php the_permalink();?>">
                            <?php the_title();?>
                        </a>
                    </h4>
                </div>
                <?php
                }
            }
        ?>
        </div>
    </div>
    <div class="lista-curos">
        <div class="row">
            <div class="col-12">
                <h2 class="text-center">Cursos</h2>
            </div>
        </div>
        <div id="resultado-cursos" class="row">
            <?php
                $args = array( 
                    'post_type' => 'curso',
                    'posts_per_page' => 4,
                    'order' => 'DESC',
                    'order_by' => 'date'
    
                );
                $cursos = new WP_Query($args);
                if($cursos->have_posts()) {
                    while($cursos->have_posts()){
                        $cursos->the_post(  );
                        ?>
                    <div class="col-md-3">
                        <?php the_post_thumbnail('large');?>
                    <h4 class='my-3 text-center'>
                        <a href="<?php the_permalink();?>">
                            <?php the_title();?>
                        </a>
                    </h4>
                </div>
                    <?php
                    }
                }
    
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <h2 class="text-center">Novedades</h2>
        </div>
        <div id="resultado-novedades"></div>
    </div>
</main>


<?php get_footer(  );?>