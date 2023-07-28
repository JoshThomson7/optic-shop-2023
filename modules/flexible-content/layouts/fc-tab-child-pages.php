<?php
/**
 * FC Tab Scrollbar
 *
 * @package Flexible Content
 * @version 1.0
 */

global $post;
if($type === 'parent_child_pages') {
    $post_id = FL1_Helpers::get_top_parent_page_id();
}

$post_types = array('library', 'catch-up', 'up-next');
$solid_bg = in_array(get_post_type($post->ID), $post_types) || get_field('fc_tab_scroller_solid') ? 'solid' : '';

// get current page child pages
$child_pages = get_pages(array(
    'child_of' => $post_id,
    'sort_column' => 'menu_order',
    'sort_order' => 'ASC'
));
?>
<section class="fc_tab_scrollbar<?php echo ' '.$solid_bg; ?>">
    <div class="max__width">
        <ul>            
            <?php if($type === 'parent_child_pages'): ?>
                <li><a href="<?php echo get_permalink($post_id); ?>"><?php echo get_the_title($post_id); ?></a></li>
            <?php endif; ?>
            <?php
                foreach($child_pages as $child_page):
                    $active = ($child_page->ID === $post->ID) ? 'active' : '';
            ?>
                <li><a href="<?php echo get_permalink($child_page->ID); ?>" class="<?php echo $active; ?>"><?php echo get_the_title($child_page->ID); ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div><!-- max__width -->
</section><!-- fc_tab_scrollbar -->
