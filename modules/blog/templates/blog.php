<?php

/**
 * Blog
 */

get_header();

AVB::avb_banners();

$current_page = get_query_var('paged');
$current_page = max( 1, $current_page );

$per_page = 15;
$offset_start = 4;
$offset = ( $current_page - 1 ) * $per_page + $offset_start;

if($paged < 1):
?>
<section class="blog">
	<div class="max__width">
		<div class="fc-news">
			<?php
				$posts_not_in = array();
				$featured_blog = FL1_Blog_Helpers::get_blogs(array(
					'posts_per_page' => 1,
				));

				foreach ($featured_blog['posts'] as $post_id) :
					$_post = new FL1_Blog($post_id);
					$_post_img = $_post->image(900, 700);
					$_post_excerpt = $_post->excerpt(45);

					$posts_not_in[] = $post_id;
			?>

				<article>
					<?php if (is_array($_post_img)) : ?>
						<figure>
							<a href="<?php echo $_post->url(); ?>" title="<?php echo $_post->title(); ?>">
								<img src="<?php echo $_post_img['url']; ?>" alt="<?php echo $_post->title() ?>">
							</a>
						</figure>
					<?php endif; ?>

					<div class="article__content">
						<h2><a href="<?php echo $_post->url(); ?>" title="<?php echo $_post->title(); ?>"><?php echo $_post->title(); ?></a></h2>
						<date><?php echo $_post->date('j M Y') ?></date>
						<?php if ($_post_excerpt) : ?><p><?php echo $_post_excerpt; ?></p><?php endif; ?>
					</div><!-- article__content -->
				</article>

			<?php endforeach; ?>

			<div class="news__widgets">
				<?php
					$featured_blogs = FL1_Blog_Helpers::get_blogs(array(
						'posts_per_page' => 3,
						'offset' => 1,
					));

					foreach ($featured_blogs['posts'] as $post_id) :
						$_post = new FL1_Blog($post_id);
						$_post_img = $_post->image(400, 300);

						$posts_not_in[] = $post_id;
				?>

					<div class="news__widget blog">
						<?php if (is_array($_post_img)) : ?>
							<a href="<?php echo $_post->url(); ?>" class="figure" style="background-image: url(<?php echo $_post_img['url']; ?>);"></a>
						<?php endif; ?>

						<div class="blog__content">
							<h4><a href="<?php echo $_post->url(); ?>" title="<?php echo $_post->title(); ?>"><?php echo $_post->title(); ?></a></h4>
							<date><?php echo $_post->date('j M Y') ?></date>
						</div><!-- blog__content -->
					</div><!-- news__widget -->

				<?php endforeach; ?>
			</div><!-- news__widgets -->
		</div>
	</div>
</section>
<?php endif; ?>

<?php
	$args = array(
		'paged' => $current_page,
		'posts_per_page' => $per_page,
		'offset' => $offset,
	);

	$more_blogs = FL1_Blog_Helpers::get_blogs($args);
	if(!empty($more_blogs['posts'])):
?>
	<div class="flexible__content">
		<section class="fc-layout fc_grid_boxes">
			<div class="fc-layout-container" style="padding: 16px 0 40px;">
				<div class="max__width">
					<div class="grid__boxes__wrapper">
						<?php
							foreach ($more_blogs['posts'] as $post_id) :
								$_post = new FL1_Blog($post_id);
								$_post_img = $_post->image(400, 300);
								$_post_excerpt = $_post->excerpt(45);
						?>
							<article class="one__third white">
								<div class="padder">
									<?php if(is_array($_post_img)): ?>
										<figure style="background-image: url(<?php echo $_post_img['url'] ?>)"><a href="<?php echo $_post->url(); ?>"></a></figure>
									<?php endif; ?>

									<div class="grid-box-content left">
										<a href="<?php echo $_post->url(); ?>">
											<h3><?php echo $_post->title(); ?></h3>
										</a>
										<date><?php echo $_post->date('j M Y') ?></date>
										<?php if($_post_excerpt): ?><p><?php echo $_post_excerpt; ?></p><?php endif; ?>
									</div><!-- grid__box__content -->
								</div><!-- padder -->
							</article>
						<?php endforeach; ?>
					</div><!-- grid__boxes__wrapper -->

					<?php FL1_Helpers::pagination($more_blogs['max_num_pages']); ?>
				</div><!-- max__width -->
			</div><!-- fc-layout-container -->
		</section><!-- fc_grid_boxes -->
	</div><!-- flexible__content -->
<?php endif; ?>

<?php get_footer(); ?>