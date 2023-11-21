<?php 
/*
 *	Team Archive
*/
function atm_templates($archive_template) {
	global $post;

    if(is_page('our-team') ) {
        $archive_template = atm_path() .'templates/team-archive.php';
    } 
    
	return $archive_template;
}
add_filter( 'page_template', 'atm_templates' );


/*
 *	Single Team Member
*/
function atm_single_template($single_template) {
    global $post;

    if ($post->post_type == 'team') {
        $single_template = atm_path() . 'templates/team-single.php';
    }

    return $single_template;
}
add_filter( 'single_template', 'atm_single_template' );
