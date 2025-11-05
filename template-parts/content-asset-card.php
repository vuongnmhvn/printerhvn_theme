<?php
/**
 * Template part for displaying asset cards
 *
 * @package PinterHVN_Theme
 * @since 1.0.0
 */

$asset_id = get_the_ID();
$asset_link = get_post_meta( $asset_id, '_pinterhvn_asset_link', true );
$view_count = get_post_meta( $asset_id, '_pinterhvn_view_count', true );
$save_count = get_post_meta( $asset_id, '_pinterhvn_save_count', true );
$download_count = get_post_meta( $asset_id, '_pinterhvn_download_count', true );

// Default values
$view_count = $view_count ? intval( $view_count ) : 0;
$save_count = $save_count ? intval( $save_count ) : 0;
$download_count = $download_count ? intval( $download_count ) : 0;
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'grid-item asset-card fade-in' ); ?> data-asset-id="<?php echo esc_attr( $asset_id ); ?>">
	
	<!-- Asset Image/Video -->
	<div class="asset-card-image">
		<a href="<?php the_permalink(); ?>">
			<?php
			if ( has_post_thumbnail() ) {
				$thumbnail_id = get_post_thumbnail_id();
				$mime_type = get_post_mime_type( $thumbnail_id );
				$attachment_url = wp_get_attachment_url( $thumbnail_id );
				$file_extension = strtolower( pathinfo( $attachment_url, PATHINFO_EXTENSION ) );

				if ( strpos( $mime_type, 'video' ) === 0 || $file_extension === 'mp4' ) {
					// Video thumbnail - Auto-play on hover, loop
					?>
					<video class="asset-video" muted loop playsinline preload="metadata">
						<source src="<?php echo esc_url( $attachment_url ); ?>" type="<?php echo esc_attr( $mime_type ); ?>">
					</video>
					<?php
				} elseif ( $file_extension === 'gif' || $mime_type === 'image/gif' ) {
					// GIF - Always animated
					?>
					<img src="<?php echo esc_url( $attachment_url ); ?>" 
					     alt="<?php echo esc_attr( get_the_title() ); ?>" 
					     class="asset-gif"
					     loading="lazy">
					<?php
				} else {
					// Regular image
					the_post_thumbnail( 'pinterhvn-medium', array(
						'alt' => get_the_title(),
						'loading' => 'lazy',
					) );
				}
			} else {
				// Placeholder
				?>
				<div class="asset-placeholder" style="width: 100%; padding-bottom: 75%; background: #f1f5f9; display: flex; align-items: center; justify-content: center;">
					<svg width="64" height="64" fill="none" viewBox="0 0 24 24" stroke="currentColor">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
					</svg>
				</div>
				<?php
			}
			?>
		</a>

		<!-- Hover Overlay -->
		<div class="asset-card-overlay">
			<div class="asset-card-actions">
				<?php if ( is_user_logged_in() ) : ?>
					<button 
						class="asset-card-action save-btn" 
						data-asset-id="<?php echo esc_attr( $asset_id ); ?>"
						title="<?php esc_attr_e( 'Save to Collection', 'pinterhvn-theme' ); ?>"
					>
						<svg width="16" height="16" viewBox="0 0 20 20" fill="currentColor">
							<path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"/>
						</svg>
						<?php _e( 'Save', 'pinterhvn-theme' ); ?>
					</button>
				<?php endif; ?>

				<button 
					class="asset-card-action share-btn" 
					data-asset-id="<?php echo esc_attr( $asset_id ); ?>"
					data-url="<?php the_permalink(); ?>"
					title="<?php esc_attr_e( 'Share', 'pinterhvn-theme' ); ?>"
				>
					<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
						<circle cx="18" cy="5" r="3" stroke-width="2"></circle>
						<circle cx="6" cy="12" r="3" stroke-width="2"></circle>
						<circle cx="18" cy="19" r="3" stroke-width="2"></circle>
						<line x1="8.59" y1="13.51" x2="15.42" y2="17.49" stroke-width="2"></line>
						<line x1="15.41" y1="6.51" x2="8.59" y2="10.49" stroke-width="2"></line>
					</svg>
					<?php _e( '', 'pinterhvn-theme' ); ?>
				</button>

				<?php if ( $asset_link ) : ?>
					<a 
						href="<?php echo esc_url( pinterhvn_get_asset_download_link( $asset_id ) ); ?>" 
						class="asset-card-action download-btn"
						target="_blank"
						title="<?php esc_attr_e( 'Download', 'pinterhvn-theme' ); ?>"
					>
						<svg width="16" height="16" viewBox="0 0 20 20" fill="currentColor">
							<path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"/>
						</svg>
						<?php _e( '', 'pinterhvn-theme' ); ?>
					</a>
				<?php endif; ?>
			</div>
		</div>
	</div>

	<!-- Asset Content -->
	<div class="asset-card-content">
		<h3 class="asset-card-title">
			<a href="<?php the_permalink(); ?>">
				<?php the_title(); ?>
			</a>
		</h3>

		<!-- Author Meta -->
		<div class="asset-card-meta">
			<div class="asset-card-author">
				<?php echo get_avatar( get_the_author_meta( 'ID' ), 24, '', '', array( 'class' => 'asset-card-author-avatar' ) ); ?>
				<span class="author-name">
					<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
						<?php the_author(); ?>
					</a>
				</span>
			</div>
		</div>

		<!-- Categories (optional) -->
		<?php
		$categories = get_the_terms( $asset_id, 'asset_category' );
		if ( $categories && ! is_wp_error( $categories ) ) :
			?>
			<div class="asset-card-categories mt-1">
				<?php
				foreach ( array_slice( $categories, 0, 2 ) as $category ) {
					echo '<a href="' . esc_url( get_term_link( $category ) ) . '" class="asset-category-badge">' . 
					     esc_html( $category->name ) . '</a>';
				}
				if ( count( $categories ) > 2 ) {
					echo '<span class="more-categories">+' . ( count( $categories ) - 2 ) . '</span>';
				}
				?>
			</div>
			<?php
		endif;
		?>
	</div>

</article>

<style>
.asset-category-badge {
	display: inline-block;
	padding: 0.25rem 0.5rem;
	background: #f1f5f9;
	color: #64748b;
	font-size: 0.75rem;
	border-radius: 4px;
	margin-right: 0.25rem;
	margin-top: 0.25rem;
	transition: all 0.2s ease;
}

.asset-category-badge:hover {
	background: #f63b3bff;
	color: #ffffff;
}

.more-categories {
	display: inline-block;
	padding: 0.25rem 0.5rem;
	background: #f1f5f9;
	color: #64748b;
	font-size: 0.75rem;
	border-radius: 4px;
	margin-top: 0.25rem;
}
</style>
