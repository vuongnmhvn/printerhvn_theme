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

function pinterhvn_search_filter( $query ) {
	if ( ! is_admin() && $query->is_main_query() && $query->is_search() ) {
		$query->set( 'post_type', 'digital_asset' );
	}
	return $query;
}
add_filter( 'pre_get_posts', 'pinterhvn_search_filter' );

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
