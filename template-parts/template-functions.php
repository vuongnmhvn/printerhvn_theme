<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package PinterHVN_Theme
 * @since 1.0.0
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function pinterhvn_body_classes_extra( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'pinterhvn_body_classes_extra' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function pinterhvn_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'pinterhvn_pingback_header' );

/**
 * Get asset thumbnail URL
 *
 * @param int    $post_id Post ID.
 * @param string $size    Image size.
 * @return string|false
 */
function pinterhvn_get_asset_thumbnail_url( $post_id = 0, $size = 'pinterhvn-medium' ) {
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}

	if ( has_post_thumbnail( $post_id ) ) {
		$thumbnail_id = get_post_thumbnail_id( $post_id );
		$thumbnail_url = wp_get_attachment_image_url( $thumbnail_id, $size );
		
		return $thumbnail_url;
	}

	return false;
}

/**
 * Get asset type (image or video)
 *
 * @param int $post_id Post ID.
 * @return string 'image', 'video', or 'unknown'
 */
function pinterhvn_get_asset_type( $post_id = 0 ) {
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}

	if ( ! has_post_thumbnail( $post_id ) ) {
		return 'unknown';
	}

	$thumbnail_id = get_post_thumbnail_id( $post_id );
	$mime_type = get_post_mime_type( $thumbnail_id );

	if ( strpos( $mime_type, 'image' ) === 0 ) {
		return 'image';
	} elseif ( strpos( $mime_type, 'video' ) === 0 ) {
		return 'video';
	}

	return 'unknown';
}

/**
 * Format relative time
 *
 * @param string $date Date string.
 * @return string
 */
function pinterhvn_time_ago( $date ) {
	if ( empty( $date ) ) {
		return '';
	}

	$timestamp = strtotime( $date );
	$diff = time() - $timestamp;

	if ( $diff < 60 ) {
		return __( 'just now', 'pinterhvn-theme' );
	}

	$intervals = array(
		31536000 => __( 'year', 'pinterhvn-theme' ),
		2592000  => __( 'month', 'pinterhvn-theme' ),
		604800   => __( 'week', 'pinterhvn-theme' ),
		86400    => __( 'day', 'pinterhvn-theme' ),
		3600     => __( 'hour', 'pinterhvn-theme' ),
		60       => __( 'minute', 'pinterhvn-theme' ),
	);

	foreach ( $intervals as $seconds => $label ) {
		$count = floor( $diff / $seconds );
		if ( $count >= 1 ) {
			return sprintf(
				/* translators: 1: count, 2: time unit */
				_n( '%1$s %2$s ago', '%1$s %2$ss ago', $count, 'pinterhvn-theme' ),
				$count,
				$label
			);
		}
	}

	return '';
}

/**
 * Truncate text
 *
 * @param string $text   Text to truncate.
 * @param int    $length Max length.
 * @param string $suffix Suffix to add.
 * @return string
 */
function pinterhvn_truncate_text( $text, $length = 100, $suffix = '...' ) {
	if ( mb_strlen( $text ) <= $length ) {
		return $text;
	}

	return mb_substr( $text, 0, $length ) . $suffix;
}

/**
 * Get breadcrumbs
 *
 * @return string
 */
function pinterhvn_get_breadcrumbs() {
	if ( is_front_page() ) {
		return '';
	}

	$breadcrumbs = array();
	
	// Home
	$breadcrumbs[] = '<a href="' . esc_url( home_url( '/' ) ) . '">' . __( 'Home', 'pinterhvn-theme' ) . '</a>';

	if ( is_singular( 'digital_asset' ) ) {
		$breadcrumbs[] = '<a href="' . esc_url( get_post_type_archive_link( 'digital_asset' ) ) . '">' . __( 'Assets', 'pinterhvn-theme' ) . '</a>';
		
		$categories = get_the_terms( get_the_ID(), 'asset_category' );
		if ( $categories && ! is_wp_error( $categories ) ) {
			$category = array_shift( $categories );
			$breadcrumbs[] = '<a href="' . esc_url( get_term_link( $category ) ) . '">' . esc_html( $category->name ) . '</a>';
		}
		
		$breadcrumbs[] = '<span>' . get_the_title() . '</span>';
	} elseif ( is_tax( array( 'asset_category', 'asset_tag', 'asset_collection' ) ) ) {
		$breadcrumbs[] = '<a href="' . esc_url( get_post_type_archive_link( 'digital_asset' ) ) . '">' . __( 'Assets', 'pinterhvn-theme' ) . '</a>';
		$breadcrumbs[] = '<span>' . single_term_title( '', false ) . '</span>';
	} elseif ( is_post_type_archive( 'digital_asset' ) ) {
		$breadcrumbs[] = '<span>' . __( 'Assets', 'pinterhvn-theme' ) . '</span>';
	} elseif ( is_search() ) {
		$breadcrumbs[] = '<span>' . sprintf( __( 'Search Results for "%s"', 'pinterhvn-theme' ), get_search_query() ) . '</span>';
	} elseif ( is_404() ) {
		$breadcrumbs[] = '<span>' . __( '404 Not Found', 'pinterhvn-theme' ) . '</span>';
	}

	if ( empty( $breadcrumbs ) ) {
		return '';
	}

	return '<nav class="breadcrumbs" aria-label="' . esc_attr__( 'Breadcrumb', 'pinterhvn-theme' ) . '">' . implode( ' <span class="separator">/</span> ', $breadcrumbs ) . '</nav>';
}

/**
 * Check if asset is saved by current user
 *
 * @param int $asset_id   Asset post ID.
 * @param int $collection_id Collection term ID (optional).
 * @return bool
 */
function pinterhvn_is_asset_saved( $asset_id, $collection_id = 0 ) {
	if ( ! is_user_logged_in() ) {
		return false;
	}

	if ( $collection_id ) {
		return has_term( $collection_id, 'asset_collection', $asset_id );
	}

	// Check any collection
	$collections = wp_get_post_terms( $asset_id, 'asset_collection' );
	return ! empty( $collections );
}

/**
 * Get user's avatar URL
 *
 * @param int $user_id User ID.
 * @param int $size    Avatar size.
 * @return string
 */
function pinterhvn_get_user_avatar_url( $user_id = 0, $size = 96 ) {
	if ( ! $user_id ) {
		$user_id = get_current_user_id();
	}

	$avatar = get_avatar_url( $user_id, array( 'size' => $size ) );
	
	return $avatar;
}

/**
 * Get asset permalink with tracking
 *
 * @param int $post_id Post ID.
 * @return string
 */
function pinterhvn_get_tracked_permalink( $post_id = 0 ) {
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}

	$permalink = get_permalink( $post_id );

	// Add tracking parameters if needed
	if ( isset( $_GET['ref'] ) ) {
		$permalink = add_query_arg( 'ref', sanitize_text_field( $_GET['ref'] ), $permalink );
	}

	return $permalink;
}
