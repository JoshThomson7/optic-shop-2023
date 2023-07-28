<?php
/**
 * News
 */
?>

<div class="fc-news">
	<?php
		$feature_post = new WP_Query(array(
			'post_type'         => 'post',
			'post_status'       => 'publish',
			'posts_per_page'    => 1,
			'orderby'           => 'date',
			'order'             => 'desc',
			'fields'            => 'ids'
		));

		foreach($feature_post->posts as $post_id):
			$_post = new FL1_Blog($post_id);
			$_post_img = $_post->image(900, 700);
			$_post_excerpt = $_post->excerpt(45);
	?>

		<article>
			<?php if(is_array($_post_img)): ?>
				<figure>
					<a href="<?php echo $_post->url(); ?>" title="<?php echo $_post->title(); ?>">
						<img src="<?php echo $_post_img['url']; ?>" alt="<?php echo $_post->title() ?>">
					</a>
				</figure>
			<?php endif; ?>

			<div class="article__content">
				<h2><a href="<?php echo $_post->url(); ?>" title="<?php echo $_post->title(); ?>"><?php echo $_post->title(); ?></a></h2>
				<date><?php echo $_post->date('j M Y') ?></date>
				<?php if($_post_excerpt): ?><p><?php echo $_post_excerpt; ?></p><?php endif; ?>
			</div><!-- article__content -->
		</article>

	<?php endforeach; ?>

	<div class="news__widgets">
		<?php
			$home_news = new WP_Query(array(
				'post_type'         => 'post',
				'post_status'       => 'publish',
				'posts_per_page'    => 3,
				'offset'            => 1,
				'orderby'           => 'date',
				'order'             => 'desc',
				'fields'            => 'ids'
			));

			foreach($home_news->posts as $post_id):
				$_post = new FL1_Blog($post_id);
				$_post_img = $_post->image(400, 300);
		?>

		<div class="news__widget blog">
			<?php if(is_array($_post_img)): ?>
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