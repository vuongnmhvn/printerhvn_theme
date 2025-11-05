<?php
/**
 * Template for displaying campaign archive (single campaign view)
 *
 * @package PinterHVN_Theme
 * @since 1.0.0
 */

get_header();

$term = get_queried_object();
$campaign_id = $term->term_id;
$description = get_term_meta( $campaign_id, 'campaign_description', true );
$thumbnail = get_term_meta( $campaign_id, 'campaign_thumbnail', true );
$start_date = get_term_meta( $campaign_id, 'campaign_start_date', true );
$end_date = get_term_meta( $campaign_id, 'campaign_end_date', true );
$status = get_term_meta( $campaign_id, 'campaign_status', true );

if ( ! $status ) $status = 'active';
?>

<main id="primary" class="site-main campaign-single-page">
	<div class="container-fluid">

		<!-- Campaign Header -->
		<div class="campaign-header">
			<div class="campaign-header-content">
				
				<!-- Back Button -->
				<a href="<?php echo esc_url( home_url( '/campaigns/' ) ); ?>" class="btn-back">
					<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
						<path d="M19 12H5M12 19l-7-7 7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
					</svg>
					<?php _e( 'Back to Campaigns', 'pinterhvn-theme' ); ?>
				</a>

				<!-- Campaign Info -->
				<div class="campaign-hero">
					<?php if ( $thumbnail ) : ?>
						<div class="campaign-hero-image">
							<img src="<?php echo esc_url( $thumbnail ); ?>" alt="<?php echo esc_attr( $term->name ); ?>">
						</div>
					<?php endif; ?>

					<div class="campaign-hero-text">
						<div class="campaign-breadcrumb">
							<span><?php _e( 'Explore', 'pinterhvn-theme' ); ?></span>
							<svg width="16" height="16" viewBox="0 0 20 20" fill="currentColor">
								<path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
							</svg>
							<span><?php _e( 'Campaign', 'pinterhvn-theme' ); ?></span>
						</div>

						<h1 class="campaign-title"><?php echo esc_html( $term->name ); ?></h1>

						<?php if ( $description ) : ?>
							<p class="campaign-description"><?php echo esc_html( $description ); ?></p>
						<?php endif; ?>

						<!-- Campaign Meta -->
						<div class="campaign-meta-bar">
							<!-- Status -->
							<?php
							$status_badges = array(
								'active'    => array( 'label' => __( 'Active', 'pinterhvn-theme' ), 'color' => '#10b981' ),
								'inactive'  => array( 'label' => __( 'Inactive', 'pinterhvn-theme' ), 'color' => '#94a3b8' ),
								'scheduled' => array( 'label' => __( 'Scheduled', 'pinterhvn-theme' ), 'color' => '#3b82f6' ),
								'completed' => array( 'label' => __( 'Completed', 'pinterhvn-theme' ), 'color' => '#64748b' ),
							);
							$badge = isset( $status_badges[ $status ] ) ? $status_badges[ $status ] : $status_badges['active'];
							?>
							<span class="meta-badge" style="background: <?php echo esc_attr( $badge['color'] ); ?>;">
								<?php echo esc_html( $badge['label'] ); ?>
							</span>

							<!-- Asset Count -->
							<span class="meta-item">
								<?php echo number_format_i18n( $term->count ); ?> <?php _e( 'assets', 'pinterhvn-theme' ); ?>
							</span>

							<!-- Dates -->
							<?php if ( $start_date ) : ?>
								<span class="meta-item">
									<?php _e( 'Started', 'pinterhvn-theme' ); ?>: <?php echo date_i18n( get_option( 'date_format' ), strtotime( $start_date ) ); ?>
								</span>
							<?php endif; ?>

							<?php if ( $end_date ) : ?>
								<span class="meta-item">
									<?php
									$is_ended = strtotime( $end_date ) < time();
									echo $is_ended ? __( 'Ended', 'pinterhvn-theme' ) : __( 'Ends', 'pinterhvn-theme' );
									?>: <?php echo date_i18n( get_option( 'date_format' ), strtotime( $end_date ) ); ?>
								</span>
							<?php endif; ?>

							<!-- Last Updated -->
							<span class="meta-item meta-updated">
								<?php _e( 'Last updated', 'pinterhvn-theme' ); ?> 
								<?php
								// Get last updated from newest asset
								$latest_asset = get_posts( array(
									'post_type'      => 'digital_asset',
									'posts_per_page' => 1,
									'orderby'        => 'modified',
									'order'          => 'DESC',
									'tax_query'      => array(
										array(
											'taxonomy' => 'campaign',
											'field'    => 'term_id',
											'terms'    => $campaign_id,
										),
									),
								) );
								
								if ( ! empty( $latest_asset ) ) {
									$days_ago = human_time_diff( strtotime( $latest_asset[0]->post_modified ), current_time( 'timestamp' ) );
									echo $days_ago . ' ' . __( 'ago', 'pinterhvn-theme' );
								}
								?>
							</span>
						</div>
					</div>
				</div>

			</div>
		</div>

		<!-- Campaign Assets -->
		<div class="campaign-assets-section">
			<?php
			// Query assets in this campaign
			$args = array(
				'post_type'      => 'digital_asset',
				'posts_per_page' => 24,
				'tax_query'      => array(
					array(
						'taxonomy' => 'campaign',
						'field'    => 'term_id',
						'terms'    => $campaign_id,
					),
				),
			);

			$campaign_query = new WP_Query( $args );

			if ( $campaign_query->have_posts() ) :
				?>
				<div class="pinterhvn-grid campaign-assets-grid">
					<div class="grid-sizer"></div>
					<?php
					while ( $campaign_query->have_posts() ) :
						$campaign_query->the_post();
						get_template_part( 'template-parts/content', 'asset-card' );
					endwhile;
					wp_reset_postdata();
					?>
				</div>
			<?php else : ?>
				<div class="empty-state">
					<p><?php _e( 'No assets in this campaign yet.', 'pinterhvn-theme' ); ?></p>
				</div>
			<?php endif; ?>
		</div>

	</div>
</main>

<style>
/* Campaign Single Page */
.campaign-single-page {
	background: #ffffff;
}

/* Campaign Header */
.campaign-header {
	background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
	color: #ffffff;
	padding: 48px 0;
	margin-bottom: 48px;
}

.campaign-header-content {
	max-width: 1200px;
	margin: 0 auto;
	padding: 0 20px;
}

.btn-back {
	display: inline-flex;
	align-items: center;
	gap: 8px;
	color: #ffffff;
	text-decoration: none;
	font-size: 14px;
	font-weight: 600;
	margin-bottom: 24px;
	padding: 8px 16px;
	border-radius: 20px;
	transition: all 0.2s ease;
	background: rgba(255, 255, 255, 0.1);
}

.btn-back:hover {
	background: rgba(255, 255, 255, 0.2);
}

.campaign-hero {
	display: grid;
	grid-template-columns: 200px 1fr;
	gap: 32px;
	align-items: center;
}

.campaign-hero-image {
	width: 200px;
	height: 200px;
	border-radius: 16px;
	overflow: hidden;
	background: rgba(255, 255, 255, 0.1);
	box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
}

.campaign-hero-image img {
	width: 100%;
	height: 100%;
	object-fit: cover;
}

.campaign-breadcrumb {
	display: flex;
	align-items: center;
	gap: 8px;
	font-size: 14px;
	margin-bottom: 12px;
	opacity: 0.9;
}

.campaign-title {
	font-size: 42px;
	font-weight: 700;
	margin-bottom: 16px;
	line-height: 1.2;
}

.campaign-description {
	font-size: 18px;
	line-height: 1.6;
	margin-bottom: 24px;
	opacity: 0.95;
}

.campaign-meta-bar {
	display: flex;
	flex-wrap: wrap;
	gap: 16px;
	align-items: center;
}

.meta-badge {
	padding: 6px 14px;
	border-radius: 16px;
	color: #ffffff;
	font-size: 13px;
	font-weight: 700;
	text-transform: uppercase;
	letter-spacing: 0.5px;
}

.meta-item {
	display: flex;
	align-items: center;
	gap: 6px;
	font-size: 14px;
	opacity: 0.9;
}

.meta-updated {
	margin-left: auto;
	font-style: italic;
}

/* Campaign Assets Section */
.campaign-assets-section {
	padding: 0 20px 48px;
}

.campaign-assets-grid {
	margin-top: 24px;
}

/* Responsive */
@media (max-width: 768px) {
	.campaign-hero {
		grid-template-columns: 1fr;
		text-align: center;
	}

	.campaign-hero-image {
		margin: 0 auto;
	}

	.campaign-breadcrumb {
		justify-content: center;
	}

	.campaign-title {
		font-size: 32px;
	}

	.campaign-meta-bar {
		justify-content: center;
	}

	.meta-updated {
		margin-left: 0;
	}
}
</style>

<script>
jQuery(document).ready(function($) {
	// Initialize Masonry for campaign assets
	$('.campaign-assets-grid').imagesLoaded(function() {
		$('.campaign-assets-grid').masonry({
			itemSelector: '.grid-item',
			columnWidth: '.grid-sizer',
			percentPosition: true,
			gutter: 20,
			transitionDuration: '0.3s'
		});
	});
});
</script>

<?php
get_footer();
