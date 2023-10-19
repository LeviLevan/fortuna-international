<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_Team_Carousel extends Widget_Base {

    public function get_name() {
       return 'team-carousel';
    }

    public function get_title() {
       return __( 'Team Carousel', 'wp_51405' );
    }

    public function get_icon() { 
        return 'eicon-person';
    }

    protected function _register_controls() {

        $this->start_controls_section(
           'section_',
            [
               'label' => __( 'Team Carousel', 'wp_51405' ),
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => __( 'Title', 'wp_51405' ),
                'type' => Controls_Manager::TEXTAREA,
                'rows' => 3,
                'default' => __( 'Default Title', 'wp_51405' ),
                'placeholder' => __( 'Type your title here', 'wp_51405' ),
            ]
        );

        $this->add_control(
            'subtitle',
            [
                'label' => __( 'Subtitle', 'wp_51405' ),
                'type' => Controls_Manager::TEXTAREA,
                'rows' => 3,
                'default' => __( 'Default Subtitle', 'wp_51405' ),
                'placeholder' => __( 'Type your subtitle here', 'wp_51405' ),
            ]
        );

        $this->add_control(
            'description',
            [
                'label' => __( 'Description', 'wp_51405' ),
                'type' => Controls_Manager::TEXTAREA,
                'rows' => 5,
                'default' => __( 'Default Description', 'wp_51405' ),
                'placeholder' => __( 'Type your description here', 'wp_51405' ),
            ]
        );

        $this->add_control(
            'btn_caption',
            [
                'label' => __( 'Button caption', 'wp_51405' ),
                'type' => Controls_Manager::TEXT,
                'placeholder' => __( 'Type your button caption here', 'wp_51405' ),
            ]
        );

        $this->add_control(
            'btn_link',
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

        $this->add_control(
            'category',
            [
                'label' => __( 'Category', 'wp_51405' ),
                'type'  => Controls_Manager::SELECT,
                'options' => $this->get_all_categories(),
                'default' => 'select_category',
            ]
        );

        $this->add_control(
            'order_by',
            [
                'label' => __( 'Order By', 'wp_51405' ),
                'type'  => Controls_Manager::SELECT,
                'default' => 'desc',
                'options' => array(
                    'asc'=> esc_html__( 'asc', 'wp_51405' ),
                    'desc' => esc_html__( 'desc', 'wp_51405' ),
                ),
            ]
        );
        $this->add_control(
            'post_count',
            [
                'label' => __( 'Team members count', 'wp_51405' ),
                'type'  => Controls_Manager::NUMBER,
                'default' => 6,
                'min'   => 1,
                'max'   => 12,
                'step'  => 1,
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'image', 
                'default' => 'thumbnail-270-236',
                'separator' => 'none',
            ]
        );        

        $this->end_controls_section();

    }

    protected function render( $instance = [] ) {

        $settings = $this->get_settings();

        if ( ($settings['category'] === 'empty_cat_list') || ($settings['category'] === 'select_category') ) {
            return;
        }

        $args = array(
            'post_type'      => 'team',
            'orderby'      => 'date',
            'posts_per_page' => esc_attr($settings['post_count']),
            'order' => esc_attr($settings['order_by']),
            'tax_query' => array(
                array(
                    'taxonomy' => 'group',
                    'field'    => 'slug',
                    'terms'    => esc_attr($settings['category']),
                ),
            ),
        );

        $query = new \WP_Query($args);

        $teamMembers = $query->posts;

        if ( empty( $teamMembers ) ) {
            return;
        }

        $navId = uniqid('owl-custom-nav-');      

        $htmlTmpl = '<div class="row row-30">
            <div class="col-md-5 col-lg-4 col-xl-3">
                <div class="box-team">
                    <h3 class="oh-desktop"><span class="d-inline-block wow slideInUp">%1$s</span></h3>
                    <h6 class="title-style-1 wow fadeInLeft" data-wow-delay=".1s">%2$s</h6>
                    <p class="wow fadeInRight" data-wow-delay=".2s">%3$s</p>
                    <div class="group-sm oh-desktop">
                        <div class="button-style-1 wow slideInLeft">
                            <span class="icon mdi mdi-email-outline"></span>
                            <span class="button-style-1-text">
                                %4$s
                            </span>
                        </div>
                        <div class="wow slideInRight">
                            <div class="owl-custom-nav" id="%5$s"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-7 col-lg-8 col-xl-9">
                <div class="owl-carousel owl-style-5" data-items="1" data-sm-items="2" data-lg-items="3" data-margin="30" data-autoplay="false" data-animation-in="fadeIn" data-animation-out="fadeOut" data-navigation-class="#%5$s">
                    %6$s
                </div>
            </div>
        </div>';

        $teamCarouselItemTmpl = '<article class="team-modern">
            <a class="team-modern-figure" href="%1$s">
                <img src="%2$s" alt="" />
            </a>
            <div class="team-modern-caption">
                <h6 class="team-modern-name">
                    <a href="%1$s">%3$s</a>
                </h6>
                <div class="team-modern-status">%4$s</div>
                <ul class="list-inline team-modern-social-list">
                    %5$s
                </ul>
            </div>
        </article>';

        $socialTmpl = '<li><a class="icon %1$s" href="%2$s"></a></li>';
        $btnTmpl = '<a href="%1$s">%2$s</a>';

        $teamItems = '';

        foreach ($teamMembers as $member) {
            $imageSrc = $this->get_image_src( get_post_thumbnail_id($member->ID), $settings['image_size'] );            
            $position = get_post_meta($member->ID, 'cherry-team-position', true);
            $position = empty( $position ) ? '' : esc_html( $position );
            $social = get_post_meta($member->ID, 'cherry-team-social', true);
            $socialHtml = '';

            if ( !empty ( $social ) ) {
                foreach ($social as $socialItem) {
                    $socialHtml .= sprintf($socialTmpl, esc_attr( $socialItem['icon'] ), esc_url( $socialItem['url'] ));
                }
            }

            $teamItems .= sprintf($teamCarouselItemTmpl, get_permalink( $member->ID ), esc_url( $imageSrc ), esc_html( $member->post_title ), esc_html( $position ), $socialHtml);
        }

        $btnHtml = '';
        if ( !empty( $settings['btn_caption'] ) && !empty( $settings['btn_link']['url'] ) ) {
            $btnHtml = sprintf($btnTmpl, esc_url( $settings['btn_link']['url'] ), esc_html( $settings['btn_caption'] ));
        }

        printf($htmlTmpl, esc_html( $settings['title'] ), esc_html( $settings['subtitle'] ), esc_html( $settings['description'] ), $btnHtml, esc_attr( $navId ), $teamItems);    
    }

    protected function content_template() {}

    public function render_plain_content( $instance = [] ) {}

    private function get_image_src( $image_id, $image_size ) {

        $image_src = wp_get_attachment_image_src( $image_id, $image_size );
        if ( empty( $image_src ) ) {
            $image_src = wp_get_attachment_image_src( $image_id, 'full' );
        }
        $image_src = $image_src ? $image_src[0] : '';

        return $image_src;
    }

    private function get_all_categories() {
        $result = array();

        $categories = get_terms( 'group', array(
            'hide_empty' => false,
        ) );

        foreach ($categories as $category) {
            $result[$category->slug] = $category->name;
        }

        if ( count($result) == 0 ){
            $result['empty_cat_list'] = __('Empty cat list', 'wp_51405');
        }
        
        $result['select_category'] = __('Select category', 'wp_51405');

        return $result;
    }

}

if ( class_exists( 'Cherry_Team_Members' ) ) {
    Plugin::instance()->widgets_manager->register_widget_type( new Widget_Team_Carousel );    
}
