<?php

$meta_query = array( 'relation' => 'AND' );
$tax_query = array( 'relation' => 'AND' );

if(!empty($filter_department_id)){

    $tax_query[] = array(
        'taxonomy' => 'team_department',
        'field'    => 'term_id',
        'terms'    => $filter_department_id,
    );

}

if(!empty($filter_branch_ids)){
    
    $meta_query[] = array(
        'key'       => 'team_branches',
        'value'     =>  '"'.$filter_branch_ids.'"',
        'compare'   => 'LIKE'
    );

}

$team_members_args = array(
    'post_type'         => 'team',
    'post_status'       => 'publish',
    'orderby'           => 'menu_order',
    'order'             => 'ASC',
    'posts_per_page'    => -1,
    'meta_query'        => $meta_query,
    'tax_query'         => $tax_query
); 

/**
 * Filters
 */

if(!empty($filter_member_name)){

   $team_members_args['s'] = $filter_member_name; 

}

$team_members = new WP_Query($team_members_args);

?>
<?php 

if($team_members->have_posts()):
    while($team_members->have_posts()) : $team_members->the_post();?>
        
        <?php include(atm_path().'templates/team-single-component.php'); ?>

    <?php endwhile; wp_reset_postdata();

else: ?>
   <div class="not__found">
        <figure><i class="fal fa-users"></i></figure>
        <h3>No Results Found</h3>
        <p>We could not find any team members with the given filters. Please refine your results</p>
    </div>
<?php endif;?>