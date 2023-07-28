<?php
/**
 * Case Studies
 */
$args = array(
    'post_type' => 'case-study',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'order_by' => 'date',
    'order' => 'DESC',
    'fields' => 'ids',
);

$case_studies = new WP_Query($args);
$case_studies = $case_studies->posts;
?>

<div class="grid__boxes__wrapper">
    <?php
        foreach($case_studies as $case_study_id):
            $case_studies_banner_id = get_field('avb_0_image', $case_study_id);
            $caption = get_field('case_study_excerpt', $case_study_id);
            $url = $coming_soon ? '#' : get_permalink($case_study_id);
            $title = get_the_title($case_study_id);
    ?>
        <article class="half">
            <div class="padder">
                <?php
                    if($case_studies_banner_id):
                        $case_studies_banner = '';
                        if($case_studies_banner_id) {
                            $case_studies_banner = vt_resize($case_studies_banner_id, '', 700, 600, true);
                        }
                ?>
                    <figure style="background-image: url(<?php echo $case_studies_banner['url']; ?>)">
                        <a href="<?php echo $url; ?>"></a>
                    </figure>
                <?php endif; ?>
                        
                <div class="grid-box-content left">
                    <a href="<?php echo $url; ?>"><h3><?php echo $title; ?></h3></a>
                    <?php if($caption) { echo $caption; } ?>
                    <a href="<?php echo $url; ?>" class="link animate-icon"><?php if(!$coming_soon): ?>Find out more<?php else: ?>Coming soon<?php endif; ?> <i class="fa fa-chevron-right"></i></a>
                </div><!-- grid__box__content -->
            </div><!-- padder -->
        </article>
    <?php endforeach; ?>
</div>