<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_Swiper_Testi extends Widget_Base {

    public function get_name() {
       return 'swiper-testi';
    }

    public function get_title() {
       return __( 'Swiper Testimonials', 'wp_51405' );
    }

    public function get_icon() { 
        return 'eicon-slider-3d';
    }

   protected function _register_controls() {

        $this->start_controls_section(
           'section_',
            [
               'label' => __( 'Swiper Testimonials', 'wp_51405' ),
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'title',
            [
                'label' => __( 'Title', 'wp_51405' ),
                'type' => Controls_Manager::TEXTAREA,
                'rows' => 4,
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

        $slideTmpl = '<div class="swiper-slide context-dark">
            <div class="swiper-slide-caption section-lg">
                <div class="container">
                    <div class="row justify-content-center justify-content-md-between">
                        <div class="col-5 d-none d-md-block position-static">
                            <div class="quote-classic-figure">
                                <img src="%1$s" alt="" width="960" height="574"/>
                            </div>
                        </div>
                        <div class="col-sm-11 col-md-7 col-xl-6">
                            <div class="inset-left-xl-70">
                                <h4>%2$s</span></h4>
                                <article class="quote-classic quote-classic-2 quote-classic-4" data-caption-animate="fadeInLeft" data-caption-delay="0">%3$s</article>
                                %4$s
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>';

        $btnTmpl = '<a class="button button-lg button-icon button-icon-right button-blue-8" href="%2$s" data-caption-animate="fadeInUp" data-caption-delay="500"><span class="icon mdi mdi-chevron-right"></span>%1$s</a>';

        $sliderTmpl = '<section id="%2$s" class="section swiper-container swiper-slider swiper-slider-8" data-loop="true" data-autoplay="5000" data-simulate-touch="false" data-slide-effect="fade">
            <div class="swiper-wrapper text-left">
                %1$s
            </div>
            <div class="swiper-navigation__module">
                <div class="swiper-pagination__fraction">
                    <span class="swiper-pagination__fraction-index"></span>
                    <span class="swiper-pagination__fraction-divider">/</span>
                    <span class="swiper-pagination__fraction-count"></span>
                </div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
            <div class="swiper-pagination" data-bullet-custom="true"></div>
        </section>';

        $slides = '';

        if ( !empty( $settings['slide_item'] ) ) {

            foreach ($settings['slide_item'] as $slide) {

                $btnHtml = '';

                if ( !empty( $slide['button_label'] ) && !empty( $slide['link'] ) ) {
                    $btnHtml = sprintf($btnTmpl, esc_html( $slide['button_label'] ), esc_url( $slide['link']['url'] ) );
                }

                $slides .= sprintf($slideTmpl, esc_url( $slide['slide_background']['url'] ), esc_html( $slide['title'] ), $slide['subtitle'] , $btnHtml);
            }

            printf($sliderTmpl, $slides, esc_attr(uniqid('swiper-slider-')));
        }
    }

    protected function content_template() {}

    public function render_plain_content( $instance = [] ) {}

}
Plugin::instance()->widgets_manager->register_widget_type( new Widget_Swiper_Testi );
