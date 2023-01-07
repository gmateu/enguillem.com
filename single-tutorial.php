<?php get_header(  );?>

<main class="container my-3">
    <?php if ( have_posts(  )){
        while ( have_posts( ) ){
            the_post(  );
    ?>
            <h1 class="my-3"><?php the_title( );?></h1>
            <div class="row">
                <div class="col-12">
                    <?php the_post_thumbnail( 'large' );?>
                </div>
                <div class="col-12">
                    <?php the_content(  );?>
                </div>
            </div>
            <?php
            //llista de tutorials 
            $args = array(
                'post_type' => 'tutorial',
                'post_per_page' =>4,
                'order' => 'DESC',
                'order_by' => 'date_published',
            );
            $tutoriales = new WP_Query( $args);
            if($tutoriales->have_posts()){
            ?>
              <div class="row justify-content-around">
                <div class="col-12 my-2 text-center">
                    <h3>Tutoriales</h3>
                </div>
                <?php 
                    while ( $tutoriales->have_posts() ){
                        $tutoriales->the_post();
                        ?>
                        <div class="col-3 my-3 text-center">
                            <?php the_post_thumbnail( 'thumbnail' ); ?>
                            <h5>
                                <a href="<?=the_permalink()?>">
                                    <?=the_title(  )?>
                                </a>
                            </h5>
                        </div>
                        <?php
                }?>
              </div>
            <?php
            }

            ?>
    <?php


        } 
    }
    ?>
</main>


<?php get_footer(  );?>