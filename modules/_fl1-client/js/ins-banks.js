/**
 * Banks - JS
 * 
 * @version 1.0
 */

(function ($, root, undefined) {

	var skeletonCount = 20;

	$('#banks_filters').filterify({
		ajaxAction: 'ins_bank_filters',
		responseEl: '#banks_response',
		paginationSelector: '.ajax-pagination',
		setUrl: false,
		skeleton: {
			count: skeletonCount,
			markup: '<article class="skeleton one-fifth">' +
				'<div class="padder">' +
				'<figure></figure>' +
				'</div>' +
				'</article>'
		}
	});

	$(document).on('click', '.clear-filter', function (e) {
		e.preventDefault();
		$('input[name="bank_letter"]').prop('checked', false).removeAttr("checked");
	});

	$(document).on('click', '.bank-open', function (e) {
		e.preventDefault();
		$('body').addClass('no__scroll');
		$(this).closest('.bank').find('.bank-modal-overlay').addClass('open');
	});

	$(document).on('click', '.bank-close', function (e) {
		e.preventDefault();
		$('body').removeClass('no__scroll');
		$('.bank-modal-overlay').removeClass('open');
	});

})(jQuery, this);
