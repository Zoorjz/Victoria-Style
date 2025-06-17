<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <header id="masthead" class="site-header">
        <nav class="navbar navbar-expand-lg navbar-light bg-white">
            <div class="container">
                <?php
                if (has_custom_logo()) {
                    the_custom_logo();
                } else {
                    ?>
                    <a class="navbar-brand" href="<?php echo esc_url(home_url('/')); ?>">
                        <?php bloginfo('name'); ?>
                    </a>
                    <?php
                }
                ?>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#primary-menu" aria-controls="primary-menu" aria-expanded="false">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse d-flex justify-content-between align-items-centers" id="primary-menu">
                    <?php   
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'menu_id'        => 'primary-menu',
                        'container'      => false,
                        'menu_class'     => 'navbar-nav me-lg-auto mb-2 mb-lg-0',
                        'fallback_cb'    => '__return_false',
                        'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                        'depth'          => 2,
                        'walker'         => new Bootstrap_5_Nav_Walker()
                    ));
                    ?>
                    <!-- Language Switcher -->
                    <div class="language-switcher ms-auto me-3">
                        <div class="btn-group" role="group" aria-label="Language switcher">
                            <a href="#" class="btn btn-outline-secondary active" data-lang="rus">RUS</a>
                            <a href="#" class="btn btn-outline-secondary" data-lang="geo">GEO</a>
                            <a href="#" class="btn btn-outline-secondary" data-lang="eng">ENG</a>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
        
        <!-- Secondary Navigation -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light border-top">
            <div class="container">
                <div class="collapse navbar-collapse justify-content-center" id="secondary-menu">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="#">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Atelie</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Cloth</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Sewing Machines</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Blog</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Contacts</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <div id="content" class="site-content"> 