<?php

add_filter('elementor/icons_manager/additional_tabs', 'register_elementor_additional_icons');

function register_elementor_additional_icons ( $tabs=[] ) {

    $tabs['restaurant-icon'] = [
        'name' => 'Restaurant',
        'label' => __( 'Restaurant', 'wp_fortuna' ),
        'url' => get_stylesheet_directory_uri() . '/icons/restaurant/icons.css' ,
        'enqueue' => [ get_stylesheet_directory_uri() . '/icons/restaurant/font.css' ],
        'prefix' => 'restaurant-icon-',
        'displayPrefix' => 'restaurant-icon',
        'labelIcon' => 'eicon-favorite',
        'ver' => null,
        'fetchJson' => get_stylesheet_directory_uri() . '/icons/restaurant/icons.json' ,
        'native' => false,
    ];

    $tabs['flaticon'] = [
        'name' => 'Flaticon',
        'label' => __( 'Flaticon', 'wp_fortuna' ),
        'url' => get_stylesheet_directory_uri() . '/icons/flaticon/icons.css' ,
        'enqueue' => [ get_stylesheet_directory_uri() . '/icons/flaticon/font.css' ],
        'prefix' => 'flaticon-',
        'displayPrefix' => 'flaticon',
        'labelIcon' => 'eicon-favorite',
        'ver' => null,
        'fetchJson' => get_stylesheet_directory_uri() . '/icons/flaticon/icons.json' ,
        'native' => false,
    ];

    $tabs['fl-great-icon-set'] = [
        'name' => 'Great',
        'label' => __( 'Great', 'wp_fortuna' ),
        'url' => get_stylesheet_directory_uri() . '/icons/fl-great/icons.css' ,
        'enqueue' => [ get_stylesheet_directory_uri() . '/icons/fl-great/font.css' ],
        'prefix' => 'fl-great-icon-set-',
        'displayPrefix' => 'fl-great-icon-set-ico',
        'labelIcon' => 'eicon-favorite',
        'ver' => null,
        'fetchJson' => get_stylesheet_directory_uri() . '/icons/fl-great/fl-great-icon.json' ,
        'native' => false,
	];

	$tabs['material-design-icons'] = [
        'name' => 'Material Design Icons',

        'label' => __( 'Material Design Icons', 'wp_fortuna' ),
        
        'url' => get_stylesheet_directory_uri() . '/icons/mdi/icons.css' ,

        'enqueue' => [ get_stylesheet_directory_uri() . '/icons/mdi/font.css' ],

        'prefix' => 'mdi-',

        'displayPrefix' => 'mdi',

        'labelIcon' => 'eicon-favorite',

        'ver' => null,

        'fetchJson' => get_stylesheet_directory_uri() . '/icons/mdi/icons.json',

        'native' => false,
    ];

    $tabs['fl-budicons-free'] = [
        'name' => 'FL Budicons Free',

        'label' => __( 'FL Budicons Free', 'wp_fortuna' ),
        
        'url' => get_stylesheet_directory_uri() . '/icons/fl-budicons-free/icons.css' ,

        'enqueue' => [ get_stylesheet_directory_uri() . '/icons/fl-budicons-free/font.css' ],

        'prefix' => 'fl-budicons-free-',

        'displayPrefix' => 'fl-budicons-free-ico',

        'labelIcon' => 'eicon-favorite',

        'ver' => null,

        'fetchJson' => get_stylesheet_directory_uri() . '/icons/fl-budicons-free/icons.json',

        'native' => false,
    ];

     $tabs['fl-bigmug-line'] = [
     	
        'name' => 'Fl Bigmug Line',

        'label' => __( 'Fl Bigmug Line', 'wp_fortuna' ),
        
        'url' => get_stylesheet_directory_uri() . '/icons/fl-bigmug-line/icons.css' ,

        'enqueue' => [ get_stylesheet_directory_uri() . '/icons/fl-bigmug-line/font.css' ],

        'prefix' => 'fl-bigmug-line-',

        'displayPrefix' => 'fl-bigmug-line-ico',

        'labelIcon' => 'eicon-favorite',

        'ver' => null,

        'fetchJson' => get_stylesheet_directory_uri() . '/icons/fl-bigmug-line/icons.json',

        'native' => false,
    ];

    return $tabs;
}
add_action('wp_enqueue_scripts', 'fonts_styles', 0);
function fonts_styles() {
    wp_enqueue_style( 'all-fonts', get_stylesheet_directory_uri() .'/assets/css/fonts.css' );
}

/*Adding new font*/
add_action( 'elementor/editor/after_enqueue_styles', 'fonts_styles' );
add_action( 'elementor/frontend/after_enqueue_styles', 'fonts_styles' );


function modify_controls( $controls_registry ) {
   // First we get the fonts setting of the font control
   $fonts = $controls_registry->get_control( 'font' )->get_settings( 'options' );
   // Then we append the custom font family in the list of the fonts we retrieved in the previous step
   $new_fonts = array_merge( [ 'Eudoxus Sans' => 'system' ], $fonts );
   // Then we set a new list of fonts as the fonts setting of the font control
   $controls_registry->get_control( 'font' )->set_settings( 'options', $new_fonts );
}
add_action( 'elementor/controls/controls_registered', 'modify_controls', 10, 1 );

add_filter( 'elementor/fonts/additional_fonts', 'add_additional_fonts' );
function add_additional_fonts( $additional_fonts ) {
    $additional_fonts[ 'Sora' ] = 'googlefonts';
    return $additional_fonts;
}

function kava_get_page_preloader () {
    $page_preloader  = kava_theme()->customizer->get_value( 'page_preloader' );

    if ( $page_preloader ) {
        $logoHtml = has_custom_logo() ? get_custom_logo() : '';


        printf('<div class="loading loading-1 slide">
                    <div class="reveal-item visible">
                        <div class="reveal-item-inner visible">
                            <div class="loading-content">
                                %1$s
                            </div>
                        </div>
                    </div>
                </div>
                <div class="loading loading-2 slide">
                <div class="reveal-item visible">
                <div class="reveal-item-inner visible">
                <div class="loading-content">
                </div>
                </div>
                </div>
                </div>',$logoHtml);
    }
}