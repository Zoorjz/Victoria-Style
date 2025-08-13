<?php
if (!defined('ABSPATH')) exit;

// Include the Bootstrap 5 Nav Walker class
require get_template_directory() . '/inc/class-bootstrap-5-nav-walker.php';

// Theme Setup
function victoria_style_setup() {
    // Add theme support
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
    add_theme_support('customize-selective-refresh-widgets');
    add_theme_support('responsive-embeds');

    // Register navigation menus
    register_nav_menus(array(
        'primary' => esc_html__('Primary Menu', 'victoria-style'),
        'footer' => esc_html__('Footer Menu', 'victoria-style'),
    ));
}
add_action('after_setup_theme', 'victoria_style_setup');

// Enqueue scripts and styles
function victoria_style_scripts() {
    // Bootstrap 5 CSS
    wp_enqueue_style('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css');
    
    // Google Fonts
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@600;800&display=swap', false);
    
    // Theme stylesheet
    wp_enqueue_style('victoria-style', get_stylesheet_uri());
    
    // Bootstrap 5 JS Bundle
    wp_enqueue_script('bootstrap-bundle', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js', array(), '5.3.0', true);
    
    // Custom JS
    wp_enqueue_script('victoria-style-js', get_template_directory_uri() . '/js/custom.js', array('jquery'), '1.0', true);
}
add_action('wp_enqueue_scripts', 'victoria_style_scripts');

// Register widget areas
function victoria_style_widgets_init() {
    register_sidebar(array(
        'name'          => esc_html__('Sidebar', 'victoria-style'),
        'id'            => 'sidebar-1',
        'description'   => esc_html__('Add widgets here.', 'victoria-style'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));
}
add_action('widgets_init', 'victoria_style_widgets_init');

// Custom template tags
require get_template_directory() . '/inc/template-tags.php';

// Custom functions
require get_template_directory() . '/inc/custom-functions.php';

// Footer settings
require get_template_directory() . '/inc/footer-settings.php';

// Security configuration
require get_template_directory() . '/inc/security-config.php';

// Database connection function
function victoria_style_db_connect() {
    global $wpdb;
    
    // You can use WordPress's built-in $wpdb object for database operations
    // Example of custom database connection if needed:
    /*
    $custom_db = new wpdb(DB_USER, DB_PASSWORD, 'custom_database', DB_HOST);
    if ($custom_db->last_error) {
        error_log('Database connection error: ' . $custom_db->last_error);
        return false;
    }
    return $custom_db;
    */
    
    return $wpdb;
}

// Add carousel management to WordPress admin
function victoria_style_carousel_settings() {
    add_options_page(
        'Carousel Settings',
        'Carousel Settings',
        'manage_options',
        'carousel-settings',
        'victoria_style_carousel_settings_page'
    );
}
add_action('admin_menu', 'victoria_style_carousel_settings');

// Register carousel settings
function victoria_style_carousel_settings_init() {
    register_setting('carousel_settings', 'carousel_slides');
    
    add_settings_section(
        'carousel_section',
        'Carousel Slides Management',
        'victoria_style_carousel_section_callback',
        'carousel_settings'
    );
    
    add_settings_field(
        'carousel_slides',
        'Carousel Slides',
        'victoria_style_carousel_slides_callback',
        'carousel_settings',
        'carousel_section'
    );
}
add_action('admin_init', 'victoria_style_carousel_settings_init');

// Section callback
function victoria_style_carousel_section_callback() {
    echo '<p>Manage your homepage carousel slides here. You can add up to 5 slides.</p>';
}

// Carousel slides callback
function victoria_style_carousel_slides_callback() {
    $slides = get_option('carousel_slides', array());
    
    // Ensure we have at least 3 empty slides
    while (count($slides) < 3) {
        $slides[] = array(
            'title' => '',
            'description' => '',
            'link' => '',
            'image' => ''
        );
    }
    
    echo '<div id="carousel-slides-container">';
    foreach ($slides as $index => $slide) {
        echo '<div class="carousel-slide-item" style="border: 1px solid #ddd; padding: 15px; margin: 10px 0; background: #f9f9f9;">';
        echo '<h4>Slide ' . ($index + 1) . '</h4>';
        
        echo '<p><label><strong>Title:</strong><br>';
        victoria_style_multilang_input_field('carousel_slides[' . $index . '][title]', $slide['title'], '<ru_>Швейные машины<ru_><ka_>საკერავი მანქანები<ka_><eng_>Sewing Machines<eng_>');
        echo '</label></p>';
        
        echo '<p><label><strong>Description:</strong><br>';
        victoria_style_multilang_input_field('carousel_slides[' . $index . '][description]', $slide['description'], '<ru_>Откройте наш ассортимент швейных машин<ru_><ka_>აღმოაჩინეთ ჩვენი საკერავი მანქანების ასორტიმენტი<ka_><eng_>Discover our range of sewing machines<eng_>', 'textarea');
        echo '</label></p>';
        
        echo '<p><label><strong>Link URL:</strong><br>';
        echo '<input type="url" name="carousel_slides[' . $index . '][link]" value="' . esc_attr($slide['link']) . '" style="width: 100%;" placeholder="https://example.com" /></label></p>';
        
        echo '<p><label><strong>Image URL:</strong><br>';
        echo '<input type="text" name="carousel_slides[' . $index . '][image]" value="' . esc_attr($slide['image']) . '" style="width: 70%;" id="carousel_image_' . $index . '" />';
        echo '<input type="button" class="button carousel-upload-button" data-target="carousel_image_' . $index . '" value="Upload Image" style="margin-left: 10px;" /></label></p>';
        
        if (!empty($slide['image'])) {
            echo '<p><img src="' . esc_url($slide['image']) . '" style="max-width: 200px; height: auto; border: 1px solid #ddd;" /></p>';
        }
        
        echo '</div>';
    }
    echo '</div>';
    
    echo '<p><button type="button" id="add-carousel-slide" class="button">Add New Slide</button></p>';
}

// Settings page
function victoria_style_carousel_settings_page() {
    ?>
    <div class="wrap">
        <h1>Carousel Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('carousel_settings');
            do_settings_sections('carousel_settings');
            submit_button();
            ?>
        </form>
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        // Handle media uploader
        var custom_uploader;
        $('.carousel-upload-button').click(function(e) {
            e.preventDefault();
            var target = $(this).data('target');
            
            if (custom_uploader) {
                custom_uploader.open();
                return;
            }
            
            custom_uploader = wp.media.frames.file_frame = wp.media({
                title: 'Choose Image',
                button: {
                    text: 'Choose Image'
                },
                multiple: false
            });
            
            custom_uploader.on('select', function() {
                var attachment = custom_uploader.state().get('selection').first().toJSON();
                $('#' + target).val(attachment.url);
                $('#' + target).trigger('change');
            });
            
            custom_uploader.open();
        });
        
        // Add new slide
        $('#add-carousel-slide').click(function() {
            var container = $('#carousel-slides-container');
            var slideCount = container.find('.carousel-slide-item').length;
            
            if (slideCount >= 5) {
                alert('Maximum 5 slides allowed');
                return;
            }
            
            var newSlide = '<div class="carousel-slide-item" style="border: 1px solid #ddd; padding: 15px; margin: 10px 0; background: #f9f9f9;">' +
                '<h4>Slide ' + (slideCount + 1) + '</h4>' +
                '<p><label><strong>Title:</strong><br>' +
                '<div class="multilang-input-container"><input type="text" name="carousel_slides[' + slideCount + '][title]" value="" style="width: 100%;" placeholder="<ru_>Швейные машины<ru_><ka_>საკერავი მანქანები<ka_><eng_>Sewing Machines<eng_>" />' +
                '<small style="color: #666; display: block; margin-top: 5px;">Format: &lt;ru_&gt;Russian text&lt;ru_&gt;&lt;ka_&gt;Georgian text&lt;ka_&gt;&lt;eng_&gt;English text&lt;eng_&gt;</small></div></label></p>' +
                '<p><label><strong>Description:</strong><br>' +
                '<div class="multilang-input-container"><textarea name="carousel_slides[' + slideCount + '][description]" style="width: 100%; height: 80px;" placeholder="<ru_>Откройте наш ассортимент швейных машин<ru_><ka_>აღმოაჩინეთ ჩვენი საკერავი მანქანების ასორტიმენტი<ka_><eng_>Discover our range of sewing machines<eng_>"></textarea>' +
                '<small style="color: #666; display: block; margin-top: 5px;">Format: &lt;ru_&gt;Russian text&lt;ru_&gt;&lt;ka_&gt;Georgian text&lt;ka_&gt;&lt;eng_&gt;English text&lt;eng_&gt;</small></div></label></p>' +
                '<p><label><strong>Link URL:</strong><br>' +
                '<input type="url" name="carousel_slides[' + slideCount + '][link]" value="" style="width: 100%;" placeholder="https://example.com" /></label></p>' +
                '<p><label><strong>Image URL:</strong><br>' +
                '<input type="text" name="carousel_slides[' + slideCount + '][image]" value="" style="width: 70%;" id="carousel_image_' + slideCount + '" />' +
                '<input type="button" class="button carousel-upload-button" data-target="carousel_image_' + slideCount + '" value="Upload Image" style="margin-left: 10px;" /></label></p>' +
                '</div>';
            
            container.append(newSlide);
        });
        
        // Re-bind upload buttons for new slides
        $(document).on('click', '.carousel-upload-button', function(e) {
            e.preventDefault();
            var target = $(this).data('target');
            
            var custom_uploader = wp.media.frames.file_frame = wp.media({
                title: 'Choose Image',
                button: {
                    text: 'Choose Image'
                },
                multiple: false
            });
            
            custom_uploader.on('select', function() {
                var attachment = custom_uploader.state().get('selection').first().toJSON();
                $('#' + target).val(attachment.url);
            });
            
            custom_uploader.open();
        });
    });
    </script>
    <?php
}

// Enqueue media uploader scripts
function victoria_style_admin_scripts($hook) {
    if ('settings_page_carousel-settings' === $hook) {
        wp_enqueue_media();
        wp_enqueue_script('jquery');
    }
}
add_action('admin_enqueue_scripts', 'victoria_style_admin_scripts');

// Add category management to WordPress admin
function victoria_style_category_settings() {
    add_options_page(
        'Category Management',
        'Category Management',
        'manage_options',
        'category-management',
        'victoria_style_category_settings_page'
    );
}
add_action('admin_menu', 'victoria_style_category_settings');

// Register category settings
function victoria_style_category_settings_init() {
    register_setting('category_settings', 'homepage_categories');
}
add_action('admin_init', 'victoria_style_category_settings_init');

// Category settings page
function victoria_style_category_settings_page() {
    $categories = get_option('homepage_categories', array());
    
    // Default categories if none exist
    if (empty($categories)) {
        $categories = array(
            array(
                'name' => 'Sewing Machines',
                'slug' => 'sewing-machines',
                'subcategories' => array(
                    array(
                        'title' => 'Home Sewing Machines',
                        'items' => array('VERITAS', 'Brother', 'Janome', 'JAPSEW')
                    ),
                    array(
                        'title' => 'Industrial Machines',
                        'items' => array('Heavy Duty Machines', 'Overlock Machines', 'Cover Stitch Machines', 'Specialty Machines')
                    ),
                    array(
                        'title' => 'Accessories',
                        'items' => array('Presser Feet', 'Needles', 'Maintenance Kits', 'Machine Parts')
                    )
                )
            ),
            array(
                'name' => 'Fabrics',
                'slug' => 'fabrics',
                'subcategories' => array(
                    array(
                        'title' => 'Natural Fabrics',
                        'items' => array('Cotton', 'Linen', 'Wool', 'Silk')
                    ),
                    array(
                        'title' => 'Synthetic Fabrics',
                        'items' => array('Polyester', 'Nylon', 'Rayon', 'Spandex')
                    )
                )
            ),
            array(
                'name' => 'Accessories',
                'slug' => 'accessories',
                'subcategories' => array()
            ),
            array(
                'name' => 'Patterns',
                'slug' => 'patterns',
                'subcategories' => array()
            )
        );
    }
    
    ?>
    <div class="wrap">
        <h1>Category Management</h1>
        <p>Manage your homepage categories and their subcategories here.</p>
        
        <form method="post" action="options.php">
            <?php settings_fields('category_settings'); ?>
            
            <div id="categories-container">
                <?php foreach ($categories as $index => $category) : ?>
                    <div class="category-item" style="border: 1px solid #ddd; padding: 20px; margin: 15px 0; background: #f9f9f9;">
                        <h3>Category <?php echo ($index + 1); ?></h3>
                        
                        <table class="form-table">
                            <tr>
                                <th><label>Category Name:</label></th>
                                <td><?php victoria_style_multilang_input_field('homepage_categories[' . $index . '][name]', $category['name'], '<ru_>Швейные машины<ru_><ka_>საკერავი მანქანები<ka_><eng_>Sewing Machines<eng_>'); ?></td>
                            </tr>
                            <tr>
                                <th><label>URL Slug:</label></th>
                                <td>
                                    <input type="text" name="homepage_categories[<?php echo $index; ?>][slug]" value="<?php echo esc_attr($category['slug']); ?>" style="width: 300px;" placeholder="category-slug" />
                                    <br><small style="color: #666;">Важно для поисковиков (Google, Yandex). Напишите на английском наименование категории которую сверху указали. Не должно повторяться с другими категориями.</small>
                                </td>
                            </tr>
                            <tr>
                                <th><label>Category Link URL:</label></th>
                                <td><input type="url" name="homepage_categories[<?php echo $index; ?>][link]" value="<?php echo esc_attr(isset($category['link']) ? $category['link'] : ''); ?>" style="width: 300px;" placeholder="https://example.com/category" /></td>
                            </tr>
                        </table>
                        
                        <h4>Subcategories</h4>
                        <div class="subcategories-container">
                            <?php if (!empty($category['subcategories'])) : ?>
                                <?php foreach ($category['subcategories'] as $sub_index => $subcategory) : ?>
                                    <div class="subcategory-item" style="border: 1px solid #ccc; padding: 15px; margin: 10px 0; background: white;">
                                        <h5>Subcategory <?php echo ($sub_index + 1); ?></h5>
                                        
                                        <p><label><strong>Title:</strong><br>
                                        <?php victoria_style_multilang_input_field('homepage_categories[' . $index . '][subcategories][' . $sub_index . '][title]', $subcategory['title'], '<ru_>Домашние швейные машины<ru_><ka_>საოჯახო საკერავი მანქანები<ka_><eng_>Home Sewing Machines<eng_>'); ?></label></p>
                                        
                                        <p><label><strong>Title Link URL:</strong><br>
                                        <input type="url" name="homepage_categories[<?php echo $index; ?>][subcategories][<?php echo $sub_index; ?>][title_link]" value="<?php echo esc_attr(isset($subcategory['title_link']) ? $subcategory['title_link'] : ''); ?>" style="width: 100%;" placeholder="https://example.com/category" /></label></p>
                                        
                                        <p><label><strong>Items (format: "Multilingual Name|URL" one per line):</strong><br>
                                        <small>Example with multilingual format: &lt;ru_&gt;Хлопковая ткань&lt;ru_&gt;&lt;ka_&gt;ბამბის ქსოვილი&lt;ka_&gt;&lt;eng_&gt;Cotton Fabric&lt;eng_&gt;|https://example.com/cotton<br>
                                        Simple format: Linen|https://example.com/linen</small><br>
                                        <textarea name="homepage_categories[<?php echo $index; ?>][subcategories][<?php echo $sub_index; ?>][items]" style="width: 100%; height: 120px;"><?php 
                                        if (!empty($subcategory['items'])) {
                                            $formatted_items = array();
                                            foreach ($subcategory['items'] as $item) {
                                                if (is_array($item)) {
                                                    $formatted_items[] = $item['name'] . '|' . $item['url'];
                                                } else {
                                                    $formatted_items[] = $item . '|#';
                                                }
                                            }
                                            echo esc_textarea(implode("\n", $formatted_items));
                                        }
                                        ?></textarea></label></p>
                                        
                                        <button type="button" class="button remove-subcategory" onclick="this.closest('.subcategory-item').remove();">Remove Subcategory</button>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                        
                        <button type="button" class="button add-subcategory" data-category-index="<?php echo $index; ?>">Add Subcategory</button>
                        <button type="button" class="button remove-category" onclick="this.closest('.category-item').remove();" style="margin-left: 10px; background: #dc3545; color: white;">Remove Category</button>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <p><button type="button" id="add-category" class="button button-primary">Add New Category</button></p>
            
            <?php submit_button(); ?>
        </form>
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        var categoryIndex = <?php echo count($categories); ?>;
        
        // Add new category
        $('#add-category').click(function() {
            var newCategory = '<div class="category-item" style="border: 1px solid #ddd; padding: 20px; margin: 15px 0; background: #f9f9f9;">' +
                '<h3>Category ' + (categoryIndex + 1) + '</h3>' +
                '<table class="form-table">' +
                '<tr><th><label>Category Name:</label></th><td><input type="text" name="homepage_categories[' + categoryIndex + '][name]" value="" style="width: 300px;" /></td></tr>' +
                '<tr><th><label>URL Slug:</label></th><td><input type="text" name="homepage_categories[' + categoryIndex + '][slug]" value="" style="width: 300px;" placeholder="category-slug" /><br><small style="color: #666;">Важно для поисковиков (Google, Yandex). Напишите на английском наименование категории которую сверху указали. Не должно повторяться с другими категориями.</small></td></tr>' +
                '<tr><th><label>Category Link URL:</label></th><td><input type="url" name="homepage_categories[' + categoryIndex + '][link]" value="" style="width: 300px;" placeholder="https://example.com/category" /></td></tr>' +
                '</table>' +
                '<h4>Subcategories</h4>' +
                '<div class="subcategories-container"></div>' +
                '<button type="button" class="button add-subcategory" data-category-index="' + categoryIndex + '">Add Subcategory</button>' +
                '<button type="button" class="button remove-category" onclick="this.closest(\'.category-item\').remove();" style="margin-left: 10px; background: #dc3545; color: white;">Remove Category</button>' +
                '</div>';
            
            $('#categories-container').append(newCategory);
            categoryIndex++;
        });
        
        // Add subcategory
        $(document).on('click', '.add-subcategory', function() {
            var catIndex = $(this).data('category-index');
            var subContainer = $(this).siblings('.subcategories-container');
            var subIndex = subContainer.find('.subcategory-item').length;
            
            var newSubcategory = '<div class="subcategory-item" style="border: 1px solid #ccc; padding: 15px; margin: 10px 0; background: white;">' +
                '<h5>Subcategory ' + (subIndex + 1) + '</h5>' +
                '<p><label><strong>Title:</strong><br>' +
                '<input type="text" name="homepage_categories[' + catIndex + '][subcategories][' + subIndex + '][title]" value="" style="width: 100%;" /></label></p>' +
                '<p><label><strong>Title Link URL:</strong><br>' +
                '<input type="url" name="homepage_categories[' + catIndex + '][subcategories][' + subIndex + '][title_link]" value="" style="width: 100%;" placeholder="https://example.com/category" /></label></p>' +
                '<p><label><strong>Items (format: "Multilingual Name|URL" one per line):</strong><br>' +
                '<small>Example with multilingual format: &lt;ru_&gt;Хлопковая ткань&lt;ru_&gt;&lt;ka_&gt;ბამბის ქსოვილი&lt;ka_&gt;&lt;eng_&gt;Cotton Fabric&lt;eng_&gt;|https://example.com/cotton<br>Simple format: Linen|https://example.com/linen</small><br>' +
                '<textarea name="homepage_categories[' + catIndex + '][subcategories][' + subIndex + '][items]" style="width: 100%; height: 120px;"></textarea></label></p>' +
                '<button type="button" class="button remove-subcategory" onclick="this.closest(\'.subcategory-item\').remove();">Remove Subcategory</button>' +
                '</div>';
            
            subContainer.append(newSubcategory);
        });
    });
    </script>
    
    <style>
    .category-item {
        border-radius: 5px;
    }
    .subcategory-item {
        border-radius: 3px;
    }
    .remove-category {
        background: #dc3545 !important;
        border-color: #dc3545 !important;
    }
    </style>
    <?php
}

// Process and sanitize category data before saving
function victoria_style_process_categories($input) {
    $processed = array();
    
    if (is_array($input)) {
        foreach ($input as $category) {
            if (!empty($category['name'])) {
                $processed_category = array(
                    'name' => victoria_style_sanitize_multilang_text($category['name']),
                    'slug' => sanitize_title($category['slug']),
                    'link' => esc_url_raw($category['link']),
                    'subcategories' => array()
                );
                
                if (!empty($category['subcategories'])) {
                    foreach ($category['subcategories'] as $subcategory) {
                        if (!empty($subcategory['title'])) {
                            $items = array();
                            if (!empty($subcategory['items'])) {
                                if (is_string($subcategory['items'])) {
                                    // Convert textarea input to array with name|url format
                                    $lines = array_filter(array_map('trim', explode("\n", $subcategory['items'])));
                                    foreach ($lines as $line) {
                                        if (strpos($line, '|') !== false) {
                                            list($name, $url) = explode('|', $line, 2);
                                            $items[] = array(
                                                'name' => victoria_style_sanitize_multilang_text(trim($name)),
                                                'url' => esc_url_raw(trim($url))
                                            );
                                        } else {
                                            $items[] = array(
                                                'name' => victoria_style_sanitize_multilang_text(trim($line)),
                                                'url' => '#'
                                            );
                                        }
                                    }
                                } else {
                                    $items = $subcategory['items'];
                                }
                            }
                            
                            $processed_category['subcategories'][] = array(
                                'title' => victoria_style_sanitize_multilang_text($subcategory['title']),
                                'title_link' => esc_url_raw($subcategory['title_link']),
                                'items' => $items
                            );
                        }
                    }
                }
                
                $processed[] = $processed_category;
            }
        }
    }
    
    return $processed;
}

// Hook to process categories before saving
add_filter('pre_update_option_homepage_categories', 'victoria_style_process_categories');

// Process and sanitize carousel data before saving
function victoria_style_process_carousel($input) {
    $processed = array();
    
    if (is_array($input)) {
        foreach ($input as $slide) {
            if (!empty($slide['title']) || !empty($slide['image'])) {
                $processed[] = array(
                    'title' => victoria_style_sanitize_multilang_text($slide['title']),
                    'description' => victoria_style_sanitize_multilang_text($slide['description']),
                    'link' => esc_url_raw($slide['link']),
                    'image' => esc_url_raw($slide['image'])
                );
            }
        }
    }
    
    return $processed;
}

// Hook to process carousel slides before saving
add_filter('pre_update_option_carousel_slides', 'victoria_style_process_carousel');

// Ensure oEmbed functionality works properly
function victoria_style_enable_oembed() {
    // Enable oEmbed discovery
    add_theme_support('oembed');
    
    // Ensure WordPress processes oEmbeds in content
    add_filter('the_content', array($GLOBALS['wp_embed'], 'autoembed'), 8);
}
add_action('after_setup_theme', 'victoria_style_enable_oembed');

// Fix oEmbed for custom content areas
function victoria_style_process_content_embeds($content) {
    global $wp_embed;
    return $wp_embed->autoembed($content);
}

// Custom content function that properly handles embeds
function victoria_style_the_content() {
    $content = get_the_content();
    $content = apply_filters('the_content', $content);
    $content = str_replace(']]>', ']]&gt;', $content);
    echo $content;
}

// Ensure oEmbed works in all contexts
function victoria_style_fix_oembed() {
    // Re-add oEmbed filters if they're missing
    if (!has_filter('the_content', array($GLOBALS['wp_embed'], 'autoembed'))) {
        add_filter('the_content', array($GLOBALS['wp_embed'], 'autoembed'), 8);
    }
    
    // Ensure oEmbed is enabled for the content
    add_filter('the_content', 'do_shortcode', 11); // After oEmbed
    
    // Fix for Ultimate Product Catalog or other plugins
    add_filter('widget_text', array($GLOBALS['wp_embed'], 'autoembed'));
    add_filter('the_excerpt', array($GLOBALS['wp_embed'], 'autoembed'));
}
add_action('init', 'victoria_style_fix_oembed');

// Add navigation management to WordPress admin
function victoria_style_navigation_settings() {
    add_options_page(
        'Navigation Management',
        'Navigation Management',
        'manage_options',
        'navigation-management',
        'victoria_style_navigation_settings_page'
    );
}
add_action('admin_menu', 'victoria_style_navigation_settings');

// Register navigation settings
function victoria_style_navigation_settings_init() {
    register_setting('navigation_settings', 'custom_secondary_navigation_items');
    
    add_settings_section(
        'navigation_section',
        'Navigation Menu Management',
        'victoria_style_navigation_section_callback',
        'navigation_settings'
    );
    
    add_settings_field(
        'secondary_navigation',
        'Navigation Menu Items',
        'victoria_style_secondary_navigation_callback',
        'navigation_settings',
        'navigation_section'
    );
}
add_action('admin_init', 'victoria_style_navigation_settings_init');

// Section callback
function victoria_style_navigation_section_callback() {
    echo '<p>Manage your navigation menu items here. You can add, remove, and reorder menu items for the secondary navigation bar.</p>';
}


// Navigation callback
function victoria_style_secondary_navigation_callback() {
    $nav_items = get_option('custom_secondary_navigation_items', array());
    
    // Default navigation items if none exist
    if (empty($nav_items)) {
        $nav_items = array(
            array('title' => 'About', 'url' => '#', 'target' => '_self'),
            array('title' => 'Atelie', 'url' => '#', 'target' => '_self'),
            array('title' => 'Cloth', 'url' => '#', 'target' => '_self'),
            array('title' => 'Sewing Machines', 'url' => '#', 'target' => '_self'),
            array('title' => 'Blog', 'url' => '#', 'target' => '_self'),
            array('title' => 'Contacts', 'url' => '#', 'target' => '_self')
        );
    }
    
    echo '<div id="nav-container">';
    foreach ($nav_items as $index => $item) {
        echo '<div class="nav-item-container" style="border: 1px solid #ddd; padding: 15px; margin: 10px 0; background: #f9f9f9;">';
        echo '<h5>Menu Item ' . ($index + 1) . '</h5>';
        
        echo '<p><label><strong>Title:</strong><br>';
        victoria_style_multilang_input_field('custom_secondary_navigation_items[' . $index . '][title]', $item['title'], '<ru_>О нас<ru_><ka_>ჩვენს შესახებ<ka_><eng_>About<eng_>');
        echo '</label></p>';
        
        echo '<p><label><strong>URL:</strong><br>';
        echo '<input type="url" name="custom_secondary_navigation_items[' . $index . '][url]" value="' . esc_attr($item['url']) . '" style="width: 300px;" placeholder="https://example.com" /></label></p>';
        
        echo '<p><label><strong>Target:</strong><br>';
        echo '<select name="custom_secondary_navigation_items[' . $index . '][target]" style="width: 200px;">';
        echo '<option value="_self"' . selected($item['target'], '_self', false) . '>Same Window</option>';
        echo '<option value="_blank"' . selected($item['target'], '_blank', false) . '>New Window</option>';
        echo '</select></label></p>';
        
        echo '<button type="button" class="button remove-nav-item" onclick="this.closest(\'.nav-item-container\').remove();">Remove Item</button>';
        echo '</div>';
    }
    echo '</div>';
    
    echo '<p><button type="button" id="add-nav-item" class="button">Add New Menu Item</button></p>';
}

// Navigation settings page
function victoria_style_navigation_settings_page() {
    ?>
    <div class="wrap">
        <h1>Navigation Management</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('navigation_settings');
            do_settings_sections('navigation_settings');
            submit_button();
            ?>
        </form>
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        // Add new navigation item
        $('#add-nav-item').click(function() {
            var container = $('#nav-container');
            var itemCount = container.find('.nav-item-container').length;
            
            var newItem = '<div class="nav-item-container" style="border: 1px solid #ddd; padding: 15px; margin: 10px 0; background: #f9f9f9;">' +
                '<h5>Menu Item ' + (itemCount + 1) + '</h5>' +
                '<p><label><strong>Title:</strong><br>' +
                '<div class="multilang-input-container"><input type="text" name="custom_secondary_navigation_items[' + itemCount + '][title]" value="" style="width: 100%;" placeholder="<ru_>О нас<ru_><ka_>ჩვენს შესახებ<ka_><eng_>About<eng_>" />' +
                '<small style="color: #666; display: block; margin-top: 5px;"><strong>Multi-language format:</strong> &lt;ru_&gt;Russian text&lt;ru_&gt;&lt;ka_&gt;Georgian text&lt;ka_&gt;&lt;eng_&gt;English text&lt;eng_&gt;</small>' +
                '<small style="color: #0073aa; display: block; margin-top: 2px;"><strong>Example:</strong> &lt;ru_&gt;О нас&lt;ru_&gt;&lt;ka_&gt;ჩვენს შესახებ&lt;ka_&gt;&lt;eng_&gt;About&lt;eng_&gt;</small></div></label></p>' +
                '<p><label><strong>URL:</strong><br>' +
                '<input type="url" name="custom_secondary_navigation_items[' + itemCount + '][url]" value="" style="width: 300px;" placeholder="https://example.com" /></label></p>' +
                '<p><label><strong>Target:</strong><br>' +
                '<select name="custom_secondary_navigation_items[' + itemCount + '][target]" style="width: 200px;">' +
                '<option value="_self">Same Window</option>' +
                '<option value="_blank">New Window</option>' +
                '</select></label></p>' +
                '<button type="button" class="button remove-nav-item" onclick="this.closest(\'.nav-item-container\').remove();">Remove Item</button>' +
                '</div>';
            
            container.append(newItem);
        });
        
        // Add helper functionality for multilang format
        $(document).on('focus', '.multilang-input-container input, .multilang-input-container textarea', function() {
            if ($(this).val() === '') {
                $(this).attr('placeholder', '<ru_>Russian text<ru_><ka_>Georgian text<ka_><eng_>English text<eng_>');
            }
        });
    });
    </script>
    
    <style>
    .nav-item-container {
        border-radius: 5px;
    }
    .remove-nav-item {
        background: #dc3545 !important;
        border-color: #dc3545 !important;
        color: white !important;
    }
    </style>
    <?php
}

// Custom sanitization function that preserves multilang tags
function victoria_style_sanitize_multilang_text($text) {
    if (empty($text)) {
        return $text;
    }
    
    // First, temporarily replace multilang tags with placeholders
    $placeholders = array();
    $counter = 0;
    
    // Pattern to match multilang tags like <ru_>text<ru_>
    $pattern = '/<(\w+)_>(.*?)<\1_>/';
    
    $text = preg_replace_callback($pattern, function($matches) use (&$placeholders, &$counter) {
        $placeholder = '__MULTILANG_' . $counter . '__';
        $placeholders[$placeholder] = '<' . $matches[1] . '_>' . $matches[2] . '<' . $matches[1] . '_>';
        $counter++;
        return $placeholder;
    }, $text);
    
    // Now sanitize the text normally (this will remove any other HTML/script tags)
    $text = sanitize_text_field($text);
    
    // Restore the multilang tags
    foreach ($placeholders as $placeholder => $original) {
        $text = str_replace($placeholder, $original, $text);
    }
    
    return $text;
}

// Process and sanitize navigation data before saving
function victoria_style_process_navigation($input) {
    $processed = array();
    
    if (is_array($input)) {
        foreach ($input as $item) {
            if (!empty($item['title']) && !empty($item['url'])) {
                $processed[] = array(
                    'title' => victoria_style_sanitize_multilang_text($item['title']),
                    'url' => esc_url_raw($item['url']),
                    'target' => in_array($item['target'], array('_self', '_blank')) ? $item['target'] : '_self'
                );
            }
        }
    }
    
    return $processed;
}

// Hook to process navigation items before saving
add_filter('pre_update_option_custom_secondary_navigation_items', 'victoria_style_process_navigation');

// Multi-language support functions
function victoria_style_parse_multilang_text($text, $lang = 'rus') {
    if (empty($text)) {
        return $text;
    }
    
    // Map language codes to proper tags
    $lang_map = array(
        'rus' => 'ru',
        'geo' => 'ka',
        'eng' => 'eng'
    );
    
    $target_lang = isset($lang_map[$lang]) ? $lang_map[$lang] : $lang;
    
    // Pattern to match language tags like <ru_>text<ru_>
    $pattern = '/<(' . $target_lang . ')_>(.*?)<\1_>/';
    
    if (preg_match($pattern, $text, $matches)) {
        return $matches[2];
    }
    
    // If specific language not found, try to extract first available language
    $general_pattern = '/<(\w+)_>(.*?)<\1_>/';
    if (preg_match($general_pattern, $text, $matches)) {
        return $matches[2];
    }
    
    // If no language tags found, return original text
    return $text;
}

// Get current language from session/cookie
function victoria_style_get_current_language() {
    // Check URL parameter first (for testing)
    if (isset($_GET['lang']) && in_array($_GET['lang'], array('rus', 'geo', 'eng'))) {
        return sanitize_text_field($_GET['lang']);
    }
    
    // Check cookie
    if (isset($_COOKIE['site_language']) && in_array($_COOKIE['site_language'], array('rus', 'geo', 'eng'))) {
        return sanitize_text_field($_COOKIE['site_language']);
    }
    
    return 'eng'; // Default to English for now to match your test
}

// Display multilang text based on current language
function victoria_style_display_multilang($text) {
    $current_lang = victoria_style_get_current_language();
    return victoria_style_parse_multilang_text($text, $current_lang);
}

// Helper function to create language input field
function victoria_style_multilang_input_field($name, $value, $placeholder = '', $type = 'text') {
    $field_id = str_replace(['[', ']'], ['_', ''], $name);
    echo '<div class="multilang-input-container">';
    
    if ($type === 'textarea') {
        echo '<textarea name="' . esc_attr($name) . '" id="' . esc_attr($field_id) . '" style="width: 100%; height: 80px;" placeholder="' . esc_attr($placeholder) . '">' . esc_textarea($value) . '</textarea>';
    } else {
        echo '<input type="' . esc_attr($type) . '" name="' . esc_attr($name) . '" id="' . esc_attr($field_id) . '" value="' . esc_attr($value) . '" style="width: 100%;" placeholder="' . esc_attr($placeholder) . '" />';
    }
    
    echo '<small style="color: #666; display: block; margin-top: 5px;"><strong>Multi-language format:</strong> &lt;ru_&gt;Russian text&lt;ru_&gt;&lt;ka_&gt;Georgian text&lt;ka_&gt;&lt;eng_&gt;English text&lt;eng_&gt;</small>';
    echo '<small style="color: #0073aa; display: block; margin-top: 2px;"><strong>Example:</strong> &lt;ru_&gt;О нас&lt;ru_&gt;&lt;ka_&gt;ჩვენს შესახებ&lt;ka_&gt;&lt;eng_&gt;About&lt;eng_&gt;</small>';
    echo '</div>';
}

// Specifically handle YouTube embeds
function victoria_style_youtube_embed_fix($content) {
    // Pattern to match YouTube URLs
    $youtube_pattern = '/(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/';
    
    // Replace YouTube URLs with proper embed code
    $content = preg_replace_callback($youtube_pattern, function($matches) {
        $video_id = $matches[1];
        return '<iframe width="560" height="315" src="https://www.youtube.com/embed/' . $video_id . '" frameborder="0" allowfullscreen></iframe>';
    }, $content);
    
    return $content;
}
add_filter('the_content', 'victoria_style_youtube_embed_fix', 9); // Before WordPress oEmbed

// Debug function to check if oEmbed is working
function victoria_style_debug_oembed() {
    if (current_user_can('manage_options') && isset($_GET['debug_oembed'])) {
        global $wp_embed;
        echo '<div style="background: #f0f0f0; padding: 10px; margin: 10px; border: 1px solid #ccc;">';
        echo '<strong>oEmbed Debug Info:</strong><br>';
        echo 'WP_Embed object exists: ' . (isset($wp_embed) ? 'Yes' : 'No') . '<br>';
        echo 'oEmbed autoembed filter active: ' . (has_filter('the_content', array($GLOBALS['wp_embed'], 'autoembed')) ? 'Yes' : 'No') . '<br>';
        echo 'oEmbed providers: ' . count(wp_oembed_get_providers()) . ' registered<br>';
        echo '</div>';
    }
}
add_action('wp_head', 'victoria_style_debug_oembed');

// Multilingual Content Support
// ============================

/**
 * Sanitize multilingual content while preserving multilang tags
 * This function runs BEFORE WordPress KSES to protect multilang tags from being stripped
 */
function victoria_style_sanitize_multilang_content($content) {
    if (empty($content)) {
        return $content;
    }
    
    // First, temporarily replace multilang tags with placeholders to protect them from KSES
    $placeholders = array();
    $counter = 0;
    
    // Pattern to match multilang tags like <ru_>text<ru_>
    $pattern = '/<(\w+)_>(.*?)<\1_>/s';
    
    $content = preg_replace_callback($pattern, function($matches) use (&$placeholders, &$counter) {
        $placeholder = '__MULTILANG_PLACEHOLDER_' . $counter . '__';
        $placeholders[$placeholder] = '<' . $matches[1] . '_>' . $matches[2] . '<' . $matches[1] . '_>';
        $counter++;
        return $placeholder;
    }, $content);
    
    // Store placeholders in a global variable so we can restore them after KSES
    global $victoria_style_multilang_placeholders;
    $victoria_style_multilang_placeholders = $placeholders;
    
    return $content;
}

/**
 * Restore multilang tags after WordPress KSES has run
 */
function victoria_style_restore_multilang_content($content) {
    global $victoria_style_multilang_placeholders;
    
    if (!empty($victoria_style_multilang_placeholders)) {
        // Restore the multilang tags
        foreach ($victoria_style_multilang_placeholders as $placeholder => $original) {
            $content = str_replace($placeholder, $original, $content);
        }
        
        // Clear the global variable
        $victoria_style_multilang_placeholders = array();
    }
    
    return $content;
}

/**
 * Display content with appropriate language based on current language setting
 */
function victoria_style_filter_multilang_content($content) {
    if (empty($content)) {
        return $content;
    }
    
    // Get current language
    $current_lang = victoria_style_get_current_language();
    
    // If we're in admin, show all languages (for editing)
    if (is_admin() && !wp_doing_ajax()) {
        return $content;
    }
    
    // Debug logging (remove in production)
    if (defined('WP_DEBUG') && WP_DEBUG) {
        error_log('Filtering content for language: ' . $current_lang);
        error_log('Content before filtering: ' . substr($content, 0, 200));
    }
    
    // Map language codes
    $lang_map = array(
        'rus' => 'ru',
        'geo' => 'ka', 
        'eng' => 'eng'
    );
    
    $target_lang = isset($lang_map[$current_lang]) ? $lang_map[$current_lang] : $current_lang;
    
    // Store original content for fallback
    $original_content = $content;
    $has_multilang = false;
    
    // Handle both HTML-encoded and normal multilang tags
    // First, handle HTML-encoded tags like &lt;ru_&gt;text&lt;ru_&gt;
    $content = preg_replace_callback('/&lt;(\w+)_&gt;(.*?)&lt;\1_&gt;/s', function($matches) use ($target_lang, &$has_multilang) {
        $has_multilang = true;
        $lang_code = $matches[1];
        $text = $matches[2];
        
        // Return text if it matches current language, otherwise return empty
        return ($lang_code === $target_lang) ? $text : '';
    }, $content);
    
    // Then handle normal tags like <ru_>text<ru_>
    $content = preg_replace_callback('/<(\w+)_>(.*?)<\1_>/s', function($matches) use ($target_lang, &$has_multilang) {
        $has_multilang = true;
        $lang_code = $matches[1];
        $text = $matches[2];
        
        // Return text if it matches current language, otherwise return empty
        return ($lang_code === $target_lang) ? $text : '';
    }, $content);
    
    // Clean up any leftover empty spaces or line breaks
    if ($has_multilang) {
        $content = preg_replace('/\n\s*\n/', "\n", $content);
        $content = trim($content);
        
        // Debug logging (remove in production)
        if (defined('WP_DEBUG') && WP_DEBUG) {
            error_log('Content after filtering: ' . substr($content, 0, 200));
        }
    }
    
    return $content;
}

/**
 * Add data attributes to content elements for JavaScript translation
 */
function victoria_style_add_multilang_attributes($content) {
    if (empty($content) || is_admin()) {
        return $content;
    }
    
    // Store original content with multilang tags in data attribute
    $original_content = $content;
    
    // Find multilang content and wrap it with data attributes
    $content = preg_replace_callback('/(<[^>]*>)*([^<]*<\w+_>.*?<\/\w+_>[^<]*)/s', function($matches) {
        $full_match = $matches[0];
        
        // Check if this contains multilang tags
        if (preg_match('/<\w+_>.*?<\/\w+_>/', $full_match)) {
            // Wrap with span that has data attribute for JS processing
            return '<span class="multilang-content" data-original-content="' . esc_attr($full_match) . '">' . $full_match . '</span>';
        }
        
        return $full_match;
    }, $content);
    
    return $content;
}

// Hook into content processing at different stages
add_filter('content_save_pre', 'victoria_style_sanitize_multilang_content', 9); // Before KSES
add_filter('content_save_pre', 'victoria_style_restore_multilang_content', 11); // After KSES

// Filter content display on frontend
add_filter('the_content', 'victoria_style_filter_multilang_content', 1); // Very early
add_filter('the_content', 'victoria_style_filter_multilang_content', 50); // Middle priority  
add_filter('the_content', 'victoria_style_filter_multilang_content', 999); // Very late, after all other filters
add_filter('the_excerpt', 'victoria_style_filter_multilang_content', 5);
add_filter('widget_text', 'victoria_style_filter_multilang_content', 5);

// Alternative content function that ensures filtering
function victoria_style_the_content_filtered() {
    $content = get_the_content();
    $content = apply_filters('the_content', $content);
    $content = victoria_style_filter_multilang_content($content);
    echo $content;
}

// Debug function to check if filtering is working
function victoria_style_debug_multilang() {
    if (current_user_can('manage_options') && isset($_GET['debug_multilang'])) {
        $current_lang = victoria_style_get_current_language();
        echo '<div style="background: #f0f0f0; padding: 10px; margin: 10px; border: 1px solid #ccc;">';
        echo '<strong>Multilang Debug Info:</strong><br>';
        echo 'Current language: ' . esc_html($current_lang) . '<br>';
        echo 'Cookie value: ' . (isset($_COOKIE['site_language']) ? esc_html($_COOKIE['site_language']) : 'Not set') . '<br>';
        echo 'Is admin: ' . (is_admin() ? 'Yes' : 'No') . '<br>';
        echo 'Content filter active: ' . (has_filter('the_content', 'victoria_style_filter_multilang_content') ? 'Yes' : 'No') . '<br>';
        echo '</div>';
    }
}
add_action('wp_head', 'victoria_style_debug_multilang');

// Also filter for AJAX requests (for dynamic content loading)
if (wp_doing_ajax()) {
    add_filter('the_content', 'victoria_style_filter_multilang_content', 5);
}

/**
 * Add admin notice about multilingual content format
 */
function victoria_style_multilang_admin_notice() {
    $screen = get_current_screen();
    if ($screen && in_array($screen->id, array('post', 'page'))) {
        ?>
        <div class="notice notice-info">
            <p><strong>Multilingual Content:</strong> Use the format <code>&lt;ru_&gt;Russian text&lt;/ru_&gt;&lt;ka_&gt;Georgian text&lt;/ka_&gt;&lt;eng_&gt;English text&lt;/eng_&gt;</code> for multilingual content that will change based on the language switcher.</p>
        </div>
        <?php
    }
}
add_action('admin_notices', 'victoria_style_multilang_admin_notice');

// Test shortcode for multilingual content (for debugging)
function victoria_style_test_multilang_shortcode($atts) {
    $current_lang = victoria_style_get_current_language();
    $test_content = '<ru_>Это русский текст<ru_><ka_>ეს არის ქართული<ka_><eng_>This is English<eng_>';
    $filtered_content = victoria_style_filter_multilang_content($test_content);
    
    return '<div class="multilang-test-box" style="border: 1px solid #ccc; padding: 10px; margin: 10px 0;" data-original-content="' . esc_attr($test_content) . '">
        <strong>Current Language:</strong> <span class="current-lang">' . esc_html($current_lang) . '</span><br>
        <strong>Original:</strong> ' . esc_html($test_content) . '<br>
        <strong>Filtered:</strong> <span class="filtered-content">' . esc_html($filtered_content) . '</span>
    </div>';
}
add_shortcode('test_multilang', 'victoria_style_test_multilang_shortcode');

/**
 * Hide product tags for non-admin users
 */
function victoria_style_hide_tags_for_non_admins() {
    // Only add CSS if user is not an administrator
    if (!current_user_can('manage_options')) {
        ?>
        <style>
            .ewd-upcp-catalog-sidebar-tags {
                display: none !important;
            }
        </style>
        <?php
    }
}
add_action('wp_head', 'victoria_style_hide_tags_for_non_admins'); 