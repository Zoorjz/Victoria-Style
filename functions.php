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
        echo '<input type="text" name="carousel_slides[' . $index . '][title]" value="' . esc_attr($slide['title']) . '" style="width: 100%;" /></label></p>';
        
        echo '<p><label><strong>Description:</strong><br>';
        echo '<textarea name="carousel_slides[' . $index . '][description]" style="width: 100%; height: 60px;">' . esc_textarea($slide['description']) . '</textarea></label></p>';
        
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
                '<input type="text" name="carousel_slides[' + slideCount + '][title]" value="" style="width: 100%;" /></label></p>' +
                '<p><label><strong>Description:</strong><br>' +
                '<textarea name="carousel_slides[' + slideCount + '][description]" style="width: 100%; height: 60px;"></textarea></label></p>' +
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
                'icon' => 'fas fa-sewing-machine',
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
                'icon' => 'fas fa-tshirt',
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
                'icon' => 'fas fa-tools',
                'slug' => 'accessories',
                'subcategories' => array()
            ),
            array(
                'name' => 'Patterns',
                'icon' => 'fas fa-cut',
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
                                <td><input type="text" name="homepage_categories[<?php echo $index; ?>][name]" value="<?php echo esc_attr($category['name']); ?>" style="width: 300px;" /></td>
                            </tr>
                            <tr>
                                <th><label>Icon Class:</label></th>
                                <td><input type="text" name="homepage_categories[<?php echo $index; ?>][icon]" value="<?php echo esc_attr($category['icon']); ?>" style="width: 300px;" placeholder="fas fa-icon-name" /></td>
                            </tr>
                            <tr>
                                <th><label>URL Slug:</label></th>
                                <td><input type="text" name="homepage_categories[<?php echo $index; ?>][slug]" value="<?php echo esc_attr($category['slug']); ?>" style="width: 300px;" placeholder="category-slug" /></td>
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
                                        <input type="text" name="homepage_categories[<?php echo $index; ?>][subcategories][<?php echo $sub_index; ?>][title]" value="<?php echo esc_attr($subcategory['title']); ?>" style="width: 100%;" /></label></p>
                                        
                                        <p><label><strong>Title Link URL:</strong><br>
                                        <input type="url" name="homepage_categories[<?php echo $index; ?>][subcategories][<?php echo $sub_index; ?>][title_link]" value="<?php echo esc_attr(isset($subcategory['title_link']) ? $subcategory['title_link'] : ''); ?>" style="width: 100%;" placeholder="https://example.com/category" /></label></p>
                                        
                                        <p><label><strong>Items (format: "Item Name|URL" one per line):</strong><br>
                                        <small>Example: Cotton Fabric|https://example.com/cotton<br>Linen|https://example.com/linen</small><br>
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
                '<tr><th><label>Icon Class:</label></th><td><input type="text" name="homepage_categories[' + categoryIndex + '][icon]" value="" style="width: 300px;" placeholder="fas fa-icon-name" /></td></tr>' +
                '<tr><th><label>URL Slug:</label></th><td><input type="text" name="homepage_categories[' + categoryIndex + '][slug]" value="" style="width: 300px;" placeholder="category-slug" /></td></tr>' +
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
                '<p><label><strong>Items (format: "Item Name|URL" one per line):</strong><br>' +
                '<small>Example: Cotton Fabric|https://example.com/cotton<br>Linen|https://example.com/linen</small><br>' +
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
                    'name' => sanitize_text_field($category['name']),
                    'icon' => sanitize_text_field($category['icon']),
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
                                                'name' => sanitize_text_field(trim($name)),
                                                'url' => esc_url_raw(trim($url))
                                            );
                                        } else {
                                            $items[] = array(
                                                'name' => sanitize_text_field(trim($line)),
                                                'url' => '#'
                                            );
                                        }
                                    }
                                } else {
                                    $items = $subcategory['items'];
                                }
                            }
                            
                            $processed_category['subcategories'][] = array(
                                'title' => sanitize_text_field($subcategory['title']),
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