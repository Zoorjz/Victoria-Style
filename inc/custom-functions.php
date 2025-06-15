<?php
/**
 * Custom functions that act independently of the theme templates.
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function victoria_style_body_classes($classes) {
    // Adds a class of hfeed to non-singular pages.
    if (!is_singular()) {
        $classes[] = 'hfeed';
    }

    // Adds a class of no-sidebar when there is no sidebar present.
    if (!is_active_sidebar('sidebar-1')) {
        $classes[] = 'no-sidebar';
    }

    return $classes;
}
add_filter('body_class', 'victoria_style_body_classes');

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function victoria_style_pingback_header() {
    if (is_singular() && pings_open()) {
        printf('<link rel="pingback" href="%s">', esc_url(get_bloginfo('pingback_url')));
    }
}
add_action('wp_head', 'victoria_style_pingback_header');

/**
 * Customize excerpt length
 */
function victoria_style_excerpt_length($length) {
    return 20;
}
add_filter('excerpt_length', 'victoria_style_excerpt_length');

/**
 * Customize excerpt more string
 */
function victoria_style_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'victoria_style_excerpt_more');

/**
 * Add custom image sizes
 */
function victoria_style_image_sizes() {
    add_image_size('victoria-featured', 1200, 600, true);
    add_image_size('victoria-thumbnail', 400, 300, true);
}
add_action('after_setup_theme', 'victoria_style_image_sizes');

/**
 * Register additional widget areas
 */
function victoria_style_additional_widget_areas() {
    register_sidebar(array(
        'name'          => esc_html__('Footer 1', 'victoria-style'),
        'id'            => 'footer-1',
        'description'   => esc_html__('Add widgets here to appear in footer column 1.', 'victoria-style'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));

    register_sidebar(array(
        'name'          => esc_html__('Footer 2', 'victoria-style'),
        'id'            => 'footer-2',
        'description'   => esc_html__('Add widgets here to appear in footer column 2.', 'victoria-style'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));

    register_sidebar(array(
        'name'          => esc_html__('Footer 3', 'victoria-style'),
        'id'            => 'footer-3',
        'description'   => esc_html__('Add widgets here to appear in footer column 3.', 'victoria-style'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));
}
add_action('widgets_init', 'victoria_style_additional_widget_areas'); 