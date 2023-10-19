<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_Swiper_Slider extends Widget_Base {

    public function get_name() {
       return 'swiper-slider';
    }

    public function get_title() {
       return __( 'Swiper Slider', 'wp_51405' );
    }

    public function get_icon() { 
        return 'eicon-slider-3d';
    }

   protected function _register_controls() {

        $this->start_controls_section(
           'section_',
            [
               'label' => __( 'Swiper Slider', 'wp_51405' ),
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'title',
            [
                'label' => __( 'Title', 'wp_51405' ),
                'type' => Controls_Manager::TEXTAREA,
                'rows' => 4,
                'default' => __( 'Title', 'wp_51405' ),
                'placeholder' => __( '', 'wp_51405' ),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'subtitle',
            [
                'label' => __( 'Subtitle', 'wp_51405' ),
                'type' => Controls_Manager::TEXTAREA,
                'rows' => 4,
            ]
        );

        $repeater->add_control(
            'button_label',
            [
                'label' => __( 'Button Label', 'wp_51405' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( '' , 'wp_51405' ),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'link',
            [
                'label' => __( 'Button Link', 'wp_51405' ),
                'type' => Controls_Manager::URL,
                'placeholder' => __( 'https://your-link.com', 'wp_51405' ),
                'show_external' => true,
                'default' => [
                    'url' => '',
                    'is_external' => true,
                    'nofollow' => true,
                ],
            ]
        );

        $repeater->add_control(
            'slide_background',
            [
                'label' => __( 'Choose Image', 'wp_51405' ),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_control(
            'slide_item',
            [
                'label'   => esc_html__( 'Slide', 'wp_51405' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
            ]
        );

        $this->end_controls_section();

   }

    protected function render( $instance = [] ) {

        $settings = $this->get_settings();

        $slideTmpl = '<div class="swiper-slide context-dark" style="background-image:url(%1$s)">
            <div class="swiper-slide-caption section-md">
                <div class="container">
                    <div class="row">
                        <h6 class="text-uppercase" data-caption-animate="fadeInRight" data-caption-delay="0">%2$s</h6>
                        <h2 class="oh font-weight-light" data-caption-animate="slideInUp" data-caption-delay="100">%3$s</h2>
                        %4$s
                    </div>
                </div>
            </div>
        </div>';

        $btnTmpl = '<a class="button button-default-outline button-ujarak fadeInLeft animated" href="%2$s" data-caption-animate="fadeInLeft" data-caption-delay="0"><span>%1$s</span></a>';

        $sliderTmpl = '<section class="section swiper-container swiper-slider swiper-slider-corporate swiper-pagination-style-2" data-loop="true" data-autoplay="5000" data-simulate-touch="true" data-nav="false" data-direction="vertical">
            <div class="swiper-wrapper text-left">
                %1$s
            </div>
            <<div class="swiper-pagination"></div>
        </section>';

        $slides = '';

        if ( !empty( $settings['slide_item'] ) ) {

            foreach ($settings['slide_item'] as $slide) {

                $btnHtml = '';

                if ( !empty( $slide['button_label'] ) && !empty( $slide['link'] ) ) {
                    $btnHtml = sprintf($btnTmpl, esc_html( $slide['button_label'] ), esc_url( $slide['link']['url'] ) );
                }

                $slides .= sprintf($slideTmpl, esc_url( $slide['slide_background']['url'] ), esc_html( $slide['title'] ), $slide['subtitle'], $btnHtml);
            }

            printf($sliderTmpl, $slides, esc_attr(uniqid('swiper-slider-')));
        }
    }

    protected function content_template() {}

    public function render_plain_content( $instance = [] ) {}

}
Plugin::instance()->widgets_manager->register_widget_type( new Widget_Swiper_Slider );
