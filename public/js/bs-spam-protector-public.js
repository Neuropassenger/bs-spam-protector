(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	$( window ).load(function () {
		$('form.wpcf7-form').append('<input type="hidden" value="'+ bs_vars.nonce +'" name="bs_hf_nonce">');
		$('form.wpcf7-form').append('<input type="hidden" value="'+ bs_vars.expiration +'" name="bs_hf_expiration">');
		$('form.wpcf7-form').append('<input type="hidden" value="" name="bs_hf_validation_key" class="bs_hf-validation-key">');

		let validationCodeSent = false;
		$('form.wpcf7-form input').on('focus', function() {
			getValidationKey(this);
		});

		$('form.wpcf7-form textarea').on('focus', function() {
			getValidationKey(this);
		});

		function getValidationKey(elemOnFocus) {
			if (validationCodeSent)
				return;

			$.ajax({
				type: 'POST',
				dataType: 'json',
				url: bs_vars.ajaxUrl,
				data: {
					action: 'bs_get_validation_key',
					nonce: bs_vars.nonce,
					expiration: bs_vars.expiration,
				},
				beforeSend: function () {

				},
				success: function (data) {
					$(elemOnFocus).closest('form.wpcf7-form').find('.bs_hf-validation-key').val(data.validationKey);
					validationCodeSent = true;
				},
				error: function (error) {
					console.log(error);
				}
			});
		}
	});

})( jQuery );
