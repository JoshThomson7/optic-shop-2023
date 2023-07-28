<?php
/**
 * Banks
 */

$bank_letters = Ins_Banks::get_bank_letters();
?>

<div class="fc-banks">
	
	<form id="banks_filters">
		<input type="hidden" name="bank_search" />
		<input type="hidden" name="bank_letter" />

		<?php /*
			<article class="input">
				<input type="text" name="bank_search" placeholder="Search by name" />
				<i class="fa-light fa-search"></i>
			</article>

			<article class="alphabet">
				<?php
					foreach(range('A', 'Z') as $letter):
						$lower_letter = strtolower($letter);
						$no_banks = !in_array($letter, $bank_letters);
				?>
					<div class="<?php echo $no_banks ? 'no-banks' : ''; ?>">
						<input id="bank_letter_<?php echo $lower_letter; ?>" type="radio" name="bank_letter" value="<?php echo $lower_letter; ?>" />
						<label for="bank_letter_<?php echo $lower_letter; ?>"><?php echo $letter; ?></label>
					</div>
				<?php endforeach; ?>

				<div class="clear">
					<input id="clear_filter" type="radio" name="bank_letter" value="" />
					<label for="clear_filter" class="tooltip" title="Clear filters"><i class="fa-light fa-times"></i></label>
				</div>
			</article>
		*/ ?>
	</form>

	<div id="banks_response" class="has-deps" data-deps='{"js":["ins-banks"]}' data-deps-path="fl1c_ajax_object"></div>
</div>