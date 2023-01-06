<?php get_header(  );?>

<main class="container">
   <h1><?php the_archive_title(  );?></h1>
   <div class="row">
   <?php
    if(have_posts(  )){
        while(have_posts()){
            the_post(  );?>

            <div class="col-4">
                <a href="<?=the_permalink();?>">
                    <?=the_post_thumbnail('large')?>
                </a>
                <h4><?=the_title( )?></h4>
            </div>

            
        <?php
        }
    }
   ?>

   </div>
</main>


<?php get_footer(  );?>
