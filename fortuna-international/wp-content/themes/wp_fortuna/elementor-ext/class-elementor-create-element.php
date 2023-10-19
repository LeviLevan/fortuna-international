<?php 

if ( ! defined( 'ABSPATH' ) ) exit;

class ElementorCreateElement {

   private static $instance = null;

   public static function get_instance() {
      if ( ! self::$instance )
         self::$instance = new self;
      return self::$instance;
   }

   public function init(){
      add_action( 'elementor/widgets/widgets_registered', array( $this, 'widgets_registered' ) );
   }

   private function widget_register($widgetPath) {
      $widget_file = get_stylesheet_directory() . $widgetPath;

      $template_file = locate_template($widget_file);
      if ( !$template_file || !is_readable( $template_file ) ) {
         $template_file = get_stylesheet_directory() . $widgetPath;
      }
      if ( $template_file && is_readable( $template_file ) ) {
         require_once $template_file;
      }
   }

   public function widgets_registered() {

      if(defined('ELEMENTOR_PATH') && class_exists('Elementor\Widget_Base')){
         $this->widget_register('/elementor-ext/widgets/class-widget-custom-testimoninal-carousel.php');
         $this->widget_register('/elementor-ext/widgets/class-widget-swiper-slider.php');
      }
   }
}

ElementorCreateElement::get_instance()->init();

add_action( 'wp_enqueue_scripts', 'custom_elementor_extensions_enqueue_scripts' );
function custom_elementor_extensions_enqueue_scripts() {
   //Scripts
   //wp_enqueue_script('custom-posts-layout-js', get_stylesheet_directory_uri().'/elementor-ext/widgets/js/post-scripts.js', array('jquery'));
   wp_enqueue_script('custom-elementor-extensions-modules', get_stylesheet_directory_uri().'/elementor-ext/widgets/js/elementor-modules.js', array('jquery'));
}
