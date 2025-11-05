/**
 * PinterHVN Theme - Save to Collection
 *
 * @package PinterHVN_Theme
 * @since 1.0.0
 */

(function($) {
	'use strict';

	// Save to collection button click
	$(document).on('click', '.save-btn', function(e) {
		e.preventDefault();
		e.stopPropagation();

		var assetId = $(this).data('asset-id');
		openSaveToCollectionModal(assetId);
	});

	// Open save modal
	function openSaveToCollectionModal(assetId) {
		$('#save-asset-id').val(assetId);

		// Load user collections
		$.ajax({
			url: pinterhvnTheme.ajax_url,
			type: 'POST',
			data: {
				action: 'pinterhvn_get_user_collections',
				nonce: pinterhvnTheme.nonce
			},
			success: function(response) {
				if (response.success && response.data.collections) {
					var html = '';
					
					if (response.data.collections.length === 0) {
						html = '<p style="color: #64748b; font-size: 14px;">You don\'t have any collections yet. Create one below!</p>';
					} else {
						response.data.collections.forEach(function(collection) {
							html += '<label style="display: block; margin-bottom: 12px; cursor: pointer;">';
							html += '<input type="checkbox" name="collections[]" value="' + collection.term_id + '" style="margin-right: 8px;">';
							html += '<span>' + collection.name + ' (' + collection.count + ')</span>';
							html += '</label>';
						});
					}

					$('#collections-list').html(html);
				}
			},
			error: function() {
				$('#collections-list').html('<p style="color: #ef4444;">Failed to load collections.</p>');
			}
		});

		$('#save-to-collection-modal').addClass('active');
	}

	// Save to collection button
	$('#save-to-collection-btn').on('click', function(e) {
		e.preventDefault();
		handleSaveToCollection();
	});

	// Handle save
	function handleSaveToCollection() {
		var assetId = $('#save-asset-id').val();
		var selectedCollections = [];
		var newCollectionName = $('#new-collection-name').val().trim();

		$('input[name="collections[]"]:checked').each(function() {
			selectedCollections.push($(this).val());
		});

		if (selectedCollections.length === 0 && !newCollectionName) {
			if (window.pinterhvnShowNotification) {
				window.pinterhvnShowNotification('Please select a collection or create one', 'error');
			}
			return;
		}

		$('#save-to-collection-btn').prop('disabled', true).text('Saving...');

		if (newCollectionName) {
			// Create collection first
			$.ajax({
				url: pinterhvnTheme.ajax_url,
				type: 'POST',
				data: {
					action: 'pinterhvn_create_collection',
					collection_name: newCollectionName,
					nonce: pinterhvnTheme.nonce
				},
				success: function(response) {
					if (response.success && response.data.collection_id) {
						selectedCollections.push(response.data.collection_id);
						saveAsset(assetId, selectedCollections);
					} else {
						if (window.pinterhvnShowNotification) {
							window.pinterhvnShowNotification(response.data.message || 'Failed to create collection', 'error');
						}
						$('#save-to-collection-btn').prop('disabled', false).text('Save');
					}
				},
				error: function() {
					if (window.pinterhvnShowNotification) {
						window.pinterhvnShowNotification('Failed to create collection', 'error');
					}
					$('#save-to-collection-btn').prop('disabled', false).text('Save');
				}
			});
		} else {
			saveAsset(assetId, selectedCollections);
		}
	}

	// Save asset to collections
	function saveAsset(assetId, collectionIds) {
		$.ajax({
			url: pinterhvnTheme.ajax_url,
			type: 'POST',
			data: {
				action: 'pinterhvn_save_to_collection',
				asset_id: assetId,
				collection_ids: collectionIds,
				nonce: pinterhvnTheme.nonce
			},
			success: function(response) {
				if (response.success) {
					if (window.pinterhvnShowNotification) {
						window.pinterhvnShowNotification(response.data.message || 'Saved to collection!', 'success');
					}
					$('#save-to-collection-modal').removeClass('active');
					$('#new-collection-name').val('');
					$('input[name="collections[]"]').prop('checked', false);
				} else {
					if (window.pinterhvnShowNotification) {
						window.pinterhvnShowNotification(response.data.message || 'Failed to save', 'error');
					}
				}
			},
			error: function() {
				if (window.pinterhvnShowNotification) {
					window.pinterhvnShowNotification('Failed to save to collection', 'error');
				}
			},
			complete: function() {
				$('#save-to-collection-btn').prop('disabled', false).text('Save');
			}
		});
	}

})(jQuery);
