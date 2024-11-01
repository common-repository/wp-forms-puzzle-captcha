var captcha_width;
jQuery(document).ready(function(){
	captcha_width = jQuery(".wpfc-captcha").width();
	jQuery(".wpfc-slidercaptcha").closest('form').find('input[type="submit"]').attr("disabled", true);
	jQuery('.wpfc-captcha').sliderCaptcha({
		width: captcha_width,
		barText: jQuery(".wpfc-captcha").data('slider'),
		failedText: jQuery(".wpfc-captcha").data('tryagain'),
		onSuccess: function () {
			jQuery.ajax({
                url: wfpc_ajax.url,
				data: { action: 'wfpc_ajax_verify', form: jQuery('.wpfc-captcha').data("form") },
                type: 'POST',
                success: function (result) {
					jQuery(".wpfc-slidercaptcha").closest('form').find('input[type="submit"]').removeAttr("disabled");
					jQuery(".wpfc-slidercaptcha").closest('form').find('button[type="submit"]').removeAttr("disabled");
                    return true;
                }
            });
		}
	});
});