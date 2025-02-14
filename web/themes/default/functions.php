<?php

 

if (!function_exists('mk_load_theme_assets')) {
    function mk_load_theme_assets()
    {
        global $current_theme_assets;
        // load style and js files
        wp_enqueue_style('bootstrap', asset($current_theme_assets . 'assets/css/bootstrap.min.css'), [], MY_THEME_VERSION);
        wp_enqueue_script('jquery', asset($current_theme_assets . 'assets/js/jquery.min.js'), [], MY_THEME_VERSION);
    }
}

if (!function_exists('mk_load_theme_footer_css')) {
    function mk_load_theme_footer_css($data)
    {
        global $current_theme_assets;
        // load js
        wp_enqueue_script('bootstrap', asset($current_theme_assets . 'assets/js/bootstrap.bundle.min.js'), ['jquery'], MY_THEME_VERSION, 1);
    }
}

//
add_action('wp_enqueue_scripts', 'mk_load_theme_assets');
add_action('wp_footer', 'mk_load_theme_footer_css', 10, 1);
