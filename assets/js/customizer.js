/**
 * PinterHVN Theme Customizer JS
 *
 * @package PinterHVN_Theme
 * @since 1.0.0
 */

(function($) {
	'use strict';

	// Site title
	wp.customize('blogname', function(value) {
		value.bind(function(newval) {
			$('.site-title a').text(newval);
		});
	});

	// Site description
	wp.customize('blogdescription', function(value) {
		value.bind(function(newval) {
			$('.site-description').text(newval);
		});
	});

	// Header text color
	wp.customize('header_textcolor', function(value) {
		value.bind(function(newval) {
			if ('blank' === newval) {
				$('.site-title, .site-description').css({
					'clip': 'rect(1px, 1px, 1px, 1px)',
					'position': 'absolute'
				});
			} else {
				$('.site-title, .site-description').css({
					'clip': 'auto',
					'position': 'relative'
				});
				$('.site-title a, .site-description').css({
					'color': newval
				});
			}
		});
	});

	// Primary color
	wp.customize('pinterhvn_primary_color', function(value) {
		value.bind(function(newval) {
			$(':root').css('--color-primary', newval);
		});
	});

	// Header background color
	wp.customize('pinterhvn_header_bg_color', function(value) {
		value.bind(function(newval) {
			$('.site-header').css('background-color', newval);
		});
	});

	// Footer background color
	wp.customize('pinterhvn_footer_bg_color', function(value) {
		value.bind(function(newval) {
			$('.site-footer').css('background-color', newval);
		});
	});

})(jQuery);
