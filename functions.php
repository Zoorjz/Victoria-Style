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