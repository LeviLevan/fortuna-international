<?php
/**
 * Child functions and definitions.
 */
add_filter( 'kava-theme/assets-depends/styles', 'kava_child_styles_depends' );

/**
 * Enqueue styles.
 */
function kava_child_styles_depends( $deps ) {

	$parent_handle = 'kava-parent-theme-style';

	wp_register_style(
		$parent_handle,
		get_template_directory_uri() . '/style.css',
		array(),
		kava_theme()->version()
	);

	$deps[] = $parent_handle;

	return $deps;
}

/**
 * Disable magic button for your clients
 *
 * Un-comment next line to disble magic button output for you clients.
 */
//add_action( 'jet-theme-core/register-config', 'kava_child_disable_magic_button' );

function kava_child_disable_magic_button( $config_manager ) {
	$config_manager->register_config( array(
		'library_button' => false,
	) );
}

/**
 * Disable unnecessary theme modules
 *
 * Un-comment next line and return unnecessary modules from returning modules array.
 */
//add_filter( 'kava-theme/allowed-modules', 'kava_child_allowed_modules' );

function kava_child_allowed_modules( $modules ) {

	return array(
		'blog-layouts'    => array(),
		'crocoblock'      => array(),
		'woo'             => array(
			'woo-breadcrumbs' => array(),
			'woo-page-title'  => array(),
		),
	);

}

/**
 * Registering a new structure
 *
 * To change structure and apropriate documnet type parameters go to
 * structures/archive.php and document-types/archive.php
 *
 * To print apropriate location add next code where you need it:
 * if ( function_exists( 'jet_theme_core' ) ) {
 *     jet_theme_core()->locations->do_location( 'kava_child_archive' );
 * }
 * Where 'kava_child_archive' - apropritate location name (from example).
 *
 * Un-comment next line to register new structure.
 */
//add_action( 'jet-theme-core/structures/register', 'kava_child_structures' );

function kava_child_structures( $structures_manager ) {

	require get_theme_file_path( 'structures/archive.php' );
	require get_theme_file_path( 'structures/404.php' );

	$structures_manager->register_structure( 'Kava_Child_Structure_Archive' );
	$structures_manager->register_structure( 'Kava_Child_Structure_404' );

}

get_template_part('inc/classes/class-tgm-plugin-activation');

add_action( 'tgmpa_register', 'wp_fortuna_register_required_plugins' );
function wp_fortuna_register_required_plugins() {

	$plugins = array(
		
		array(
			'name'         => esc_html__( 'Elementor', 'wp_fortuna' ),
			'slug'         => 'elementor',
			'required'     => true
		),
		array(
            'name'         => esc_html__( 'Contact Form 7', 'wp_fortuna' ),
            'slug'         => 'contact-form-7',
            'required'     => true
            ),
          
		array(
			'name'         => esc_html__( 'Jet Elements For Elementor', 'wp_fortuna' ),
			'slug'         => 'jet-elements',
			'source'       => get_stylesheet_directory() . '/plugins/jet-elements.zip',
			'required'     => true,
		),
           
   
      array(
            'name'         => esc_html__( 'Jet Blocks For Elementor', 'wp_fortuna' ),
            'slug'         => 'jet-blocks',
            'source'       => get_stylesheet_directory() . '/plugins/jet-blocks.zip',
            'required'     => true,
      ),
      array(
            'name'         => esc_html__( 'Jet Blog For Elementor', 'wp_fortuna' ),
            'slug'         => 'jet-blog',
            'source'       => get_stylesheet_directory() . '/plugins/jet-blog.zip',
            'required'     => true,
      ),
     
  
      array(
            'name'         => esc_html__( 'Jet Theme Core', 'wp_fortuna' ),
            'slug'         => 'jet-theme-core',
            'source'       => get_stylesheet_directory() . '/plugins/jet-theme-core.zip',
            'required'     => true,
      ),

      array(
            'name'         => esc_html__( 'Jet Engine', 'wp_fortuna' ),
            'slug'         => 'jet-engine',
            'source'       => get_stylesheet_directory() . '/plugins/jet-engine.zip',
            'required'     => true,
      ),
       array(
            'name'         => esc_html__( 'Jet Tricks', 'wp_fortuna' ),
            'slug'         => 'jet-tricks',
            'source'       => get_stylesheet_directory() . '/plugins/jet-tricks.zip',
            'required'     => true,
      ),
 	array(
            'name'         => esc_html__( 'Jet Menu', 'wp_fortuna' ),
            'slug'         => 'jet-menu',
            'source'       => get_stylesheet_directory() . '/plugins/jet-menu.zip',
            'required'     => true,
      ),
      array(
            'name'         => esc_html__( 'Jet Pop Up', 'wp_fortuna' ),
            'slug'         => 'jet-popup',
            'source'       => get_stylesheet_directory() . '/plugins/jet-popup.zip',
            'required'     => true,
      ),
       array(
            'name'         => esc_html__( 'Jet Tabs', 'wp_fortuna' ),
            'slug'         => 'jet-tabs',
            'source'       => get_stylesheet_directory() . '/plugins/jet-tabs.zip',
            'required'     => true,
      ),
      
	);

	$config = array(
		'id'           => 'wp_fortuna',
		'default_path' => '',
		'menu'         => 'tgmpa-install-plugins',
		'has_notices'  => true,
		'dismissable'  => true,
		'dismiss_msg'  => '',
		'is_automatic' => true,
		'message'      => '',
	);

	tgmpa( $plugins, $config );
}

locate_template('inc/theme-filters.php', true);

add_action('wp_enqueue_scripts', 'wp_fortuna_enqueue_style_script', 99);

function wp_fortuna_enqueue_style_script() {
	wp_enqueue_style('swiper-css', get_stylesheet_directory_uri() . '/assets/css/swiper.min.css');
	wp_enqueue_style('main-css', get_stylesheet_directory_uri() . '/assets/css/main.css');

	// wp_register_script('knob', 'https://cdnjs.cloudflare.com/ajax/libs/jQuery-Knob/1.2.13/jquery.knob.min.js', array('jquery'), true );
	// wp_enqueue_script('knob');
	
	wp_deregister_script('jquery-swiper');
    wp_deregister_script('jquery-slick');
    wp_enqueue_script('jquery-swiper', get_stylesheet_directory_uri().'/assets/js/swiper.min.js', array('jquery'));
    wp_enqueue_script('jquery-slick', get_stylesheet_directory_uri().'/assets/js/slick.min.js', array('jquery'));
    
    wp_enqueue_script( 'gsap', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/gsap.min.js', array(), false, true );
    wp_enqueue_script( 'gsap-st', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/ScrollTrigger.min.js', array(), false, true );
    wp_enqueue_script('splittext', get_stylesheet_directory_uri() .'/assets/js/splittext.min.js', array('jquery'), true );
      wp_enqueue_script('main', get_stylesheet_directory_uri() .'/assets/js/main.js', array('jquery'), true );

}
if ( function_exists( 'add_theme_support' ) ) { // Added in 2.9
			add_theme_support( 'post-thumbnails' );
			add_image_size( 'thumbnail-83-83', 83, 83, true );
		}
// Elementor plugins
include ( get_stylesheet_directory() . '/elementor-ext/class-elementor-create-element.php' );
//locate_template( 'extensions/wp-deep-linking/main.php', true );


add_filter('wpcf7_autop_or_not', '__return_false');

