<?php

/**
 * Theme filters.
 */

namespace App;

/**
 * Add "… Continued" to the excerpt.
 *
 * @return string
 */
add_filter('excerpt_more', function () {
    return sprintf(' &hellip; <a href="%s">%s</a>', get_permalink(), __('Continued', 'sage'));
});

/**
 * Remove WordPress version information for security.
 *
 * @return void
 */
add_action('init', function () {
    // Remove WordPress generator meta tag from head
    remove_action('wp_head', 'wp_generator');
});

/**
 * Remove generator info from RSS feeds.
 *
 * @return string
 */
add_filter('the_generator', '__return_empty_string');
