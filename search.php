<?php
/**
 * The template for displaying search results
 *
 * @package PinterHVN_Theme
 * @since 1.0.0
 */

get_header();
?>

<main id="primary" class="site-main">
	<div class="container">

		<header class="page-header">
			<h1 class="page-title">
				<?php
				printf(
					esc_html__( 'Search Results for: %s', 'pinterhvn-theme' ),
					'<span>' . get_search_query() . '</span>'
				);
				?>
			</h1>
		</header>

		<?php if ( have_posts() ) : ?>

			<div class="pinterhvn-grid" id="assets-grid">
				<div class="grid-sizer"></div>
				
				<?php
				while ( have_posts() ) :
					the_post();
					
					// Use asset card for digital_asset post type
					if ( get_post_type() === 'digital_asset' ) {
						get_template_part( 'template-parts/content', 'asset-card' );
					} else {
						// Fallback for other post types
						?>
						<article id="post-<?php the_ID(); ?>" <?php post_class( 'grid-item search-result' ); ?>>
							<div class="search-result-content" style="background: #fff; padding: 1.5rem; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
								<h3 class="entry-title" style="margin-bottom: 0.5rem;">
									<a href="<?php the_permalink(); ?>">
										<?php the_title(); ?>
									</a>
								</h3>
								<div class="entry-meta" style="color: #64748b; font-size: 0.875rem; margin-bottom: 1rem;">
									<?php pinterhvn_posted_on(); ?>
								</div>
								<div class="entry-summary">
									<?php the_excerpt(); ?>
								</div>
								<a href="<?php the_permalink(); ?>" class="read-more" style="color: #3b82f6; font-weight: 600; display: inline-block; margin-top: 0.5rem;">
									<?php esc_html_e( 'Read More →', 'pinterhvn-theme' ); ?>
								</a>
							</div>
						</article>
						<?php
					}
				endwhile;
				?>
			</div>

			<?php pinterhvn_pagination(); ?>

		<?php else : ?>

			<div class="no-results" style="text-align: center; padding: 4rem 2rem;">
				<svg width="128" height="128" viewBox="0 0 24 24" fill="none" stroke="currentColor" style="opacity: 0.2; margin: 0 auto 2rem;">
					<circle cx="11" cy="11" r="8"/>
					<path d="m21 21-4.35-4.35"/>
					<line x1="11" y1="8" x2="11" y2="14"/>
					<line x1="8" y1="11" x2="14" y2="11"/>
				</svg>

				<h2 style="font-size: 2rem; margin-bottom: 1rem;">
					<?php esc_html_e( 'Nothing Found', 'pinterhvn-theme' ); ?>
				</h2>

				<p style="color: #64748b; margin-bottom: 2rem;">
					<?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with different keywords.', 'pinterhvn-theme' ); ?>
				</p>

				<div style="max-width: 500px; margin: 0 auto 2rem;">
					<?php get_search_form(); ?>
				</div>

				<div class="search-suggestions" style="text-align: left; max-width: 600px; margin: 0 auto;">
					<h3 style="font-size: 1.25rem; margin-bottom: 1rem;">
						<?php esc_html_e( 'Search Suggestions:', 'pinterhvn-theme' ); ?>
					</h3>
					<ul style="list-style: disc; margin-left: 1.5rem; color: #64748b;">
						<li><?php esc_html_e( 'Check your spelling', 'pinterhvn-theme' ); ?></li>
						<li><?php esc_html_e( 'Try more general keywords', 'pinterhvn-theme' ); ?></li>
						<li><?php esc_html_e( 'Try different keywords', 'pinterhvn-theme' ); ?></li>
						<li><?php esc_html_e( 'Browse all assets instead', 'pinterhvn-theme' ); ?></li>
					</ul>
				</div>

				<div class="mt-4">
					<a href="<?php echo esc_url( get_post_type_archive_link( 'digital_asset' ) ); ?>" class="btn btn-primary">
						<?php esc_html_e( 'Browse All Assets', 'pinterhvn-theme' ); ?>
					</a>
				</div>
			</div>

		<?php endif; ?>

	</div>
</main>

<?php
get_footer();
