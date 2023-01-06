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
        <div class="row">
        <?php
            $args = array( 
                'post_type' => 'tutorial',
                'post_per_page' => -1,
                'order' => 'ASC',
                'order_by' => 'date'

            );
            $tutoriales = new WP_Query($args);
            if($tutoriales->have_posts(  )){
                while($tutoriales->have_posts()) {
                    $tutoriales->the_post();
                ?>
                <div class="col-md-4">
                    <figure>
                        <?php the_post_thumbnail('large');?>
                    </figure>
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
</main>


<?php get_footer(  );?>