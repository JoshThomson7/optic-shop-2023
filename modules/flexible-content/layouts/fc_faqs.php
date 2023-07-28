<?php

/**
 * FAQs
 */

// format
$order_by = get_sub_field('faqs_order_by');

$args = array(
    'post_type'         => 'faq',
    'post_status'       => 'publish',
    'orderby'           => $order_by,
    'order'             => 'asc',
    'posts_per_page'    => -1,
    'fields'            => 'ids'
);

if ($order_by === 'tax') {
    $cats = get_sub_field('categories');
    $args['tax_query'] = array(
        array(
            'taxonomy' => 'faq_category',
            'terms'    => $cats,
            'field'    => 'term_id',
        ),
    );
    unset($args['orderby']);
}

if ($order_by === 'custom') {
    $args['post__in'] = $custom;
    $args['orderby'] = 'post__in';
    unset($args['order']);
}

$faqs = new WP_Query($args);
$faqs = $faqs->posts;
?>


<?php
$row_index = 1;
foreach ($faqs as $faq_id) :
    $faq = new FL1C_FAQ($faq_id);
?>
    <div class="accordion__wrap" id="<?php echo 'fc-accordion-' . $row_count . '-' . $faq_id; ?>">
        <h3 class="toggle"><i class="fal fa-plus"></i> <?php echo $faq->title(); ?></h3>

        <div class="accordion__content">
            <?php echo $faq->answer(); ?>
        </div>
    </div>
<?php
    $row_index++;
endforeach; ?>