<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package PinterHVN_Theme
 * @since 1.0.0
 */

get_header();
?>

<main id="primary" class="site-main">
	<div class="container">
		<section class="error-404 not-found" style="text-align: center; padding: 4rem 2rem;">
			
			<!-- 404 Icon -->
			<div class="error-icon" style="margin-bottom: 2rem;">
				<svg width="200" height="200" viewBox="0 0 24 24" fill="none" stroke="currentColor" style="opacity: 0.2; margin: 0 auto;">
					<circle cx="12" cy="12" r="10"/>
					<line x1="12" y1="8" x2="12" y2="12"/>
					<line x1="12" y1="16" x2="12.01" y2="16"/>
				</svg>
			</div>

			<h1 class="page-title" style="font-size: 3rem; margin-bottom: 1rem;">
				<?php esc_html_e( '404', 'pinterhvn-theme' ); ?>
			</h1>

			<p style="font-size: 1.5rem; color: #64748b; margin-bottom: 2rem;">
				<?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'pinterhvn-theme' ); ?>
			</p>

			<p style="color: #64748b; margin-bottom: 3rem;">
				<?php esc_html_e( 'It looks like nothing was found at this location. Maybe try a search or browse our assets?', 'pinterhvn-theme' ); ?>
			</p>

			<!-- Search Form -->
			<div style="max-width: 500px; margin: 0 auto 3rem;">
				<?php get_search_form(); ?>
			</div>

			<!-- Action Buttons -->
			<div class="error-actions" style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-primary">
					<svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor" style="margin-right: 0.5rem;">
						<path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
					</svg>
					<?php esc_html_e( 'Go to Homepage', 'pinterhvn-theme' ); ?>
				</a>

				<a href="<?php echo esc_url( get_post_type_archive_link( 'digital_asset' ) ); ?>" class="btn btn-secondary">
					<svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor" style="margin-right: 0.5rem;">
						<path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
					</svg>
					<?php esc_html_e( 'Browse Assets', 'pinterhvn-theme' ); ?>
				</a>
			</div>

		</section>
	</div>
</main>

<?php
get_footer();
