<?php

/**
 * FL1 Hoooks
 *
 * Helper static functions
 *
 * @author  fl1
 * @link    http://fl1.digital
 * @version 1.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

class FL1_Public
{

    /**
     * Initialize hooks on load.
     *
     * @since 1.0
     * @return void
     */
    public function __construct()
    {

        add_filter('wp_title', array($this, 'wp_title'), 10, 2);
        add_filter('login_headerurl', array($this, 'wp_login_logo'));

        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts_styles'));
        add_action('login_enqueue_scripts', array($this, 'enqueue_login_scripts_styles'));

        add_action('body_class', array($this, 'body_classes'), 20);
    }

    /**
     * Enqueue scripts and styles.
     *
     * @since 1.0
     * @return void
     */
    public function enqueue_scripts_styles()
    {

        wp_dequeue_style('wp-block-library');
        wp_dequeue_style('wp-block-library-theme');
        wp_dequeue_style('wc-block-style');
        wp_dequeue_style('global-styles');

        // Needed for Widget Factory
        wp_register_script('jquery-ui-script', 'https://code.jquery.com/ui/1.12.1/jquery-ui.min.js', array('jquery'), '1.12.1');
        wp_enqueue_script('jquery-ui-script');

        // scripts
        wp_enqueue_script('custom-js', get_stylesheet_directory_uri() . '/js/custom-min.js', array('jquery'), filemtime(get_stylesheet_directory() . '/js/custom-min.js'));

        // Ajax
        wp_localize_script('custom-js', 'fl1_ajax_object', apply_filters(
            'fl1_wp_localize_script',
            array(
                'ajaxUrl' => admin_url('admin-ajax.php'),
                'ajaxNonce' => wp_create_nonce('$C.cGLu/1zxq%.KH}PjIKK|2_7WDN`x[vdhtF5GS4|+6%$wvG)2xZgJcWv3H2K_M'),
                'jsPath' => get_stylesheet_directory_uri() . '/js/',
            )
        ));

        wp_enqueue_style('style-base', get_stylesheet_directory_uri() . '/style-base.css', [], filemtime(get_stylesheet_directory() . '/style-base.css'));

        do_action('fl1_enqueue_scripts_styles');
    }

    /**
     * Enqueue WP Login scripts and styles.
     *
     * @since 1.0
     * @return void
     */
    public function enqueue_login_scripts_styles()
    {
        wp_enqueue_style('wp-login', get_stylesheet_directory_uri() . '/wp-login.min.css');
    }

    /**
     * Custom title.
     *
     * @since 1.0
     * @return $title
     */
    public function wp_title($title, $sep)
    {
        if (is_feed()) {
            return $title;
        }

        global $page, $paged;

        // Add the blog name
        $title .= get_bloginfo('name', 'display');

        // Add the blog description for the home/front page.
        $site_description = get_bloginfo('description', 'display');
        if ($site_description && (is_home() || is_front_page())) {
            $title = get_bloginfo('name', 'display') . $sep . $site_description;
        }

        // Add a page number if necessary:
        if (($paged >= 2 || $page >= 2) && !is_404()) {
            $title .= " $sep " . sprintf(__('Page %s', '_s'), max($paged, $page));
        }

        return $title;
    }

    public function wp_login_logo($url)
    {
        return get_bloginfo('url');
    }

    /**
     * Returns body CSS class names.
     *
     * @since 1.0
     * @param array $classes
     */
    public function body_classes($classes)
    {

        $classes = apply_filters('fl1_body_classes', $classes);

        return $classes;
    }
}
