<?php
/**
 * Taxonomy template for asset categories, tags, and collections
 *
 * @package PinterHVN_Theme
 * @since 1.0.0
 */

get_header();
?>

<main id="primary" class="site-main">
	<div class="container">

		<header class="page-header">
			<?php
			$term = get_queried_object();
			$taxonomy = get_taxonomy( $term->taxonomy );
			?>
			
			<div class="term-header" style="display: flex; align-items: center; gap: 1.5rem; margin-bottom: 1rem;">
				<?php
				// Display category thumbnail if available
				if ( $term->taxonomy === 'asset_category' ) {
					$thumbnail = get_term_meta( $term->term_id, 'term_thumbnail', true );
					if ( $thumbnail ) {
						echo '<div class="term-thumbnail" style="width: 100px; height: 100px; border-radius: 50%; overflow: hidden; background: #f1f5f9;">';
						echo '<img src="' . esc_url( $thumbnail ) . '" alt="' . esc_attr( $term->name ) . '" style="width: 100%; height: 100%; object-fit: cover;">';
						echo '</div>';
					}
				}
				?>

				<div class="term-info">
					<div class="term-meta" style="font-size: 0.875rem; color: #64748b; margin-bottom: 0.5rem;">
						<?php echo esc_html( $taxonomy->labels->singular_name ); ?>
					</div>
					
					<h1 class="page-title" style="margin-bottom: 0.5rem;">
						<?php single_term_title(); ?>
					</h1>

					<div class="term-count" style="color: #64748b;">
						<?php
						printf(
							_n(
								'%s asset',
								'%s assets',
								$term->count,
								'pinterhvn-theme'
							),
							number_format_i18n( $term->count )
						);
						?>
					</div>
				</div>
			</div>

			<?php if ( term_description() ) : ?>
				<div class="term-description" style="color: #475569; font-size: 1.125rem; margin-bottom: 2rem;">
					<?php echo term_description(); ?>
				</div>
			<?php endif; ?>
		</header>

		<?php if ( have_posts() ) : ?>

			<div class="pinterhvn-grid" id="assets-grid">
				<div class="grid-sizer"></div>
				
				<?php
				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/content', 'asset-card' );
				endwhile;
				?>
			</div>

			<?php pinterhvn_pagination(); ?>

			<div class="load-more-wrapper text-center mt-4">
				<button class="btn btn-primary" id="load-more-assets">
					<?php _e( 'Tải thêm', 'pinterhvn-theme' ); ?>
				</button>
				<div class="spinner" style="display: none;"></div>
			</div>

		<?php else : ?>

			<div class="no-results text-center" style="padding: 4rem 2rem;">
				<svg width="128" height="128" viewBox="0 0 24 24" fill="none" stroke="currentColor" style="opacity: 0.2; margin: 0 auto 2rem;">
					<rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
					<circle cx="8.5" cy="8.5" r="1.5"/>
					<polyline points="21 15 16 10 5 21"/>
				</svg>
				
				<h2 style="font-size: 2rem; margin-bottom: 1rem;">
					<?php _e( 'No Assets in This Collection', 'pinterhvn-theme' ); ?>
				</h2>
				
				<p style="color: #64748b; margin-bottom: 2rem;">
					<?php _e( 'This collection is empty. Start adding assets to build your collection!', 'pinterhvn-theme' ); ?>
				</p>

				<a href="<?php echo esc_url( get_post_type_archive_link( 'digital_asset' ) ); ?>" class="btn btn-primary">
					<?php _e( 'Browse All Assets', 'pinterhvn-theme' ); ?>
				</a>
			</div>

		<?php endif; ?>

	</div>
</main>

<?php
get_footer();
