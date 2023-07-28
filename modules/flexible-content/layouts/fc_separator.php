<?php
/**
 * Separator
 */
$type = get_sub_field('type');
?>
<div class="fc-separator <?php if($type === 'border') { echo 'fc-separator--border'; }; ?>">
    <?php if($type === 'waves'): ?>
        <img src="<?php echo FL1_URL.'/img/waves/wave-separator.svg'; ?>">
    <?php endif; ?>
</div>
