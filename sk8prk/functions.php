<?php
/**
 * Child Theme Functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Sk8prk
 * @since 1.0.0
 */

if ( ! function_exists( 'varya_sk8prk_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function varya_sk8prk_setup() {

		// Add support for editor styles.
        add_theme_support( 'editor-styles' );

		// Enqueue editor styles.
		add_editor_style( array(
			// get_template_directory_uri() . '/assets/css/style-editor.css', // varya editor styles
			varya_sk8prk_fonts_url(),
			'variables.css',
			'style.css',
		) );

		// Add child theme editor font sizes to match Sass-map variables in `_config-child-theme-deep.scss`.
		add_theme_support(
			'editor-font-sizes',
			array(
				array(
					'name'      => __( 'Tiny', 'varya-sk8prk' ),
					'shortName' => __( 'XS', 'varya-sk8prk' ),
					'size'      => 14,
					'slug'      => 'xs',
				),
				array(
					'name'      => __( 'Small', 'varya-sk8prk' ),
					'shortName' => __( 'S', 'varya-sk8prk' ),
					'size'      => 16,
					'slug'      => 'small',
				),
				array(
					'name'      => __( 'Medium', 'varya-sk8prk' ),
					'shortName' => __( 'M', 'varya-sk8prk' ),
					'size'      => 20,
					'slug'      => 'medium',
				),
				array(
					'name'      => __( 'Large', 'varya-sk8prk' ),
					'shortName' => __( 'L', 'varya-sk8prk' ),
					'size'      => 24,
					'slug'      => 'large',
				),
				array(
					'name'      => __( 'XL', 'varya-sk8prk' ),
					'shortName' => __( 'XL', 'varya-sk8prk' ),
					'size'      => 36,
					'slug'      => 'xl',
				),
				array(
					'name'      => __( 'Huge', 'varya-sk8prk' ),
					'shortName' => __( 'XXL', 'varya-sk8prk' ),
					'size'      => 48,
					'slug'      => 'huge',
				),
			)
		);

		// Add child theme editor color pallete to match Sass-map variables in `_config-child-theme-deep.scss`.
		add_theme_support(
			'editor-color-palette',
			array(
				array(
					'name'  => __( 'Primary', 'varya-sk8prk' ),
					'slug'  => 'primary',
					'color' => '#000000',
				),
				array(
					'name'  => __( 'Background', 'varya-sk8prk' ),
					'slug'  => 'background',
					'color' => '#BFF5A5',
				),
			)
        );
	}
endif;
add_action( 'after_setup_theme', 'varya_sk8prk_setup', 12 );

/**
 * Filter the content_width in pixels, based on the child-theme's design and stylesheet.
 */
function varya_sk8prk_content_width() {
	return 744;
}
add_filter( 'varya_content_width', 'varya_sk8prk_content_width' );

/**
 * Enqueue scripts and styles.
 */
function varya_sk8prk_scripts() {

	// enqueue Google fonts, if necessary
    wp_enqueue_style( 'varya-sk8park-fonts', varya_sk8prk_fonts_url(), array(), null );

	// Child theme variables
	wp_enqueue_style( 'varya-sk8prk-variables-style', get_stylesheet_directory_uri() . '/variables.css', array(), wp_get_theme()->get( 'Version' ) );

	// dequeue parent styles
	// wp_dequeue_style( 'varya-variables-style' );

	// enqueue child styles
	wp_enqueue_style('varya-sk8prk-style', get_stylesheet_uri(), array(), wp_get_theme()->get( 'Version' ));

	// enqueue child RTL styles
	wp_style_add_data( 'varya-sk8prk-style', 'rtl', 'replace' );

}
add_action( 'wp_enqueue_scripts', 'varya_sk8prk_scripts', 99 );

/**
 * Enqueue Custom Cover Block Styles and Scripts
 */
function varya_sk8prk_block_extends() {
	// Block Tweaks
	wp_enqueue_script( 'varya-sk8prk-block-extends',
		get_stylesheet_directory_uri() . '/assets/block-extends/extend-blocks.js',
		array( 'wp-blocks', 'wp-edit-post' ) // wp-edit-post is added to avoid a race condition when trying to unregister a style variation 
	);
}
add_action( 'enqueue_block_assets', 'varya_sk8prk_block_extends' );

/**
 * Add Google webfonts
 *
 * @return string
 */
function varya_sk8prk_fonts_url() : string {
    $fonts_url = '';

	$font_families   = array();
	$font_families[] = 'family=Red+Hat+Display:ital,wght@0,900;1,900';
	$font_families[] = 'family=Red+Hat+Text:ital,wght@0,400;0,500;0,700;1,400;1,500;1,700';
	$font_families[] = 'display=swap';

    // Make a single request for the theme fonts.
    $fonts_url = 'https://fonts.googleapis.com/css2?' . implode( '&', $font_families );
    
    return $fonts_url;
}

/**
 * Load extras
 */
// require get_stylesheet_directory() . '/inc/custom-header.php';