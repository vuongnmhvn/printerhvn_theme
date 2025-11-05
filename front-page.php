<?php
/**
 * The front page template
 *
 * @package PinterHVN_Theme
 * @since 1.0.0
 */

get_header();
?>

<main id="primary" class="site-main">
	<div class="container-fluid">

		<?php
		// Query digital assets
		$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
		
		$settings = get_option( 'pinterhvn_core_settings', array() );
		$posts_per_page = isset( $settings['assets_per_page'] ) ? $settings['assets_per_page'] : 12;

		$args = array(
			'post_type'      => 'digital_asset',
			'posts_per_page' => $posts_per_page,
			'paged'          => $paged,
			'orderby'        => 'date',
			'order'          => 'DESC',
		);

		$asset_query = new WP_Query( $args );

		if ( $asset_query->have_posts() ) : ?>

			<!-- Page Header (Optional) -->
			<?php if ( $paged == 1 ) : ?>
				<div class="page-header text-center">
					<!-- <h1 class="page-title"><?php bloginfo( 'name' ); ?></h1> -->
					<?php
					$description = get_bloginfo( 'description', 'display' );
					if ( $description ) :
						?>
						<p class="page-description" style="color: #64748b; font-size: 1.125rem; margin-top: 0.5rem;">
							<?php echo $description; ?>
						</p>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<!-- Masonry Grid -->
			<div class="pinterhvn-grid" id="assets-grid">
				<div class="grid-sizer"></div>
				
				<?php
				while ( $asset_query->have_posts() ) :
					$asset_query->the_post();
					get_template_part( 'template-parts/content', 'asset-card' );
				endwhile;
				?>
			</div>

			<?php
			// Pagination
			echo '<nav class="pagination" role="navigation" style="display: none;">';
			echo paginate_links( array(
				'base'      => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
				'format'    => '?paged=%#%',
				'current'   => max( 1, $paged ),
				'total'     => $asset_query->max_num_pages,
				'prev_text' => __( '← Previous', 'pinterhvn-theme' ),
				'next_text' => __( 'Next →', 'pinterhvn-theme' ),
				'type'      => 'list',
			) );
			echo '</nav>';

			// Reset post data
			wp_reset_postdata();
			?>

			<!-- Load More Button (for infinite scroll) -->
			<?php if ( $asset_query->max_num_pages > 1 ) : ?>
				<div class="load-more-wrapper text-center mt-4">
					<button class="btn btn-primary" id="load-more-assets">
						<?php _e( 'Tải thêm', 'pinterhvn-theme' ); ?>
					</button>
					<div class="spinner" style="display: none;"></div>
				</div>
			<?php endif; ?>

		<?php else : ?>

			<!-- No Assets Found -->
			<div class="no-results text-center" style="padding: 4rem 2rem;">
				<svg width="120" height="120" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" style="margin: 0 auto 2rem; color: #cbd5e1;">
					<rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
					<circle cx="8.5" cy="8.5" r="1.5"/>
					<polyline points="21 15 16 10 5 21"/>
				</svg>
				
				<h2 style="font-size: 1.75rem; margin-bottom: 1rem; color: #0f172a;">
					<?php _e( 'No Assets Found', 'pinterhvn-theme' ); ?>
				</h2>
				
				<p style="color: #64748b; font-size: 1.125rem; margin-bottom: 2rem; max-width: 600px; margin-left: auto; margin-right: auto;">
					<?php _e( 'Start building your digital asset library by uploading your first asset.', 'pinterhvn-theme' ); ?>
				</p>
				
				<?php if ( is_user_logged_in() && current_user_can( 'edit_posts' ) ) : ?>
					<a href="<?php echo esc_url( home_url( '/upload-asset/' ) ); ?>" class="btn btn-primary" style="display: inline-flex;">
						<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin-right: 0.5rem;">
							<path d="M10 4V16M4 10H16" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
						</svg>
						<?php _e( 'Upload Your First Asset', 'pinterhvn-theme' ); ?>
					</a>
				<?php endif; ?>
			</div>

		<?php endif; ?>

	</div>
</main>

<?php
get_footer();
