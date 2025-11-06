<?php
/**
 * Template Name: Campaigns
 * Template for displaying all campaigns
 *
 * @package PinterHVN_Theme
 * @since 1.0.0
 */

get_header();
?>

<main id="primary" class="site-main campaigns-page">
	<div class="container-fluid">

		<!-- Page Header -->
		<div class="campaigns-header">
			<h1 class="page-title"><?php _e( 'Chiến dịch', 'pinterhvn-theme' ); ?></h1>
			<p class="page-subtitle"><?php _e( 'Khám phá các bộ sưu tập tài sản được quản lý theo các chiến dịch tiếp thị', 'pinterhvn-theme' ); ?></p>
		</div>

		<!-- Campaigns Grid -->
		<div class="campaigns-grid">
			<?php
			// Query active campaigns
			$campaigns = get_terms( array(
				'taxonomy'   => 'campaign',
				'hide_empty' => false,
				'orderby'    => 'meta_value',
				'meta_key'   => 'campaign_start_date',
				'order'      => 'DESC',
			) );

			if ( ! empty( $campaigns ) && ! is_wp_error( $campaigns ) ) :
				foreach ( $campaigns as $campaign ) :
					$campaign_id = $campaign->term_id;
					$description = get_term_meta( $campaign_id, 'campaign_description', true );
					$thumbnail_id = get_term_meta( $campaign_id, 'campaign_thumbnail_id', true );
					$thumbnail_url = $thumbnail_id ? wp_get_attachment_image_url( $thumbnail_id, 'large' ) : '';
					$start_date = get_term_meta( $campaign_id, 'campaign_start_date', true );
					$end_date = get_term_meta( $campaign_id, 'campaign_end_date', true );
					$status = get_term_meta( $campaign_id, 'campaign_status', true );
					
					if ( ! $status ) $status = 'active';
					
					// Status badge
					$status_badges = array(
						'active'    => array( 'label' => __( 'Active', 'pinterhvn-theme' ), 'color' => '#10b981' ),
						'inactive'  => array( 'label' => __( 'Inactive', 'pinterhvn-theme' ), 'color' => '#94a3b8' ),
						'scheduled' => array( 'label' => __( 'Scheduled', 'pinterhvn-theme' ), 'color' => '#3b82f6' ),
						'completed' => array( 'label' => __( 'Completed', 'pinterhvn-theme' ), 'color' => '#64748b' ),
					);
					
					$badge = isset( $status_badges[ $status ] ) ? $status_badges[ $status ] : $status_badges['active'];
					
					// Get preview assets
					$preview_assets = get_posts( array(
						'post_type'      => 'digital_asset',
						'posts_per_page' => 4,
						'tax_query'      => array(
							array(
								'taxonomy' => 'campaign',
								'field'    => 'term_id',
								'terms'    => $campaign_id,
							),
						),
					) );
					?>
					<div class="campaign-card <?php echo esc_attr( 'status-' . $status ); ?>">
						<a href="<?php echo esc_url( get_term_link( $campaign ) ); ?>" class="campaign-link">
							
							<!-- Campaign Preview -->
							<div class="campaign-preview">
								<?php if ( $thumbnail_url ) : ?>
									<img src="<?php echo esc_url( $thumbnail_url ); ?>" alt="<?php echo esc_attr( $campaign->name ); ?>" class="campaign-cover">
								<?php elseif ( ! empty( $preview_assets ) ) : ?>
									<div class="campaign-assets-preview">
										<?php foreach ( array_slice( $preview_assets, 0, 4 ) as $index => $asset ) : ?>
											<?php
											$thumb = get_the_post_thumbnail_url( $asset->ID, 'pinterhvn-small' );
											if ( $thumb ) :
												?>
												<div class="preview-asset preview-asset-<?php echo $index + 1; ?>">
													<img src="<?php echo esc_url( $thumb ); ?>" alt="">
												</div>
											<?php endif; ?>
										<?php endforeach; ?>
									</div>
								<?php else : ?>
									<div class="campaign-placeholder">
										<svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor">
											<rect x="3" y="3" width="18" height="18" rx="2" stroke-width="1"/>
											<path d="M3 9h18M9 21V9" stroke-width="1"/>
										</svg>
									</div>
								<?php endif; ?>
								
								<!-- Status Badge -->
								<div class="campaign-status-badge" style="background: <?php echo esc_attr( $badge['color'] ); ?>;">
									<?php echo esc_html( $badge['label'] ); ?>
								</div>
							</div>

							<!-- Campaign Info -->
							<div class="campaign-info">
								<h3 class="campaign-name"><?php echo esc_html( $campaign->name ); ?></h3>
								
								<?php if ( $description ) : ?>
									<p class="campaign-description"><?php echo esc_html( wp_trim_words( $description, 15 ) ); ?></p>
								<?php endif; ?>

								<div class="campaign-meta">
									<span class="campaign-count">
										<svg width="16" height="16" viewBox="0 0 20 20" fill="currentColor">
											<path d="M4 3a2 2 0 100 4h12a2 2 0 100-4H4z"/>
											<path fill-rule="evenodd" d="M3 8h14v7a2 2 0 01-2 2H5a2 2 0 01-2-2V8zm5 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z" clip-rule="evenodd"/>
										</svg>
										<?php echo number_format_i18n( $campaign->count ); ?> tài nguyên
									</span>

									<?php if ( $start_date || $end_date ) : ?>
										<span class="campaign-dates">
											<svg width="16" height="16" viewBox="0 0 20 20" fill="currentColor">
												<path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
											</svg>
											<?php
											if ( $start_date && $end_date ) {
												echo date_i18n( 'M d', strtotime( $start_date ) ) . ' - ' . date_i18n( 'M d, Y', strtotime( $end_date ) );
											} elseif ( $start_date ) {
												echo __( 'Từ', 'pinterhvn-theme' ) . ' ' . date_i18n( get_option( 'date_format' ), strtotime( $start_date ) );
											} elseif ( $end_date ) {
												echo __( 'đến', 'pinterhvn-theme' ) . ' ' . date_i18n( get_option( 'date_format' ), strtotime( $end_date ) );
											}
											?>
										</span>
									<?php endif; ?>
								</div>
							</div>

						</a>
					</div>
				<?php endforeach; ?>

			<?php else : ?>
				
				<!-- Empty State -->
				<div class="empty-state">
					<svg width="120" height="120" viewBox="0 0 24 24" fill="none" stroke="currentColor">
						<rect x="3" y="3" width="18" height="18" rx="2" stroke-width="1"/>
						<path d="M3 9h18M9 21V9" stroke-width="1"/>
					</svg>
					<h2><?php _e( 'Chưa có chiến dịch nào', 'pinterhvn-theme' ); ?></h2>
					<p><?php _e( 'Các chiến dịch sẽ xuất hiện ở đây khi người quản trị tạo chúng', 'pinterhvn-theme' ); ?></p>
				</div>

			<?php endif; ?>
		</div>

	</div>
</main>

<style>
/* Campaigns Page */
.campaigns-page {
	padding: 120px 20px;
}

.campaigns-header {
	text-align: center;
	max-width: 800px;
	margin: 0 auto 48px;
	padding: 0 20px;
}

.page-title {
	font-size: 36px;
	font-weight: 700;
	margin-bottom: 12px;
	color: #0f172a;
}

.page-subtitle {
	font-size: 16px;
	color: #64748b;
	line-height: 1.6;
}

/* Campaigns Grid */
.campaigns-grid {
	display: grid;
	grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
	gap: 24px;
	padding: 0 20px;
}

.campaign-card {
	background: #ffffff;
	border-radius: 20px;
	overflow: hidden;
	box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
	transition: all 0.3s ease;
}

.campaign-card:hover {
	box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
	transform: translateY(-4px);
}

.campaign-link {
	display: block;
	text-decoration: none;
	color: inherit;
}

/* Campaign Preview */
.campaign-preview {
	position: relative;
	width: 100%;
	padding-bottom: 75%;
	background: #f8fafc;
	overflow: hidden;
}

.campaign-cover {
	position: absolute;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
	object-fit: cover;
}

.campaign-assets-preview {
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

.preview-asset {
	border-radius: 8px;
	overflow: hidden;
	background: #e2e8f0;
}

.preview-asset img {
	width: 100%;
	height: 100%;
	object-fit: cover;
}

.campaign-placeholder {
	position: absolute;
	top: 50%;
	left: 50%;
	transform: translate(-50%, -50%);
	color: #cbd5e1;
}

/* Status Badge */
.campaign-status-badge {
	position: absolute;
	top: 12px;
	right: 12px;
	padding: 6px 12px;
	border-radius: 16px;
	color: #ffffff;
	font-size: 12px;
	font-weight: 700;
	text-transform: uppercase;
	letter-spacing: 0.5px;
	backdrop-filter: blur(8px);
}

/* Campaign Info */
.campaign-info {
	padding: 20px;
}

.campaign-name {
	font-size: 18px;
	font-weight: 700;
	margin-bottom: 8px;
	color: #0f172a;
	line-height: 1.3;
}

.campaign-description {
	font-size: 14px;
	color: #64748b;
	line-height: 1.5;
	margin-bottom: 12px;
}

.campaign-meta {
	display: flex;
	flex-wrap: wrap;
	gap: 12px;
	font-size: 13px;
	color: #64748b;
}

.campaign-count,
.campaign-dates {
	display: flex;
	align-items: center;
	gap: 4px;
}

.campaign-count svg,
.campaign-dates svg {
	flex-shrink: 0;
}

/* Empty State */
.empty-state {
	text-align: center;
	padding: 80px 20px;
	grid-column: 1 / -1;
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

.empty-state p {
	font-size: 16px;
	color: #64748b;
}

/* Responsive */
@media (max-width: 768px) {
	.campaigns-grid {
		grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
		gap: 16px;
	}

	.page-title {
		font-size: 28px;
	}
}

@media (max-width: 480px) {
	.campaigns-grid {
		grid-template-columns: 1fr;
	}
}
</style>

<?php
get_footer();
