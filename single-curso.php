<?php get_header(  );?>

<main class="container my-3">
    <div class="metabox">
        <p>
            <a href="<?php echo site_url('cursos');?>" class="metabox__home">
                cursos
            </a>
        </p>
    </div>
    <?php if ( have_posts(  )){
        while ( have_posts( ) ){
            the_post(  );
    ?>
            <h1 class="my-3"><?php the_title( );?></h1>
            <div class="row">
                <div class="col-12 text-center">
                    <?php the_post_thumbnail( 'medium' );?>
                </div>
                <div class="col-12">
                    <?php the_content(  );?>
                </div>
            </div>
            <?php
        }
    }?>
    </main>


<?php get_footer(  );?>