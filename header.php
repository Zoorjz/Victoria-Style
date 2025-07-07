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
                    <div class="language-switcher ms-auto me-3" id="language-switcher">
                        <div class="btn-group" role="group" aria-label="Language switcher">
                            <?php 
                            $current_lang = victoria_style_get_current_language();
                            $languages = array(
                                'rus' => 'RUS',
                                'geo' => 'GEO', 
                                'eng' => 'ENG'
                            );
                            
                            foreach ($languages as $lang_code => $lang_label) {
                                $active_class = ($current_lang === $lang_code) ? ' active' : '';
                                echo '<a href="#" class="btn btn-outline-secondary language-btn' . $active_class . '" data-lang="' . esc_attr($lang_code) . '" id="lang-' . esc_attr($lang_code) . '">' . esc_html($lang_label) . '</a>';
                            }
                            ?>
                        </div>
                    </div>
                    
                    <script>
                    // Initialize language switcher immediately
                    document.addEventListener('DOMContentLoaded', function() {
                        // Store current language in a global variable
                        window.currentSiteLanguage = '<?php echo esc_js($current_lang); ?>';
                        
                        // Add click event listeners to language buttons
                        const languageButtons = document.querySelectorAll('.language-switcher .language-btn');
                        
                        languageButtons.forEach(function(button) {
                            button.addEventListener('click', function(e) {
                                e.preventDefault();
                                
                                const selectedLang = this.getAttribute('data-lang');
                                console.log('Language button clicked:', selectedLang);
                                
                                // Store language preference
                                document.cookie = 'site_language=' + selectedLang + '; path=/; max-age=' + (365 * 24 * 60 * 60);
                                
                                // Reload page to apply server-side language filtering
                                window.location.reload();
                            });
                        });
                        
                        // Language switching now uses page refresh for reliable server-side filtering
                    });
                    </script>
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
                            array('title' => '<ru_>О нас<ru_><ka_>ჩვენს შესახებ<ka_><eng_>About<eng_>', 'url' => '#', 'target' => '_self'),
                            array('title' => '<ru_>Ателье<ru_><ka_>სახელოსნო<ka_><eng_>Atelier<eng_>', 'url' => '#', 'target' => '_self'),
                            array('title' => '<ru_>Ткани<ru_><ka_>ქსოვილები<ka_><eng_>Cloth<eng_>', 'url' => '#', 'target' => '_self'),
                            array('title' => '<ru_>Швейные машины<ru_><ka_>საკერავი მანქანები<ka_><eng_>Sewing Machines<eng_>', 'url' => '#', 'target' => '_self'),
                            array('title' => '<ru_>Блог<ru_><ka_>ბლოგი<ka_><eng_>Blog<eng_>', 'url' => '#', 'target' => '_self'),
                            array('title' => '<ru_>Контакты<ru_><ka_>კონტაქტი<ka_><eng_>Contacts<eng_>', 'url' => '#', 'target' => '_self')
                        );
                    }
                    
                    if (!empty($custom_secondary_nav_items)) {
                        echo '<ul class="navbar-nav">';
                        foreach ($custom_secondary_nav_items as $item) {
                            echo '<li class="nav-item">';
                            echo '<a class="nav-link" href="' . esc_url($item['url']) . '" target="' . esc_attr($item['target']) . '" data-original-text="' . esc_attr($item['title']) . '">' . esc_html(victoria_style_display_multilang($item['title'])) . '</a>';
                            echo '</li>';
                        }
                        echo '</ul>';
                    }
                    ?>
                </div>
            </div>
        </nav>
    </header>

    