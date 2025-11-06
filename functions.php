<?php
/**
 * PinterHVN Theme Functions
 *
 * @package PinterHVN_Theme
 * @since 1.0.0
 */

// Nếu file được gọi trực tiếp, dừng lại
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Define constants
 */
define( 'PINTERHVN_THEME_VERSION', '1.0.0' );
define( 'PINTERHVN_THEME_DIR', get_template_directory() );
define( 'PINTERHVN_THEME_URI', get_template_directory_uri() );

/**
 * Theme Setup
 */
function pinterhvn_theme_setup() {
	
	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// Let WordPress manage the document title
	add_theme_support( 'title-tag' );

	// Enable support for Post Thumbnails
	add_theme_support( 'post-thumbnails' );

	// Custom image sizes
	add_image_size( 'pinterhvn-small', 400, 9999, false );
	add_image_size( 'pinterhvn-medium', 600, 9999, false );
	add_image_size( 'pinterhvn-large', 800, 9999, false );

	// Register navigation menus
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'pinterhvn-theme' ),
		'footer'  => __( 'Footer Menu', 'pinterhvn-theme' ),
	) );

	// Switch default core markup to output valid HTML5
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
		'style',
		'script',
	) );

	// Add theme support for selective refresh for widgets
	add_theme_support( 'customize-selective-refresh-widgets' );

	// Add support for custom logo
	add_theme_support( 'custom-logo', array(
		'height'      => 100,
		'width'       => 100,
		'flex-height' => true,
		'flex-width'  => true,
	) );
}
add_action( 'after_setup_theme', 'pinterhvn_theme_setup' );

/**
 * Allow GIF and MP4 uploads
 */
function pinterhvn_allow_gif_mp4_uploads( $mimes ) {
	if ( ! isset( $mimes['gif'] ) ) {
		$mimes['gif'] = 'image/gif';
	}
	if ( ! isset( $mimes['mp4'] ) ) {
		$mimes['mp4'] = 'video/mp4';
	}
	if ( ! isset( $mimes['m4v'] ) ) {
		$mimes['m4v'] = 'video/mp4';
	}
	return $mimes;
}
add_filter( 'upload_mimes', 'pinterhvn_allow_gif_mp4_uploads' );

/**
 * Increase upload size limit
 */
function pinterhvn_increase_upload_size( $size ) {
	return 200 * 1024 * 1024;
}
add_filter( 'upload_size_limit', 'pinterhvn_increase_upload_size' );

/**
 * Set content width
 */
function pinterhvn_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'pinterhvn_content_width', 1400 );
}
add_action( 'after_setup_theme', 'pinterhvn_content_width', 0 );

/**
 * Register widget areas
 */
function pinterhvn_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'pinterhvn-theme' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Add widgets here.', 'pinterhvn-theme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'pinterhvn_widgets_init' );

/**
 * Enqueue scripts and styles
 */
function pinterhvn_scripts() {
	
	wp_enqueue_style( 'pinterhvn-style', get_stylesheet_uri(), array(), PINTERHVN_THEME_VERSION );
	wp_enqueue_script( 'masonry' );
	wp_enqueue_script( 'imagesloaded' );
	
	wp_enqueue_script(
		'pinterhvn-main',
		PINTERHVN_THEME_URI . '/assets/js/main.js',
		array( 'jquery', 'masonry', 'imagesloaded' ),
		PINTERHVN_THEME_VERSION,
		true
	);

	// Navigation & Menus
	wp_enqueue_script(
		'pinterhvn-navigation',
		PINTERHVN_THEME_URI . '/assets/js/navigation.js',
		array( 'jquery' ),
		PINTERHVN_THEME_VERSION,
		true
	);

	// Share & Notifications
	wp_enqueue_script(
		'pinterhvn-share',
		PINTERHVN_THEME_URI . '/assets/js/share-notifications.js',
		array( 'jquery' ),
		PINTERHVN_THEME_VERSION,
		true
	);

	// Save to Collection
	wp_enqueue_script(
		'pinterhvn-save-collection',
		PINTERHVN_THEME_URI . '/assets/js/save-to-collection.js',
		array( 'jquery', 'pinterhvn-share' ),
		PINTERHVN_THEME_VERSION,
		true
	);

	wp_localize_script(
		'pinterhvn-main',
		'pinterhvnTheme',
		array(
			'ajax_url'      => admin_url( 'admin-ajax.php' ),
			'nonce'         => wp_create_nonce( 'pinterhvn_ajax_nonce' ),
			'loading_text'  => __( 'Loading...', 'pinterhvn-theme' ),
			'no_more_posts' => __( 'No more assets to load.', 'pinterhvn-theme' ),
		)
	);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'pinterhvn_scripts' );

/**
 * Load custom files
 */
$inc_files = array(
	get_template_directory() . '/inc/template-tags.php',
	get_template_directory() . '/inc/template-functions.php',
	get_template_directory() . '/inc/customizer.php',
);

foreach ( $inc_files as $inc_file ) {
	if ( file_exists( $inc_file ) ) {
		require_once $inc_file;
	}
}

// Additional theme functions...
function pinterhvn_excerpt_length( $length ) { return 20; }
add_filter( 'excerpt_length', 'pinterhvn_excerpt_length' );

function pinterhvn_excerpt_more( $more ) { return '...'; }
add_filter( 'excerpt_more', 'pinterhvn_excerpt_more' );

function pinterhvn_modify_archive_query( $query ) {
	if ( is_admin() || ! $query->is_main_query() ) return;
	if ( is_post_type_archive( 'digital_asset' ) || is_tax( array( 'asset_category', 'asset_tag', 'asset_collection' ) ) ) {
		$settings = get_option( 'pinterhvn_core_settings', array() );
		$posts_per_page = isset( $settings['assets_per_page'] ) ? $settings['assets_per_page'] : 12;
		$query->set( 'posts_per_page', $posts_per_page );
		$query->set( 'orderby', 'date' );
		$query->set( 'order', 'DESC' );
	}
}
add_action( 'pre_get_posts', 'pinterhvn_modify_archive_query' );

function pinterhvn_body_classes( $classes ) {
	if ( is_post_type_archive( 'digital_asset' ) || is_tax( array( 'asset_category', 'asset_tag', 'asset_collection' ) ) ) {
		$classes[] = 'has-masonry-layout';
	}
	if ( is_singular( 'digital_asset' ) ) {
		$classes[] = 'single-digital-asset';
	}
	return $classes;
}
add_filter( 'body_class', 'pinterhvn_body_classes' );

function pinterhvn_track_asset_view() {
	if ( ! is_singular( 'digital_asset' ) ) return;
	global $post;
	if ( ! $post ) return;
	if ( ! session_id() ) session_start();
	$session_key = 'pinterhvn_viewed_' . $post->ID;
	if ( isset( $_SESSION[ $session_key ] ) ) return;
	if ( function_exists( 'pinterhvn_increment_view_count' ) ) {
		pinterhvn_increment_view_count( $post->ID );
		$_SESSION[ $session_key ] = true;
	}
}
add_action( 'wp_head', 'pinterhvn_track_asset_view' );

/**
 * Helper function to remove Vietnamese accents.
 *
 * @param string $str The string to remove accents from.
 * @return string String without accents.
 */
function pinterhvn_remove_accents( $str ) {
    $str = preg_replace( '/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/', 'a', $str );
    $str = preg_replace( '/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/', 'e', $str );
    $str = preg_replace( '/(ì|í|ị|ỉ|ĩ)/', 'i', $str );
    $str = preg_replace( '/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/', 'o', $str );
    $str = preg_replace( '/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/', 'u', $str );
    $str = preg_replace( '/(ỳ|ý|ỵ|ỷ|ỹ)/', 'y', $str );
    $str = preg_replace( '/(đ)/', 'd', $str );
    $str = preg_replace( '/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/', 'A', $str );
    $str = preg_replace( '/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/', 'E', $str );
    $str = preg_replace( '/(Ì|Í|Ị|Ỉ|Ĩ)/', 'I', $str );
    $str = preg_replace( '/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/', 'O', $str );
    $str = preg_replace( '/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/', 'U', $str );
    $str = preg_replace( '/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/', 'Y', $str );
    $str = preg_replace( '/(Đ)/', 'D', $str );
    return $str;
}

/**
 * Advanced search functionality.
 * - Searches both accented and unaccented keywords.
 * - Searches in post title, content, and 'asset_tag' taxonomy.
 * - Orders results by relevance.
 */
function pinterhvn_advanced_search_filter( $query ) {
    if ( is_admin() || ! $query->is_main_query() || ! $query->is_search() ) {
        return;
    }

    $search_term = $query->get( 's' );
    if ( empty( $search_term ) ) {
        return;
    }

    $query->set( 'post_type', 'digital_asset' );
    // Suppress filters to avoid conflicts with other plugins/themes
    $query->set( 'suppress_filters', false );

    // Remove the default search filter
    remove_filter( 'posts_search', '_filter_posts_search', 10, 2 );

    add_filter( 'posts_fields', 'pinterhvn_search_fields', 10, 2 );
    add_filter( 'posts_join', 'pinterhvn_search_join', 10, 2 );
    add_filter( 'posts_where', 'pinterhvn_search_where', 10, 2 );
    add_filter( 'posts_orderby', 'pinterhvn_search_orderby', 10, 2 );
    add_filter( 'posts_groupby', 'pinterhvn_search_groupby', 10, 2 );
}
add_action( 'pre_get_posts', 'pinterhvn_advanced_search_filter' );

function pinterhvn_search_fields( $fields, $query ) {
    global $wpdb;
    $search_term = $query->get( 's' );
    $like = '%' . $wpdb->esc_like( $search_term ) . '%';

    $relevance = $wpdb->prepare( "
        (CASE WHEN {$wpdb->posts}.post_title LIKE %s COLLATE utf8mb4_unicode_ci THEN 10 ELSE 0 END) +
        (CASE WHEN terms.name LIKE %s COLLATE utf8mb4_unicode_ci THEN 5 ELSE 0 END) +
        (CASE WHEN {$wpdb->posts}.post_content LIKE %s COLLATE utf8mb4_unicode_ci THEN 2 ELSE 0 END)
    ", $like, $like, $like );

    return $fields . ", " . $relevance . " AS relevance";
}

function pinterhvn_search_join( $join, $query ) {
    global $wpdb;
    $join .= " LEFT JOIN {$wpdb->term_relationships} tr ON {$wpdb->posts}.ID = tr.object_id ";
    $join .= " LEFT JOIN {$wpdb->term_taxonomy} tt ON tr.term_taxonomy_id = tt.term_taxonomy_id AND tt.taxonomy = 'asset_tag' ";
    $join .= " LEFT JOIN {$wpdb->terms} terms ON tt.term_id = terms.term_id ";
    return $join;
}

function pinterhvn_search_where( $where, $query ) {
    global $wpdb;
    $search_term = $query->get( 's' );

    $like = '%' . $wpdb->esc_like( $search_term ) . '%';
    
    // Build our own WHERE clause
    $where = $wpdb->prepare( " AND (
        ({$wpdb->posts}.post_title LIKE %s COLLATE utf8mb4_unicode_ci) OR
        ({$wpdb->posts}.post_content LIKE %s COLLATE utf8mb4_unicode_ci) OR
        (terms.name LIKE %s COLLATE utf8mb4_unicode_ci)
    )", $like, $like, $like );

    return $where;
}

function pinterhvn_search_orderby( $orderby, $query ) {
    if ( $query->is_search() ) {
        return "relevance DESC, post_date DESC";
    }
    return $orderby;
}

function pinterhvn_search_groupby( $groupby, $query ) {
    global $wpdb;
    if ( $query->is_search() ) {
        return "{$wpdb->posts}.ID";
    }
    return $groupby;
}

function pinterhvn_get_user_collections( $user_id = 0 ) {
	if ( ! $user_id ) $user_id = get_current_user_id();
	if ( ! $user_id ) return array();
	if ( class_exists( 'PinterHVN_Asset_AJAX_Handler' ) && method_exists( 'PinterHVN_Asset_AJAX_Handler', 'get_user_collections' ) ) {
		return PinterHVN_Asset_AJAX_Handler::get_user_collections( $user_id );
	}
	return get_terms( array( 'taxonomy' => 'asset_collection', 'hide_empty' => false ) );
}

function pinterhvn_can_edit_asset( $post_id = 0, $user_id = 0 ) {
	if ( ! $post_id ) {
		global $post;
		if ( ! $post ) return false;
		$post_id = $post->ID;
	}
	if ( ! $user_id ) $user_id = get_current_user_id();
	if ( ! $user_id ) return false;
	$post = get_post( $post_id );
	if ( ! $post ) return false;
	if ( $post->post_author == $user_id ) return true;
	if ( current_user_can( 'edit_others_posts' ) ) return true;
	return false;
}

function pinterhvn_get_related_assets( $post_id = 0, $limit = 6 ) {
	if ( ! $post_id ) {
		global $post;
		if ( ! $post ) return array();
		$post_id = $post->ID;
	}
	$categories = wp_get_post_terms( $post_id, 'asset_category', array( 'fields' => 'ids' ) );
	if ( empty( $categories ) || is_wp_error( $categories ) ) return array();
	$args = array(
		'post_type'      => 'digital_asset',
		'posts_per_page' => $limit,
		'post__not_in'   => array( $post_id ),
		'orderby'        => 'rand',
		'tax_query'      => array(
			array(
				'taxonomy' => 'asset_category',
				'field'    => 'term_id',
				'terms'    => $categories,
			),
		),
	);
	$query = new WP_Query( $args );
	return $query->posts;
}

function pinterhvn_get_asset_download_link( $post_id ) {
	$asset_link = get_post_meta( $post_id, '_pinterhvn_asset_link', true );
	if ( ! $asset_link ) return '#';
	return add_query_arg( array(
		'pinterhvn_download' => $post_id,
		'nonce'              => wp_create_nonce( 'pinterhvn_download_' . $post_id ),
	), home_url() );
}

function pinterhvn_handle_download_tracking() {
	if ( ! isset( $_GET['pinterhvn_download'] ) ) return;
	$post_id = intval( $_GET['pinterhvn_download'] );
	$nonce = isset( $_GET['nonce'] ) ? $_GET['nonce'] : '';
	if ( ! wp_verify_nonce( $nonce, 'pinterhvn_download_' . $post_id ) ) return;
	if ( function_exists( 'pinterhvn_increment_download_count' ) ) {
		pinterhvn_increment_download_count( $post_id );
	}
	$asset_link = get_post_meta( $post_id, '_pinterhvn_asset_link', true );
	if ( $asset_link ) {
		wp_redirect( $asset_link );
		exit;
	}
}
add_action( 'template_redirect', 'pinterhvn_handle_download_tracking' );

function pinterhvn_pagination() {
	global $wp_query;
	if ( $wp_query->max_num_pages <= 1 ) return;
	$paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
	echo '<nav class="pagination">';
	echo paginate_links( array(
		'base'      => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
		'format'    => '?paged=%#%',
		'current'   => max( 1, $paged ),
		'total'     => $wp_query->max_num_pages,
		'prev_text' => __( '← Previous', 'pinterhvn-theme' ),
		'next_text' => __( 'Next →', 'pinterhvn-theme' ),
		'type'      => 'list',
	) );
	echo '</nav>';
}

/**
 * Handle asset upload from the front-end form.
 * This function should be placed in your theme's functions.php file.
 */
function pinterhvn_handle_asset_upload() {
    // Verify nonce
    if ( ! isset( $_POST['pinterhvn_upload_nonce'] ) || ! wp_verify_nonce( $_POST['pinterhvn_upload_nonce'], 'pinterhvn_upload_asset' ) ) {
        wp_die( 'Security check failed.' );
    }

    // Check user permissions
    if ( ! current_user_can( 'edit_posts' ) ) {
        wp_die( 'You do not have permission to upload assets.' );
    }

    // Sanitize and prepare post data
    $asset_title       = sanitize_text_field( $_POST['asset_title'] );
    $asset_description = wp_kses_post( $_POST['asset_description'] );
    $asset_link        = esc_url_raw( $_POST['asset_link'] );
    $asset_categories  = array();
    if ( ! empty( $_POST['asset_category'] ) && is_array( $_POST['asset_category'] ) ) {
        $asset_categories = array_map( 'intval', $_POST['asset_category'] );
    }
    $asset_collections = array();
	if ( ! empty( $_POST['asset_collections'] ) && is_array( $_POST['asset_collections'] ) ) {
		$asset_collections = array_map( 'intval', $_POST['asset_collections'] );
	}
    $asset_tags = isset($_POST['asset_tags']) ? sanitize_text_field( $_POST['asset_tags'] ) : '';


    // Basic validation
    if ( empty( $asset_title ) || empty( $_FILES['asset_thumbnail']['name'] ) ) {
        wp_die( 'Title and a media file are required.' );
    }

    $post_data = array(
        'post_title'   => $asset_title,
        'post_content' => $asset_description,
        'post_status'  => 'publish',
        'post_author'  => get_current_user_id(),
        'post_type'    => 'digital_asset',
    );

    // Insert the post into the database
    $post_id = wp_insert_post( $post_data );

    if ( is_wp_error( $post_id ) ) {
        wp_die( $post_id->get_error_message() );
    }

    // These files are needed for media_handle_upload()
    require_once( ABSPATH . 'wp-admin/includes/image.php' );
    require_once( ABSPATH . 'wp-admin/includes/file.php' );
    require_once( ABSPATH . 'wp-admin/includes/media.php' );

    // Handle file upload (thumbnail)
    if ( ! empty( $_FILES['asset_thumbnail']['name'] ) ) {
        $attachment_id = media_handle_upload( 'asset_thumbnail', $post_id );

        if ( ! is_wp_error( $attachment_id ) ) {
            set_post_thumbnail( $post_id, $attachment_id );
        } else {
            // If upload fails, delete the post and show an error
            wp_delete_post( $post_id, true );
            wp_die( 'File upload failed: ' . $attachment_id->get_error_message() );
        }
    }

    // Handle preview video upload
    if ( ! empty( $_FILES['asset_preview_video']['name'] ) ) {
        $preview_video_id = media_handle_upload( 'asset_preview_video', $post_id );

        if ( ! is_wp_error( $preview_video_id ) ) {
            update_post_meta( $post_id, '_pinterhvn_preview_video_id', $preview_video_id );
        } else {
            // Optional: Log error, but don't kill the process if only preview video fails
        }
    }

    // Update post meta
    if ( ! empty( $asset_link ) ) {
        update_post_meta( $post_id, '_pinterhvn_asset_link', $asset_link );
    }

    // Set taxonomies
    if ( ! empty( $asset_categories ) ) {
        wp_set_post_terms( $post_id, $asset_categories, 'asset_category' );
    }
    if ( ! empty( $asset_tags ) ) {
        wp_set_post_terms( $post_id, $asset_tags, 'asset_tag' );
    }
    if ( ! empty( $asset_collections ) ) {
		wp_set_post_terms( $post_id, $asset_collections, 'asset_collection' );
	}

    // Redirect to the new asset page on success
    wp_redirect( get_permalink( $post_id ) );
    exit;
}
add_action( 'admin_post_pinterhvn_upload_asset', 'pinterhvn_handle_asset_upload' );

/**
 * AJAX handler for sideloading an image from a URL.
 */
function pinterhvn_sideload_from_url() {
    check_ajax_referer( 'pinterhvn_sideload_nonce', 'nonce' );

    if ( ! current_user_can( 'upload_files' ) ) {
        wp_send_json_error( __( 'You do not have permission to upload files.', 'pinterhvn-theme' ), 403 );
    }

    if ( empty( $_POST['file_url'] ) ) {
        wp_send_json_error( __( 'No file URL provided.', 'pinterhvn-theme' ), 400 );
    }

    $file_url = esc_url_raw( $_POST['file_url'] );

    // These files are needed for media_handle_sideload()
    require_once( ABSPATH . 'wp-admin/includes/image.php' );
    require_once( ABSPATH . 'wp-admin/includes/file.php' );
    require_once( ABSPATH . 'wp-admin/includes/media.php' );

    // Download file to temp location
    $tmp = download_url( $file_url );

    if ( is_wp_error( $tmp ) ) {
        @unlink( $tmp );
        wp_send_json_error( $tmp->get_error_message(), 400 );
    }

    $file_array = array(
        'name'     => basename( $file_url ),
        'tmp_name' => $tmp,
    );

    // Sideload it
    $id = media_handle_sideload( $file_array, 0 ); // 0 means not attached to any post

    if ( is_wp_error( $id ) ) {
        @unlink( $file_array['tmp_name'] );
        wp_send_json_error( $id->get_error_message(), 500 );
    }

    $attachment_url = wp_get_attachment_url( $id );

    wp_send_json_success( array(
        'id'       => $id,
        'url'      => $attachment_url,
        'type'     => get_post_mime_type( $id ),
        'filename' => basename( $attachment_url ),
    ) );
}
add_action( 'wp_ajax_pinterhvn_sideload_from_url', 'pinterhvn_sideload_from_url' );

/**
 * AJAX handler to get all asset tags.
 */
function pinterhvn_get_all_tags_ajax_handler() {
    $tags = get_terms( array(
        'taxonomy'   => 'asset_tag',
        'hide_empty' => false,
        'fields'     => 'names',
    ) );

    if ( is_wp_error( $tags ) ) {
        wp_send_json_error( 'Could not retrieve tags.' );
    }

    wp_send_json_success( $tags );
}
add_action( 'wp_ajax_pinterhvn_get_all_tags', 'pinterhvn_get_all_tags_ajax_handler' );

/**
 * AJAX handler for loading more assets (Infinite Scroll)
 */
function pinterhvn_load_more_assets_handler() {
    check_ajax_referer( 'pinterhvn_ajax_nonce', 'nonce' );

    $paged = isset( $_POST['page'] ) ? intval( $_POST['page'] ) : 1;
    $posts_per_page = isset( $_POST['posts_per_page'] ) ? intval( $_POST['posts_per_page'] ) : 12;

    $args = array(
        'post_type'      => 'digital_asset',
        'posts_per_page' => $posts_per_page,
        'paged'          => $paged,
        'post_status'    => 'publish',
    );

    // Add author parameter if it exists
    if ( ! empty( $_POST['author'] ) ) {
        $args['author'] = intval( $_POST['author'] );
    }

    $query = new WP_Query( $args );

    ob_start();
    if ( $query->have_posts() ) {
        while ( $query->have_posts() ) {
            $query->the_post();
            get_template_part( 'template-parts/content', 'asset-card' );
        }
    }
    $html = ob_get_clean();

    wp_send_json_success( array(
        'html'     => $html,
        'has_more' => $query->max_num_pages > $paged,
    ) );
}
add_action( 'wp_ajax_pinterhvn_load_more_assets', 'pinterhvn_load_more_assets_handler' );
add_action( 'wp_ajax_nopriv_pinterhvn_load_more_assets', 'pinterhvn_load_more_assets_handler' );

/**
 * Displays a login gate popup for non-logged-in users.
 * This covers the entire site and requires login to proceed.
 */
function pinterhvn_login_gate_popup() {
    // Only show for non-logged-in users
    if ( is_user_logged_in() ) {
        return;
    }
    ?>
    <div class="login-gate-overlay">
        <div class="login-popup">
            <div class="login-popup-header">
                <?php
                if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) {
                    the_custom_logo();
                } else {
                    echo '<h1 class="site-title-text">' . get_bloginfo( 'name' ) . '</h1>';
                }
                ?>
                <h2 class="welcome-message"><?php _e( 'Chào mừng đến với PinterHVN', 'pinterhvn-theme' ); ?></h2>
                <p class="welcome-subtext"><?php _e( 'Cổng quản lý tài nguyên kỹ thuật số của HVN Group', 'pinterhvn-theme' ); ?></p>
            </div>

            <div class="login-popup-body">
                <form name="loginform" id="loginform-popup" action="<?php echo esc_url( site_url( 'wp-login.php', 'login_post' ) ); ?>" method="post">
                    
                    <div class="form-group">
                        <label for="user_login_popup"><?php _e( 'Email / Username', 'pinterhvn-theme' ); ?></label>
                        <input type="text" name="log" id="user_login_popup" class="input" value="" size="20" placeholder="">
                    </div>

                    <div class="form-group password-group">
                        <label for="user_pass_popup"><?php _e( 'Mật khẩu', 'pinterhvn-theme' ); ?></label>
                        <input type="password" name="pwd" id="user_pass_popup" class="input" value="" size="20" placeholder="">
                        <button type="button" class="toggle-password" aria-label="<?php esc_attr_e( 'Show password', 'pinterhvn-theme' ); ?>"></button>
                    </div>

                    <div class="form-group-sub">
                        <a href="<?php echo esc_url( wp_lostpassword_url() ); ?>" class="forgot-password-link"><?php _e( 'Quên mật khẩu?', 'pinterhvn-theme' ); ?></a>
                    </div>

                    <p class="login-submit">
                        <input type="submit" name="wp-submit" id="wp-submit-popup" class="button button-primary button-large" value="<?php esc_attr_e( 'Đăng nhập', 'pinterhvn-theme' ); ?>">
                        <input type="hidden" name="redirect_to" value="<?php echo esc_url( home_url( $_SERVER['REQUEST_URI'] ) ); ?>">
                    </p>

                </form>

                <div class="sso-divider">
                    <span><?php _e( 'HOẶC', 'pinterhvn-theme' ); ?></span>
                </div>

                <?php
                // Assuming the Google SSO login URL is available via a function or option.
                // Replace '#' with the actual SSO login URL.
                $sso_url = apply_filters( 'pinterhvn_google_sso_login_url', '#' );
                ?>
                <a href="<?php echo esc_url( $sso_url ); ?>" class="btn-sso-google">
                    <img src="<?php echo PINTERHVN_THEME_URI . '/assets/images/google-logo.svg'; ?>" alt="Google" width="20" height="20">
                    <span><?php _e( 'Tiếp tục với Google', 'pinterhvn-theme' ); ?></span>
                </a>

                <div class="login-footer-text">
                    <p><?php _e( 'Bằng cách tiếp tục, bạn đồng ý với <a href="#">Điều khoản dịch vụ</a> của PinterHVN và xác nhận rằng bạn đã đọc <a href="#">Chính sách quyền riêng tư</a> của chúng tôi.', 'pinterhvn-theme' ); ?></p>
                </div>
            </div>
        </div>
    </div>
    <?php
}
add_action( 'wp_footer', 'pinterhvn_login_gate_popup' );
