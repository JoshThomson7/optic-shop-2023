<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/**
 * ATeam Post Type
 *
 * @package modules/woocommerce
 * @version 1.0
*/

add_action( 'init', 'ateam_create_team_post_type', 4 );
function ateam_create_team_post_type() {
  	$labels = array(
		'name' => __( 'Team' ),
		'singular_name' => __( 'Team' ),
		'add_new' => __( 'Add New' ),
		'add_new_item' => __( 'Create Team Member' ),
		'edit' => __( 'Edit' ),
		'edit_item' => __( 'Edit Team Member' ),
		'new_item' => __( 'New Team Member' ),
		'view' => __( 'View Team Member' ),
		'view_item' => __( 'View Team Member' ),
		'search_items' => __( 'Search Team Members' ),
		'not_found' => __( 'No team members found' ),
		'not_found_in_trash' => __( 'No team members found in trash' ),
		'parent' => __( 'Parent Team Member' ),
	  );

	$args = array(
		'labels' 				=> $labels,
		'description' 			=> __( 'This is where you can create team members.' ),
		'public' 				=> true,
		'show_ui' 				=> true,
		'capability_type' 		=> 'post',
		'publicly_queryable' 	=> true,
		'exclude_from_search' 	=> true,
		'menu_icon' 			=> 'dashicons-groups',
		'menu_position' 		=> 30,
		'hierarchical' 			=> true,
		'_builtin' 				=> false, // It's a custom post type, not built in!
		'rewrite' 				=> array( 'slug' => 'our-team', 'with_front' => true ),
		'query_var' 			=> true,
		'has_archive'			=> false, 
		'supports' 				=> array( 'title', 'editor', 'author', 'thumbnail', 'excerpt' ),
	  );

	register_post_type('team', $args);
}


/*================================================================================================================*/
/*                                                                                                                */
/*                                                2. TAXONOMIES                                                   */
/*                                                                                                                */
/*================================================================================================================*/
// Department
add_action( 'init', 'create_team_departments_taxonomy', 0 );
function create_team_departments_taxonomy() {
  // Add new taxonomy, make it hierarchical => true for categories-like taxonomies)
  $labels = array(
    'name' => _x( 'Departments', 'taxonomy general name' ),
    'singular_name' => _x( 'Department', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Departments' ),
    'all_items' => __( 'All Departments' ),
    'parent_item' => __( 'Parent Department' ),
    'parent_item_colon' => __( 'Parent Department:' ),
    'edit_item' => __( 'Edit Department' ),
    'update_item' => __( 'Update Department' ),
    'add_new_item' => __( 'Add New Department' ),
    'new_item_name' => __( 'New Department' ),
    'menu_name' => __( 'Department' ),
  );

  register_taxonomy('team_department', array('team'), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'query_var' => true,
    'public' => false,
    // 'rewrite' => array( 'slug' => 'property', 'with_front' => true ),
  ));
}

