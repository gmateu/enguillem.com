<?php get_header(); ?>

<main class="container">
    <?php if ( have_posts(  )){
        while ( have_posts( ) ){
            the_post(  );
    ?>
            <h2><a href="<?=the_permalink()?>"><?=the_title()?></a></h2>
            
            <p><?php the_content(  );?></p>
    <?php
        } 
    }
    ?>
</main>
<?php get_footer(); ?>