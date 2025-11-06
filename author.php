<?php
/**
 * The template for displaying author archive pages
 *
 * @package PinterHVN_Theme
 * @since 1.0.0
 */

get_header();

// Get author data
$author = get_queried_object();
$author_id = $author->ID;
?>

<main id="primary" class="site-main">
	<div class="container-fluid">

		<header class="page-header author-header text-center" style="margin-bottom: 3rem; padding-top: 2rem;">
			<div class="author-avatar" style="margin-bottom: 1rem;">
				<?php echo get_avatar( $author_id, 120, '', '', array( 'class' => 'mx-auto rounded-full' ) ); ?>
			</div>
			<h1 class="page-title author-name"><?php echo esc_html( $author->display_name ); ?></h1>
			<?php
			$description = get_the_author_meta( 'description', $author_id );
			if ( $description ) :
				?>
				<div class="author-bio" style="color: #64748b; font-size: 1.125rem; max-width: 700px; margin: 0.5rem auto 0;">
					<?php echo wp_kses_post( $description ); ?>
				</div>
			<?php endif; ?>
		</header>

		<?php
		// Query digital assets for this author
		$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
		
		$settings = get_option( 'pinterhvn_core_settings', array() );
		$posts_per_page = isset( $settings['assets_per_page'] ) ? $settings['assets_per_page'] : 12;

		$args = array(
			'post_type'      => 'digital_asset',
			'posts_per_page' => $posts_per_page,
			'paged'          => $paged,
			'author'         => $author_id,
		);

		$asset_query = new WP_Query( $args );

		if ( $asset_query->have_posts() ) : ?>

			<!-- Masonry Grid -->
			<div class="pinterhvn-grid" id="assets-grid" data-author-id="<?php echo esc_attr( $author_id ); ?>">
				<div class="grid-sizer"></div>
				
				<?php
				while ( $asset_query->have_posts() ) :
					$asset_query->the_post();
					get_template_part( 'template-parts/content', 'asset-card' );
				endwhile;
				?>
			</div>

			<?php
			// Hidden pagination for JS to use
			echo '<nav class="pagination" role="navigation" style="display: none;">';
			echo paginate_links( array(
				'base'      => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
				'format'    => '?paged=%#%',
				'current'   => max( 1, $paged ),
				'total'     => $asset_query->max_num_pages,
				'type'      => 'list',
			) );
			echo '</nav>';

			wp_reset_postdata();
			?>

			<!-- Load More Button -->
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
			<div class="no-results text-center" style="padding: 2rem;">
				<p style="color: #64748b; font-size: 1.125rem;">
					<?php _e( 'This author has not uploaded any assets yet.', 'pinterhvn-theme' ); ?>
				</p>
			</div>

		<?php endif; ?>

	</div>
</main>

<?php
get_footer();