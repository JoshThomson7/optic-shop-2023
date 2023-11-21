<?php /* Template Name: Single Team Template */ ?>

<?php get_header();

global $post;

$team_id = $team_member->ID;

$team_name = get_the_title($team_id);
$first_name = explode(' ', $team_name);
$first_name = reset($first_name);

$job_title = get_field('team_job_title', $team_id);
$qualifications = get_field('team_qualifications', $team_id);
$team_phone = get_field('team_phone', $team_id);
$team_phone_direct = get_field('team_phone_direct', $team_id);
$team_phone_mobile = get_field('team_phone_mobile', $team_id);
$team_email = get_field('team_email', $team_id);
$team_video = get_field('team_video', $team_id);

// SOCIAL
$team_website = get_field('team_single_website', $team_id);
$team_facebook = get_field('team_single_facebook', $team_id);
$team_twitter = get_field('team_single_twitter', $team_id);
$team_instagram = get_field('team_single_instagram', $team_id);

$branch_link = get_field('branch_link', $team_id);
$branch_text = get_field('branch_text', $team_id);

$member_id = strtolower(preg_replace("#[^A-Za-z0-9]#", "", $team_name));

// NEW RESPONSE FIELDS
$my_job = get_field('team_my_job' , $team_id);
$my_ambition = get_field('team_my_ambition' , $team_id);
$my_quote = get_field('team_my_quote' , $team_id);

if(get_field('team_second_image', $team_id)) {
    $attachment_id = get_field('team_second_image', $team_id);
} else {
    $attachment_id = get_post_thumbnail_id($team_id);
}

$team_img = vt_resize($attachment_id,'' , 900, 900, true);

$bottom_img_1 = get_field('bottom_image_1', $team_id);
$bottom_img_2 = get_field('bottom_image_2', $team_id);

?>

<div class="team__single__container">

    <div class="max__width">

        <div class="top">
            <div class="left">  
                <div class="info">
                    <div class="image">
                        <div class="small-img" style="background-image:url(<?php echo $team_img['url']; ?>);"></div>
                    </div>

                    <div class="text">
                        <h3><?php echo $team_name ?></h3>
                        <h6><?php echo $qualifications ?></h6>
                        <h5><?php echo $job_title ?></h5>

                        <!-- <div class="phone">
                            <a href="tel:<?php echo $team_phone; ?>"><span>T:</span><?php echo $team_phone; ?></a>
                        </div>

                        <div class="email">
                            <a href="mailto:<?php echo $team_email; ?>"><span>E:</span><?php echo $team_email; ?></a>
                        </div> -->
                    </div>
                </div>

                <?php if(get_field('team_video', $team_id)): ?>

                <iframe width="100%" height="350" src="https://www.youtube.com/embed/<?php echo $team_video; ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

                <?php else: ?>

                <div class="content">
                    <h2>About Me</h2>
                    <p><?php the_content(); ?></p>
                </div>

                <?php endif; ?>

                
            </div>
        </div>
    </div>

</div>

<?php 

get_footer();
?>