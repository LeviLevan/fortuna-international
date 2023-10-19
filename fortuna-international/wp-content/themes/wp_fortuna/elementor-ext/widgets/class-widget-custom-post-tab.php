<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_Custom_Post_Tab extends Widget_Base {

    public function get_name() {
       return 'custom-post-tab';
    }

    public function get_title() {
       return __( 'Post Tab', 'wp_51405' );
    }

    public function get_icon() { 
        return 'eicon-tabs';
    }

    protected function _register_controls() {

        $this->start_controls_section(
           'section_',
            [
               'label' => __( 'Post Tab', 'wp_51405' ),
            ]
        );

        $this->add_control(
            'tab_main_title',
            [
                'label' => __( 'Main Tab Title', 'wp_51405' ),
                'type' => Controls_Manager::TEXTAREA,
                'rows' => 3,
                'default' => __( 'Main Tab Title', 'wp_51405' ),
                'placeholder' => __( 'Type your text here', 'wp_51405' ),
            ]
        );

        $this->add_control(
            'post_ids',
            [
                'label'     => esc_html__( 'Set comma seprated IDs list (10, 22, 19 etc.)', 'wp_51405' ),
                'type'      => Controls_Manager::TEXTAREA,
                'rows' => 3,
                'default'   => '',
            ]
        );

        $this->end_controls_section();

    }

    protected function render( $instance = [] ) {

        $settings = $this->get_settings();

        $postIn = esc_html( $settings['post_ids'] );
        $postInArr = explode(',', str_replace(' ', '', $postIn));
        $query_args = array(
            'post_status'    => 'publish',
            'post__in' => $postInArr
        );

        $query = new \WP_Query( $query_args );

        if ( ! $query->have_posts() ) {
            _e('Posts Not Found!', 'wp_51405');
            return;
        }

        $tabContentTmpl = '<div class="tab-pane fade %1$s" id="%2$s">
            <div class="post-amy-figure">
                <img src="%3$s" alt="" />
                <a href="%4$s">
                    <span class="icon linearicons-link2"></span>
                </a>
            </div>
        </div>';

        $tabItemTmpl = '<li class="nav-item wow fadeInRight" role="presentation">
            <a class="nav-link %1$s" href="#%2$s" data-toggle="tab"></a>
            <div class="post-amy">
                <h5 class="post-amy-title">
                    <a href="%3$s">%4$s</a>
                </h5>
                <ul class="post-amy-info list-inline">
                    <li class="post-amy-time">
                        <span class="icon mdi mdi-clock"></span>
                        <time datetime="%5$s">%6$s</time>
                    </li>
                    <li class="post-amy-autor">
                        <span class="icon mdi mdi-account-outline"></span>
                        <a href="%7$s">%8$s</a>
                    </li>
                </ul>
            </div>
        </li>';

        $tabTmpl = '<div class="tabs-custom tabs-post" id="%1$s">
            <div class="row align-items-md-end align-items-xl-start">
                <div class="col-md-6 tab-content-3 wow fadeInUp">
                    <div class="tab-content">
                        %2$s
                    </div>
                </div>
                <div class="col-md-6 index-1">
                    <h3 class="tabs-post-title oh-desktop">
                        <span class="d-inline-block wow slideInDown">%3$s</span>
                    </h3>
                    <ul class="nav nav-tabs">
                        %4$s
                    </ul>
                </div>
            </div>
        </div>';

        $tabList = '';
        $tabContent = '';
        $tabId = uniqid('tabs-');
        $postCounter = 0;
        while ( $query->have_posts() ) {
            $query->the_post();

            $author_nickname = get_the_author_meta('nickname');
            $author_url = get_author_posts_url(get_the_author_meta('ID'), $author_nickname);
            $image_src = get_the_post_thumbnail_url( get_the_ID(), 'thumbnail-570-505' );
            if ( empty( $image_src ) ) {
                $image_src = get_the_post_thumbnail_url( get_the_ID(), 'full' );
            }
            $image_src = $image_src ? $image_src : '';

            if ( $postCounter == 0 ) {
                $tabList .= sprintf($tabItemTmpl, esc_attr('active'), esc_attr( $tabId . '-' . $postCounter ), get_permalink(), get_the_title(), get_the_date('Y-m-d'), get_the_date('F d, Y'), esc_url($author_url), esc_html($author_nickname));
                $tabContent .= sprintf($tabContentTmpl, esc_attr('show active'), esc_attr( $tabId . '-' . $postCounter ), esc_url($image_src), get_permalink());
            } else {
                $tabList .= sprintf($tabItemTmpl, '', esc_attr( $tabId . '-' . $postCounter ), get_permalink(), get_the_title(), get_the_date('Y-m-d'), get_the_date('F d, Y'), esc_url($author_url), esc_html($author_nickname));
                $tabContent .= sprintf($tabContentTmpl, '', esc_attr( $tabId . '-' . $postCounter ), esc_url($image_src), get_permalink());
            }

            $postCounter++;
        }
        wp_reset_postdata();

        printf($tabTmpl, esc_attr( $tabId ), $tabContent, esc_html($settings['tab_main_title']), $tabList);

    }

    protected function content_template() {}

    public function render_plain_content( $instance = [] ) {}

}
Plugin::instance()->widgets_manager->register_widget_type( new Widget_Custom_Post_Tab );