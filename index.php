<?php
/**
 * The main template file
 *
 * @package PinterHVN_Theme
 * @since 1.0.0
 */

get_header();
?>

<main id="primary" class="site-main">
	<div class="container">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<?php
				the_archive_title( '<h1 class="page-title">', '</h1>' );
				the_archive_description( '<div class="archive-description">', '</div>' );
				?>
			</header>

			<div class="pinterhvn-grid" id="assets-grid">
				<div class="grid-sizer"></div>
				
				<?php
				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/content', 'asset-card' );
				endwhile;
				?>
			</div>

			<?php
			// Pagination
			pinterhvn_pagination();
			?>

			<!-- Load More Button (for infinite scroll) -->
			<div class="load-more-wrapper text-center mt-4" style="display: none;">
				<button class="btn btn-primary" id="load-more-assets">
					<?php _e( 'Load More', 'pinterhvn-theme' ); ?>
				</button>
				<div class="spinner" style="display: none;"></div>
			</div>

		<?php else : ?>

			<div class="no-results">
				<h2><?php _e( 'Nothing Found', 'pinterhvn-theme' ); ?></h2>
				<p><?php _e( 'No assets found. Try uploading some!', 'pinterhvn-theme' ); ?></p>
				
				<?php if ( is_user_logged_in() && current_user_can( 'edit_posts' ) ) : ?>
					<a href="<?php echo esc_url( home_url( '/upload-asset/' ) ); ?>" class="btn btn-primary">
						<?php _e( 'Upload Asset', 'pinterhvn-theme' ); ?>
					</a>
				<?php endif; ?>
			</div>

		<?php endif; ?>

	</div>
</main>

<?php
get_footer();
