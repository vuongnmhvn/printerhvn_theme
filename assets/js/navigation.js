/**
 * PinterHVN Theme - Navigation & Menu Toggles
 *
 * @package PinterHVN_Theme
 * @since 1.0.0
 */

(function($) {
	'use strict';

	$(document).ready(function() {
		
		// Settings dropdown toggle
		$('.nav-settings-trigger').on('click', function(e) {
			e.preventDefault();
			$('.nav-settings-dropdown').toggleClass('active');
		});

		// User mega menu toggle
		$('.user-avatar-trigger').on('click', function(e) {
			e.preventDefault();
			$(this).closest('.search-bar-user').toggleClass('active');
		});

		// Close dropdowns when clicking outside
		$(document).on('click', function(e) {
			// Close settings dropdown
			if (!$(e.target).closest('.nav-settings-trigger, .nav-settings-dropdown').length) {
				$('.nav-settings-dropdown').removeClass('active');
			}
			// Close user mega menu
			if (!$(e.target).closest('.search-bar-user').length) {
				$('.search-bar-user').removeClass('active');
			}
		});

		// Close on ESC key
		$(document).on('keydown', function(e) {
			if (e.key === 'Escape' || e.keyCode === 27) {
				$('.nav-settings-dropdown, .search-bar-user').removeClass('active');
			}
		});

		// Video hover play/pause for asset cards
		$(document).on('mouseenter', '.asset-card .asset-video', function() {
			this.play().catch(function(error) {
				// Autoplay prevented, ignore
			});
		});

		$(document).on('mouseleave', '.asset-card .asset-video', function() {
			this.pause();
			this.currentTime = 0;
		});

		// Intersection Observer for lazy video loading
		if ('IntersectionObserver' in window) {
			var videoObserver = new IntersectionObserver(function(entries) {
				entries.forEach(function(entry) {
					if (entry.isIntersecting) {
						var video = entry.target;
						if (video.readyState === 0) {
							video.load();
						}
					}
				});
			}, {
				rootMargin: '50px'
			});

			$('.asset-video').each(function() {
				videoObserver.observe(this);
			});
		}

	});

})(jQuery);
