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
                <!-- Desktop Logo (hidden on mobile) -->
                <div class="desktop-logo d-none d-lg-flex">
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
                </div>
                
                <!-- Mobile burger menu (left side on mobile) -->
                <button class="navbar-toggler d-lg-none" type="button" id="mobile-menu-toggle" aria-controls="mobile-side-panel" aria-expanded="false">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <!-- Mobile Logo (centered, only visible on mobile) -->
                <div class="mobile-logo d-lg-none position-absolute start-50 translate-middle-x">
                    <?php
                    if (has_custom_logo()) {
                        // Get the custom logo and add custom-logo-phone class
                        $custom_logo = get_custom_logo();
                        $custom_logo = str_replace('custom-logo', 'custom-logo custom-logo-phone', $custom_logo);
                        echo $custom_logo;
                    } else {
                        ?>
                        <a class="navbar-brand site-title" href="<?php echo esc_url(home_url('/')); ?>">
                            <?php bloginfo('name'); ?>
                        </a>
                        <?php
                    }
                    ?>
                </div>

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
                    <div class="language-switcher ms-auto" id="language-switcher">
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
        
        <!-- Floating Back to Home Button -->
        <?php if (!is_front_page() || isset($_GET['singleproduct'])) : ?>
        <div class="floating-back-home">
            <div class="container">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="floating-back-home-link" title="<?php echo esc_attr(victoria_style_display_multilang('<ru_>Вернуться на главную<ru_><ka_>მთავარზე დაბრუნება<ka_><eng_>Back to Home<eng_>')); ?>">
                    <span class="arrow-icon">←</span>
                    <span class="floating-back-home-text" data-original-text="<ru_>На главную<ru_><ka_>მთავარზე<ka_><eng_>Home<eng_>">
                        <?php echo victoria_style_display_multilang('<ru_>На главную<ru_><ka_>მთავარზე<ka_><eng_>Home<eng_>'); ?>
                    </span>
                </a>
            </div>
        </div>
        <?php endif; ?>
    </header>
    
    <!-- Mobile Side Panel -->
    <div class="mobile-side-panel" id="mobile-side-panel">
        <div class="mobile-side-panel-overlay" id="mobile-side-panel-overlay"></div>
        <div class="mobile-side-panel-content">
            <div class="mobile-side-panel-header">
                <h5><?php echo esc_html(victoria_style_display_multilang('<ru_>Меню<ru_><ka_>მენიუ<ka_><eng_>Menu<eng_>')); ?></h5>
                <button class="mobile-side-panel-close" id="mobile-side-panel-close">&times;</button>
            </div>
            <div class="mobile-side-panel-body">
                <!-- Navigation Section -->
                <div class="mobile-navigation-section">
                    <h6 class="mobile-section-title"><?php echo esc_html(victoria_style_display_multilang('<ru_>Навигация<ru_><ka_>ნავიგაცია<ka_><eng_>Navigation<eng_>')); ?></h6>
                    <ul class="mobile-navigation-list">
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
                            foreach ($custom_secondary_nav_items as $item) {
                                echo '<li>';
                                echo '<a href="' . esc_url($item['url']) . '" target="' . esc_attr($item['target']) . '" data-original-text="' . esc_attr($item['title']) . '">' . esc_html(victoria_style_display_multilang($item['title'])) . '</a>';
                                echo '</li>';
                            }
                        }
                        ?>
                    </ul>
                </div>
                
                <!-- Categories Section -->
                <div class="mobile-categories-section">
                    <h6 class="mobile-section-title"><?php echo esc_html(victoria_style_display_multilang('<ru_>Категории<ru_><ka_>კატეგორიები<ka_><eng_>Categories<eng_>')); ?></h6>
                <?php
                // Get categories for mobile panel
                $homepage_categories = get_option('homepage_categories', array());
                
                // Default categories if none exist
                if (empty($homepage_categories)) {
                    $homepage_categories = array(
                        array('name' => '<ru_>Швейные машины<ru_><ka_>საკერავი მანქანები<ka_><eng_>Sewing Machines<eng_>', 'icon' => 'fas fa-sewing-machine', 'slug' => 'sewing-machines', 'link' => '#?categories=13'),
                        array('name' => '<ru_>Ткани<ru_><ka_>ქსოვილები<ka_><eng_>Fabrics<eng_>', 'icon' => 'fas fa-tshirt', 'slug' => 'fabrics', 'link' => '#'),
                        array('name' => '<ru_>Аксессуары<ru_><ka_>აქსესუარები<ka_><eng_>Accessories<eng_>', 'icon' => 'fas fa-tools', 'slug' => 'accessories', 'link' => '#'),
                        array('name' => '<ru_>Выкройки<ru_><ka_>ნიმუშები<ka_><eng_>Patterns<eng_>', 'icon' => 'fas fa-cut', 'slug' => 'patterns', 'link' => '#')
                    );
                }
                
                foreach ($homepage_categories as $index => $category) :
                    $subcategories = !empty($category['subcategories']) ? $category['subcategories'] : array();
                    $has_subcategories = !empty($subcategories);
                ?>
                <div class="mobile-category-item">
                    <div class="mobile-category-header" data-category="<?php echo esc_attr($category['slug']); ?>">
                        <a href="<?php echo esc_url(!empty($category['link']) ? $category['link'] : '#'); ?>" class="mobile-category-link">
                            <?php if (!empty($category['icon'])) : ?>
                                <i class="<?php echo esc_attr($category['icon']); ?> me-2"></i>
                            <?php endif; ?>
                            <?php echo esc_html(victoria_style_display_multilang($category['name'])); ?>
                        </a>
                        <?php if ($has_subcategories) : ?>
                        <button class="mobile-category-toggle" type="button">
                            <span class="arrow-down"></span>
                        </button>
                        <?php endif; ?>
                    </div>
                    
                    <?php if ($has_subcategories) : ?>
                    <div class="mobile-subcategory-content">
                        <?php foreach ($subcategories as $subcategory) : ?>
                        <div class="mobile-subcategory-section">
                            <?php if (!empty($subcategory['title_link']) && $subcategory['title_link'] !== '#') : ?>
                                <h6><a href="<?php echo esc_url($subcategory['title_link']); ?>"><?php echo esc_html(victoria_style_display_multilang($subcategory['title'])); ?></a></h6>
                            <?php else : ?>
                                <h6><?php echo esc_html(victoria_style_display_multilang($subcategory['title'])); ?></h6>
                            <?php endif; ?>
                            
                            <?php if (!empty($subcategory['items'])) : ?>
                            <ul class="mobile-subcategory-items">
                                <?php foreach ($subcategory['items'] as $item) : ?>
                                <li>
                                    <?php if (is_array($item)) : ?>
                                        <a href="<?php echo esc_url($item['url']); ?>"><?php echo esc_html(victoria_style_display_multilang($item['name'])); ?></a>
                                    <?php else : ?>
                                        <a href="#"><?php echo esc_html(victoria_style_display_multilang($item)); ?></a>
                                    <?php endif; ?>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
                </div> <!-- End mobile-categories-section -->
            </div>
        </div>
    </div>
    
    <script>
    // Mobile Side Panel Functionality
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
        const mobileSidePanel = document.getElementById('mobile-side-panel');
        const mobileSidePanelOverlay = document.getElementById('mobile-side-panel-overlay');
        const mobileSidePanelClose = document.getElementById('mobile-side-panel-close');
        
        // Open mobile panel
        if (mobileMenuToggle) {
            mobileMenuToggle.addEventListener('click', function(e) {
                e.preventDefault();
                console.log('Mobile menu toggle clicked');
                if (mobileSidePanel) {
                    mobileSidePanel.classList.add('active');
                    document.body.classList.add('mobile-panel-open');
                }
            });
        }
        
        // Close mobile panel
        function closeMobilePanel() {
            if (mobileSidePanel) {
                mobileSidePanel.classList.remove('active');
                document.body.classList.remove('mobile-panel-open');
            }
        }
        
        if (mobileSidePanelClose) {
            mobileSidePanelClose.addEventListener('click', closeMobilePanel);
        }
        
        if (mobileSidePanelOverlay) {
            mobileSidePanelOverlay.addEventListener('click', closeMobilePanel);
        }
        
        // Toggle subcategories in mobile panel
        const mobileCategoryToggles = document.querySelectorAll('.mobile-category-toggle');
        mobileCategoryToggles.forEach(function(toggle) {
            toggle.addEventListener('click', function(e) {
                e.preventDefault();
                const categoryItem = this.closest('.mobile-category-item');
                const subcategoryContent = categoryItem.querySelector('.mobile-subcategory-content');
                const arrow = this.querySelector('span');
                
                if (subcategoryContent.style.display === 'block') {
                    subcategoryContent.style.display = 'none';
                    arrow.classList.remove('arrow-up');
                    arrow.classList.add('arrow-down');
                } else {
                    subcategoryContent.style.display = 'block';
                    arrow.classList.remove('arrow-down');
                    arrow.classList.add('arrow-up');
                }
            });
        });
    });
    </script>

    