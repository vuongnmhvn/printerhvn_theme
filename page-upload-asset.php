<?php
/**
 * Template Name: Upload Asset
 * Template for uploading new assets (Pinterest Create Pin style)
 *
 * @package PinterHVN_Theme
 * @since 1.0.0
 */

// Redirect if not logged in
if ( ! is_user_logged_in() ) {
	wp_redirect( wp_login_url( get_permalink() ) );
	exit;
}

// Check permission
if ( ! current_user_can( 'edit_posts' ) ) {
	wp_die( __( 'You do not have permission to upload assets.', 'pinterhvn-theme' ) );
}

get_header();
?>

<main id="primary" class="site-main upload-page">
	<div class="upload-container">

		<!-- Header -->
		<div class="upload-header">
			<h1 class="upload-title"><?php _e( 'Đăng tài nguyên mới', 'pinterhvn-theme' ); ?></h1>
			<div class="header-spacer"></div>
		</div>

		<!-- Upload Form -->
		<form id="pinterhvn-upload-form" class="upload-form" enctype="multipart/form-data">
			<?php wp_nonce_field( 'pinterhvn_upload_asset', 'pinterhvn_upload_nonce' ); ?>

			<div class="upload-grid">
				
				<!-- Left Column - Media Upload -->
				<div class="upload-media-section">
					<!-- File input is moved outside the drop zone to prevent event bubbling loops -->
					<input 
						type="file" 
						id="asset_thumbnail" 
						name="asset_thumbnail" 
						accept="image/*,video/mp4,.gif"
						style="display: none;"
					>
					
					<!-- File Drop Zone -->
					<label for="asset_thumbnail" class="file-drop-zone" id="file-drop-zone">
						<!-- 
							We use a label to trigger the file input. 
							The input itself is hidden and placed outside this label 
							to avoid event bubbling issues.
						-->
						<div class="drop-zone-content" id="drop-zone-content" style="pointer-events: none;">
							<div class="upload-icon">
								<svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor">
									<path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
									<polyline points="17 8 12 3 7 8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
									<line x1="12" y1="3" x2="12" y2="15" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
								</svg>
							</div>
							<p class="drop-zone-text"><?php _e( 'Choose a file or drag and drop it here', 'pinterhvn-theme' ); ?></p>
							<p class="drop-zone-hint">
								<?php _e( 'We recommend using high quality .jpg files less than 20 MB or .mp4 files less than 200 MB.', 'pinterhvn-theme' ); ?>
							</p>
							<button type="button" class="btn btn-choose-file" id="choose-file-btn">
								<?php _e( 'Choose file', 'pinterhvn-theme' ); ?>
							</button>
						</div>

						<!-- Preview Area -->
						<div class="preview-area" id="preview-area" style="display: none;">
							<div class="preview-wrapper">
								<img id="preview-image" style="display: none;" alt="Preview">
								<video id="preview-video" style="display: none;" autoplay loop muted playsinline></video>
							</div>
							<button type="button" class="btn-change-file" id="change-file-btn">
								<?php _e( 'Change', 'pinterhvn-theme' ); ?>
							</button>
						</div>
					</label>

					<!-- Save from URL -->
					<div class="url-upload-section">
						<button type="button" class="btn-url-upload" id="toggle-url-upload">
							<?php _e( 'Save from URL', 'pinterhvn-theme' ); ?>
						</button>
					</div>

				</div>

				<!-- Right Column - Asset Details -->
				<div class="upload-details-section">

					<!-- Title -->
					<div class="form-group">
						<label for="asset_title" class="form-label">
							<?php _e( 'Title', 'pinterhvn-theme' ); ?>
						</label>
						<input 
							type="text" 
							id="asset_title" 
							name="asset_title" 
							class="form-input" 
							placeholder="<?php esc_attr_e( 'Add a title', 'pinterhvn-theme' ); ?>"
							required
						>
					</div>

					<!-- Description -->
					<div class="form-group">
						<label for="asset_description" class="form-label">
							<?php _e( 'Description', 'pinterhvn-theme' ); ?>
						</label>
						<textarea 
							id="asset_description" 
							name="asset_description" 
							class="form-textarea" 
							rows="5"
							placeholder="<?php esc_attr_e( 'Add a detailed description', 'pinterhvn-theme' ); ?>"
						></textarea>
					</div>

					<!-- Asset Link -->
					<div class="form-group">
						<label for="asset_link" class="form-label">
							<?php _e( 'Link', 'pinterhvn-theme' ); ?>
						</label>
						<input 
							type="url" 
							id="asset_link" 
							name="asset_link" 
							class="form-input" 
							placeholder="<?php esc_attr_e( 'Add a link', 'pinterhvn-theme' ); ?>"
							required
						>
					</div>

					<!-- Category -->
					<div class="form-group">
						<label for="asset_category" class="form-label">
							<?php _e( 'Category', 'pinterhvn-theme' ); ?>
						</label>
						<select id="asset_category" name="asset_category" class="form-select">
							<option value=""><?php _e( 'Choose a board', 'pinterhvn-theme' ); ?></option>
							<?php
							$categories = get_terms( array(
								'taxonomy'   => 'asset_category',
								'hide_empty' => false,
							) );
							
							if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) {
								foreach ( $categories as $category ) {
									echo '<option value="' . esc_attr( $category->term_id ) . '">' . 
									     esc_html( $category->name ) . '</option>';
								}
							}
							?>
						</select>
					</div>

					<!-- Tags -->
					<div class="form-group">
						<label for="asset_tags" class="form-label">
							<?php _e( 'Tagged topics (0)', 'pinterhvn-theme' ); ?>
						</label>
						<input 
							type="text" 
							id="asset_tags" 
							name="asset_tags" 
							class="form-input tag-input" 
							placeholder="<?php esc_attr_e( 'Search for a tag', 'pinterhvn-theme' ); ?>"
						>
						<div class="tags-selected" id="tags-selected"></div>
					</div>

					<!-- Collections (Optional) -->
					<div class="form-group">
						<button type="button" class="btn-more-options" id="toggle-more-options">
							<?php _e( 'More options', 'pinterhvn-theme' ); ?>
							<svg width="16" height="16" viewBox="0 0 16 16" fill="none" stroke="currentColor" class="chevron">
								<path d="M4 6l4 4 4-4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>
						</button>

						<div class="more-options-content" id="more-options-content" style="display: none;">
							<label class="form-label"><?php _e( 'Collections', 'pinterhvn-theme' ); ?></label>
							<select id="asset_collections" name="asset_collections[]" class="form-select" multiple>
								<?php
								$collections = pinterhvn_get_user_collections( get_current_user_id() );
								
								if ( ! empty( $collections ) ) {
									foreach ( $collections as $collection ) {
										echo '<option value="' . esc_attr( $collection->term_id ) . '">' . 
										     esc_html( $collection->name ) . ' (' . $collection->count . ')</option>';
									}
								}
								?>
							</select>
							<p class="field-hint"><?php _e( 'Hold Ctrl (Cmd on Mac) to select multiple', 'pinterhvn-theme' ); ?></p>
						</div>
					</div>

					<!-- Submit Button -->
					<div class="form-actions">
						<button type="submit" class="btn btn-publish" id="publish-asset-btn">
							<?php _e( 'Publish', 'pinterhvn-theme' ); ?>
						</button>
					</div>

					<!-- Messages -->
					<div id="upload-message" class="upload-message" style="display: none;"></div>

				</div>

			</div>
		</form>

	</div>
</main>

<style>
/* Upload Page Styles */
.upload-page {
	padding: 120px 0px 120px 0px;
	min-height: 100vh;
	background: #f8f9fa;
}

.upload-container {
	max-width: 100%;
	height: 100%;
}

/* Header */
.upload-header {
	padding: 16px 24px;
	text-align: center;
}

.btn-close-upload {
	width: 40px;
	height: 40px;
	display: flex;
	align-items: center;
	justify-content: center;
	border-radius: 50%;
	background: transparent;
	border: none;
	cursor: pointer;
	transition: all 0.2s ease;
}

.btn-close-upload:hover {
	background: #f1f5f9;
}

.upload-title {
	font-size: 20px;
	font-weight: 700;
	margin: 0;
	color: #0f172a;
}

.header-spacer {
	width: 40px;
}

/* Upload Grid */
.upload-grid {
	display: grid;
	grid-template-columns: 450px 1fr;
	gap: 40px;
	max-width: 1200px;
	margin: 0 auto;
	padding: 40px 24px;
}

/* Media Section */
.upload-media-section {
	position: sticky;
	top: 140px;
	height: fit-content;
}

.file-drop-zone {
	background: #f1f5f9;
	border: 2px dashed #cbd5e1;
	border-radius: 16px;
	padding: 40px 24px;
	text-align: center;
	transition: all 0.3s ease;
	cursor: pointer;
	min-height: 500px;
	display: flex;
	flex-direction: column;
	align-items: center;
	justify-content: center;
}

.file-drop-zone.drag-over {
	background: #e0f2fe;
	border-color: #3b82f6;
	transform: scale(1.02);
}

.drop-zone-content {
	display: flex;
	flex-direction: column;
	align-items: center;
	gap: 16px;
}

.upload-icon {
	width: 48px;
	height: 48px;
	display: flex;
	align-items: center;
	justify-content: center;
	background: #ffffff;
	border-radius: 50%;
	color: #64748b;
}

.drop-zone-text {
	font-size: 16px;
	font-weight: 600;
	color: #0f172a;
	margin: 0;
}

.drop-zone-hint {
	font-size: 12px;
	color: #64748b;
	margin: 0;
	max-width: 300px;
	line-height: 1.4;
}

.btn-choose-file {
	background: #e2e8f0;
	color: #0f172a;
	padding: 12px 24px;
	border: none;
	border-radius: 24px;
	font-weight: 600;
	font-size: 15px;
	cursor: pointer;
	transition: all 0.2s ease;
	margin-top: 8px;
}

.btn-choose-file:hover {
	background: #cbd5e1;
}

/* Preview Area */
.preview-area {
	width: 100%;
	height: 100%;
	display: flex;
	flex-direction: column;
	gap: 16px;
}

.preview-wrapper {
	flex: 1;
	border-radius: 12px;
	overflow: hidden;
	background: #000000;
	display: flex;
	align-items: center;
	justify-content: center;
	min-height: 400px;
	position: relative;
}

.preview-wrapper img,
.preview-wrapper video {
	max-width: 100%;
	max-height: 600px;
	object-fit: contain;
	display: block;
}

.preview-wrapper video {
	width: 100%;
	height: auto;
}

.btn-change-file {
	background: #e2e8f0;
	color: #0f172a;
	padding: 10px 20px;
	border: none;
	border-radius: 20px;
	font-weight: 600;
	font-size: 14px;
	cursor: pointer;
	transition: all 0.2s ease;
	align-self: center;
}

.btn-change-file:hover {
	background: #cbd5e1;
}

/* URL Upload */
.url-upload-section {
	margin-top: 16px;
	text-align: center;
}

.btn-url-upload {
	background: transparent;
	color: #64748b;
	border: none;
	font-size: 14px;
	font-weight: 600;
	cursor: pointer;
	padding: 8px 16px;
	border-radius: 20px;
	transition: all 0.2s ease;
}

.btn-url-upload:hover {
	background: #f1f5f9;
	color: #1e293b;
}

/* Details Section */
.upload-details-section {
	background: #ffffff;
	padding: 32px;
	border-radius: 16px;
	box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.form-group {
	margin-bottom: 24px;
}

.form-label {
	display: block;
	font-size: 13px;
	font-weight: 600;
	color: #0f172a;
	margin-bottom: 8px;
}

.form-input,
.form-textarea,
.form-select {
	width: 100%;
	padding: 12px 16px;
	font-size: 16px;
	border: 2px solid #cbd5e1;
	border-radius: 12px;
	background: #ffffff;
	color: #0f172a;
	transition: all 0.2s ease;
	font-family: inherit;
}

.form-input:focus,
.form-textarea:focus,
.form-select:focus {
	outline: none;
	border-color: #3b82f6;
	box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
}

.form-textarea {
	resize: vertical;
	min-height: 120px;
}

.form-select {
	cursor: pointer;
	appearance: none;
	background-image: url("data:image/svg+xml,%3Csvg width='12' height='12' viewBox='0 0 12 12' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M2 4l4 4 4-4' stroke='%2364748b' stroke-width='2' stroke-linecap='round'/%3E%3C/svg%3E");
	background-repeat: no-repeat;
	background-position: right 16px center;
	padding-right: 40px;
}

/* Tags */
.tag-input {
	/* Additional styles if needed */
}

.tags-selected {
	display: flex;
	flex-wrap: wrap;
	gap: 8px;
	margin-top: 12px;
}

.tag-badge {
	background: #e2e8f0;
	color: #1e293b;
	padding: 6px 12px;
	border-radius: 16px;
	font-size: 13px;
	font-weight: 500;
	display: inline-flex;
	align-items: center;
	gap: 6px;
}

.tag-remove {
	cursor: pointer;
	width: 16px;
	height: 16px;
	display: flex;
	align-items: center;
	justify-content: center;
	border-radius: 50%;
	background: #cbd5e1;
	color: #1e293b;
	font-size: 12px;
	transition: background 0.2s ease;
}

.tag-remove:hover {
	background: #94a3b8;
	color: #ffffff;
}

/* More Options */
.btn-more-options {
	background: transparent;
	border: none;
	color: #64748b;
	font-size: 14px;
	font-weight: 600;
	cursor: pointer;
	padding: 8px 0;
	display: flex;
	align-items: center;
	gap: 8px;
	transition: color 0.2s ease;
}

.btn-more-options:hover {
	color: #1e293b;
}

.btn-more-options .chevron {
	transition: transform 0.2s ease;
}

.btn-more-options.active .chevron {
	transform: rotate(180deg);
}

.more-options-content {
	margin-top: 16px;
	padding-top: 16px;
	border-top: 1px solid #e2e8f0;
}

.field-hint {
	font-size: 12px;
	color: #64748b;
	margin-top: 8px;
}

/* Form Actions */
.form-actions {
	margin-top: 32px;
	padding-top: 24px;
	border-top: 1px solid #e2e8f0;
}

.btn-publish {
	width: 100%;
	background: #e60023;
	color: #ffffff;
	padding: 14px 24px;
	border: none;
	border-radius: 24px;
	font-weight: 700;
	font-size: 16px;
	cursor: pointer;
	transition: all 0.2s ease;
}

.btn-publish:hover {
	background: #ad081b;
	transform: translateY(-2px);
	box-shadow: 0 4px 12px rgba(230, 0, 35, 0.3);
}

.btn-publish:disabled {
	background: #cbd5e1;
	cursor: not-allowed;
	transform: none;
}

/* Upload Message */
.upload-message {
	padding: 12px 16px;
	border-radius: 12px;
	font-size: 14px;
	margin-top: 16px;
}

.upload-message.success {
	background: #d1fae5;
	color: #065f46;
	border: 1px solid #6ee7b7;
}

.upload-message.error {
	background: #fee2e2;
	color: #991b1b;
	border: 1px solid #fca5a5;
}

/* Loading State */
.uploading .file-drop-zone {
	opacity: 0.6;
	pointer-events: none;
}

/* Responsive */
@media (max-width: 1024px) {
	.upload-grid {
		grid-template-columns: 1fr;
		gap: 24px;
	}

	.upload-media-section {
		position: static;
	}
}

@media (max-width: 768px) {
	.upload-header {
		padding: 12px 16px;
	}

	.upload-title {
		font-size: 18px;
	}

	.upload-grid {
		padding: 24px 16px;
	}

	.file-drop-zone {
		min-height: 300px;
		padding: 24px 16px;
	}

	.upload-details-section {
		padding: 24px 16px;
	}
}
</style>

<script>
jQuery(document).ready(function($) {
	var selectedFile = null;
	var selectedTags = [];

	// File input change
	$('#asset_thumbnail').on('change', function(e) {
		var file = e.target.files[0];
		if (file) {
			handleFileSelect(file);
		}
	});

	// Drag and drop
	var dropZone = $('#file-drop-zone');

	dropZone.on('dragover', function(e) {
		e.preventDefault();
		e.stopPropagation();
		$(this).addClass('drag-over');
	});

	dropZone.on('dragleave', function(e) {
		e.preventDefault();
		e.stopPropagation();
		$(this).removeClass('drag-over');
	});

	dropZone.on('drop', function(e) {
		e.preventDefault();
		e.stopPropagation();
		$(this).removeClass('drag-over');

		var files = e.originalEvent.dataTransfer ? e.originalEvent.dataTransfer.files : [];
        if (files.length > 0) {
            // Set files to input element
            var input = document.getElementById('asset_thumbnail');
            if (input) {
                input.files = files;
                // Trigger change event manually as it's not always fired programmatically
                var event = new Event('change', { bubbles: true });
                input.dispatchEvent(event);
            }
        }
	});

	// When clicking the preview area, prevent the label from triggering the file input.
	// The "Change" button inside will handle its own click.
	$('#preview-area').on('click', function(e) {
		e.preventDefault();
	});

	$('#change-file-btn').on('click', function() { $('#asset_thumbnail').trigger('click'); });

	// Handle file select
	function handleFileSelect(file) {
		selectedFile = file;

		// Validate file
		var allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'video/mp4'];
		if (!allowedTypes.includes(file.type)) {
			alert('<?php _e( 'Please select a valid file (JPG, PNG, GIF, or MP4)', 'pinterhvn-theme' ); ?>');
			return;
		}

		// Validate size
		var maxSize = 200 * 1024 * 1024; // 200MB
		if (file.size > maxSize) {
			alert('<?php _e( 'File is too large. Maximum size is 200MB', 'pinterhvn-theme' ); ?>');
			return;
		}

		// Show preview
		$('#drop-zone-content').hide();
		$('#preview-area').show();

		var reader = new FileReader();
		reader.onload = function(e) {
			if (file.type.startsWith('video/')) {
				$('#preview-image').hide();
				$('#preview-video').show();
				$('#preview-video').attr('src', e.target.result);
				// Ensure video plays
				var videoElement = document.getElementById('preview-video');
				videoElement.load();
				videoElement.play();
			} else {
				$('#preview-video').hide();
				$('#preview-image').show();
				$('#preview-image').attr('src', e.target.result);
			}
		};
		reader.readAsDataURL(file);

		// Enable publish button
		$('#publish-asset-btn').prop('disabled', false);
	}

	// Tags handling
	var tagTimeout;
	$('#asset_tags').on('keyup', function(e) {
		if (e.key === 'Enter' || e.key === ',') {
			e.preventDefault();
			var tag = $(this).val().trim().replace(/,/g, '');
			if (tag && !selectedTags.includes(tag)) {
				selectedTags.push(tag);
				addTagBadge(tag);
				$(this).val('');
				updateTagLabel();
			}
		}
	});

	function addTagBadge(tag) {
		var badge = $('<div class="tag-badge">' +
			'<span>' + tag + '</span>' +
			'<span class="tag-remove" data-tag="' + tag + '">×</span>' +
			'</div>');
		$('#tags-selected').append(badge);
	}

	function updateTagLabel() {
		var label = '<?php _e( 'Tagged topics', 'pinterhvn-theme' ); ?> (' + selectedTags.length + ')';
		$('label[for="asset_tags"]').text(label);
	}

	// Remove tag
	$(document).on('click', '.tag-remove', function() {
		var tag = $(this).data('tag');
		selectedTags = selectedTags.filter(t => t !== tag);
		$(this).closest('.tag-badge').remove();
		updateTagLabel();
	});

	// More options toggle
	$('#toggle-more-options').on('click', function() {
		$(this).toggleClass('active');
		$('#more-options-content').slideToggle();
	});

	// Form submission
	$('#pinterhvn-upload-form').on('submit', function(e) {
		e.preventDefault();

		if (!selectedFile) {
			alert('<?php _e( 'Please select a file', 'pinterhvn-theme' ); ?>');
			return;
		}

		var formData = new FormData(this);
		formData.append('action', 'pinterhvn_upload_asset');
		formData.append('asset_tags', selectedTags.join(','));

		// Disable button
		$('#publish-asset-btn').prop('disabled', true).text('<?php _e( 'Publishing...', 'pinterhvn-theme' ); ?>');
		$('.upload-page').addClass('uploading');

		$.ajax({
			url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
			type: 'POST',
			data: formData,
			processData: false,
			contentType: false,
			success: function(response) {
				if (response.success) {
					$('#upload-message')
						.removeClass('error')
						.addClass('success')
						.html('<strong><?php _e( 'Success!', 'pinterhvn-theme' ); ?></strong> ' + response.data.message)
						.slideDown();

					// Redirect after 2 seconds
					setTimeout(function() {
						if (response.data.view_url) {
							window.location.href = response.data.view_url;
						} else {
							window.location.href = '<?php echo home_url( '/' ); ?>';
						}
					}, 2000);
				} else {
					$('#upload-message')
						.removeClass('success')
						.addClass('error')
						.html('<strong><?php _e( 'Error!', 'pinterhvn-theme' ); ?></strong> ' + response.data.message)
						.slideDown();
					
					$('#publish-asset-btn').prop('disabled', false).text('<?php _e( 'Publish', 'pinterhvn-theme' ); ?>');
					$('.upload-page').removeClass('uploading');
				}
			},
			error: function(xhr, status, error) {
				$('#upload-message')
					.removeClass('success')
					.addClass('error')
					.html('<strong><?php _e( 'Error!', 'pinterhvn-theme' ); ?></strong> <?php _e( 'Upload failed. Please try again.', 'pinterhvn-theme' ); ?>')
					.slideDown();
				
				$('#publish-asset-btn').prop('disabled', false).text('<?php _e( 'Publish', 'pinterhvn-theme' ); ?>');
				$('.upload-page').removeClass('uploading');
			}
		});
	});

	// Disable publish initially
	$('#publish-asset-btn').prop('disabled', true);
});
</script>

<?php
get_footer();
