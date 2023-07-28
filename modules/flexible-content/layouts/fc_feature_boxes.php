<?php
/*
    Feature Boxes
*/

$feature_boxes_classes = array();

if(get_sub_field('feature_boxes_per_row')) { 
    $feature_boxes_classes[] = get_sub_field('feature_boxes_per_row');
}

if(get_sub_field('feature_boxes_shadow')) { 
    $feature_boxes_classes[] = 'with-shadow';
}

if(get_sub_field('feature_boxes_animate')) { 
    $feature_boxes_classes[] = 'animate';
}
?>

<div class="fc_feature_boxes_wrapper">
    <?php
        while(have_rows('feature_boxes')) : the_row();

		$feature_box_classes = array();

		$colour = get_sub_field('feature_box_colour');
        if($colour) { 
			$feature_box_classes[] = $colour;
		}

		$type = get_sub_field('type');
		$feature_box_classes[] = $type;

		$bg_img = '';
		if($type === 'image') {
			$img = vt_resize(get_sub_field('image'), '', 800, 800, true);
			$bg_img = is_array($img) ? ' style="background-image: url(' . $img['url']. ');"' : '';
		}

		$img = get_sub_field('feature_box_img');
		$icon = get_sub_field('feature_box_icon');

		$fig_class = '';
		if($img || $icon) {
			if($img) {
				$fig_class = 'svg';
				if($colour === 'orange') {
					$fig_class .= ' white';
				}
			} elseif($icon) {
				$fig_class = 'icon';
			}
		}

		$feature_box_classes = array_merge($feature_box_classes, $feature_boxes_classes);
    ?>
        <article class="<?php echo join(' ', $feature_box_classes); ?>">
            <div class="fc__feature__box__inner"<?php echo $bg_img; ?>>
				<?php if($type !== 'image'): ?>
					<h3>
						<?php if(get_sub_field('feature_box_icon') || get_sub_field('feature_box_img')): ?>
							<figure class="<?php echo $fig_class; ?>">
								<?php if(get_sub_field('feature_box_img')): ?>
									<?php echo file_get_contents(wp_get_original_image_path(get_sub_field('feature_box_img'))); ?>
								<?php elseif(get_sub_field('feature_box_icon')): ?>
									<i class="<?php the_sub_field('feature_box_icon'); ?>"></i>
								<?php endif; ?>
							</figure>
						<?php endif; ?>
						<?php if(get_sub_field('feature_box_button_url')): ?><a href="<?php the_sub_field('feature_box_button_url'); ?>" title="<?php echo strip_tags(get_sub_field('feature_box_heading')); ?>"><?php endif; ?>
							<?php the_sub_field('feature_box_heading'); ?>
						<?php if(get_sub_field('feature_box_button_url')): ?></a><?php endif; ?>
					</h3>

					<?php the_sub_field('feature_box_content'); ?>

					<?php
						if(get_sub_field('feature_box_button_label') && get_sub_field('feature_box_button_url')):
					?>
						<a href="<?php the_sub_field('feature_box_button_url'); ?>" class="link animate-icon">
							<?php the_sub_field('feature_box_button_label'); ?> <i class="fa fa-chevron-right"></i>
						</a>
					<?php endif; ?>
				<?php endif; ?>
            </div><!-- fc__feature__box__inner -->
        </article>
    <?php endwhile; ?>
</div><!-- fc_feature_boxes_wrapper -->
