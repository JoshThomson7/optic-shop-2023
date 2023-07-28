<?php
/**
 * Testimonials
 */

// format
$order_by = get_sub_field('testimonials_order_by');
$posts_per_page = get_sub_field('testimonials_number') ? get_sub_field('testimonials_number') : 9;

$args = array(
    'post_type'         => 'testimonial',
    'post_status'       => 'publish',
    'orderby'           => $order_by,
    'order'             => 'asc',
    'posts_per_page'    => $posts_per_page,
	'fields'			=> 'ids'
);

if($order_by === 'tax') {
	$cats = get_sub_field('categories');
    $args['tax_query'] = array(
		array(
			'taxonomy' => 'testimonial_category',
			'terms'    => $cats,
			'field'    => 'term_id',
		),
	);
}

if($order_by === 'custom') {
    $args['post__in'] = $custom;
    $args['orderby'] = 'post__in';
    unset($args['order']);
}

$testimonials = new WP_Query($args);
?>
<div class="testimonials__wrapper testimonials-carousel">
    <?php
        foreach($testimonials->posts as $testimonial_id):
			$testm = new FL1C_Testimonial($testimonial_id);
        	//$stars = get_field('review_rating');
    ?>
        <article>
            <div class="inner">
                <div class="testimonial__meta">
					<?php /* if($stars): ?>
						<div class="stars">
							<?php for($x = 1; $x <= $stars; $x++): ?>
								<span>&#x2605;</span>
							<?php endfor; ?>
						</div>
					<?php endif; */ ?>
					<figure><?php echo file_get_contents(FL1_PATH.'/img/squares.svg'); ?></figure>
                    <h3>
						<?php echo $testm->name(); ?>
						<?php if($testm->company()) { echo '<br/>'.$testm->company(); } ?>
					</h3>
                </div><!-- testimonial__meta -->

                <div class="testim__content">
                    <?php echo $testm->quote(); ?>
                </div><!-- testim__content -->
            </div>
        </article>
    <?php endforeach; ?>
</idv>
