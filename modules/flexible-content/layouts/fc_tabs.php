<?php
/*
---------------------------
  ______      __
 /_  __/___ _/ /_  _____
  / / / __ `/ __ \/ ___/
 / / / /_/ / /_/ (__  )
/_/  \__,_/_.___/____/

---------------------------
Tabs
*/

$tab_classes = array();

$layout = get_sub_field('tabs_layout');
if($layout) {
    $tab_classes[] = $layout;
}

$tabs_alignment = get_sub_field('tabs_alignment');
if($tabs_alignment) {
    $tab_classes[] = $tabs_alignment;
}

$tabs_content_align = get_sub_field('tabs_content_align');
if($tabs_content_align) {
    $tab_classes[] = 'content-'.$tabs_content_align;
}
?>

<div class="tabbed-wrapper <?php echo join(' ', $tab_classes); ?>">
    <ul class="tabbed">
        <?php
            while(have_rows('tabs')) : the_row();
            $tabbed_id = strtolower(preg_replace("#[^A-Za-z0-9]#", "", get_sub_field('tab_heading')));
        ?>
            <li>
                <a href="#" data-id="<?php echo $tabbed_id; ?>_tabbed" title="<?php the_sub_field('tab_heading'); ?>">
                    <?php if(get_sub_field('tab_icon')): ?>
                        <figure><img src="<?php the_sub_field('tab_icon'); ?>" /></figure>
                    <?php endif; ?>

                    <?php if(!get_sub_field('tab_heading_hide')): ?>
                        <strong><?php the_sub_field('tab_heading'); ?></strong>
                    <?php endif; ?>
                </a>
            </li>
        <?php endwhile; ?>
    </ul>

    <?php
        while(have_rows('tabs')) : the_row();
        $tabbed_id = strtolower(preg_replace("#[^A-Za-z0-9]#", "", get_sub_field('tab_heading')));
        $tab_align = get_sub_field('tab_align');
    ?>
        <div class="tab__content <?php echo $tabbed_id; ?>_tabbed">
            <div class="tab__content--text">
                <?php echo apply_filters('the_content', get_sub_field('tab_content')); ?>
            </div>

            <?php if(get_sub_field('tab_button_label') && get_sub_field('tab_button_link')): ?>
                <a href="<?php the_sub_field('tab_button_link'); ?>" class="button primary"><span><?php the_sub_field('tab_button_label'); ?></span> <i class="fa fa-chevron-right"></i></a>
            <?php endif; ?>
        </div><!-- tab-content -->
    <?php endwhile; ?>
</div>