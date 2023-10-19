<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_Custom_Testimonial_Carousel extends Widget_Base {

    public function get_name() {
       return 'custom-testimonial-carousel';
    }

    public function get_title() {
       return __( 'Custom Testimonial Carousel', 'wp_fortuna' );
    }

    public function get_icon() { 
        return 'eicon-person';
    }

    protected function _register_controls() {

        $this->start_controls_section(
           'section_',
            [
               'label' => __( 'Testimonial Item', 'wp_fortuna' ),
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
            'item_title',
            [
                'label' => __( 'Title', 'wp_fortuna' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Title', 'wp_fortuna' ),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'name', [
                'label' => __( 'Name', 'wp_fortuna' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Name' , 'wp_fortuna' ),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'image',
            [
                'label' => __( 'Choose Image', 'wp_fortuna' ),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );        

        $repeater->add_control(
            'item_description',
            [
                'label' => __( 'Description', 'wp_fortuna' ),
                'type' => Controls_Manager::TEXTAREA,
                'rows' => 10,
                'default' => __( 'Default description', 'wp_fortuna' ),
                'placeholder' => __( 'Type your description here', 'wp_fortuna' ),
            ]
        );

        $repeater->add_control(
            'item_position',
            [
                'label' => __( 'Position', 'wp_fortuna' ),
                'type' => Controls_Manager::TEXTAREA,
                'rows' => 3,
                'default' => __( 'Default position', 'wp_fortuna' ),
                'placeholder' => __( 'Type your position here', 'wp_fortuna' ),
            ]
        );

        $this->add_control(
            'list',
            [
                'label' => __( 'Testimonials List', 'wp_fortuna' ),
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
                <div class="col-xs-12 col-md-12 col-lg-12 ch-car-mob">
                    <div class="slick-slider child-carousel" id="%2$s" data-arrows="true" data-for=".%3$s" data-items="2" data-sm-items="3" data-md-items="5" data-lg-items="5" data-xl-items="5" data-slide-to-scroll="1">%4$s
                    </div>
                </div>
            </div>
        </div>';
        $layoutItemTmpl = 
        '<div class="item">
            <article class="row quote-modern">
                <div class="col-xs-12 col-md-12 col-lg-12 content-testimonials">
                    <h3 class="quote-modern-title">%1$s</h3>
                    <h5 class="quote-modern-text"><span class="q">%2$s</span></h5>
                    <div class="slider-divider">
                    </div>
                </div>
            </article>
        </div>';
        $childLayoutItemTmpl = '<div class="item">
            <img class="img-circle" src="%1$s" alt="" />
            <div class="itemauthor">%2$s</div>
            <div class="itemText">%3$s</div>
        </div>';

        $slidesContent = '';
        $clildSlidesContent = '';

        if ( !empty( $settings['list'] ) ) {
            foreach ($settings['list'] as $list_item) {
                $image_src = wp_get_attachment_image_src( $list_item['image']['id'], $settings['image_size'] );
                if ( empty( $image_src ) ) {
                    $image_src = wp_get_attachment_image_src( $list_item['image']['id'], 'full' );
                }
                $image_src = $image_src ? $image_src[0] : '';
                $slidesContent .= sprintf($layoutItemTmpl, esc_html( $list_item['item_title'] ), esc_html( $list_item['item_description'] ));
                $clildSlidesContent .= sprintf($childLayoutItemTmpl, esc_url($image_src), esc_html( $list_item['name'] ), esc_html( $list_item['item_position'] ));
            }
            printf($layoutTmpl, $slidesContent, esc_attr( $uniqChildId ), esc_attr( $uniqParentClass ), $clildSlidesContent);
        }

    }

    protected function content_template() {}

    public function render_plain_content( $instance = [] ) {}

}
Plugin::instance()->widgets_manager->register_widget_type( new Widget_Custom_Testimonial_Carousel );