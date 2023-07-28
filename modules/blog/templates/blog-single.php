<?php
/*
*	Blog Single
*
*	@package Blog
*	@version 1.0
*/

global $post;
get_header();

$blog = new FL1_Blog($post->ID);

// Image
$blog_image = $blog->image(900, 700, true);

// Main category
$blog_cat_id = $blog->main_category('ids');
$blog_cat_url = get_term_link($blog_cat_id, 'category');
$blog_cat_name = $blog->main_category('id=>name');
$excerpt = $blog->excerpt(1000);
$blog_author_id = $blog->author();
?>

<section class="blog--header">
    <div class="max__width">
		<div class="blog--header-nav">
			<nav>
				<a href="<?php echo esc_url(get_permalink(FL1_BLOG_PAGE_ID)); ?>">&lsaquo; News</a> / <a href="<?php echo $blog_cat_url ?>"><?php echo $blog_cat_name; ?></a>
			</nav>
			<aside>
				<?php if(shortcode_exists('shared_counts')) { echo do_shortcode('[shared_counts]'); } ?>
			</aside>
		</div>

		<h1><?php echo get_the_title($post->ID); ?></h1>
		<date><?php echo $blog->date('M jS Y'); ?></date>

		<?php if($excerpt): ?>
			<p><?php echo $excerpt; ?></p>
		<?php endif; ?>
    </div>
</section>

<?php FC_Helpers::flexible_content(); ?>

<?php
	if($blog_author_id):
		$_team = new FL1C_Team_Member($blog_author_id);
		$team_img = $_team->image(400, 400);
?>
	<div class="max__width">
		<div class="blog--author">
			<?php if(is_array($team_img)): ?>
				<figure>
					<img src="<?php echo $team_img['url']; ?>" alt="<?php echo $_team->name(); ?>">
				</figure>
			<?php endif; ?>

			<div class="blog--author-content">
				<h4><?php echo $_team->name(); ?></h4>
				<h6><?php echo $_team->job_title(); ?></h6>

				<?php if($_team->bio()): ?>
					<div class="description">
						<p><?php echo $_team->bio(); ?></p>
					</div>
				<?php endif; ?>

			</div>
		</div>
	</div>
<?php endif ?>

<?php get_footer(); ?>