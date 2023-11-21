<?php 

/**
 * Ajax Team filter
 */
function get_more_team_members(){
   
	// Security check
    wp_verify_nonce('$C.cGLu/1zxq%.KH}PjIKK|2_7WDN`x[vdhtF5GS4|+6%$wvG)2xZgJcWv3H2K_M', 'ajax_security');
    
   /**
    * Grab Values
    */
    parse_str($_POST['form_data'], $form_data);
    $filter_member_name = isset( $form_data['team_name']) && !empty($form_data['team_name']) ? $form_data['team_name'] : NULL ; 
    $filter_department_id = isset( $form_data['team_department']) && !empty($form_data['team_department']) ? $form_data['team_department'] : NULL;  
    $filter_branch_ids = isset( $form_data['team_branch']) && !empty($form_data['team_branch']) ? $form_data['team_branch'] : NULL;

    /**
     * DISPLAY RESULTS
     */
    include(atm_path().'helpers/team-loop.php');
    
    wp_die(); 
}
add_action('wp_ajax_nopriv_get_more_team_members', 'get_more_team_members');
add_action('wp_ajax_get_more_team_members', 'get_more_team_members');