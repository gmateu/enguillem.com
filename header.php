<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php wp_head() ?>
</head>
<body>

<header>
    <!--<div class="container">
        <div class="row align-items-center">
            <div class="col-4">
                <a href="/">
                    <img src="<?php echo get_template_directory_uri()?>/assets/img/logo.png" alt="logo">
                </a>
            </div>
            <div class="col-8">
                <nav>
                    <?php wp_nav_menu(
                        array(
                            'theme_location' => 'top_menu',
                            'menu_class'    => 'menu-principal',
                            'container_class' => 'container-menu',
                        )
                    ); 
                    ?>
                </nav>
            </div>
        </div>
    </div>-->
    <nav class="navbar navbar-expand-md navbar-dark">
        <a class="navbar-brand" href="home">
        <img src="<?php echo get_template_directory_uri()?>/assets/img/logo.png" alt="logo">
        </a>

        <button class="navbar-toggler" 
                type="button" 
                data-toggle="collapse" 
                data-target="#navbarNav" 
                aria-controls="navbarNav" 
                aria-expanded="false" 
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <?php
            wp_nav_menu( array(
                'theme_location'    => 'top_menu',
                'menu_class'    => 'menu-principal',
                'depth'             => 3,
                'container'         => 'div',
                'container_class'   => 'collapse navbar-collapse',
                'container_id'      => 'navbarNav',
                'menu_class'        => 'nav navbar-nav',
                'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
                'walker'            => new WP_Bootstrap_Navwalker(),
            ) );
        ?>
        
    </nav>
</header>