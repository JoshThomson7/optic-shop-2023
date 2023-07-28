<?php
/**
 * AEF CPT
 *
 * Class in charge of registering AEF custom post types
 */

 // Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class AEF_CPT {

    public function __construct() {

        $post_types = array(
            'event',
        );

        foreach($post_types as $post_type) {
            $method = 'register_'.$post_type.'_cpt';

            if(method_exists($this, $method)) {
                $this->$method();
            }
        }

        add_action('admin_menu', array($this, 'menu_page'));
        add_action('admin_menu', array($this, 'remove_duplicate_subpage'));
        add_filter('parent_file', array($this, 'highlight_current_menu'));
        add_action('admin_head', array($this, 'column_widths'));

        $this->post_status();

        add_action('admin_footer-edit.php', array($this, 'status_dropdown'));
        add_action('admin_footer-post.php', array($this, 'status_dropdown'));

    }

    public function menu_page() {
        add_menu_page(
            __('AEF', AEF_SLUG),
            'Events',
            'manage_options',
            AEF_SLUG,
            '',
            'dashicons-calendar',
            31
        );

        $submenu_pages = array(
            array(
                'page_title'  => 'Events',
                'menu_title'  => 'Events',
                'capability'  => 'manage_options',
                'menu_slug'   => 'edit.php?post_type=event',
                'function'    => null,
            ),
                array(
                    'menu_title'  => '&nbsp;- Categories',
                    'capability'  => 'manage_options',
                    'menu_slug'   => 'edit-tags.php?taxonomy=event_category&post_type=event',
                    'function'    => null,
                )
        );

        foreach ( $submenu_pages as $submenu ) {

            add_submenu_page(
                AEF_SLUG,
                $submenu['page_title'],
                $submenu['menu_title'],
                $submenu['capability'],
                $submenu['menu_slug'],
                $submenu['function']
            );

        }
    }

    public function highlight_current_menu( $parent_file ) {

        global $submenu_file, $current_screen, $pagenow;

        $cpts = FL1_Helpers::registered_post_types(AEF_SLUG);

        # Set the submenu as active/current while anywhere APM
        if (in_array($current_screen->post_type, $cpts)) {

            if ( $pagenow == 'post.php' ) {
                $submenu_file = 'edit.php?post_type=' . $current_screen->post_type;
            }

            if ( $pagenow == 'edit-tags.php' ) {
                $submenu_file = 'edit-tags.php?taxonomy='.$current_screen->taxonomy.'&post_type=' . $current_screen->post_type;
            }

            $parent_file = AEF_SLUG;

        }

        return $parent_file;

    }

    

    /**
     * Event CPT
     */
    private function register_event_cpt() {

        // CPT
        $cpt = new FL1_CPT(
            array(
                'post_type_name' => 'event',
                'plural' => 'Events',
                'menu_name' => 'Events'
            ),
            array(
                'menu_position' => 21,
                'rewrite' => array( 'slug' => 'event', 'with_front' => true ),
                'show_in_menu' => false,
                'publicly_queryable' => true,
                'generator' => AEF_SLUG
            )
        );


        // Taxonomies
        $cpt->register_taxonomy(
            array(
                'taxonomy_name' => 'event_category',
                'slug' => 'event_category',
                'singular' => 'Event Category',
                'plural' => 'Event Categories'
            )
        );

        $cpt->columns(array(
            'cb' => '<input type="checkbox" />',
            'title' => __('Event name'),
            'event_category' => __('Category'),
            'event_date' => __('Date'),
            'event_address' => __('Address'),
        ));

        $cpt->populate_column('event_date', function($column, $post) {

            $post_id = $post->ID;
            $event = new AEF_Event($post_id);

            if($event->start_date()) {
                echo $event->date('j M Y (H:i)', 'start_end');
            } else {
                echo __( '--' );
            }
        
        });

        $cpt->populate_column('event_address', function($column, $post) {

            $post_id = $post->ID;
            $event = new AEF_Event($post_id);
            $address = $event->address(array('latutude', 'longitude'), ', ');

            if(!empty($address)) {
                echo $address;
            } else {
                echo __( '--' );
            }
        
        });

    }

    public function column_widths() {
        $screen = get_current_screen();
        
        if($screen->post_type && $screen->post_type === 'speaker') {
            echo '<style type="text/css">';
            echo '.column-picture { width:100px !important; overflow:hidden }';
            echo '.column-title { width:250px !important; overflow:hidden }';
            echo '.column-picture img { max-width:100% !important;}';
            echo '</style>';
        }
    }


    /**
	 * Remove duplicate sub page
	 *
	 * @since 1.0
	 */
	public function remove_duplicate_subpage() {
        remove_submenu_page(AEF_SLUG, AEF_SLUG);
    }

    /**
     * Add custom statuses to admin dropdown
     */
    public function status_dropdown() {

        global $current_screen;
        
        if($current_screen->post_type === "event") {
            echo "<script>
                jQuery(document).ready( function() {
                    jQuery('select[name=\"post_status\"]' ).append( '<option value=\"expired_event\">Expired event</option>' );
                });
            </script>";
        }

    }

    /**
     * Expire event
     * @param  int $post_id
     * @return void
     */
    public function post_status() {
        
        register_post_status( 'expired_event', array(
            'label'                     => _x( 'Past Events', 'event' ),
            'public'                    => false,
            'exclude_from_search'       => true,
            'show_in_admin_status_list' => true,
            'show_in_admin_all_list'    => true,
            'label_count'               => _n_noop( 'Past Events <span class="count">(%s)</span>', 'Past Events <span class="count">(%s)</span>' ),
        ));

    }

}