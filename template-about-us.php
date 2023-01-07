<?php 
//Template Name: sobre nosotros
get_header(  );
$fields=get_fields();
//echo "fields: ".var_dump($fields);
?>

<main class="container">
    
</main>

<main class="container">
    <h1><?php echo $fields['nombre']?></h1>
    <?php if ( have_posts(  )){
        while ( have_posts( ) ){
            the_post(  );
    ?>
            <img src="<?php echo $fields['imagen'];?>" alt="">      
            <p><?php the_content(  );?></p>
    <?php
        } 
    }
    ?>
</main>


<?php get_footer(  );?>