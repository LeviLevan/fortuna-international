<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_Custom_Big_Tab_Home extends Widget_Base {

    public function get_name() {
       return 'custom-big-tab-home';
    }

    public function get_title() {
       return __( 'Big Tab Home', 'wp_51405' );
    }

    public function get_icon() { 
        return 'eicon-tabs';
    }

    protected function _register_controls() {

        $this->start_controls_section(
           'section_',
            [
               'label' => __( 'Big Tab Home', 'wp_51405' ),
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
                'label' => __( 'Tab Custom Button Link', 'wp_51405' ),
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
                'label' => __( 'Tab Custom Button Label', 'wp_51405' ),
                'type' => Controls_Manager::TEXTAREA,
                'rows' => 3,
                'placeholder' => __( 'Type your text here', 'wp_51405' ),
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
                'type' => Controls_Manager::WYSIWYG,
                'rows' => 10,
                'default' => __( 'Default tab content', 'wp_51405' ),
                'placeholder' => __( 'Type your description here', 'wp_51405' ),
            ]
        );

        $repeater->add_control(
            'image',
            [
                'label' => __( 'Choose Content Image', 'wp_51405' ),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
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

        $btnTmpl = '<a class="button button-icon button-icon-right button-primary" href="%1$s"><span class="icon mdi mdi-chevron-right"></span>%2$s</a>';

        $customTitleTmpl = '<h5 class="text-spacing-200">%1$s</h5>';

        $tabItemTmpl = '<li class="nav-item-3" role="presentation"><a class="nav-link-3 %1$s" href="#%2$s" data-toggle="tab">%3$s</a></li>';

        $tabImgTmpl = '<img class="hide-content" src="%1$s" alt="" />';

        $tabContentTmpl = '<div class="tab-pane fade %1$s" id="%2$s">
            %3$s
            %4$s
        </div>';

        $tabTmpl = '<section class="section bg-gray-100">
            <div class="container-fluid container-inset-0">
                <div class="row no-gutters" >
                    <div class="col-md-4 col-lg-5 col-xl-6 box-transform-wrap box-transform-1">
                        <div class="box-transform">
                            %6$s
                        </div>
                    </div>
                    <div class="col-md-8 col-lg-7 col-xl-6 bg-image-3">
                        <div class="tabs-custom tabs-custom-3" id="%1$s">
                            <div class="tab-content tab-content-4 section-inset-7">
                                %5$s
                                %4$s
                            </div>
                            <ul class="nav nav-tabs-3">
                                %3$s
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
        </section>';

        $tabList = '';
        $tabContent = '';
        $tabId = uniqid('tabs-');
        
        if ( !empty( $settings['tab_list'] ) ) {
            $i = 0;
            foreach ($settings['tab_list'] as $tab) {
                $imgHtml = sprintf($tabImgTmpl, esc_url( $tab['image']['url'] ));
                if ( $i == 0 ) {
                    $tabList .= sprintf($tabItemTmpl, 'active', esc_attr( $tabId . '-' . $i ), esc_html( $tab['tab_title'] ));
                    $tabContent .= sprintf($tabContentTmpl, 'show active', esc_attr( $tabId . '-' . $i ), wp_kses_post( $tab['tab_content'] ), $imgHtml);
                } else {
                    $tabList .= sprintf($tabItemTmpl, '', esc_attr( $tabId . '-' . $i ), esc_html( $tab['tab_title'] ));
                    $tabContent .= sprintf($tabContentTmpl, '', esc_attr( $tabId . '-' . $i ), wp_kses_post( $tab['tab_content'] ), $imgHtml);
                }
                $i++;
            }
        }

        $btnHtml = '';
        $titleHtml = empty( $settings['tab_main_title'] ) ? '' : sprintf($customTitleTmpl, esc_html($settings['tab_main_title']));

        if ( !empty( $settings['tab_button_link'] ) && !empty( $settings['tab_button_label'] ) ) {
            $btnHtml = sprintf($btnTmpl, esc_url($settings['tab_button_link']['url']), esc_html($settings['tab_button_label'] ));
        }

        printf($tabTmpl, esc_attr( $tabId ), $titleHtml, $tabList, $btnHtml, $tabContent, $imgHtml);

    }

    protected function content_template() {}

    public function render_plain_content( $instance = [] ) {}

}
Plugin::instance()->widgets_manager->register_widget_type( new Widget_Custom_Big_Tab_Home );