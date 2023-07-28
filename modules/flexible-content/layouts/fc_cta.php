<?php
/*
    Call to action
*/

// image
$cta_classes = array('cta__wrapper');
$cta_bk = get_sub_field('cta_bk');
$bk_img = '';
if($cta_bk) {
	$bk_pos = get_sub_field('cta_bk_position');
    $bk_img = vt_resize($cta_bk, '', 2000, 600, true);
    $bk_img = ' style="background-image:url('.$bk_img['url'].'); background-position: center '.$bk_pos.'"';
	$cta_classes[] = 'has-img';
}

$scroll = '';
if (substr(get_sub_field('cta_button_link'), 0, 1) === '#') {
    $scroll = 'scroll ';
}

$parallax = '';
if(get_sub_field('cta_parallax')) {
    $parallax = ' cta__parallax';
}

// styles
$styles = get_sub_field('fc_styles');
$full_width = $styles['fc_full_width'] == true ? true : false;
if($full_width) {
	$cta_classes[] = 'fw';
}

$heading = get_sub_field('cta_heading');
$caption = get_sub_field('cta_caption');
$button_link = get_sub_field('cta_button_link');
$button_label = get_sub_field('cta_button_label');
$overlay_opacity = get_sub_field('cta_overlay_opacity') ?? 0;
?>
<div class="<?php echo join(' ', $cta_classes); ?>"<?php echo $bk_img; ?>>
	<?php if($full_width): ?><div class="max__width"><?php endif; ?>
	<article>
		<?php if($heading): ?><h2><?php echo $heading; ?></h2><?php endif; ?>
		<?php if($caption): ?><p><?php echo $caption; ?></p><?php endif; ?>
	</article>

	<?php if($button_link): ?>
		<a href="<?php echo $button_link; ?>" class="button secondary"<?php echo FL1_Helpers::link_target($button_link) ?>>
			<?php echo $button_label; ?>
		</a>
	<?php endif; ?>

	<div class="cta__overlay" style="background:rgba(0, 0, 0, <?php echo $overlay_opacity; ?>)"></div>
	<div class="cta__image<?php echo $parallax; ?>"<?php echo $bk_img; ?>></div>
	<?php if($full_width): ?></div><?php endif; ?>
</div><!-- cta__wrapper -->
