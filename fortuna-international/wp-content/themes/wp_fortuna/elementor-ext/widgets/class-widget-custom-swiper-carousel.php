<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_Custom_Swiper_Carousel extends Widget_Base {

    public function get_name() {
       return 'custom-swiper-carousel';
    }

    public function get_title() {
       return __( 'Custom Swiper Carousel', 'wp_51405' );
    }

    public function get_icon() { 
        return 'eicon-person';
    }

    protected function _register_controls() {

        $this->start_controls_section(
           'section_',
            [
               'label' => __( 'Swiper Item', 'wp_51405' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'image', 
                'default' => 'thumbnail-83-83',
                'separator' => 'none',
            ]
        );

        $repeater = new Repeater(); 

        $repeater->add_control(
            'item_year',
            [
                'label' => __( 'Year', 'wp_51405' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Year', 'wp_51405' ),
                'label_block' => true,
            ]
        );

         $repeater->add_control(
            'item_title',
            [
                'label' => __( 'Title', 'wp_51405' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Title', 'wp_51405' ),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'name', [
                'label' => __( 'Name', 'wp_51405' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Name' , 'wp_51405' ),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'image',
            [
                'label' => __( 'Choose Image', 'wp_51405' ),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );        

        $repeater->add_control(
            'item_description',
            [
                'label' => __( 'Description', 'wp_51405' ),
                'type' => Controls_Manager::TEXTAREA,
                'rows' => 10,
                'default' => __( 'Default description', 'wp_51405' ),
                'placeholder' => __( 'Type your description here', 'wp_51405' ),
            ]
        );

        $repeater->add_control(
            'item_position',
            [
                'label' => __( 'Position', 'wp_51405' ),
                'type' => Controls_Manager::TEXTAREA,
                'rows' => 3,
                'default' => __( 'Default position', 'wp_51405' ),
                'placeholder' => __( 'Type your position here', 'wp_51405' ),
            ]
        );

        $this->add_control(
            'list',
            [
                'label' => __( 'Testimonials List', 'wp_51405' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{ name }}}',
            ]
        );  

        $this->end_controls_section();

    }

    protected function render( $instance = [] ) {

        $settings = $this->get_settings();

        $uniqChildId = uniqid('child-carousel-');
        $uniqParentClass = uniqid('carousel-parent-');
        $layoutTmpl = 
        '<div class="slick-quote">
            <div class="slick-slider carousel-parent %3$s" data-autoplay="false" data-swipe="true" data-items="1" data-child="#%2$s" data-for="#%2$s" data-slide-effect="true">
                %1$s
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-12 col-lg-4"></div>
                <div class="col-xs-12 col-md-12 col-lg-8 ch-car-mob">
                    <div class="slick-slider child-carousel" id="%2$s" data-arrows="true" data-for=".%3$s" data-items="5" data-sm-items="6" data-md-items="8" data-lg-items="11" data-xl-items="10" data-slide-to-scroll="1">%4$s
                    </div>
                </div>
            </div>
        </div>';
        $layoutItemTmpl = 
        '<div class="item">
            <article class="row quote-modern">
                <div class="col-xs-12 col-md-12 col-lg-4 item-big-image">
                    <img class="img-rectangle" src="%1$s" alt="" />
                </div>
                <div class="col-xs-12 col-md-12 col-lg-8 content-testimonials">
                    <div class="quote-modern-year">%2$s</div>
                    <h3 class="quote-modern-title">%3$s</h3>
                    <h5 class="quote-modern-text"><span class="q">%4$s</span></h5>
                    <h6 class="quote-modern-author">
                    <span class="elementor-icon-list-icon">
                        <i aria-hidden="true" class="fas fa-window-minimize"></i>
                    </span> 
                        %5$s
                    </h6>
                    <p class="quote-modern-status">%6$s</p>
                    <div class="slider-divider">
                    </div>
                </div>
            </article>
        </div>';
        $childLayoutItemTmpl = '<div class="item">
            <img class="img-circle" src="%1$s" alt="" />
        </div>';

        $slidesContent = '';
        $clildSlidesContent = '';

        if ( !empty( $settings['list'] ) ) {
            foreach ($settings['list'] as $list_item) {
                $image_src = wp_get_attachment_image_src( $list_item['image']['id'], $settings['image_size'] );
                $image_src_big = wp_get_attachment_image_src( $list_item['image']['id'], 'full' );
                if ( empty( $image_src ) ) {
                    $image_src = wp_get_attachment_image_src( $list_item['image']['id'], 'full' );
                }
                $image_src = $image_src ? $image_src[0] : '';
                $image_src_big = $image_src_big ? $image_src_big[0] : '';
                $slidesContent .= sprintf($layoutItemTmpl, $image_src_big, esc_html( $list_item['item_year'] ), esc_html( $list_item['item_title'] ), esc_html( $list_item['item_description'] ), esc_html( $list_item['name'] ), esc_html( $list_item['item_position'] ));
                $clildSlidesContent .= sprintf($childLayoutItemTmpl, esc_url($image_src));
            }
            printf($layoutTmpl, $slidesContent, esc_attr( $uniqChildId ), esc_attr( $uniqParentClass ), $clildSlidesContent);
        }

    }

    protected function content_template() {}

    public function render_plain_content( $instance = [] ) {}

}
Plugin::instance()->widgets_manager->register_widget_type( new Widget_Custom_Swiper_Carousel );