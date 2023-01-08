<?php get_header(  );?>

<main class="container">
    <div class="lista-tutoriales my-3">
        <div class="row">
        <?php 
        
        if ( have_posts(  )){
            while ( have_posts( ) ){
                the_post(  );
        ?>
            <div class="col-12">
                <h1 class='my-3 text-center'>
                     <?php the_title();?>
                </h1>
            </div>
            <?php
            } 
        }?>
            <div class="col-12">
                <?php
                echo do_shortcode( '[contact-form-7 id="95" title="Formulario de contacto tutoriales"]' );
                ?>
            </div>
        </div>
    </div>
</main>


<?php get_footer(  );?>