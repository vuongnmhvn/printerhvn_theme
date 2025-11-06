<?php
/**
 * Archive template for digital assets
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
				<?php post_type_archive_title(); ?>
			</h1>
			<?php
			$post_type_obj = get_post_type_object( 'digital_asset' );
			if ( $post_type_obj && ! empty( $post_type_obj->description ) ) {
				echo '<div class="archive-description">' . wp_kses_post( $post_type_obj->description ) . '</div>';
			}
			?>
		</header>

		<div class="archive-filters" style="margin-bottom: 2rem;">
			<!-- Categories List -->
			<?php
			$categories = get_terms( array(
				'taxonomy'   => 'asset_category',
				'hide_empty' => true,
			) );

			if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) :
				?>
				<div class="filter-section" style="margin-bottom: 1.5rem;">
					<h3 class="filter-title" style="font-size: 1.25rem; font-weight: 600; margin-bottom: 1rem;">
						<?php _e( 'Danh mục', 'pinterhvn-theme' ); ?>
					</h3>
					<div class="filter-chips" style="display: flex; flex-wrap: wrap; gap: 0.75rem;">
						<?php foreach ( $categories as $category ) : ?> 
							<a href="<?php echo esc_url( get_term_link( $category ) ); ?>" class="filter-chip">
								<?php echo esc_html( $category->name ); ?>
							</a>
						<?php endforeach; ?>
					</div>
				</div>
			<?php endif; ?>

			<!-- Tags List -->
			<?php
			$tags = get_terms( array(
				'taxonomy'   => 'asset_tag',
				'hide_empty' => true,
			) );

			if ( ! empty( $tags ) && ! is_wp_error( $tags ) ) :
				?>
				<div class="filter-section">
					<h3 class="filter-title" style="font-size: 1.25rem; font-weight: 600; margin-bottom: 1rem;">
						<?php _e( 'Chủ đề', 'pinterhvn-theme' ); ?>
					</h3>
					<div class="filter-chips" style="display: flex; flex-wrap: wrap; gap: 0.75rem;">
						<?php foreach ( $tags as $tag ) : ?> 
							<a href="<?php echo esc_url( get_term_link( $tag ) ); ?>" class="filter-chip">
								#<?php echo esc_html( $tag->name ); ?>
							</a>
						<?php endforeach; ?>
					</div>
				</div>
			<?php endif; ?>
		</div>

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
					<?php _e( 'Chưa có tài nguyên nào', 'pinterhvn-theme' ); ?>
				</h2>
				
				<p style="color: #64748b; margin-bottom: 2rem;">
					<?php _e( 'Bắt đầu xây dựng thư viện tài sản kỹ thuật số của bạn bằng cách tải lên tài sản đầu tiên.', 'pinterhvn-theme' ); ?>
				</p>
				
				<?php if ( is_user_logged_in() && current_user_can( 'edit_posts' ) ) : ?>
					<a href="<?php echo esc_url( home_url( '/upload-asset/' ) ); ?>" class="btn btn-primary">
						<svg width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor" style="margin-right: 0.5rem;">
							<path d="M10 4V16M4 10H16" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
						</svg>
						<?php _e( 'Tải lên tài nguyên', 'pinterhvn-theme' ); ?>
					</a>
				<?php endif; ?>
			</div>

		<?php endif; ?>

	</div>
</main>

<?php
get_footer();
