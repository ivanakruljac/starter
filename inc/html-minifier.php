<?php
//-- HTML overall compression
add_action('get_header', 'html_minify_start');
function html_minify_start()
{
    ob_start('html_minyfy_finish');
}
function html_minyfy_finish($html)
{
    $html = preg_replace('/<!--(?!s*(?:[if [^]]+]|!|>))(?:(?!-->).)*-->/s', '', $html);
    $html = str_replace(array("\r\n", "\r", "\n", "\t"), '', $html);
    while (stristr($html, '  '))
        $html = str_replace('  ', ' ', $html);
    return $html;
}
