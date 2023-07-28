<?php
/**
 * WVL Banks
 *
 * Class in charge of Banks
 */

 // Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class Ins_Banks {

    public function init() {

        //add_filter('single_template', array($this, 'bank_single_template' ));

        add_action('wp_ajax_nopriv_ins_bank_filters', array($this, 'ins_bank_filters'));
        add_action('wp_ajax_ins_bank_filters', array($this, 'ins_bank_filters'));

		add_filter('posts_where', array($this, 'posts_where'), 10, 2);
        
        //add_filter('fl1_searchables', array($this, FL1C_SLUG.'_bank_searchables'), 10, 2);

    }

    public function bank_single_template($single_template) {
        global $post;

        if ($post->post_type === 'bank') {
            $single_template = FL1C_PATH . 'templates/banks/bank-single.php';
        }

        return $single_template;
    }

    /**
     * WP_Query
     * 
     * @param array $custom_args
     */
    public static function get_banks($custom_args = array()) {

        $posts = array();

        $default_args = array(
            'post_type' => 'bank',
			'post_status' => 'publish',
            'posts_per_page' => -1,
            'orderby' => 'title',
            'order' => 'ASC'
        );

        $args = wp_parse_args($custom_args, $default_args);

        $posts = new WP_Query($args);
        return $posts->posts;

    }

    /**
     * WP_Query
     * 
     * @param array $custom_args
     */
    public static function get_bank_letters() {

        $banks = self::get_banks(array(
			'fields' => 'ids'
		));
		$unique_letters = array();

		foreach($banks as $bank_id) {
			$bank_name = get_the_title($bank_id);
			$first_letter = strtoupper(substr($bank_name, 0, 1));
			
			if (!in_array($first_letter, $unique_letters)) {
				$unique_letters[] = $first_letter;
			}
		}

		return $unique_letters;

    }

    /**
     * Filter banks.
     *
     * @since	1.0
     */
    public function ins_bank_filters() {

        // Security check.
        wp_verify_nonce('$C.cGLu/1zxq%.KH}PjIKK|2_7WDN`x[vdhtF5GS4|+6%$wvG)2xZgJcWv3H2K_M', 'ajax_security');

        $form_data = isset($_POST['formData']) && !empty($_POST['formData']) ? $_POST['formData'] : null;

        $args = array();

        if($form_data) {

            // Get data
            $bank_search = isset($form_data['bank_search']) && !empty($form_data['bank_search']) ? $form_data['bank_search'] : null;
            $bank_letter = isset($form_data['bank_letter']) && !empty($form_data['bank_letter']) ? $form_data['bank_letter'] : null;

			if($bank_letter) {
                $args['starts_with'] = $bank_letter;
            }

			if($bank_search) {
                $args['s'] = $bank_search;
				$args['starts_with'] = '';
            }

        }

        $banks = self::get_banks($args);
        
        include FL1C_PATH .'templates/banks/banks-loop.php';

        wp_die();

    }

    /**
     * Add bank fields to searchables
     */
    public function ins_bank_searchables($searchables, $post_type) {

        if($post_type === 'bank') {
            $searchables['taxonomies'] = array('bank_theme', 'bank_travels_from');
            $searchables['meta'] = array('bank_role');
        }

        return $searchables;

    }

	/**
	 * Posts where filter
	 * 
	 * @param string $where
	 * @param WP_Query $query
	 */
	public function posts_where($where, $query) {
		global $wpdb;
	
		$starts_with = esc_sql($query->get('starts_with'));
	
		if ($starts_with) {
			$where .= " AND $wpdb->posts.post_title LIKE '$starts_with%'";
		}
	
		return $where;
	}

}

