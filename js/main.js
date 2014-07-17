jQuery(document).ready(function() {

	tx_simpleslider_pi1_conf['items'] = new Array();
	tx_simpleslider_pi1_conf['focus'] = true;

	jQuery('.tx-simpleslider-pi1-slider').each(function(count) {

		jQuery(this).attr('id', 'tx-simpleslider-pi1-slider-' + count);
		jQuery(this).find('.tx-simpleslider-pi1-switcher').attr('id', 'tx-simpleslider-pi1-switcher-' + count);

		tx_simpleslider_pi1_conf['items'][count] = new Array();

		var items = jQuery(this).find('.tx-simpleslider-pi1-item');

		if (items.length > 1) {

			tx_simpleslider_pi1_conf['items'][count]['currentItem'] = 1;
			tx_simpleslider_pi1_conf['items'][count]['totalItems'] = items.length;

			if (tx_simpleslider_pi1_conf['animation'] == 'slide') {

				jQuery(this).find('DIV.tx-simpleslider-pi1-item').css({
					'float': 'left'
				});

				tx_simpleslider_pi1_conf['items'][count]['firstItemWidth'] = jQuery(this).find('.tx-simpleslider-pi1-item:eq(0)').width();
				jQuery(this).css({
					'width': tx_simpleslider_pi1_conf['items'][count]['firstItemWidth'],
					'overflow': 'hidden'
				});

				var sliderWidth = 1;
				jQuery(this).find('.tx-simpleslider-pi1-item').each(function() {
					sliderWidth += jQuery(this).width();
				});
				jQuery(this).find('.tx-simpleslider-pi1-slides').css({
					'width': sliderWidth
				});

			}

			if (tx_simpleslider_pi1_conf['animation'] == 'fade') {

				jQuery(this).find('.tx-simpleslider-pi1-item').css({
					'position': 'absolute',
					'opacity': 0
				});

				jQuery(this).find('.tx-simpleslider-pi1-item:eq(0)').css({'opacity': 1});

			}

			tx_simpleslider_pi1_conf['items'][count]['interval'] = setInterval(function() { tx_simpleslider_pi1_slide(count); }, tx_simpleslider_pi1_conf['slidePause']);

			jQuery('#tx-simpleslider-pi1-switcher-' + count).append('<ul />');
			var switcherContent = '<ul>';
			for (var i=0; i<items.length; i++) {
				if (i == 0)
					switcherContent += '<li class="active"><a href="javascript:tx_simpleslider_pi1_switch(' + count + ', ' + i + ');"></a></li>';
				else
					switcherContent += '<li><a href="javascript:tx_simpleslider_pi1_switch(' + count + ', ' + i + ');"></a></li>';
			}
			switcherContent += '</ul>';
			jQuery('#tx-simpleslider-pi1-switcher-' + count).html(switcherContent);

		}

	});

});

function tx_simpleslider_pi1_slide(slider) {

	if (tx_simpleslider_pi1_conf['focus']) {

		if (tx_simpleslider_pi1_conf['items'][slider]['currentItem'] == tx_simpleslider_pi1_conf['items'][slider]['totalItems'])
			tx_simpleslider_pi1_conf['items'][slider]['currentItem'] = 0;

		if (tx_simpleslider_pi1_conf['animation'] == 'slide') {

			jQuery('#tx-simpleslider-pi1-slider-' + slider).find('.tx-simpleslider-pi1-slides').animate({
				'margin-left': (tx_simpleslider_pi1_conf['items'][slider]['firstItemWidth'] * tx_simpleslider_pi1_conf['items'][slider]['currentItem']) * -1
			}, tx_simpleslider_pi1_conf['animationSpeed']);

		}

		if (tx_simpleslider_pi1_conf['animation'] == 'fade') {

			if (tx_simpleslider_pi1_conf['items'][slider]['currentItem'] == 0)
				jQuery('#tx-simpleslider-pi1-slider-' + slider + ' .tx-simpleslider-pi1-item:gt(0)').animate({
					'opacity': 0
				}, tx_simpleslider_pi1_conf['animationSpeed']);
			else
				jQuery('#tx-simpleslider-pi1-slider-' + slider + ' .tx-simpleslider-pi1-item:eq(' + tx_simpleslider_pi1_conf['items'][slider]['currentItem'] + ')').animate({
					'opacity': 1
				}, tx_simpleslider_pi1_conf['animationSpeed']);

		}

		jQuery('#tx-simpleslider-pi1-switcher-' + slider + ' UL LI.active').removeClass('active');
		jQuery('#tx-simpleslider-pi1-switcher-' + slider + ' UL LI:eq(' + tx_simpleslider_pi1_conf['items'][slider]['currentItem'] + ')').addClass('active');

		tx_simpleslider_pi1_conf['items'][slider]['currentItem']++;

	}

}

function tx_simpleslider_pi1_switch(slider, slideNum) {

	clearInterval(tx_simpleslider_pi1_conf['items'][slider]['interval']);
	jQuery('#tx-simpleslider-pi1-switcher-' + slider + ' UL LI.active').removeClass('active');
	jQuery('#tx-simpleslider-pi1-switcher-' + slider + ' UL LI:eq(' + slideNum + ')').addClass('active');

	tx_simpleslider_pi1_conf['items'][slider]['currentItem'] = slideNum;

	if (tx_simpleslider_pi1_conf['animation'] == 'slide') {
		jQuery('#tx-simpleslider-pi1-slider-' + slider).find('.tx-simpleslider-pi1-slides').stop().animate({
			'margin-left': (tx_simpleslider_pi1_conf['items'][slider]['firstItemWidth'] * tx_simpleslider_pi1_conf['items'][slider]['currentItem']) * -1
		}, tx_simpleslider_pi1_conf['animationSpeed']);
	}

	if (tx_simpleslider_pi1_conf['animation'] == 'fade') {

		if (slideNum == 0)
			jQuery('#tx-simpleslider-pi1-slider-' + slider + ' .tx-simpleslider-pi1-item:gt(0)').animate({
				'opacity': 0
			}, tx_simpleslider_pi1_conf['animationSpeed']);
		else {
			jQuery('#tx-simpleslider-pi1-slider-' + slider + ' .tx-simpleslider-pi1-item:eq(' + slideNum + ')').animate({
				'opacity': 1
			}, tx_simpleslider_pi1_conf['animationSpeed']);
			jQuery('#tx-simpleslider-pi1-slider-' + slider + ' .tx-simpleslider-pi1-item:gt(' + slideNum + ')').animate({
				'opacity': 0
			}, tx_simpleslider_pi1_conf['animationSpeed']);
		}

	}

	tx_simpleslider_pi1_conf['items'][slider]['interval'] = setInterval(function() { tx_simpleslider_pi1_slide(slider); }, tx_simpleslider_pi1_conf['slidePause']);

}

jQuery(window).focus(function() {
	tx_simpleslider_pi1_conf['focus'] = true;
});

jQuery(window).blur(function() {
	tx_simpleslider_pi1_conf['focus'] = false;
});