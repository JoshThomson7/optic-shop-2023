<?php
/**
 * Stats
 */
$heading = get_sub_field('heading');
$caption = get_sub_field('caption');
$stats_type = get_sub_field('stats_type');
$small_print = get_sub_field('small_print');

$rates = array();
if($stats_type === 'client') {
	$client_id = get_sub_field('client');
	$rate = new Ins_Rate($client_id);
	$rates = $rate->get_rates();
	
	if($small_print) {
		$small_print = str_replace('%rates-date%', $rate->last_modified('j M Y'), $small_print);
	}
} else {
	$rates = get_sub_field('stats') ?? array();
}
?>
<div class="fc-stats">
	<div class="fc-stats--heading">
		<figure><?php echo file_get_contents(FL1_PATH.'/img/squares.svg'); ?></figure>
		<div>
			<?php if($heading): ?><h3><?php echo $heading; ?></h3><?php endif; ?>
			<?php if($caption): ?><p><?php echo $caption; ?></p><?php endif; ?>
		</div>
	</div>

	<?php if($rates): ?>
		<div class="fc-stats--values">
			<?php foreach($rates as $rate): ?>
				<article>
					<small><?php echo $rate['label']; ?></small>
					<p><?php echo $rate['value']; ?><?php echo $rate['symbol']; ?></p>
				</article>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>

	<?php if($small_print): ?>
		<small class="fc-stats-print"><?php echo $small_print; ?></small>
	<?php endif; ?>
</div>