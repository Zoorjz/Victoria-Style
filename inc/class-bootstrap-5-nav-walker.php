<?php
/**
 * Bootstrap 5 Nav Walker
 */
class Bootstrap_5_Nav_Walker extends Walker_Nav_Menu {
    public function start_lvl(&$output, $depth = 0, $args = null) {
        $output .= "<ul class='dropdown-menu'>";
    }

    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $item_html = '';
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        
        if (in_array('current-menu-item', $classes)) {
            $classes[] = 'active';
        }
        if (in_array('menu-item-has-children', $classes)) {
            $classes[] = 'dropdown';
        }
        
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        $class_names = ' class="nav-item ' . esc_attr($class_names) . '"';
        
        $item_html = '<li' . $class_names . '>';
        
        $attributes = '';
        
        if (!empty($item->attr_title)) {
            $attributes .= ' title="' . esc_attr($item->attr_title) . '"';
        }
        if (!empty($item->target)) {
            $attributes .= ' target="' . esc_attr($item->target) . '"';
        }
        if (!empty($item->xfn)) {
            $attributes .= ' rel="' . esc_attr($item->xfn) . '"';
        }
        if (!empty($item->url)) {
            $attributes .= ' href="' . esc_attr($item->url) . '"';
        }
        
        $item_html .= '<a class="nav-link' . (in_array('menu-item-has-children', $classes) ? ' dropdown-toggle' : '') . '"' . $attributes . '>';
        $item_html .= apply_filters('the_title', $item->title, $item->ID);
        $item_html .= '</a>';
        
        $output .= apply_filters('walker_nav_menu_start_el', $item_html, $item, $depth, $args);
    }
} 