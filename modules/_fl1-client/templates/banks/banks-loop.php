<?php
if (!defined('ABSPATH')) exit;

if (!empty($banks)) :

	foreach ($banks as $bank) :
		$_bank = new Ins_Bank($bank->ID);
		$logo = $_bank->image(400, 400, false);
?>
		<article class="bank one-fifth">

			<div class="bank__wrapper">
				<figure class="bank__logo">
					<img src="<?php echo $logo['url']; ?>" />
				</figure>

				<div class="bank__actions">
					<a href="#" class="bank-open">Read bio <i class="fa-regular fa-arrow-right"></i></a>
				</div>

				<div class="bank-modal-overlay">
					<div class="bank-modal">
						<div class="bank-modal__header">
							<a href="#" class="bank-close"><i class="fal fa-times"></i></a>
						</div>
						<div class="bank-modal__content">
							<div class="flex-wrap">
								<div class="flex-column flex-column--one-third">
									<figure class="bank-modal__logo">
										<img src="<?php echo $logo['url']; ?>" />
									</figure>
								</div>
								<div class="flex-column flex-column--two-thirds">
									<div class="bank-modal__text">
										<h3><?php echo $_bank->name(); ?></h3>
										<?php echo $_bank->bio(); ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
		</article>
	<?php endforeach; ?>
<?php else : ?>
	<div class="not__found">
		<figure>
			<i class="fa-light fa-building-columns"></i>
		</figure>

		<h4>No banks found</h4>
		<p>We could not find any banks matching your criteria.</p>
	</div>
<?php endif; ?>