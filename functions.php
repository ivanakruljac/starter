<?php
// -- Defer load
function defer_scripts($url)
{
    if (strpos($url, '#defer') === false)
        return $url;
    else if (is_admin())
        return str_replace('#defer', '', $url);
    else
        return str_replace('#defer', '', $url) . "' defer='defer";
}
add_filter('clean_url', 'defer_scripts', 11, 1);

function wpb_adding_scripts()
{
    wp_deregister_script('jquery');
    wp_enqueue_style('starter-style', get_stylesheet_uri());
    wp_enqueue_script('starter-js', get_template_directory_uri() . '/assets/js/starter.min.js#defer', array(), '1.0', true);
}
add_action('wp_enqueue_scripts', 'wpb_adding_scripts');


// -- clear the HTML structure and remove wp-stuff
function starter_setup()
{
    require_once('inc/remove-wp-defaults.php');
    require_once('inc/html-minifier.php');
}
add_action('after_setup_theme', 'starter_setup');

// -- EXTEND THEME
if (function_exists('add_theme_support')) {
    add_theme_support('menus');
    add_theme_support('post-thumbnails');
}

/* -- EXCERPT Usage:  <?= excerpt(100); ?> */
function excerpt($limit)
{
    $excerpt = explode(' ', get_the_excerpt(), $limit);
    if (count($excerpt) >= $limit) {
        array_pop($excerpt);
        $excerpt = implode(" ", $excerpt);
    } else {
        $excerpt = implode(" ", $excerpt);
    }
    $excerpt = preg_replace('`\[[^\]]*\]`', '', $excerpt);
    return $excerpt . '...';
}
