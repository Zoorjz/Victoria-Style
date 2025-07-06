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
                    ?>
                    <a class="navbar-brand site-title" href="<?php echo esc_url(home_url('/')); ?>">
                        <?php bloginfo('name'); ?>
                    </a>
                    <?php
                } else {
                    ?>
                    <a class="navbar-brand site-title" href="<?php echo esc_url(home_url('/')); ?>">
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
                    <?php
                    // Get custom secondary navigation items
                    $custom_secondary_nav_items = get_option('custom_secondary_navigation_items', array());
                    
                    // Default secondary navigation items if none exist
                    if (empty($custom_secondary_nav_items)) {
                        $custom_secondary_nav_items = array(
                            array('title' => 'About', 'url' => '#', 'target' => '_self'),
                            array('title' => 'Atelie', 'url' => '#', 'target' => '_self'),
                            array('title' => 'Cloth', 'url' => '#', 'target' => '_self'),
                            array('title' => 'Sewing Machines', 'url' => '#', 'target' => '_self'),
                            array('title' => 'Blog', 'url' => '#', 'target' => '_self'),
                            array('title' => 'Contacts', 'url' => '#', 'target' => '_self')
                        );
                    }
                    
                    if (!empty($custom_secondary_nav_items)) {
                        echo '<ul class="navbar-nav">';
                        foreach ($custom_secondary_nav_items as $item) {
                            echo '<li class="nav-item">';
                            echo '<a class="nav-link" href="' . esc_url($item['url']) . '" target="' . esc_attr($item['target']) . '">' . esc_html($item['title']) . '</a>';
                            echo '</li>';
                        }
                        echo '</ul>';
                    }
                    ?>
                </div>
            </div>
        </nav>
    </header>

    