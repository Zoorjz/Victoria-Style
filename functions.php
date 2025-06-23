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