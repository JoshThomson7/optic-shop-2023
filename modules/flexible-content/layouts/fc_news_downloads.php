<?php
/**
 * News + downloads
 */

$news_enable = get_sub_field('news_enable');
$downloads_enable = get_sub_field('downloads_enable');
?>

<div class="fc-news-downloads">
	<?php
		if($news_enable):
			$news = new WP_Query(array(
				'post_type'         => 'post',
				'post_status'       => 'publish',
				'posts_per_page'    => 4,
				'orderby'           => 'date',
				'order'             => 'desc',
				'fields'            => 'ids'
			));
	?>
		<div class="news">
			<h3>News <a href="<?php echo esc_url(get_permalink(FL1_BLOG_PAGE_ID)); ?>">View all <i class="fa-regular fa-chevron-right"></i></a></h3>

			<?php
				foreach($news->posts as $post_id):
					$_post = new FL1_Blog($post_id);
			?>
				<article>
					<a href="<?php echo $_post->url(); ?>" alt="<?php echo $_post->title(); ?>"><?php echo $_post->title(); ?>.</a>
					<date><?php echo $_post->date('j M Y'); ?></date>
				</article>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>

	<?php
		if($downloads_enable):
			$downloads = get_sub_field('downloads');
	?>
		<div class="downloads">
			<h3>Downloads</h3>

			<?php
				foreach($downloads as $download):
					$download_img_id = $download['image'];
					$download_img = vt_resize($download_img_id, '', 200, 200, true);
					$download_size = filesize(get_attached_file($download_img_id));
					$downlod_size = FL1_Helpers::byte_size($download_size);
					$download_file = $download['file'];
					$download_label = $download['label'];
			?>
				<article>
					<?php if(is_array($download_img)): ?>
						<figure><img src="<?php echo $download_img['url']; ?>" /></figure>
					<?php endif; ?>
					<a href="<?php echo $download_file; ?>" target="_blank" download>
						<?php echo $download_label; ?>
						<small><?php echo $downlod_size; ?></small>
					</a>
				</article>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</div>