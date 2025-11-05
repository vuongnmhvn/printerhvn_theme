<?php
/**
 * Template Name: My Collections
 * Template for user's saved assets and collections
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
$current_tab = isset( $_GET['tab'] ) ? sanitize_text_field( $_GET['tab'] ) : 'saved';

get_header();
?>

<main id="primary" class="site-main profile-page collections-page">
	<div class="container-fluid">

		<!-- Profile Header -->
			<div class="profile-hero">
				<!-- Back Button -->
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn-back">
					<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
						<path d="M19 12H5M12 19l-7-7 7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
					</svg>
				</a>

				<!-- User Info -->
				<div class="profile-user-info">
					<div class="profile-avatar">
						<?php echo get_avatar( $current_user->ID, 120 ); ?>
					</div>
					<h1 class="profile-name"><?php echo esc_html( $current_user->display_name ); ?></h1>
					<p class="profile-username">@<?php echo esc_html( $current_user->user_login ); ?></p>
					
					<?php
					$user_bio = get_user_meta( $current_user->ID, 'description', true );
					if ( $user_bio ) :
						?>
						<p class="profile-bio"><?php echo esc_html( $user_bio ); ?></p>
					<?php endif; ?>
				</div>

				<!-- Action Buttons -->
				<div class="profile-actions">
					<a href="<?php echo esc_url( home_url( '/my-profile/' ) ); ?>" class="btn btn-secondary">
						<?php _e( 'Edit profile', 'pinterhvn-theme' ); ?>
					</a>
				</div>
			</div>

			<!-- Tabs Navigation -->
			<div class="profile-tabs">
				<a href="<?php echo esc_url( add_query_arg( 'tab', 'saved' ) ); ?>" 
				   class="tab-link <?php echo ( $current_tab === 'saved' ) ? 'active' : ''; ?>">
					<?php _e( 'Tài nguyên đã lưu', 'pinterhvn-theme' ); ?>
				</a>
				<a href="<?php echo esc_url( add_query_arg( 'tab', 'collections' ) ); ?>" 
				   class="tab-link <?php echo ( $current_tab === 'collections' ) ? 'active' : ''; ?>">
					<?php _e( 'Bộ sưu tập', 'pinterhvn-theme' ); ?>
				</a>
			</div>

		<!-- Tab Content -->
		<div class="tab-content">
			
			<?php if ( $current_tab === 'saved' ) : ?>
				
				<!-- Assets Saved Tab -->
				<div class="tab-pane active" id="saved-assets">
					<?php
					// Query saved assets (assets in any collection of this user)
					$user_collections = pinterhvn_get_user_collections( $current_user->ID );
					
					if ( empty( $user_collections ) ) {
						?>
						<div class="empty-state">
							<svg width="120" height="120" viewBox="0 0 24 24" fill="none" stroke="currentColor">
								<path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z" stroke-width="1"/>
								<polyline points="17 21 17 13 7 13 7 21" stroke-width="1"/>
							</svg>
							<h2><?php _e( 'No saved assets yet', 'pinterhvn-theme' ); ?></h2>
							<p><?php _e( 'Start exploring and save assets you love!', 'pinterhvn-theme' ); ?></p>
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-primary">
								<?php _e( 'Explore Assets', 'pinterhvn-theme' ); ?>
							</a>
						</div>
						<?php
					} else {
						// Get collection IDs
						$collection_ids = array_map( function( $col ) {
							return $col->term_id;
						}, $user_collections );

						// Query assets
						$args = array(
							'post_type'      => 'digital_asset',
							'posts_per_page' => 24,
							'tax_query'      => array(
								array(
									'taxonomy' => 'asset_collection',
									'field'    => 'term_id',
									'terms'    => $collection_ids,
								),
							),
						);

						$saved_query = new WP_Query( $args );

						if ( $saved_query->have_posts() ) :
							?>
							<div class="pinterhvn-grid" id="saved-assets-grid">
								<div class="grid-sizer"></div>
								<?php
								while ( $saved_query->have_posts() ) :
									$saved_query->the_post();
									get_template_part( 'template-parts/content', 'asset-card' );
								endwhile;
								wp_reset_postdata();
								?>
							</div>
							<?php
						else :
							?>
							<div class="empty-state">
								<h3><?php _e( 'No assets found in your collections', 'pinterhvn-theme' ); ?></h3>
							</div>
							<?php
						endif;
					}
					?>
				</div>

			<?php else : ?>
				
				<!-- Assets Collections Tab -->
				<div class="tab-pane active" id="collections">
					<?php
					$user_collections = pinterhvn_get_user_collections( $current_user->ID );
					
					if ( empty( $user_collections ) ) :
						?>
						<div class="empty-state">
							<svg width="120" height="120" viewBox="0 0 24 24" fill="none" stroke="currentColor">
								<rect x="3" y="3" width="18" height="18" rx="2" stroke-width="1"/>
								<path d="M3 9h18M9 21V9" stroke-width="1"/>
							</svg>
							<h2><?php _e( 'No collections yet', 'pinterhvn-theme' ); ?></h2>
							<p><?php _e( 'Create collections to organize your saved assets', 'pinterhvn-theme' ); ?></p>
						</div>
						<?php
					else :
						?>
						<div class="collections-grid">
							<?php foreach ( $user_collections as $collection ) : ?>
								<?php
								// Get collection assets
								$collection_assets = get_posts( array(
									'post_type'      => 'digital_asset',
									'posts_per_page' => 3,
									'tax_query'      => array(
										array(
											'taxonomy' => 'asset_collection',
											'field'    => 'term_id',
											'terms'    => $collection->term_id,
										),
									),
								) );

								$asset_count = $collection->count;
								?>
								<div class="collection-card">
									<a href="<?php echo esc_url( get_term_link( $collection ) ); ?>" class="collection-link">
										<div class="collection-preview">
											<?php if ( ! empty( $collection_assets ) ) : ?>
												<div class="preview-grid">
													<?php foreach ( array_slice( $collection_assets, 0, 3 ) as $index => $asset ) : ?>
														<div class="preview-item preview-item-<?php echo $index + 1; ?>">
															<?php 
															$thumbnail = get_the_post_thumbnail_url( $asset->ID, 'pinterhvn-small' );
															if ( $thumbnail ) :
																?>
																<img src="<?php echo esc_url( $thumbnail ); ?>" alt="<?php echo esc_attr( get_the_title( $asset->ID ) ); ?>">
															<?php else : ?>
																<div class="preview-placeholder">
																	<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor">
																		<rect x="3" y="3" width="18" height="18" rx="2" stroke-width="2"/>
																		<circle cx="8.5" cy="8.5" r="1.5"/>
																		<polyline points="21 15 16 10 5 21"/>
																	</svg>
																</div>
															<?php endif; ?>
														</div>
													<?php endforeach; ?>
												</div>
											<?php else : ?>
												<div class="preview-empty">
													<svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor">
														<rect x="3" y="3" width="18" height="18" rx="2" stroke-width="1"/>
													</svg>
												</div>
											<?php endif; ?>
										</div>

										<div class="collection-info">
											<h3 class="collection-name"><?php echo esc_html( $collection->name ); ?></h3>
											<p class="collection-count">
												<?php 
												printf( 
													_n( '%s asset', '%s assets', $asset_count, 'pinterhvn-theme' ),
													number_format_i18n( $asset_count )
												); 
												?>
											</p>
										</div>
									</a>
								</div>
							<?php endforeach; ?>
						</div>
						<?php
					endif;
					?>
				</div>

			<?php endif; ?>

		</div>

	</div>
</main>

<style>
/* Profile/Collections Page Styles */
.collections-page {
	padding: 80px 0px;
	background: #ffffff;
}

/* Profile Header Section */
.profile-header-section {
	border-bottom: 1px solid #e2e8f0;
	background: #ffffff;
	/* position: sticky; */
	top: 64px;
	z-index: 100;
}

.btn-back {
	position: absolute;
	left: 20px;
	top: 40px;
	width: 40px;
	height: 40px;
	display: flex;
	align-items: center;
	justify-content: center;
	border-radius: 50%;
	background: transparent;
	color: #1e293b;
	transition: all 0.2s ease;
	text-decoration: none;
}

.btn-back:hover {
	background: #f1f5f9;
}

.profile-avatar {
	width: 120px;
	height: 120px;
	border-radius: 50%;
	overflow: hidden;
	margin: 0 auto 16px;
	border: 4px solid #ffffff;
	box-shadow: 0 0 0 1px #e2e8f0;
}

.profile-avatar img {
	width: 100%;
	height: 100%;
	object-fit: cover;
}

.profile-name {
	font-size: 36px;
	font-weight: 700;
	margin-bottom: 4px;
	color: #0f172a;
}

.profile-username {
	font-size: 14px;
	color: #64748b;
	margin-bottom: 16px;
	display: flex;
	align-items: center;
	justify-content: center;
	gap: 4px;
}

.profile-username svg {
	width: 14px;
	height: 14px;
}

.profile-bio {
	font-size: 16px;
	color: #1e293b;
	line-height: 1.5;
	max-width: 500px;
	margin: 0 auto 24px;
}

.profile-actions {
	display: flex;
	gap: 12px;
	justify-content: center;
	margin-top: 24px;
}

.profile-actions .btn {
	padding: 12px 24px;
	border-radius: 24px;
	font-weight: 600;
	font-size: 15px;
}

/* Tabs */
.profile-hero{
	text-align: center;
    padding: 30px 0px;
}

.profile-tabs {
	display: flex;
	justify-content: center;
	gap: 32px;
	padding: 0 20px;
	border-top: 1px solid #e2e8f0;
	position: sticky;
    top: 60px;
    z-index: 99;
    background: #fff;
	border-bottom: 1px solid #e2e8f0;
}

.tab-link {
	padding: 16px 0;
	color: #64748b;
	text-decoration: none;
	font-weight: 600;
	font-size: 16px;
	border-bottom: 3px solid transparent;
	transition: all 0.2s ease;
	position: relative;
	top: 1px;
}

.tab-link:hover {
	color: #1e293b;
}

.tab-link.active {
	color: #0f172a;
	border-bottom-color: #0f172a;
}

/* Tab Content */
.tab-content {
	padding: 32px 0;
	min-height: 400px;
}

/* Empty State */
.empty-state {
	text-align: center;
	padding: 80px 20px;
}

.empty-state svg {
	margin: 0 auto 24px;
	color: #cbd5e1;
}

.empty-state h2 {
	font-size: 24px;
	font-weight: 700;
	margin-bottom: 12px;
	color: #0f172a;
}

.empty-state h3 {
	font-size: 20px;
	font-weight: 600;
	color: #64748b;
}

.empty-state p {
	font-size: 16px;
	color: #64748b;
	margin-bottom: 24px;
}

/* Collections Grid */
.collections-grid {
	display: grid;
	grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
	gap: 24px;
	padding: 0 20px;
	/* max-width: 1400px; */
	margin: 0 auto;
}

.collection-card {
	background: #ffffff;
	border-radius: 16px;
	overflow: hidden;
	transition: all 0.3s ease;
	box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.collection-card:hover {
	box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
	transform: translateY(-4px);
}

.collection-link {
	display: block;
	text-decoration: none;
	color: inherit;
}

/* Collection Preview */
.collection-preview {
	width: 100%;
	padding-bottom: 100%; /* 1:1 aspect ratio */
	position: relative;
	background: #f8fafc;
	overflow: hidden;
}

.preview-grid {
	position: absolute;
	top: 0;
	left: 0;
	right: 0;
	bottom: 0;
	display: grid;
	grid-template-columns: repeat(2, 1fr);
	grid-template-rows: repeat(2, 1fr);
	gap: 2px;
	padding: 8px;
}

.preview-item {
	border-radius: 8px;
	overflow: hidden;
	background: #e2e8f0;
}

.preview-item-1 {
	grid-column: 1 / 3;
	grid-row: 1 / 2;
}

.preview-item-2 {
	grid-column: 1 / 2;
	grid-row: 2 / 3;
}

.preview-item-3 {
	grid-column: 2 / 3;
	grid-row: 2 / 3;
}

.preview-item img {
	width: 100%;
	height: 100%;
	object-fit: cover;
	display: block;
}

.preview-placeholder {
	width: 100%;
	height: 100%;
	display: flex;
	align-items: center;
	justify-content: center;
	background: #f1f5f9;
	color: #94a3b8;
}

.preview-empty {
	position: absolute;
	top: 50%;
	left: 50%;
	transform: translate(-50%, -50%);
	color: #cbd5e1;
}

/* Collection Info */
.collection-info {
	padding: 16px;
}

.collection-name {
	font-size: 16px;
	font-weight: 700;
	color: #0f172a;
	margin-bottom: 4px;
}

.collection-count {
	font-size: 14px;
	color: #64748b;
	margin: 0;
}

/* Saved Assets Grid */
#saved-assets-grid {
	margin-top: 0;
}

/* Responsive */
@media (max-width: 768px) {
	.profile-name {
		font-size: 28px;
	}

	.profile-tabs {
		gap: 16px;
	}

	.tab-link {
		font-size: 14px;
	}

	.collections-grid {
		grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
		gap: 16px;
	}

	.btn-back {
		width: 36px;
		height: 36px;
		left: 12px;
		top: 32px;
	}

	.profile-actions {
		flex-direction: column;
	}

	.profile-actions .btn {
		width: 100%;
		max-width: 300px;
	}
}

@media (max-width: 480px) {
	.collections-grid {
		grid-template-columns: repeat(2, 1fr);
		gap: 12px;
		padding: 0 12px;
	}
}
</style>

<script>
jQuery(document).ready(function($) {
	// Initialize Masonry for saved assets grid
	if ($('#saved-assets-grid').length) {
		$('#saved-assets-grid').imagesLoaded(function() {
			$('#saved-assets-grid').masonry({
				itemSelector: '.grid-item',
				columnWidth: '.grid-sizer',
				percentPosition: true,
				gutter: 20,
				transitionDuration: '0.3s'
			});
		});
	}
});
</script>

<?php
get_footer();
