<?php

/**
 * Team
 */

$no_bios = get_sub_field('no_bios');
$args = array(
	'post_type'         => 'team',
	'post_status'       => 'publish',
	'orderby'           => 'menu_order',
	'order'             => 'asc',
	'posts_per_page'    => -1,
	'fields'			=> 'ids',
);

if (get_sub_field('type') === 'custom') {
	$args['post__in'] = get_sub_field('team_custom') ?? array(0);
}

$team_query = new WP_Query($args);
$team = $team_query->posts;
$team_total = $team_query->post_count;
?>

<div class="team__wrap">
	<?php
	foreach ($team as $team_id) :

		$member = new FL1C_Team_Member($team_id);
		$member_id = preg_replace("#[^A-Za-z0-9]#", "", $member->name());
		$member_image = $member->image(400, 400);
		$member_image_url = $member_image ? $member_image['url'] : "";
		$member_name = $member->name();

	?>
		<article data-image-list="<?php echo $member_image_url; ?>">
			<div class="padder">
				<a <?php echo !$no_bios ? 'href="#' . $member_id . '"' : ''; ?> title="<?php echo $member_name; ?>" class="<?php echo !$no_bios ? 'team__modal' : ''; ?>">
					<img src="<?php echo $member_image_url ?>" alt="<?php echo $member_name; ?>" />
				</a>
				<h5><?php echo $member_name ?><span><?php echo $member->job_title(); ?></span></h5>

				<?php if (!$no_bios) : ?>
					<a href="#<?php echo $member_id; ?>" title="<?php echo $member_name ?>" class="team__modal plus">
						<i class="fa-regular fa-plus"></i>
					</a>
				<?php endif; ?>
			</div>
		</article>
	<?php endforeach; ?>
</div>

<?php if (!$no_bios) : ?>
	<div class="team__popup__holder">
		<?php
		$i = 1;
		foreach ($team as $team_id) :
			$member = new FL1C_Team_Member($team_id);
			$member_id = preg_replace("#[^A-Za-z0-9]#", "", $member->name());
			$member_image = $member->image(600, 700);
			$member_image_url = $member_image ? $member_image['url'] : "";
			$member_name = $member->name();
			$member_email = $member->email();
			$member_phone = $member->phone();
		?>
			<div id="<?php echo $member_id; ?>" class="team__popup">

				<div class="team__popup__img">
					<img src="<?php echo $member_image_url ?>" alt="<?php echo $member_name; ?>" />
				</div>

				<div class="team__popup__content">

					<div class="team__popup__nav">
						<ul>
							<li <?php if ($i == 1) : ?> class="inactive" <?php endif; ?>><a href="#" class="team__switch team__prev"><i class="fa-regular fa-chevron-left"></i></a></li>
							<li <?php if ($i == $team_total) : ?> class="inactive" <?php endif; ?>><a href="#" class="team__switch team__next"><i class="fa-regular fa-chevron-right"></i></a></li>
							<li><a href="#" class="team__close"><i class="fa-regular fa-times"></i></a></li>
						</ul>
					</div>

					<h3><?php echo $member_name; ?> <span><?php echo $member->job_title(); ?></span></h3>

					<?php if ($member_email) : ?>
						<div class="team__popup__icon">
							<i class="fa-regular fa-envelope"></i>
							<?php echo FL1_Helpers::hide_email($member_email); ?>
						</div>
					<?php endif; ?>

					<?php if ($member_phone) : ?>
						<div class="team__popup__icon">
							<i class="fa-regular fa-phone"></i>
							<a href="tel:<?php echo $member_phone; ?>" target="_blank"><?php echo $member_phone; ?></a>
						</div>
					<?php endif; ?>

					<?php echo $member->bio(); ?>
				</div>
			</div>
		<?php $i++;
		endforeach; ?>
	</div>
<?php endif; ?>