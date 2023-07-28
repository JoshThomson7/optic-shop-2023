<?php
/**
 * FL1C_CPT
 *
 * Class in charge of registering custom post types
 */

 // Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class FL1C_CPT {

	private $post_types = array(
		'faq',
		'bank',
		'rate',
		'team',
		'testimonial',
	);

    public function __construct() {

        foreach($this->post_types as $post_type) {
            $method = 'register_'.$post_type.'_cpt';

            if(method_exists($this, $method)) {
                $this->$method();
            }
        }

        add_action('admin_menu', array($this, 'menu_page'));
        add_action('admin_menu', array($this, 'remove_duplicate_subpage'));
        add_filter('parent_file', array($this, 'highlight_current_menu'));
        add_action('admin_head', array($this, 'column_widths'));

        add_action('acf/init', array($this, 'acf_init'));

    }

    public function menu_page() {
        add_menu_page(
            __('FL1C', FL1C_SLUG),
            FL1C_NAME,
            'edit_posts',
            FL1C_SLUG,
            '',
            'dashicons-flag',
            32
        );

        $submenu_pages = array(
            array(
                'page_title'  => 'Banks',
                'menu_title'  => 'Banks',
                'capability'  => 'edit_posts',
                'menu_slug'   => 'edit.php?post_type=bank',
                'function'    => null,
            ),
            array(
                'page_title'  => 'FAQs',
                'menu_title'  => 'FAQs',
                'capability'  => 'edit_posts',
                'menu_slug'   => 'edit.php?post_type=faq',
                'function'    => null,
            ),
				array(
					'page_title'  => '',
					'menu_title'  => '&nbsp;- Categories',
					'capability'  => 'edit_posts',
					'menu_slug'   => 'edit-tags.php?taxonomy=faq_category&post_type=faq',
					'function'    => null,
				),
			array(
				'page_title'  => 'Rates',
				'menu_title'  => 'Rates',
				'capability'  => 'edit_posts',
				'menu_slug'   => 'edit.php?post_type=rate',
				'function'    => null,
			),
            array(
                'page_title'  => 'Team',
                'menu_title'  => 'Team',
                'capability'  => 'edit_posts',
                'menu_slug'   => 'edit.php?post_type=team',
                'function'    => null,
            ),
            array(
                'page_title'  => 'Testimonials',
                'menu_title'  => 'Testimonials',
                'capability'  => 'edit_posts',
                'menu_slug'   => 'edit.php?post_type=testimonial',
                'function'    => null,
            ),
				array(
					'page_title'  => '',
					'menu_title'  => '&nbsp;- Categories',
					'capability'  => 'edit_posts',
					'menu_slug'   => 'edit-tags.php?taxonomy=testimonial_category&post_type=testimonial',
					'function'    => null,
				),
        );

        foreach ( $submenu_pages as $submenu ) {

            add_submenu_page(
                FL1C_SLUG,
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

        $cpts = FL1_Helpers::registered_post_types(FL1C_SLUG);

        # Set the submenu as active/current while anywhere APM
        if (in_array($current_screen->post_type, $cpts)) {

            if ( $pagenow == 'post.php' ) {
                $submenu_file = 'edit.php?post_type=' . $current_screen->post_type;
            }

            if ( $pagenow == 'edit-tags.php' ) {
                $submenu_file = 'edit-tags.php?taxonomy='.$current_screen->taxonomy.'&post_type=' . $current_screen->post_type;
            }

            $parent_file = FL1C_SLUG;

        }

        return $parent_file;

    }

	/**
     * Banks CPT
     */
    private function register_bank_cpt() {

        // CPT
        $cpt = new FL1_CPT(
            array(
                'post_type_name' => 'bank',
                'plural' => 'Banks',
                'menu_name' => 'Banks'
            ),
            array(
                'menu_position' => 21,
                'rewrite' => array( 'slug' => 'bank', 'with_front' => true ),
                'publicly_queryable' => false,
				'exclude_from_search' => false,
				'capability_type' => 'page',
                'generator' => FL1C_SLUG
            )
        );

        $cpt->columns(array(
            'cb' => '<input type="checkbox" />',
            'logo' => __('Logo'),
            'title' => __('Name'),
            'bio' => __('Bio')
        ));

        $cpt->populate_column('logo', function($column, $post) {

            $post_id = $post->ID;
            $bank = new Ins_bank($post_id);
			$logo = $bank->image(300, 100, false);

            if(is_array($logo) && !empty($logo)) {
				echo '<a href="'.get_admin_url().'post.php?post='.$post_id.'&action=edit"><img src="'.$logo['url'].'" style="width: 120px;" /></a>';

			} else {
				echo __( '<div class="dashicons dashicons-format-image" style="font-size:48px; height:48px; color:#e0e0e0;"></div>' );

			}
        
        });

        $cpt->populate_column('bio', function($column, $post) {

            $post_id = $post->ID;
            $bank = new Ins_bank($post_id);

			echo $bank->bio(45);
        
        });

    }

	/**
     * Banks CPT
     */
    private function register_faq_cpt() {

        // CPT
        $cpt = new FL1_CPT(
            array(
                'post_type_name' => 'faq',
                'plural' => 'FAQs',
                'menu_name' => 'FAQs'
            ),
            array(
                'menu_position' => 21,
                'rewrite' => array( 'slug' => 'faq', 'with_front' => true ),
                'publicly_queryable' => false,
				'exclude_from_search' => true,
                'generator' => FL1C_SLUG
            )
        );

		// Taxonomies
        $cpt->register_taxonomy(
            array(
                'taxonomy_name' => 'faq_category',
                'slug' => 'faq_category',
                'singular' => 'FAQ Category',
                'plural' => 'FAQ Categories',
				'public' => false,
				'query_var' => false,
				'rewrite' => false,
				'publicly_queryable' => false
            )
        );

        $cpt->columns(array(
            'cb' => '<input type="checkbox" />',
            'title' => __('Question'),
            'answer' => __('Answer'),
            'faq_category' => __('Categories'),
            'date' => __('Published'),
        ));

        $cpt->populate_column('answer', function($column, $post) {

            $post_id = $post->ID;
			$faq = new FL1C_FAQ($post_id);
			
			echo $faq->answer(50);    
        
        });

    }

	/**
     * Rate CPT
     */
    private function register_rate_cpt() {

        // CPT
        $cpt = new FL1_CPT(
            array(
                'post_type_name' => 'rate',
                'plural' => 'Rates',
                'menu_name' => 'Rates'
            ),
            array(
                'menu_position' => 21,
                'rewrite' => array( 'slug' => 'rate', 'with_front' => true ),
                'publicly_queryable' => false,
				'exclude_from_search' => true,
                'generator' => FL1C_SLUG
            )
        );

		$cols = array(
			'cb' => '<input type="checkbox" />',
            'title' => __('Client'),
		);

		$extra_cols = array(
			'easy_access' => __('Easy Access'),
            '30-45_day_notice' => __('30-45 Day Notice'),
            '90-100_day_notice' => __('90-100 Day Notice'),
            '3_month_fixed_term' => __('3 Month Fixed Term'),
			'6_month_fixed_term' => __('6 Month Fixed Term'),
			'1_year_fixed_term' => __('1 Year Fixed Term'),
			'2_year_fixed_term' => __('2 Year Fixed Term')
		);

        $cpt->columns(array_merge($cols, $extra_cols));

		foreach($extra_cols as $key => $label) {
			$cpt->populate_column($key, function($column, $post) {
				$post_id = $post->ID;
				$rate = new Ins_Rate($post_id);
				$the_rate = $rate->rate($column);
				echo $the_rate != 0 ? '<strong>'.$the_rate.'%</strong>' : '';
			});
		}

    }

    /**
     * Team CPT
     */
    private function register_team_cpt() {

        // CPT
        $cpt = new FL1_CPT(
            array(
                'post_type_name' => 'team',
                'plural' => 'Team',
                'menu_name' => 'Team'
            ),
            array(
                'menu_position' => 21,
                'rewrite' => array( 'slug' => 'team', 'with_front' => true ),
                'publicly_queryable' => false,
                'generator' => FL1C_SLUG
            )
        );

		$cpt->columns(array(
            'cb' => '<input type="checkbox" />',
	        'picture' => __('Picture'),
            'title' => __('Name'),
            'job_title' => __('Job Title'),
            'contact' => __('Contact'),
        ));

		$cpt->populate_column('picture', function($column, $post) {

            $post_id = $post->ID;
            $team = new FL1C_Team_Member($post_id);

            if(get_post_thumbnail_id($post_id)) {
				echo '<a href="'.get_admin_url().'post.php?post='.$post_id.'&action=edit"><img src="'.$team->image(200, 200)['url'].'" style="width: 80px; border-radius: 8px;" /></a>';

			} else {
				echo __( '<div class="dashicons dashicons-format-image" style="font-size:48px; height:48px; color:#e0e0e0;"></div>' );

			}
		});

		$cpt->populate_column('job_title', function($column, $post) {
            $post_id = $post->ID;
            $team = new FL1C_Team_Member($post_id);
			$job_title = $team->job_title();

            echo $job_title ? $job_title : '--';
		});

		$cpt->populate_column('contact', function($column, $post) {
            $post_id = $post->ID;
            $team = new FL1C_Team_Member($post_id);
			$phone = $team->phone();
			$email = $team->email();

            $contact = array();

			if($phone) {
				$contact[] = '&bull; '.$phone;
			}

			if($email) {
				$contact[] = '&bull; '.$email;
			}

			echo join('<br />', $contact);
		});

    }

    /**
     * Testimonials CPT
     */
    private function register_testimonial_cpt() {

        // CPT
        $cpt = new FL1_CPT(
            array(
                'post_type_name' => 'testimonial',
                'plural' => 'Testimonials',
                'menu_name' => 'Testimonials'
            ),
            array(
                'menu_position' => 21,
                'rewrite' => array( 'slug' => 'testimonial', 'with_front' => true ),
                'publicly_queryable' => false,
                'generator' => FL1C_SLUG
            )
        );

		// Taxonomies
        $cpt->register_taxonomy(
            array(
                'taxonomy_name' => 'testimonial_category',
                'slug' => 'testimonial_category',
                'singular' => 'Testimonial Category',
                'plural' => 'Testimonial Categories',
				'public' => false,
				'query_var' => false,
				'rewrite' => false,
				'publicly_queryable' => false
            )
        );

        $cpt->columns(array(
            'cb' => '<input type="checkbox" />',
            //'rating' => __('Rating'),
            'title' => __('Name'),
            'quote' => __('Quote'),
            'testimonial_category' => __('Categories'),
        ));

        // $cpt->populate_column('rating', function($column, $post) {

        //     $post_id = $post->ID;
        //     $testimonial = new FL1C_Testimonial($post_id);
            
        //     $testimonial->rating_display();
        
        // });

        $cpt->populate_column('quote', function($column, $post) {

            $post_id = $post->ID;
            $testimonial = new FL1C_Testimonial($post_id);
            
            echo $testimonial->quote(30);
        
        });

    }

    public function column_widths() {
        $screen = get_current_screen();

		$post_types = array('bank', 'team');
        
        if($screen->post_type && in_array($screen->post_type, $post_types)) {
            echo '<style type="text/css">';
            echo '.column-logo, .column-picture { width: 120px !important; overflow: hidden }';
            echo '.column-title { width: 320px !important; overflow: hidden }';
            echo '</style>';
        }
    }


    /**
	 * Remove duplicate sub page
	 *
	 * @since 1.0
	 */
	public function remove_duplicate_subpage() {
        remove_submenu_page(FL1C_SLUG, FL1C_SLUG);
		
		foreach($this->post_types as $post_type) {
			$post_type = str_replace('_', '-', $post_type);
            remove_menu_page('edit.php?post_type='.$post_type);
        }
    }

    /**
	 * Remove duplicate sub page
	 *
	 * @since 1.0
	 */
	public function acf_init() {

        if(function_exists('acf_add_options_sub_page')) {
        
            acf_add_options_sub_page(array(
                'page_title'  => 'Settings',
                'menu_title'  => 'Settings',
                'menu_slug' => 'fl1c-settings',
                'parent_slug' => FL1C_SLUG,
            ));

        }

    }

}