<?php
/**
 * Template Name: My Profile
 * Template for user profile page
 *
 * @package PinterHVN_Theme
 * @since 1.0.0
 */

// Redirect if not logged in
if ( ! is_user_logged_in() ) {
	wp_redirect( wp_login_url( get_permalink() ) );
	exit;
}

$current_user = wp_get_current_user();

get_header();
?>

<main id="primary" class="site-main profile-page">
	<div class="container" style="max-width: 680px; margin: 0 auto;">

		<!-- Profile Header -->
		<div class="profile-header">
			<h1 class="profile-title"><?php _e( 'Edit profile', 'pinterhvn-theme' ); ?></h1>
			<p class="profile-subtitle">
				<?php _e( 'Keep your personal details private. Information you add here is visible to anyone who can view your profile.', 'pinterhvn-theme' ); ?>
			</p>
		</div>

		<!-- Profile Form -->
		<form id="pinterhvn-profile-form" class="profile-form" method="post" enctype="multipart/form-data">
			<?php wp_nonce_field( 'pinterhvn_update_profile', 'pinterhvn_profile_nonce' ); ?>

			<!-- Photo Section -->
			<div class="form-section">
				<label class="form-label"><?php _e( 'Photo', 'pinterhvn-theme' ); ?></label>
				<div class="photo-upload-wrapper">
					<div class="current-avatar">
						<?php echo get_avatar( $current_user->ID, 120 ); ?>
					</div>
					<button type="button" class="btn-change-photo" id="change-avatar-btn">
						<?php _e( 'Change', 'pinterhvn-theme' ); ?>
					</button>
					<input type="file" id="profile-avatar-upload" name="profile_avatar" accept="image/*" style="display: none;">
				</div>
			</div>

			<!-- First Name -->
			<div class="form-section">
				<label class="form-label" for="first_name"><?php _e( 'First name', 'pinterhvn-theme' ); ?></label>
				<input 
					type="text" 
					id="first_name" 
					name="first_name" 
					class="form-input" 
					value="<?php echo esc_attr( $current_user->first_name ); ?>"
					placeholder="<?php esc_attr_e( 'First name', 'pinterhvn-theme' ); ?>"
				>
			</div>

			<!-- Last Name -->
			<div class="form-section">
				<label class="form-label" for="last_name"><?php _e( 'Last name', 'pinterhvn-theme' ); ?></label>
				<input 
					type="text" 
					id="last_name" 
					name="last_name" 
					class="form-input" 
					value="<?php echo esc_attr( $current_user->last_name ); ?>"
					placeholder="<?php esc_attr_e( 'Last name', 'pinterhvn-theme' ); ?>"
				>
			</div>

			<!-- About / Bio -->
			<div class="form-section">
				<label class="form-label" for="user_bio"><?php _e( 'About', 'pinterhvn-theme' ); ?></label>
				<textarea 
					id="user_bio" 
					name="user_bio" 
					class="form-textarea" 
					rows="4"
					placeholder="<?php esc_attr_e( 'Tell your story', 'pinterhvn-theme' ); ?>"
				><?php echo esc_textarea( get_user_meta( $current_user->ID, 'description', true ) ); ?></textarea>
			</div>

			<!-- Website -->
			<div class="form-section">
				<label class="form-label" for="user_url"><?php _e( 'Website', 'pinterhvn-theme' ); ?></label>
				<input 
					type="url" 
					id="user_url" 
					name="user_url" 
					class="form-input" 
					value="<?php echo esc_url( $current_user->user_url ); ?>"
					placeholder="https://"
				>
				<p class="field-hint"><?php _e( 'Add a link to drive traffic to your site', 'pinterhvn-theme' ); ?></p>
			</div>

			<!-- Username (readonly) -->
			<div class="form-section">
				<label class="form-label" for="user_login"><?php _e( 'Username', 'pinterhvn-theme' ); ?></label>
				<input 
					type="text" 
					id="user_login" 
					name="user_login" 
					class="form-input" 
					value="<?php echo esc_attr( $current_user->user_login ); ?>"
					readonly
					disabled
				>
				<p class="field-hint">
					<?php 
					$profile_url = home_url( '/@' . $current_user->user_login );
					printf( 
						__( 'www.pinterhvn.local/@%s', 'pinterhvn-theme' ), 
						esc_html( $current_user->user_login ) 
					); 
					?>
				</p>
			</div>

			<!-- Messages -->
			<div id="profile-message" class="profile-message" style="display: none;"></div>

			<!-- Submit Buttons -->
			<div class="form-actions">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-secondary">
					<?php _e( 'Cancel', 'pinterhvn-theme' ); ?>
				</a>
				<button type="submit" class="btn btn-primary" id="save-profile-btn">
					<?php _e( 'Save', 'pinterhvn-theme' ); ?>
				</button>
			</div>

		</form>

		<!-- Divider -->
		<hr class="section-divider">

		<!-- Account Management Section -->
		<div class="account-management-section">
			<h2 class="section-title"><?php _e( 'Account management', 'pinterhvn-theme' ); ?></h2>
			<p class="section-subtitle">
				<?php _e( 'Make changes to your personal information or account type.', 'pinterhvn-theme' ); ?>
			</p>

			<!-- Your Account -->
			<div class="account-section">
				<h3 class="subsection-title"><?php _e( 'Your account', 'pinterhvn-theme' ); ?></h3>

				<!-- Email -->
				<div class="account-item">
					<div class="account-item-header">
						<div class="account-item-label">
							<?php _e( 'Email', 'pinterhvn-theme' ); ?>
							<span class="privacy-badge"><?php _e( '• Private', 'pinterhvn-theme' ); ?></span>
						</div>
					</div>
					<div class="account-item-value"><?php echo esc_html( $current_user->user_email ); ?></div>
				</div>

				<!-- Password -->
				<div class="account-item">
					<div class="account-item-header">
						<div class="account-item-label"><?php _e( 'Password', 'pinterhvn-theme' ); ?></div>
						<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>" class="btn-change">
							<?php _e( 'Change', 'pinterhvn-theme' ); ?>
						</a>
					</div>
				</div>
			</div>

		</div>

	</div>
</main>

<style>
/* Profile Page Styles */
.profile-page {
	padding: 120px 20px 80px 20px;
}

.profile-header {
	margin-bottom: 40px;
}

.profile-title {
	font-size: 36px;
	font-weight: 700;
	margin-bottom: 12px;
	color: #0f172a;
}

.profile-subtitle {
	font-size: 16px;
	color: #64748b;
	line-height: 1.5;
}

/* Form Sections */
.form-section {
	margin-bottom: 24px;
}

.form-label {
	display: block;
	font-size: 14px;
	font-weight: 600;
	color: #0f172a;
	margin-bottom: 8px;
}

.form-input,
.form-textarea {
	width: 100%;
	padding: 16px;
	font-size: 16px;
	border: 2px solid #cbd5e1;
	border-radius: 16px;
	background: #ffffff;
	color: #0f172a;
	transition: all 0.2s ease;
}

.form-input:focus,
.form-textarea:focus {
	outline: none;
	border-color: #3b82f6;
	box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
}

.form-input:disabled {
	background: #f8fafc;
	color: #94a3b8;
	cursor: not-allowed;
}

.form-textarea {
	resize: vertical;
	min-height: 100px;
	font-family: inherit;
}

.field-hint {
	font-size: 13px;
	color: #64748b;
	margin-top: 8px;
}

/* Photo Upload */
.photo-upload-wrapper {
	display: flex;
	align-items: center;
	gap: 16px;
	padding: 16px;
	border: 2px solid #cbd5e1;
	border-radius: 16px;
	background: #ffffff;
}

.current-avatar {
	width: 120px;
	height: 120px;
	border-radius: 50%;
	overflow: hidden;
	flex-shrink: 0;
}

.current-avatar img {
	width: 100%;
	height: 100%;
	object-fit: cover;
}

.btn-change-photo {
	background: #e2e8f0;
	color: #0f172a;
	padding: 12px 24px;
	border: none;
	border-radius: 24px;
	font-size: 15px;
	font-weight: 600;
	cursor: pointer;
	transition: all 0.2s ease;
}

.btn-change-photo:hover {
	background: #cbd5e1;
}

/* Form Actions */
.form-actions {
	display: flex;
	gap: 12px;
	margin-top: 32px;
	padding-top: 24px;
	border-top: 1px solid #e2e8f0;
}

.btn {
	padding: 12px 24px;
	font-size: 15px;
	font-weight: 600;
	border: none;
	border-radius: 24px;
	cursor: pointer;
	transition: all 0.2s ease;
	text-decoration: none;
	display: inline-block;
}

.btn-primary {
	background: #e60023;
	color: #ffffff;
}

.btn-primary:hover {
	background: #ad081b;
}

.btn-secondary {
	background: #e2e8f0;
	color: #0f172a;
}

.btn-secondary:hover {
	background: #cbd5e1;
}

/* Messages */
.profile-message {
	padding: 16px;
	border-radius: 12px;
	margin: 16px 0;
	font-size: 14px;
}

.profile-message.success {
	background: #d1fae5;
	color: #065f46;
	border: 1px solid #6ee7b7;
}

.profile-message.error {
	background: #fee2e2;
	color: #991b1b;
	border: 1px solid #fca5a5;
}

/* Section Divider */
.section-divider {
	margin: 48px 0;
	border: none;
	border-top: 1px solid #e2e8f0;
}

/* Account Management */
.account-management-section {
	margin-top: 48px;
}

.section-title {
	font-size: 28px;
	font-weight: 700;
	margin-bottom: 12px;
	color: #0f172a;
}

.section-subtitle {
	font-size: 16px;
	color: #64748b;
	margin-bottom: 32px;
	line-height: 1.5;
}

.subsection-title {
	font-size: 20px;
	font-weight: 700;
	margin-bottom: 24px;
	color: #0f172a;
}

.account-item {
	padding: 20px;
	border: 2px solid #cbd5e1;
	border-radius: 16px;
	margin-bottom: 16px;
	background: #ffffff;
}

.account-item-header {
	display: flex;
	justify-content: space-between;
	align-items: center;
	margin-bottom: 8px;
}

.account-item-label {
	font-size: 14px;
	font-weight: 600;
	color: #0f172a;
	display: flex;
	align-items: center;
	gap: 8px;
}

.privacy-badge {
	font-size: 13px;
	font-weight: 500;
	color: #64748b;
}

.account-item-value {
	font-size: 16px;
	color: #0f172a;
	font-weight: 500;
}

.btn-change {
	background: #e2e8f0;
	color: #0f172a;
	padding: 8px 20px;
	border-radius: 20px;
	font-size: 14px;
	font-weight: 600;
	text-decoration: none;
	transition: all 0.2s ease;
}

.btn-change:hover {
	background: #cbd5e1;
}

/* Responsive */
@media (max-width: 768px) {
	.profile-title {
		font-size: 28px;
	}

	.photo-upload-wrapper {
		flex-direction: column;
		text-align: center;
	}

	.form-actions {
		flex-direction: column;
	}

	.btn {
		width: 100%;
	}
}
</style>

<script>
jQuery(document).ready(function($) {
	// Change avatar button
	$('#change-avatar-btn').on('click', function(e) {
		e.preventDefault();
		$('#profile-avatar-upload').click();
	});

	// Preview avatar on change
	$('#profile-avatar-upload').on('change', function(e) {
		if (this.files && this.files[0]) {
			var reader = new FileReader();
			reader.onload = function(e) {
				$('.current-avatar img').attr('src', e.target.result);
			};
			reader.readAsDataURL(this.files[0]);
		}
	});

	// Handle form submission
	$('#pinterhvn-profile-form').on('submit', function(e) {
		e.preventDefault();

		var formData = new FormData(this);
		formData.append('action', 'pinterhvn_update_profile');

		$('#save-profile-btn').prop('disabled', true).text('<?php _e( 'Saving...', 'pinterhvn-theme' ); ?>');

		$.ajax({
			url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
			type: 'POST',
			data: formData,
			processData: false,
			contentType: false,
			success: function(response) {
				if (response.success) {
					$('#profile-message')
						.removeClass('error')
						.addClass('success')
						.html('<strong><?php _e( 'Success!', 'pinterhvn-theme' ); ?></strong> ' + response.data.message)
						.slideDown();

					// Scroll to message
					$('html, body').animate({
						scrollTop: $('#profile-message').offset().top - 100
					}, 500);
				} else {
					$('#profile-message')
						.removeClass('success')
						.addClass('error')
						.html('<strong><?php _e( 'Error!', 'pinterhvn-theme' ); ?></strong> ' + response.data.message)
						.slideDown();
				}
			},
			error: function() {
				$('#profile-message')
					.removeClass('success')
					.addClass('error')
					.html('<strong><?php _e( 'Error!', 'pinterhvn-theme' ); ?></strong> <?php _e( 'Failed to update profile. Please try again.', 'pinterhvn-theme' ); ?>')
					.slideDown();
			},
			complete: function() {
				$('#save-profile-btn').prop('disabled', false).text('<?php _e( 'Save', 'pinterhvn-theme' ); ?>');
				
				// Hide message after 5 seconds
				setTimeout(function() {
					$('#profile-message').slideUp();
				}, 5000);
			}
		});
	});
});
</script>

<?php
get_footer();
