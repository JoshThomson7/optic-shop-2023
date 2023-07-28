<?php
/**
 * Blog
 */

global $paged;
get_header();

$term = get_queried_object();

$title = 'Blog';

if($term->taxonomy === 'category') {
	$top_heading = 'Category';
}

if($term->taxonomy === 'post_tag') {
	$top_heading = 'Tag';
}

$blog_args['paged'] = $paged;
$blog_args['posts_per_page'] = 15;
$blog_args['tax_query'] = array(
	array(
		'taxonomy' => $term->taxonomy,
		'field' => 'id',
		'terms' => $term->term_id
	)
);
$blogs = FL1_Blog_Helpers::get_blogs($blog_args);
?>

<section class="avb">
	<div class="avb-banners avb-inner">
		<div class="avb-banner">

			<div class="avb-banner__caption">
				<div class="avb-banner__caption-wrap" style="gap: 0;">
					<h3>News <?php echo $top_heading; ?></h3>
					<h1><?php echo $term->name; ?></h1>
				</div>
			</div>
		</div>
	</div><!-- avb-banners -->
</section>

<section class="blog">
    <div class="max__width">
        <div class="blog__loop grid">
            <?php include FL1_BLOG_PATH .'templates/blog-loop.php'; ?>
            <?php FL1_Helpers::pagination($blogs['max_num_pages']); ?>
        </div>

        <?php include 'blog-filters.php'; ?>
    </div><!-- max__width -->
</section><!-- blog -->

<?php get_footer(); ?>
