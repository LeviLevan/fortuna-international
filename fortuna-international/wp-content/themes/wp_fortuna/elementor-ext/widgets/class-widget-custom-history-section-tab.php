<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_Custom_History_Section_Tab extends Widget_Base {

    public function get_name() {
       return 'custom-history-section-tab';
    }

    public function get_title() {
       return __( 'History Section Tab', 'wp_51405' );
    }

    public function get_icon() { 
        return 'eicon-tabs';
    }

    protected function _register_controls() {

        $this->start_controls_section(
           'section_',
            [
               'label' => __( 'History Section Tab', 'wp_51405' ),
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
            'tab_button_link',
            [
                'label' => __( 'Youtube Link', 'wp_51405' ),
                'type' => Controls_Manager::URL,
                'placeholder' => __( 'https://your-link.com', 'wp_51405' ),
                'show_external' => true,
                'default' => [
                    'url' => '#',
                    'is_external' => true,
                    'nofollow' => true,
                ],
            ]
        );

        $this->add_control(
            'tab_button_label',
            [
                'label' => __( 'Link Label', 'wp_51405' ),
                'type' => Controls_Manager::TEXTAREA,
                'rows' => 3,
                'placeholder' => __( 'Type your text here', 'wp_51405' ),
            ]
        );

        $this->add_control(
            'image',
            [
                'label' => __( 'Choose Image', 'wp_51405' ),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater = new Repeater();        

        $repeater->add_control(
            'tab_title',
            [
                'label' => __( 'Tab title', 'wp_51405' ),
                'type' => Controls_Manager::TEXTAREA,
                'rows' => 3,
                'default' => __( 'Tab title', 'wp_51405' ),
                'placeholder' => __( 'Type your text here', 'wp_51405' ),
            ]
        );        

        $repeater->add_control(
            'tab_content',
            [
                'label' => __( 'Tab content', 'wp_51405' ),
                'type' => Controls_Manager::TEXTAREA,
                'rows' => 10,
                'default' => __( 'Default tab content', 'wp_51405' ),
                'placeholder' => __( 'Type your description here', 'wp_51405' ),
            ]
        );

        $repeater->add_control(
            'tab_nav_name',
            [
                'label' => __( 'Tab Nav Name', 'wp_51405' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Default title', 'wp_51405' ),
                'placeholder' => __( 'Type your title here', 'wp_51405' ),
            ]
        );        

        $this->add_control(
            'tab_list',
            [
                'label' => __( 'Repeater Tab List', 'wp_51405' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'tab_title' => __( 'Title #1', 'wp_51405' ),
                    ],
                    [
                        'tab_title' => __( 'Title #2', 'wp_51405' ),
                    ],
                ],
                'title_field' => '{{{ tab_title }}}',
            ]
        );

        $this->end_controls_section();

    }

    protected function render( $instance = [] ) {

        $settings = $this->get_settings();

        $rightPartTmpl = '<div class="bg-image-right-1 bg-image-right-lg" style="background-image: url(%1$s);">
            <img src="%1$s" alt="" >
            <div class="link-play-modern">
                <a class="icon mdi mdi-play" data-lightbox="iframe" href="%2$s"></a>
                <div class="link-play-modern-title">%3$s</div>
                <div class="link-play-modern-decor"></div>
            </div>
            <div class="box-transform" style="background-image: url(%1$s);"></div>
        </div>';

        $tabItemTmpl = '<li class="list-history-item" role="presentation">
            <a class="%1$s" href="#%2$s" data-toggle="tab">
                <div class="list-history-circle"></div>%3$s
            </a>
        </li>';

        $tabContentTmpl = '<div class="tab-pane fade %1$s" id="%2$s">
            <h5 class="font-weight-normal text-transform-none text-spacing-75">%3$s</h5>
            <p>%4$s</p>
        </div>';

        $tabWrapperTmpl = '<div class="tabs-custom" id="%1$s">
            <div class="tab-content tab-content-1">%2$s</div>
            <div class="list-history-wrap">
                <ul class="nav list-history">%3$s</ul>
            </div>
        </div>';

        $sectionWrapperTmpl = '<section class="section section-lg bg-gray-100 text-left section-relative">
            <div class="container">
                <div class="row row-60 justify-content-center justify-content-xxl-between">
                    <div class="col-lg-6 col-xxl-5 position-static">
                        <h3>%1$s</h3>
                        %2$s
                    </div>
                    <div class="col-md-9 col-lg-6 position-static index-1">
                        %3$s
                    </div>
                </div>
            </div>
        </section>';

        $tabList = '';
        $tabContent = '';
        $tabId = uniqid('tabs-');

        if ( !empty( $settings['tab_list'] ) ) {
            $i = 0;
            foreach ($settings['tab_list'] as $tab_item) {
                if ( $i == 0 ) {
                    $tabList .= sprintf($tabItemTmpl, ' active', esc_attr( $tabId . '-' . $i ), esc_html( $tab_item['tab_nav_name'] ));
                    $tabContent .= sprintf($tabContentTmpl, ' active show', esc_attr( $tabId . '-' . $i ), esc_html( $tab_item['tab_title'] ), esc_html( $tab_item['tab_content'] ));
                } else {
                    $tabList .= sprintf($tabItemTmpl, '', esc_attr( $tabId . '-' . $i ), esc_html( $tab_item['tab_nav_name'] ));
                    $tabContent .= sprintf($tabContentTmpl, '', esc_attr( $tabId . '-' . $i ), esc_html( $tab_item['tab_title'] ), esc_html( $tab_item['tab_content'] ));
                } 
                $i++;
            }
        }

        $tabWrapper = sprintf($tabWrapperTmpl, esc_attr($tabId), $tabContent, $tabList);
        $sectionRightPart = sprintf($rightPartTmpl, esc_url( $settings['image']['url'] ), esc_url( $settings['tab_button_link']['url'] ), strip_tags($settings['tab_button_label'], '<span>'));

        printf($sectionWrapperTmpl, esc_html( $settings['tab_main_title'] ), $tabWrapper, $sectionRightPart);
    }

    protected function content_template() {}

    public function render_plain_content( $instance = [] ) {}

}
Plugin::instance()->widgets_manager->register_widget_type( new Widget_Custom_History_Section_Tab );
?>