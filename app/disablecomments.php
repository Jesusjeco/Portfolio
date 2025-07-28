<?php

/**
 * Complete WordPress Comments Disable
 * Add this code to your theme's functions.php file or create a custom plugin
 */

// Disable support for comments and trackbacks in post types
function disable_comments_post_types_support()
{
  $post_types = get_post_types();
  foreach ($post_types as $post_type) {
    if (post_type_supports($post_type, 'comments')) {
      remove_post_type_support($post_type, 'comments');
      remove_post_type_support($post_type, 'trackbacks');
    }
  }
}
add_action('admin_init', 'disable_comments_post_types_support');

// Close comments on the front-end
function disable_comments_status()
{
  return false;
}
add_filter('comments_open', 'disable_comments_status', 20, 2);
add_filter('pings_open', 'disable_comments_status', 20, 2);

// Hide existing comments
function disable_comments_hide_existing_comments($comments)
{
  $comments = array();
  return $comments;
}
add_filter('comments_array', 'disable_comments_hide_existing_comments', 10, 2);

// Remove comments page in menu
function disable_comments_admin_menu()
{
  remove_menu_page('edit-comments.php');
}
add_action('admin_menu', 'disable_comments_admin_menu');

// Redirect any user trying to access comments page
function disable_comments_admin_menu_redirect()
{
  global $pagenow;
  if ($pagenow === 'edit-comments.php') {
    wp_redirect(admin_url());
    exit;
  }
}
add_action('admin_init', 'disable_comments_admin_menu_redirect');

// Remove comments metabox from dashboard
function disable_comments_dashboard()
{
  remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
}
add_action('admin_init', 'disable_comments_dashboard');

// Remove comments links from admin bar
function disable_comments_admin_bar()
{
  if (is_admin_bar_showing()) {
    remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
  }
}
add_action('init', 'disable_comments_admin_bar');

// Remove comment-reply.js from frontend
function disable_comments_reply_js()
{
  if (is_single() && comments_open()) {
    wp_deregister_script('comment-reply');
  }
}
add_action('wp_print_scripts', 'disable_comments_reply_js', 100);

// Remove Recent Comments widget
function disable_comments_widget()
{
  unregister_widget('WP_Widget_Recent_Comments');
  // Also remove the Recent Comments dashboard widget
  add_action('wp_dashboard_setup', function () {
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
  });
}
add_action('widgets_init', 'disable_comments_widget');

// Disable REST API endpoints for comments
function disable_comments_rest_api_remove_endpoints($endpoints)
{
  if (isset($endpoints['/wp/v2/comments'])) {
    unset($endpoints['/wp/v2/comments']);
  }
  if (isset($endpoints['/wp/v2/comments/(?P<id>[\d]+)'])) {
    unset($endpoints['/wp/v2/comments/(?P<id>[\d]+)']);
  }
  return $endpoints;
}
add_filter('rest_endpoints', 'disable_comments_rest_api_remove_endpoints');

// Remove comments from REST API responses for posts
function disable_comments_rest_api_response($response, $post, $request)
{
  if (isset($response->data['comment_status'])) {
    $response->data['comment_status'] = 'closed';
  }
  if (isset($response->data['ping_status'])) {
    $response->data['ping_status'] = 'closed';
  }
  return $response;
}
add_filter('rest_prepare_post', 'disable_comments_rest_api_response', 10, 3);
add_filter('rest_prepare_page', 'disable_comments_rest_api_response', 10, 3);

// Remove X-Pingback HTTP header
function disable_comments_remove_pingback_header($headers)
{
  if (isset($headers['X-Pingback'])) {
    unset($headers['X-Pingback']);
  }
  return $headers;
}
add_filter('wp_headers', 'disable_comments_remove_pingback_header');

// Remove comment feeds
function disable_comments_feed()
{
  wp_die(__('No comment feeds available.'));
}
add_action('do_feed_rdf', 'disable_comments_feed', 1);
add_action('do_feed_rss', 'disable_comments_feed', 1);
add_action('do_feed_rss2', 'disable_comments_feed', 1);
add_action('do_feed_atom', 'disable_comments_feed', 1);
add_action('do_feed_rss2_comments', 'disable_comments_feed', 1);
add_action('do_feed_atom_comments', 'disable_comments_feed', 1);

// Remove comment feed links from head
function disable_comments_remove_feed_links()
{
  remove_action('wp_head', 'feed_links_extra', 3);
}
add_action('init', 'disable_comments_remove_feed_links');

// Close comments for existing posts
function disable_comments_close_for_existing_posts()
{
  // This will run once to close comments on existing posts
  if (get_option('comments_disabled_processed') != 'yes') {
    global $wpdb;

    // Close comments for all posts
    $wpdb->query("UPDATE {$wpdb->posts} SET comment_status = 'closed' WHERE post_status = 'publish'");

    // Close pingbacks for all posts
    $wpdb->query("UPDATE {$wpdb->posts} SET ping_status = 'closed' WHERE post_status = 'publish'");

    // Mark as processed
    update_option('comments_disabled_processed', 'yes');
  }
}
add_action('admin_init', 'disable_comments_close_for_existing_posts');

// Remove comment form completely from themes
function disable_comments_template_redirect()
{
  if (is_comment_feed()) {
    wp_die(__('Comments are disabled.'), '', array('response' => 403));
  }
}
add_action('template_redirect', 'disable_comments_template_redirect');

// Filter the comments template to return blank
function disable_comments_template($file)
{
  if (basename($file) == 'comments.php') {
    return dirname(__FILE__) . '/blank-comments.php';
  }
  return $file;
}
add_filter('comments_template', 'disable_comments_template');

// Create blank comments template content
function create_blank_comments_template()
{
  $upload_dir = wp_upload_dir();
  $blank_comments_file = $upload_dir['basedir'] . '/blank-comments.php';

  if (!file_exists($blank_comments_file)) {
    $blank_content = '<?php
// This file intentionally left blank to disable comments template
// Generated by WordPress comments disable code
?>';
    file_put_contents($blank_comments_file, $blank_content);
  }
}
add_action('init', 'create_blank_comments_template');

// Remove comment-related database queries
function disable_comments_pre_get_comments($query)
{
  if (is_admin() && current_user_can('manage_options')) {
    return $query; // Allow admins to see comments in backend if needed
  }

  $query->query_vars['post__in'] = array(0); // Return no comments
  return $query;
}
add_action('pre_get_comments', 'disable_comments_pre_get_comments');

// Disable XML-RPC methods related to comments
function disable_comments_xmlrpc_methods($methods)
{
  unset($methods['wp.newComment']);
  unset($methods['wp.getComments']);
  unset($methods['wp.deleteComment']);
  unset($methods['wp.editComment']);
  unset($methods['wp.getComment']);
  unset($methods['wp.getCommentStatusList']);
  return $methods;
}
add_filter('xmlrpc_methods', 'disable_comments_xmlrpc_methods');

// Remove comment notification options from admin
function disable_comments_admin_init()
{
  // Remove comment settings from Discussion Settings page
  add_filter('pre_option_default_comment_status', '__return_zero');
  add_filter('pre_option_default_ping_status', '__return_zero');
}
add_action('admin_init', 'disable_comments_admin_init');

// Remove comment count from posts list in admin
function disable_comments_manage_posts_columns($columns)
{
  unset($columns['comments']);
  return $columns;
}
add_filter('manage_posts_columns', 'disable_comments_manage_posts_columns');
add_filter('manage_pages_columns', 'disable_comments_manage_posts_columns');

// Clean up comment count in At a Glance dashboard widget
function disable_comments_right_now_content_table_end()
{
  echo '<script>
        jQuery(document).ready(function($) {
            $(".comment-count, .comment-mod-count").parent().remove();
        });
    </script>';
}
add_action('dashboard_glance_items', 'disable_comments_right_now_content_table_end');
