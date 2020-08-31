<?php
// -- Remove unnecessary code from wp-header
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('admin_print_styles', 'print_emoji_styles');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'wp_resource_hints', 2);
remove_action('wp_head', 'rest_output_link_wp_head', 10);
// <link rel='alternate'
remove_action('wp_head', 'wp_oembed_add_discovery_links');
// <link rel='shortlink' href='http://example.com/?p=25' />
remove_action('wp_head', 'wp_shortlink_wp_head', 10);
// remove HTTP header
// Link: <https://example.com/?p=25>; rel=shortlink
remove_action('template_redirect', 'wp_shortlink_header', 11);

// -- Remove Gutenberg CSS
add_action('wp_print_styles', 'wps_deregister_styles', 100);
function wps_deregister_styles()
{
    wp_dequeue_style('wp-block-library');
}

// -- REMOVE wp-embed.min.js
function my_deregister_scripts()
{
    wp_dequeue_script('wp-embed');
}
add_action('wp_footer', 'my_deregister_scripts');

// -- Remove JQuery migrate
function remove_jquery_migrate($scripts)
{
    if (!is_admin() && isset($scripts->registered['jquery'])) {
        $script = $scripts->registered['jquery'];
        if ($script->deps) { // Check whether the script has any dependencies
            $script->deps = array_diff($script->deps, array(
                'jquery-migrate'
            ));
        }
    }
}
add_action('wp_default_scripts', 'remove_jquery_migrate');

// Remove All Yoast HTML Comments
// https://gist.github.com/paulcollett/4c81c4f6eb85334ba076
add_action('wp_head', function () {
    ob_start(function ($o) {
        return preg_replace('/^\n?<!--.*?[Y]oast.*?-->\n?$/mi', '', $o);
    });
}, ~PHP_INT_MAX);

//Remove [All in One SEO Pack] HTML Comments
//gist.github.com/llgruff/a7ab776167aa0ed307ec445df54e5fdb
if (defined('AIOSEOP_VERSION')) {
    add_action('get_header', function () {
        ob_start(
            function ($o) {
                return preg_replace('/\n?<.*?One SEO Pack.*?>/mi', '', $o);
            }
        );
    });
    add_action('wp_head', function () {
        ob_end_flush();
    }, 999);
}

// Remove All Schema HTML Comments
add_action('wp_head', function () {
    ob_start(function ($o) {
        return preg_replace('/^\n?<!--.*?Schema plugin.*?-->\n?$/mi', '', $o);
    });
}, ~PHP_INT_MAX);