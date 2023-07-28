<?php
/**
 * FC Public
 *
 * Class in charge of FC Public facing side
 */

 // Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class FC_Public {

    public function __construct() {

        add_filter('fl1_body_classes', array($this, 'body_classes'));
        add_action('fc_tab_scroller', array($this, 'fc_tab_scroller'));

    }

    /**
	 * Returns body CSS class names.
	 *
	 * @since 1.0
     * @param array $classes
	 */
    public function body_classes($classes) {
        global $post;
    
        if(have_rows('fc_content_types', $post->ID)) { 
            $classes[] = 'page-has-flexible-content';

			$fc = get_field('fc_content_types', $post_id);
			$fc_bg = $fc[0]['fc_styles']['fc_background'];
			if($fc_bg) {
				$classes[] = 'fc-background-'.$fc_bg;
			}
        }

		if(get_field('fc_overlap', $post->ID)) {
			$classes[] = 'fc-overlap';
		}
        
        return $classes;
    }

    /**
	 * Outputs the tab scroller.
	 */
    public function fc_tab_scroller($post_id) {

        $post_type = get_post_type($post_id);
    
        if(get_field('fc_tab_scroller', $post_id)) {
            $type = get_field('fc_menu_type', $post_id);
            if($type === 'fc_sections' && have_rows('fc_content_types', $post_id)) { 
                include FC_PATH.'layouts/fc-tab-scrollbar.php';
            }

            if($type === 'child_pages' || $type === 'parent_child_pages') { 
                include FC_PATH.'layouts/fc-tab-child-pages.php';
            }
        }
        
    }

}

