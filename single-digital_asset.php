<?php
/**
 * Template for displaying single digital asset (Pinterest Pin style)
 *
 * @package PinterHVN_Theme
 * @since 1.0.0
 */

get_header();
?>

<main id="primary" class="site-main single-pin-page">
	<?php
	while ( have_posts() ) :
		the_post();

		$asset_id = get_the_ID();
		$asset_link = get_post_meta( $asset_id, '_pinterhvn_asset_link', true );
		$view_count = intval( get_post_meta( $asset_id, '_pinterhvn_view_count', true ) );
		$save_count = intval( get_post_meta( $asset_id, '_pinterhvn_save_count', true ) );
		$like_count = intval( get_post_meta( $asset_id, '_pinterhvn_like_count', true ) );
		$download_count = intval( get_post_meta( $asset_id, '_pinterhvn_download_count', true ) );
		
		// Check if current user liked this asset
		$current_user_id = get_current_user_id();
		$user_liked = false;
		if ( $current_user_id ) {
			$liked_users = get_post_meta( $asset_id, '_pinterhvn_liked_users', true );
			if ( ! is_array( $liked_users ) ) {
				$liked_users = array();
			}
			$user_liked = in_array( $current_user_id, $liked_users );
		}
		
		// Get taxonomies
		$categories = get_the_terms( $asset_id, 'asset_category' );
		$tags       = get_the_terms( $asset_id, 'asset_tag' );
		$campaigns  = get_the_terms( $asset_id, 'campaign' );
		?>

		<div class="single-pin-container">
			
			<!-- Back Button -->
			<div class="pin-back-button">
				<button onclick="window.history.back()" class="btn-back-circle">
					<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
						<path d="M19 12H5M12 19l-7-7 7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
					</svg>
				</button>
			</div>

			<!-- Pin Content -->
			<div class="pin-content-wrapper">
				
				<!-- Media Section (Left) -->
				<div class="pin-media-section">
					<div class="pin-media-container">
						<?php
						$preview_video_id = get_post_meta( $asset_id, '_pinterhvn_preview_video_id', true );
						if ( $preview_video_id ) {
							$preview_video_url = wp_get_attachment_url( $preview_video_id );
							?>
							<video class="pin-video" controls autoplay loop playsinline>
								<source src="<?php echo esc_url( $preview_video_url ); ?>" type="video/mp4">
							</video>
							<?php
						}
						elseif ( has_post_thumbnail() ) {
							$thumbnail_id = get_post_thumbnail_id();
							$mime_type = get_post_mime_type( $thumbnail_id );
							$attachment_url = wp_get_attachment_url( $thumbnail_id );
							$file_extension = strtolower( pathinfo( $attachment_url, PATHINFO_EXTENSION ) );

							if ( strpos( $mime_type, 'video' ) === 0 || $file_extension === 'mp4' ) {
								// MP4 Video
								?>
								<video class="pin-video" controls autoplay loop playsinline>
									<source src="<?php echo esc_url( $attachment_url ); ?>" type="<?php echo esc_attr( $mime_type ); ?>">
								</video>
								<div class="video-duration-badge">
									<svg width="12" height="12" viewBox="0 0 16 16" fill="currentColor">
										<path d="M3 2v12l10-6L3 2z"/>
									</svg>
									<span><?php _e( '0:09', 'pinterhvn-theme' ); ?></span>
								</div>
								<?php
							} elseif ( $file_extension === 'gif' || $mime_type === 'image/gif' ) {
								// GIF
								?>
								<img src="<?php echo esc_url( $attachment_url ); ?>" 
								     alt="<?php echo esc_attr( get_the_title() ); ?>"
								     class="pin-gif">
								<?php
							} else {
								// Static image
								?>
								<img src="<?php echo esc_url( $attachment_url ); ?>" 
								     alt="<?php echo esc_attr( get_the_title() ); ?>"
								     class="pin-image">
								<?php
							}
						}
						?>
					</div>
				</div>

				<!-- Details Section (Right) -->
				<div class="pin-details-section">
					
					<!-- Action Bar (Top) -->
					<div class="pin-action-bar">
						<!-- Like/Save/Share Icons -->
						<div class="action-icons-left">
							<!-- Like Button with Counter -->
							<button class="action-icon btn-like <?php echo $user_liked ? 'liked' : ''; ?>" data-asset-id="<?php echo esc_attr( $asset_id ); ?>" title="<?php esc_attr_e( 'Like', 'pinterhvn-theme' ); ?>">
							<svg width="24" height="24" viewBox="0 0 24 24" <?php echo $user_liked ? 'fill="#e60023" stroke="#e60023"' : 'fill="none" stroke="currentColor"'; ?> class="icon-heart">
							<path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z" stroke-width="2"/>
							</svg>
							<span class="like-count"><?php echo number_format_i18n( $save_count ); ?></span>
							</button>

							<!-- Share Button -->
							<button class="action-icon share-btn" data-asset-id="<?php echo esc_attr( $asset_id ); ?>" data-url="<?php the_permalink(); ?>" title="<?php esc_attr_e( 'Share', 'pinterhvn-theme' ); ?>">
								<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
									<circle cx="18" cy="5" r="3" stroke-width="2"/>
									<circle cx="6" cy="12" r="3" stroke-width="2"/>
									<circle cx="18" cy="19" r="3" stroke-width="2"/>
									<line x1="8.59" y1="13.51" x2="15.42" y2="17.49" stroke-width="2"/>
									<line x1="15.41" y1="6.51" x2="8.59" y2="10.49" stroke-width="2"/>
								</svg>
							</button>

							<?php if ( pinterhvn_can_edit_asset( $asset_id ) ) : ?>
							<!-- Edit Button -->
							<button class="action-icon btn-edit" onclick="window.location.href='<?php echo esc_url( get_edit_post_link( $asset_id ) ); ?>'" title="<?php esc_attr_e( 'Edit', 'pinterhvn-theme' ); ?>">
								<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
									<path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
									<path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
								</svg>
							</button>
							<?php endif; ?>
						
						<!-- Asset Link -->
						<?php if ( $asset_link ) : ?>
						<?php if ( is_user_logged_in() ) : ?>
							<button class="action-icon btn-download" onclick="window.location.href='<?php echo esc_url( $asset_link ); ?>'" title="<?php esc_attr_e( 'Download', 'pinterhvn-theme' ); ?>">
							<svg width="24" height="24" viewBox="0 0 20 20" fill="currentColor">
							<path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path>
							</svg>
							</button>
						<?php endif; ?>
						<?php endif; ?>
						
						</div>

						<!-- Save Button (Right) -->
						<div class="action-icons-right">
							<?php if ( is_user_logged_in() ) : ?>
								<button class="btn btn-save save-btn" data-asset-id="<?php echo esc_attr( $asset_id ); ?>">
									<?php _e( 'Save', 'pinterhvn-theme' ); ?>
								</button>
							<?php endif; ?>
						</div>
					</div>

					<!-- Asset Info -->
					<div class="pin-info-content">
						
						<!-- Title -->
						<h1 class="pin-title"><?php the_title(); ?></h1>

						<!-- Description -->
						<?php if ( get_the_content() ) : ?>
							<div class="pin-description">
								<?php the_content(); ?>
							</div>
						<?php endif; ?>

						<!-- Author Info -->
						<div class="pin-author">
							<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" class="author-link">
								<?php echo get_avatar( get_the_author_meta( 'ID' ), 48 ); ?>
								<div class="author-info">
									<div class="author-name"><?php the_author(); ?></div>
									<!-- Asset Stats -->
								<?php if ( $view_count || $save_count || $download_count ) : ?>
									<div class="asset-card-stats">
										<?php if ( $view_count ) : ?>
											<div class="asset-card-stat" title="<?php esc_attr_e( 'Views', 'pinterhvn-theme' ); ?>">
												<svg width="16" height="16" viewBox="0 0 20 20" fill="currentColor">
													<path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
													<path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
												</svg>
												<span><?php echo number_format_i18n( $view_count ); ?> <?php _e( 'đã xem', 'pinterhvn-theme' ); ?></span>
											</div>
										<?php endif; ?>

										<?php if ( $save_count ) : ?>
											<div class="asset-card-stat" title="<?php esc_attr_e( 'Saves', 'pinterhvn-theme' ); ?>">
												<svg width="16" height="16" viewBox="0 0 20 20" fill="currentColor">
													<path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"/>
												</svg>
												<span><?php echo number_format_i18n( $save_count ); ?> <?php _e( 'đã lưu', 'pinterhvn-theme' ); ?></span>
											</div>
										<?php endif; ?>

										<?php if ( $download_count ) : ?>
											<div class="asset-card-stat" title="<?php esc_attr_e( 'Downloads', 'pinterhvn-theme' ); ?>">
												<svg width="16" height="16" viewBox="0 0 20 20" fill="currentColor">
													<path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"/>
												</svg>
												<span><?php echo number_format_i18n( $download_count ); ?> <?php _e( 'đã tải', 'pinterhvn-theme' ); ?></span>
											</div>
										<?php endif; ?>
									</div>
								<?php endif; ?>
								</div>
							</a>
						</div>

						<!-- Categories -->
						<?php if ( $categories && ! is_wp_error( $categories ) ) : ?>
							<div class="pin-categories">
								<?php foreach ( $categories as $category ) : ?>
									<a href="<?php echo esc_url( get_term_link( $category ) ); ?>" class="category-chip">
										<?php echo esc_html( $category->name ); ?>
									</a>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>

						<!-- Tags -->
						<?php if ( $tags && ! is_wp_error( $tags ) ) : ?>
							<div class="pin-tags">
								<?php foreach ( $tags as $tag ) : ?>
									<a href="<?php echo esc_url( get_term_link( $tag ) ); ?>" class="tag-chip">
										#<?php echo esc_html( $tag->name ); ?>
									</a>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>

						<!-- Campaigns -->
						<?php if ( $campaigns && ! is_wp_error( $campaigns ) ) : ?>
							<div class="pin-campaigns">
								<h3 class="pin-section-title"><?php _e( 'Thuộc chiến dịch', 'pinterhvn-theme' ); ?></h3>
								<?php foreach ( $campaigns as $campaign ) : ?>
									<a href="<?php echo esc_url( get_term_link( $campaign ) ); ?>" class="campaign-chip">
										<?php echo esc_html( $campaign->name ); ?>
									</a>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>

					</div>

				</div>

			</div>

		</div>

		<!-- More Like This Section -->
		<?php
		$related_assets = pinterhvn_get_related_assets( $asset_id, 12 );
		if ( ! empty( $related_assets ) ) :
			?>
			<div class="more-like-this-section">
				<div class="container-fluid">
					<h2 class="section-heading"><?php _e( 'Tài nguyên khác', 'pinterhvn-theme' ); ?></h2>
					
					<div class="pinterhvn-grid related-assets-grid">
						<div class="grid-sizer"></div>
						<?php
						foreach ( $related_assets as $related_post ) {
							$GLOBALS['post'] = $related_post;
							setup_postdata( $related_post );
							get_template_part( 'template-parts/content', 'asset-card' );
						}
						wp_reset_postdata();
						?>
					</div>
				</div>
			</div>
			<?php
		endif;
		?>

	<?php endwhile; ?>
</main>

<style>
/* Single Pin Page */
.single-pin-page {
	padding: 60px 0px 0px 0px;
	background: #ffffff;
}

.single-pin-container {
	max-width: 1200px;
	margin: 0 auto;
	padding: 32px 16px;
	position: relative;
}

/* Back Button */
.pin-back-button {
	position: absolute;
	top: 16px;
	left: 16px;
	z-index: 10;
}

.btn-back-circle {
	width: 48px;
	height: 48px;
	display: flex;
	align-items: center;
	justify-content: center;
	background: #ffffff;
	border: none;
	border-radius: 50%;
	box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
	cursor: pointer;
	transition: all 0.2s ease;
}

.btn-back-circle:hover {
	background: #f8fafc;
	box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
}

/* Pin Content */
.pin-content-wrapper {
	display: grid;
	grid-template-columns: 1fr 500px;
	gap: 32px;
	background: #ffffff;
	border-radius: 32px;
	overflow: hidden;
	box-shadow: 0 1px 20px rgba(0, 0, 0, 0.1);
}

/* Media Section */
.pin-media-section {
	position: relative;
	background: #ffe6e6;
	display: flex;
	align-items: center;
	justify-content: center;
	min-height: 500px;
}

.pin-media-container {
	width: 100%;
	height: 100%;
	display: flex;
	align-items: center;
	justify-content: center;
	position: relative;
}

.pin-video,
.pin-gif,
.pin-image {
	max-width: 100%;
	max-height: 90vh;
	width: auto;
	height: auto;
	object-fit: contain;
	display: block;
}

.video-duration-badge {
	position: absolute;
	bottom: 16px;
	right: 16px;
	background: rgba(0, 0, 0, 0.8);
	color: #ffffff;
	padding: 6px 10px;
	border-radius: 8px;
	font-size: 12px;
	font-weight: 600;
	display: flex;
	align-items: center;
	gap: 4px;
}

/* Details Section */
.pin-details-section {
	padding: 32px;
	display: flex;
	flex-direction: column;
	max-height: 90vh;
	overflow-y: auto;
}

/* Action Bar */
.pin-action-bar {
	display: flex;
	justify-content: space-between;
	align-items: center;
	padding-bottom: 20px;
	border-bottom: 1px solid #e2e8f0;
	margin-bottom: 20px;
}

.action-icons-left {
	display: flex;
	gap: 8px;
}

.action-icon {
	width: 48px;
	height: 48px;
	display: flex;
	align-items: center;
	justify-content: center;
	background: transparent;
	border: none;
	border-radius: 50%;
	cursor: pointer;
	transition: all 0.2s ease;
	color: #1e293b;
	position: relative;
}

.action-icon:hover {
	background: #f1f5f9;
}

.action-icon span {
	position: absolute;
	bottom: -2px;
	right: -2px;
	background: #ffffff;
	color: #64748b;
	font-size: 11px;
	font-weight: 600;
	padding: 2px 6px;
	border-radius: 10px;
	border: 1px solid #e2e8f0;
}

/* Like Button Styles */
.btn-like.liked {
	color: #e60023;
}

.btn-like.liked .icon-heart {
	fill: #e60023;
	stroke: #e60023;
}

.btn-like .like-count {
	position: static;
	margin-left: 4px;
	background: transparent;
	border: none;
	color: inherit;
	padding: 0;
	font-size: 14px;
}

/* Pulse Animation */
@keyframes pulse {
	0% { transform: scale(1); }
	50% { transform: scale(1.2); }
	100% { transform: scale(1); }
}

.btn-like.pulse {
	animation: pulse 0.3s ease;
}

.btn-save {
	background: #e60023;
	color: #ffffff;
	padding: 12px 24px;
	border: none;
	border-radius: 24px;
	font-weight: 700;
	font-size: 16px;
	cursor: pointer;
	transition: all 0.2s ease;
}

.btn-save:hover {
	background: #ad081b;
	transform: translateY(-2px);
	box-shadow: 0 4px 12px rgba(230, 0, 35, 0.3);
}

/* Pin Info */
.pin-info-content {
	flex: 1;
}

.pin-title {
	font-size: 28px;
	font-weight: 700;
	line-height: 1.3;
	color: #0f172a;
	margin-bottom: 16px;
}

.pin-description {
	font-size: 16px;
	line-height: 1.6;
	color: #1e293b;
	margin-bottom: 20px;
}

.pin-external-link {
	display: inline-flex;
	align-items: center;
	gap: 6px;
	color: #64748b;
	font-size: 14px;
	text-decoration: none;
	margin-bottom: 24px;
	transition: color 0.2s ease;
}

.pin-external-link:hover {
	color: #3b82f6;
}

/* Author */
.pin-author {
	padding: 16px 0;
	border-top: 1px solid #e2e8f0;
	border-bottom: 1px solid #e2e8f0;
	margin-bottom: 20px;
}

.author-link {
	display: flex;
	align-items: center;
	gap: 12px;
	text-decoration: none;
	color: inherit;
	transition: opacity 0.2s ease;
}

.author-link:hover {
	opacity: 0.8;
}

.author-link img {
	width: 48px;
	height: 48px;
	border-radius: 50%;
}

.author-name {
	font-size: 16px;
	font-weight: 700;
	color: #0f172a;
}

.author-meta {
	font-size: 14px;
	color: #64748b;
}

/* Categories */
.pin-categories {
	display: flex;
	flex-wrap: wrap;
	gap: 8px;
	margin-bottom: 24px;
}

.category-chip {
	background: #f1f5f9;
	color: #1e293b;
	padding: 8px 16px;
	border-radius: 20px;
	font-size: 14px;
	font-weight: 600;
	text-decoration: none;
	transition: all 0.2s ease;
}

.category-chip:hover {
	background: #3b82f6;
	color: #ffffff;
}

/* Tags */
.pin-tags {
	display: flex;
	flex-wrap: wrap;
	gap: 8px;
	margin-bottom: 24px;
}

.tag-chip {
	background: #eef2ff;
	color: #ca3838ff;
	padding: 6px 12px;
	border-radius: 16px;
	font-size: 13px;
	font-weight: 500;
	text-decoration: none;
	transition: all 0.2s ease;
}

.tag-chip:hover {
	background: #ca3838ff;
	color: #ffffff;
}

/* Campaigns */
.pin-campaigns {
	margin-bottom: 24px;
}

.pin-section-title {
	font-size: 16px;
	font-weight: 700;
	color: #0f172a;
	margin-bottom: 12px;
}

.campaign-chip {
	display: inline-block;
	background: #fee2e2;
	color: #991b1b;
	padding: 8px 16px;
	border-radius: 20px;
	font-size: 14px;
	font-weight: 600;
	text-decoration: none;
	transition: all 0.2s ease;
	margin-right: 8px;
	margin-bottom: 8px;
}

.campaign-chip:hover {
	background: #ef4444;
	color: #ffffff;
}
/* Removed Comments Section - Not needed */

/* More Like This Section */
.more-like-this-section {
	background: #f8f9fa;
	padding: 48px 0;
	margin-top: 48px;
}

.section-heading {
	font-size: 24px;
	font-weight: 700;
	margin-bottom: 24px;
	color: #0f172a;
	text-align: center;
}

.related-assets-grid {
	margin-top: 24px;
}

/* Responsive */
@media (max-width: 1024px) {
	.pin-content-wrapper {
		grid-template-columns: 1fr;
		max-width: 600px;
		margin: 0 auto;
	}

	.pin-details-section {
		max-height: none;
		overflow-y: visible;
	}

	.pin-media-section {
		min-height: 400px;
	}
}

@media (max-width: 768px) {
	.single-pin-container {
		padding: 16px 8px;
	}

	.pin-content-wrapper {
		border-radius: 16px;
	}

	.pin-details-section {
		padding: 20px;
	}

	.pin-title {
		font-size: 24px;
	}

	.pin-action-bar {
		flex-wrap: wrap;
	}

	.btn-save {
		width: 100%;
		margin-top: 12px;
	}
}
</style>

<script>
jQuery(document).ready(function($) {
	// Initialize Masonry for related assets
	$('.related-assets-grid').imagesLoaded(function() {
		$('.related-assets-grid').masonry({
			itemSelector: '.grid-item',
			columnWidth: '.grid-sizer',
			percentPosition: true,
			gutter: 20,
			transitionDuration: '0.3s'
		});
	});

	// Video interaction
	$('.pin-video').on('click', function() {
		if (this.paused) {
			this.play();
		} else {
			this.pause();
		}
	});

	// Like button functionality
	$('.btn-like').on('click', function(e) {
		e.preventDefault();
		
		var $btn = $(this);
		var assetId = $btn.data('asset-id');
		var $icon = $btn.find('.icon-heart');
		var $count = $btn.find('.like-count');
		var isLiked = $btn.hasClass('liked');

		// Disable button during request
		$btn.prop('disabled', true);

		$.ajax({
			url: pinterhvnTheme.ajax_url,
			type: 'POST',
			data: {
				action: 'pinterhvn_like_asset',
				asset_id: assetId,
				nonce: pinterhvnTheme.nonce
			},
			success: function(response) {
				if (response.success) {
					// Toggle liked state
					if (response.data.is_liked) {
						$btn.addClass('liked');
						$icon.attr('fill', '#e60023');
						$icon.attr('stroke', '#e60023');
					} else {
						$btn.removeClass('liked');
						$icon.attr('fill', 'none');
						$icon.attr('stroke', 'currentColor');
					}

					// Update count
					$count.text(response.data.like_count.toLocaleString());

					// Show quick animation
					$btn.addClass('pulse');
					setTimeout(function() {
						$btn.removeClass('pulse');
					}, 300);
				}
			},
			error: function() {
				alert('<?php _e( 'Failed to like asset. Please try again.', 'pinterhvn-theme' ); ?>');
			},
			complete: function() {
				$btn.prop('disabled', false);
			}
		});
	});

	// Check if user already liked this asset on page load
	<?php if ( is_user_logged_in() ) : ?>
		var assetId = $('.btn-like').data('asset-id');
		if (assetId) {
			// You could add AJAX to check if user liked this asset
			// For now, we'll rely on server-side rendering
		}
	<?php endif; ?>
});
</script>

<?php
get_footer();
