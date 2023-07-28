<?php
/*
FC Buttons
*/

$align = 'align-'.get_sub_field('buttons_align');
?>
<div class="buttons__wrap <?php echo $align; ?>">
    <?php
        while(have_rows('buttons')) : the_row();

        $button_label = get_sub_field('button_label');
        $button_url = get_sub_field('button_url');

		if(!$button_label || !$button_url) continue;
    ?>
        <a href="<?php echo $button_url; ?>"<?php echo FL1_Helpers::link_target($button_url) ?> class="button secondary small"><?php echo $button_label; ?></a>
    <?php endwhile; ?>
</div><!-- buttons__wrap -->
