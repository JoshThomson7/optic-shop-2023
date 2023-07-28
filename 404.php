<?php
/*
	404 template
*/
global $post;

get_header();
?>

<section class="avb">
	<div class="avb-banners avb-empty">
		<div class="avb-banner" style="min-height: 140px;">
		</div>
	</div>
</section>

<section class="four_o_four">
    <div class="max__width">

        <div class="four_o_four__page">
            <div class="four_o_four__img">
                <i class="fa-light fa-ghost"></i>
            </div><!-- four_o_four__img -->

            <h2>Oops!</h2>
            <p>The page you're looking for isn't here anymore.<br>Please check the spelling on the address bar or try a different page.</p>

            <?php echo get_post_type(); ?>
        </div><!-- four_o_four__page -->
    </div><!-- max__width -->
</section><!-- four_o_four -->

<?php get_footer(); ?>
