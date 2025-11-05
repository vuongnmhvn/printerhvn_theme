<?php
/**
 * PinterHVN Theme Customizer
 *
 * @package PinterHVN_Theme
 * @since 1.0.0
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function pinterhvn_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'        => '.site-title a',
				'render_callback' => 'pinterhvn_customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'        => '.site-description',
				'render_callback' => 'pinterhvn_customize_partial_blogdescription',
			)
		);
	}

	// Add Theme Options Panel
	$wp_customize->add_panel(
		'pinterhvn_theme_options',
		array(
			'title'       => __( 'PinterHVN Options', 'pinterhvn-theme' ),
			'description' => __( 'Customize your PinterHVN theme settings', 'pinterhvn-theme' ),
			'priority'    => 30,
		)
	);

	// Layout Section
	$wp_customize->add_section(
		'pinterhvn_layout_section',
		array(
			'title'    => __( 'Layout Settings', 'pinterhvn-theme' ),
			'panel'    => 'pinterhvn_theme_options',
			'priority' => 10,
		)
	);

	// Grid Columns
	$wp_customize->add_setting(
		'pinterhvn_grid_columns',
		array(
			'default'           => '4',
			'sanitize_callback' => 'absint',
			'transport'         => 'refresh',
		)
	);

	$wp_customize->add_control(
		'pinterhvn_grid_columns',
		array(
			'label'       => __( 'Grid Columns (Desktop)', 'pinterhvn-theme' ),
			'description' => __( 'Number of columns in the masonry grid on desktop', 'pinterhvn-theme' ),
			'section'     => 'pinterhvn_layout_section',
			'type'        => 'select',
			'choices'     => array(
				'2' => '2',
				'3' => '3',
				'4' => '4',
				'5' => '5',
				'6' => '6',
			),
		)
	);

	// Posts Per Page
	$wp_customize->add_setting(
		'pinterhvn_posts_per_page',
		array(
			'default'           => '12',
			'sanitize_callback' => 'absint',
			'transport'         => 'refresh',
		)
	);

	$wp_customize->add_control(
		'pinterhvn_posts_per_page',
		array(
			'label'       => __( 'Assets Per Page', 'pinterhvn-theme' ),
			'description' => __( 'Number of assets to show per page', 'pinterhvn-theme' ),
			'section'     => 'pinterhvn_layout_section',
			'type'        => 'number',
			'input_attrs' => array(
				'min'  => 6,
				'max'  => 48,
				'step' => 6,
			),
		)
	);

	// Infinite Scroll
	$wp_customize->add_setting(
		'pinterhvn_infinite_scroll',
		array(
			'default'           => true,
			'sanitize_callback' => 'wp_validate_boolean',
			'transport'         => 'refresh',
		)
	);

	$wp_customize->add_control(
		'pinterhvn_infinite_scroll',
		array(
			'label'       => __( 'Enable Infinite Scroll', 'pinterhvn-theme' ),
			'description' => __( 'Automatically load more assets when scrolling', 'pinterhvn-theme' ),
			'section'     => 'pinterhvn_layout_section',
			'type'        => 'checkbox',
		)
	);

	// Colors Section
	$wp_customize->add_section(
		'pinterhvn_colors_section',
		array(
			'title'    => __( 'Color Settings', 'pinterhvn-theme' ),
			'panel'    => 'pinterhvn_theme_options',
			'priority' => 20,
		)
	);

	// Primary Color
	$wp_customize->add_setting(
		'pinterhvn_primary_color',
		array(
			'default'           => '#3b82f6',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'pinterhvn_primary_color',
			array(
				'label'       => __( 'Primary Color', 'pinterhvn-theme' ),
				'description' => __( 'Main brand color used for buttons and links', 'pinterhvn-theme' ),
				'section'     => 'pinterhvn_colors_section',
			)
		)
	);

	// Header Background Color
	$wp_customize->add_setting(
		'pinterhvn_header_bg_color',
		array(
			'default'           => '#ffffff',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'pinterhvn_header_bg_color',
			array(
				'label'   => __( 'Header Background Color', 'pinterhvn-theme' ),
				'section' => 'pinterhvn_colors_section',
			)
		)
	);

	// Footer Background Color
	$wp_customize->add_setting(
		'pinterhvn_footer_bg_color',
		array(
			'default'           => '#0f172a',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'pinterhvn_footer_bg_color',
			array(
				'label'   => __( 'Footer Background Color', 'pinterhvn-theme' ),
				'section' => 'pinterhvn_colors_section',
			)
		)
	);

	// Social Links Section
	$wp_customize->add_section(
		'pinterhvn_social_section',
		array(
			'title'    => __( 'Social Links', 'pinterhvn-theme' ),
			'panel'    => 'pinterhvn_theme_options',
			'priority' => 30,
		)
	);

	// Social links
	$social_links = array(
		'facebook'  => 'Facebook',
		'twitter'   => 'Twitter',
		'instagram' => 'Instagram',
		'linkedin'  => 'LinkedIn',
		'youtube'   => 'YouTube',
	);

	foreach ( $social_links as $key => $label ) {
		$wp_customize->add_setting(
			'pinterhvn_social_' . $key,
			array(
				'default'           => '',
				'sanitize_callback' => 'esc_url_raw',
				'transport'         => 'refresh',
			)
		);

		$wp_customize->add_control(
			'pinterhvn_social_' . $key,
			array(
				'label'   => $label . ' URL',
				'section' => 'pinterhvn_social_section',
				'type'    => 'url',
			)
		);
	}
}
add_action( 'customize_register', 'pinterhvn_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function pinterhvn_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function pinterhvn_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function pinterhvn_customize_preview_js() {
	wp_enqueue_script(
		'pinterhvn-customizer',
		PINTERHVN_THEME_URI . '/assets/js/customizer.js',
		array( 'customize-preview' ),
		PINTERHVN_THEME_VERSION,
		true
	);
}
add_action( 'customize_preview_init', 'pinterhvn_customize_preview_js' );

/**
 * Output custom CSS based on customizer settings
 */
function pinterhvn_customizer_css() {
	$primary_color = get_theme_mod( 'pinterhvn_primary_color', '#3b82f6' );
	$header_bg = get_theme_mod( 'pinterhvn_header_bg_color', '#ffffff' );
	$footer_bg = get_theme_mod( 'pinterhvn_footer_bg_color', '#0f172a' );

	?>
	<style type="text/css">
		:root {
			--color-primary: <?php echo esc_attr( $primary_color ); ?>;
			--color-header-bg: <?php echo esc_attr( $header_bg ); ?>;
			--color-footer-bg: <?php echo esc_attr( $footer_bg ); ?>;
		}
		
		a,
		.main-navigation a:hover,
		.main-navigation .current-menu-item a {
			color: var(--color-primary);
		}
		
		.btn-primary,
		.upload-btn {
			background: var(--color-primary);
		}
		
		.btn-primary:hover,
		.upload-btn:hover {
			background: color-mix(in srgb, var(--color-primary) 85%, black);
		}
		
		.site-header {
			background: var(--color-header-bg);
		}
		
		.site-footer {
			background: var(--color-footer-bg);
		}
		
		.asset-card-action.save-btn {
			background: var(--color-primary);
		}
	</style>
	<?php
}
add_action( 'wp_head', 'pinterhvn_customizer_css' );
