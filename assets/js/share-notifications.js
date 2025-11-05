/**
 * PinterHVN Theme - Share & Notification Functions
 *
 * @package PinterHVN_Theme
 * @since 1.0.0
 */

(function($) {
	'use strict';

	// Prevent multiple notifications
	var isNotifying = false;

	// Share button - Open modal with asset URL
	$(document).on('click', '.share-btn:not([data-platform])', function(e) {
		e.preventDefault();
		e.stopPropagation();
		
		var assetUrl = $(this).data('url');
		if (assetUrl) {
			$('#share-link-input').val(assetUrl);
			$('#share-modal').addClass('active');
		}
	});

	// Copy link button - FIXED
	$(document).on('click', '.share-btn[data-platform="copy"]', function(e) {
		e.preventDefault();
		e.stopPropagation(); // Important: prevent event bubbling
		
		// Prevent multiple clicks
		if (isNotifying) return;
		
		var url = $('#share-link-input').val();
		
		if (!url) {
			showNotification('No URL to copy', 'error');
			return;
		}
		
		// Set notifying flag
		isNotifying = true;

		// Modern Clipboard API
		if (navigator.clipboard && navigator.clipboard.writeText) {
			navigator.clipboard.writeText(url).then(function() {
				showNotification('Link copied to clipboard!', 'success');
				setTimeout(function() {
					$('#share-modal').removeClass('active');
					isNotifying = false;
				}, 1000);
			}).catch(function(err) {
				console.error('Clipboard API failed:', err);
				copyFallback();
			});
		} else {
			// Fallback for older browsers
			copyFallback();
		}

		function copyFallback() {
			var input = document.getElementById('share-link-input');
			if (!input) {
				isNotifying = false;
				return;
			}
			
			input.select();
			input.setSelectionRange(0, 99999);
			
			try {
				var successful = document.execCommand('copy');
				if (successful) {
					showNotification('Link copied to clipboard!', 'success');
					setTimeout(function() {
						$('#share-modal').removeClass('active');
						isNotifying = false;
					}, 1000);
				} else {
					showNotification('Failed to copy. Please copy manually.', 'error');
					isNotifying = false;
				}
			} catch (err) {
				console.error('Copy failed:', err);
				showNotification('Failed to copy. Please copy manually.', 'error');
				isNotifying = false;
			}
		}
	});

	// Modal close handlers
	$('.modal-close').on('click', function() {
		$(this).closest('.modal').removeClass('active');
	});

	$('.modal').on('click', function(e) {
		if ($(e.target).hasClass('modal')) {
			$(this).removeClass('active');
		}
	});

	// ESC key to close modals
	$(document).on('keydown', function(e) {
		if (e.key === 'Escape' || e.keyCode === 27) {
			$('.modal.active').removeClass('active');
		}
	});

	// Notification helper
	function showNotification(message, type) {
		// Remove any existing notifications first
		$('.pinterhvn-notification').remove();
		
		var $notification = $('<div>')
			.addClass('pinterhvn-notification ' + type)
			.text(message);
		
		var baseStyles = {
			position: 'fixed',
			top: '80px',
			right: '20px',
			padding: '12px 20px',
			borderRadius: '24px',
			boxShadow: '0 4px 12px rgba(0, 0, 0, 0.15)',
			zIndex: 10000,
			fontSize: '14px',
			fontWeight: 600,
			opacity: 0,
			transform: 'translateX(100%)',
			transition: 'all 0.3s ease'
		};

		if (type === 'success') {
			baseStyles.background = '#d1fae5';
			baseStyles.color = '#065f46';
			baseStyles.border = '1px solid #6ee7b7';
		} else {
			baseStyles.background = '#fee2e2';
			baseStyles.color = '#991b1b';
			baseStyles.border = '1px solid #fca5a5';
		}

		$notification.css(baseStyles);
		$('body').append($notification);
		
		// Trigger animation
		setTimeout(function() {
			$notification.css({
				opacity: 1,
				transform: 'translateX(0)'
			});
		}, 10);
		
		// Auto remove
		setTimeout(function() {
			$notification.css({
				opacity: 0,
				transform: 'translateX(100%)'
			});
			setTimeout(function() {
				$notification.remove();
			}, 300);
		}, 3000);
	}

	// Export for global use
	window.pinterhvnShowNotification = showNotification;

})(jQuery);
