<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_Custom_Post_Layout extends Widget_Base {

	public function get_name() {
		return 'custom-post-layout';
	}

	public function get_title() {
		return esc_html__( 'Custom Post Layout', 'wp_51405' );
	}

	public function get_icon() {
		return 'eicon-posts-grid';
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'custom_post_layout',
			[
				'label'   => esc_html__( 'Custom Post Layout', 'wp_51405' ),
				'tab'     => Controls_Manager::TAB_LAYOUT,
			]
		);
		$this->add_control(
			'post_layout',
			[
				'label'   => esc_html__( 'Post Layout', 'wp_51405' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => $this->get_templates_names(),
			]
		);
		$this->add_control(
			'post_type',
			[
				'label'   => esc_html__( 'Post Type', 'wp_51405' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'post',
				'options' => $this->cust_get_post_types(),
			]
		);
		$this->add_control(
			'posts_query_post',
			[
				'label'      => esc_html__( 'Query posts by', 'wp_51405' ),
				'type'       => Controls_Manager::SELECT,
				'default'    => 'latest',
				'options'    => array(
					'latest'   => esc_html__( 'Latest Posts', 'wp_51405' ),
					'ids'      => esc_html__( 'By Specific IDs', 'wp_51405' ),
					'category' => esc_html__( 'Category', 'wp_51405' ),
				),
				'condition'   => array(
					'post_type' => 'post',
				),
			]
		);
		$this->add_control(
			'post_ids',
			[
				'label'     => esc_html__( 'Set comma seprated IDs list (10, 22, 19 etc.)', 'wp_51405' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => '',
				'condition' => array(
					'post_type'        => 'post',
					'posts_query_post' => 'ids',
				),
			]
		);
		$this->add_control(
			'post_cat',
			[
				'label'     => esc_html__( 'Choose category', 'wp_51405' ),
				'type'      => Controls_Manager::SELECT2,
				'multiple'  => true,
				'default'   => '',
				'options'   => $this->cust_get_post_categories(),
				'condition' => array(
					'post_type'        => 'post',
					'posts_query_post' => 'category',
				),
			]
		);
		$this->add_control(
			'posts_query_page',
			[
				'label'       => esc_html__( 'Set Page ID', 'wp_51405' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'condition'   => array(
					'post_type' => 'page',
				),
			]
		);
		$this->add_control(
			'posts_query_projects',
			[
				'label'       => esc_html__( 'Choose category', 'wp_51405' ),
				'type'        => Controls_Manager::SELECT2,
				'multiple'    => true,
				'default'     => '',
				'options'     => $this->cust_get_projects_categories(),
				'condition'   => array(
					'post_type' => 'projects',
				),
			]
		);
		$this->add_control(
			'posts_query_team',
			[
				'label'       => esc_html__( 'Choose group', 'wp_51405' ),
				'type'        => Controls_Manager::SELECT2,
				'multiple'    => true,
				'default'     => '',
				'options'     => $this->cust_get_team_groups(),
				'condition'   => array(
					'post_type' => 'team',
				),
			]
		);
		$this->add_control(
			'posts_query_services',
			[
				'label'       => esc_html__( 'Choose services', 'wp_51405' ),
				'type'        => Controls_Manager::SELECT2,
				'multiple'    => true,
				'default'     => '',
				'options'     => $this->cust_get_services_category(),
				'condition'   => array(
					'post_type' => 'cherry-services',
				),
			]
		);
		$this->add_control(
			'posts_query_testimonials',
			[
				'label'       => esc_html__( 'Choose testimonials', 'wp_51405' ),
				'type'        => Controls_Manager::SELECT2,
				'multiple'    => true,
				'default'     => '',
				'options'     => $this->cust_get_testimonials_category(),
				'condition'   => array(
					'post_type' => 'tm-testimonials',
				),
			]
		);
		$this->add_control(
			'query_image',
			[
				'label'   => esc_html__( 'Choose image size', 'wp_51405' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'thumbnail',
				'options' => $this->get_images(),
			]
		);
		$this->add_control(
			'order',
			[
				'label'   => esc_html__( 'Order By', 'wp_51405' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'DESC',
				'options' => array(
					'DESC'  => esc_html__( 'DESC', 'wp_51405' ),
					'ASC'   => esc_html__( 'ASC', 'wp_51405' ),
				),
			]
		);
		$this->add_control(
			'title_trimmed',
			[
				'label'        => esc_html__( 'Title Word Trim', 'wp_51405' ),
				'label_on'     => esc_html__( 'Yes', 'wp_51405' ),
				'label_off'    => esc_html__( 'No', 'wp_51405' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);
		$this->add_control(
			'title_length',
			[
				'label'     => esc_html__( 'Title Length', 'wp_51405' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 5,
				'min'       => 1,
				'max'       => 50,
				'step'      => 1,
				'condition' => array(
					'title_trimmed' => 'yes',
				),
			]
		);
		$this->add_control(
			'title_trimmed_ending_text',
			[
				'label'           => esc_html__( 'Title Trimmed Ending', 'wp_51405' ),
				'type'            => Controls_Manager::TEXT,
				'default'         => '...',
				'condition'       => array(
					'title_trimmed' => 'yes',
				),
			]
		);
		$this->add_control(
			'excerpt_show',
			[
				'label'        => esc_html__( 'Show Excerpt', 'wp_51405' ),
				'label_on'     => esc_html__( 'Yes', 'wp_51405' ),
				'label_off'    => esc_html__( 'No', 'wp_51405' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);
		$this->add_control(
			'excerpt_length',
			[
				'label'     => esc_html__( 'Excerpt Length', 'wp_51405' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 35,
				'min'       => 1,
				'max'       => 200,
				'step'      => 1,
				'condition' => array(
					'excerpt_show' => 'yes',
				),
			]
		);
		$this->add_control(
			'excerpt_ending_text',
			[
				'label'          => esc_html__( 'Excerpt Trimmed Ending', 'wp_51405' ),
				'type'           => Controls_Manager::TEXT,
				'default'        => '...',
				'condition'      => array(
					'excerpt_show' => 'yes',
				),
			]
		);
		$this->add_control(
			'number',
			[
				'label'   => esc_html__( 'Posts Per Page', 'wp_51405' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 3,
				'min'     => -1,
				'max'     => 30,
				'step'    => 1,
			]
		);
		$this->add_responsive_control(
			'columns',
			[
				'label'        => esc_html__( 'Columns', 'wp_51405' ),
				'description'  => esc_html__( 'Except team-big', 'wp_51405' ),
				'type'         => Controls_Manager::NUMBER,
				'default'      => 3,
				'min'          => 1,
				'max'          => 6,
				'device_args'  => [
					Controls_Stack::RESPONSIVE_TABLET => [
						'default'  => 2,
						'max'      => 6,
						'required' => false,
					],
					Controls_Stack::RESPONSIVE_MOBILE => [
						'default'  => 1,
						'max'      => 3,
						'required' => false,
					],
				],
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'owl_carousel_section',
			[
				'label' => esc_html__( 'Owl carousel', 'wp_51405' ),
				'tab'   => Controls_Manager::TAB_LAYOUT,
			]
		);
		$this->add_control(
			'owl_carousel',
			[
				'label'        => esc_html__( 'Enable carousel?', 'wp_51405' ),
				'label_on'     => esc_html__( 'Yes', 'wp_51405' ),
				'label_off'    => esc_html__( 'No', 'wp_51405' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);
		$this->add_control(
			'show_arrows',
			[
				'label'          => esc_html__( 'Show Arrows Navigation', 'wp_51405' ),
				'label_on'       => esc_html__( 'Yes', 'wp_51405' ),
				'label_off'      => esc_html__( 'No', 'wp_51405' ),
				'type'           => Controls_Manager::SWITCHER,
				'return_value'   => 'yes',
				'default'        => 'no',
				'condition'      => array(
					'owl_carousel' => 'yes',
				),
			]
		);
		$this->add_control(
			'show_dots',
			[
				'label'          => esc_html__( 'Show Dots Navigation', 'wp_51405' ),
				'label_on'       => esc_html__( 'Yes', 'wp_51405' ),
				'label_off'      => esc_html__( 'No', 'wp_51405' ),
				'type'           => Controls_Manager::SWITCHER,
				'return_value'   => 'yes',
				'default'        => 'no',
				'condition'      => array(
					'owl_carousel' => 'yes',
				),
			]
		);
		$this->add_control(
			'dots_each',
			[
				'label'          => esc_html__( 'Show Dots Each X Item', 'wp_51405' ),
				'label_on'       => esc_html__( 'Yes', 'wp_51405' ),
				'label_off'      => esc_html__( 'No', 'wp_51405' ),
				'type'           => Controls_Manager::SWITCHER,
				'return_value'   => 'yes',
				'default'        => 'no',
				'condition'      => array(
					'owl_carousel' => 'yes',
					'show_dots'    => 'yes',
				),
			]
		);
		$this->add_control(
			'owl_autoplay',
			[
				'label'          => esc_html__( 'Autoplay', 'wp_51405' ),
				'label_on'       => esc_html__( 'Yes', 'wp_51405' ),
				'label_off'      => esc_html__( 'No', 'wp_51405' ),
				'type'           => Controls_Manager::SWITCHER,
				'return_value'   => 'yes',
				'default'        => 'yes',
				'condition'      => array(
					'owl_carousel' => 'yes',
				),
			]
		);
		$this->add_control(
			'autoplay_timeout',
			[
				'label'     => esc_html__( 'Autoplay Timeout', 'wp_51405' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 5000,
				'condition' => array(
					'owl_carousel' => 'yes',
					'owl_autoplay' => 'yes',
				),
			]
		);
		$this->add_control(
			'animation_speed',
			[
				'label'     => esc_html__( 'Animation Speed', 'wp_51405' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 500,
				'condition' => array(
					'owl_carousel' => 'yes',
				),
			]
		);
		$this->add_control(
			'owl_margin_slide',
			[
				'label'     => esc_html__( 'Space Between Slides', 'wp_51405' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 20,
				'step'      => 1,
				'min'       => 0,
				'max'       => 200,
				'condition' => array(
					'owl_carousel' => 'yes',
				),
			]
		);
		$this->add_control(
			'pause_on_hover',
			[
				'label'          => esc_html__( 'Pause on Hover', 'wp_51405' ),
				'label_on'       => esc_html__( 'Yes', 'wp_51405' ),
				'label_off'      => esc_html__( 'No', 'wp_51405' ),
				'type'           => Controls_Manager::SWITCHER,
				'return_value'   => 'yes',
				'default'        => 'yes',
				'condition'      => array(
					'owl_carousel' => 'yes',
				),
			]
		);
		$this->add_control(
			'infinite_loop',
			[
				'label'          => esc_html__( 'Infinite Loop', 'wp_51405' ),
				'label_on'       => esc_html__( 'Yes', 'wp_51405' ),
				'label_off'      => esc_html__( 'No', 'wp_51405' ),
				'type'           => Controls_Manager::SWITCHER,
				'return_value'   => 'yes',
				'default'        => 'yes',
				'condition'      => array(
					'owl_carousel' => 'yes',
				),
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'custom_posts_background',
			[
				'label' => esc_html__( 'Column', 'wp_51405' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			'posts_column_padding',
			[
				'label'       => esc_html__( 'Column Padding', 'wp_51405' ),
				'type'        => Controls_Manager::DIMENSIONS,
				'size_units'  => array( 'px' ),
				'render_type' => 'template',
				'selectors'   => array(
					'{{WRAPPER}} ' . '.custom_posts_wrapper .custom_posts_item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			]
		);
		$this->add_responsive_control(
			'posts_column_margin',
			[
				'label'       => esc_html__( 'Column Margin', 'wp_51405' ),
				'type'        => Controls_Manager::DIMENSIONS,
				'size_units'  => array( 'px' ),
				'render_type' => 'template',
				'selectors'   => array(
					'{{WRAPPER}} ' . '.custom_posts_wrapper .custom_posts_item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			]
		);
	}

	public function cust_get_post_types() {
		$post_types = get_post_types( array( 'public' => true ), 'objects' );
		$deprecated = array( 'attachment', 'elementor_library' );
		$result = array();
		if ( empty( $post_types ) ) {
			return $result;
		}
		foreach($post_types as $slug => $post_type) {
			if ( in_array( $slug, $deprecated ) ) {
				continue;
			}
			$result[$slug] = $post_type->label;
		}
		return $result;
	}

	public function cust_get_post_categories() {
		$result = array();
		$args = array(
			'type'     => 'post',
			'taxonomy' => 'category',
		);
		$categories = get_categories($args);
		foreach ( $categories as $category ) {
			$result[$category->term_id] = $category->name;
		}
		return $result;
	}

	public function cust_get_projects_categories() {
		$result = array();
		$args = array(
			'hide_empty' => true,
			'taxonomy'   => 'projects_category',
		);
		$categories = get_terms($args);
		foreach ( $categories as $category ) {
			$result[$category->slug] = $category->name;
		}
		return $result;
	}

	public function cust_get_team_groups() {
		$result = array();
		$args = array(
			'hide_empty' => true,
			'taxonomy'   => 'group',
		);
		$categories = get_terms($args);
		foreach ( $categories as $category ) {
			$result[$category->slug] = $category->name;
		}
		return $result;
	}

	public function cust_get_services_category() {
		$result = array();
		$args = array(
			'hide_empty' => true,
			'taxonomy'   => 'cherry-services_category',
		);
		$categories = get_terms($args);
		foreach ( $categories as $category ) {
			$result[$category->slug] = $category->name;
		}
		return $result;
	}

	public function cust_get_testimonials_category() {
		$result = array();
		$args = array(
			'hide_empty' => true,
			'taxonomy'   => 'tm-testimonials_category',
		);
		$categories = get_terms($args);
		foreach ( $categories as $category ) {
			$result[$category->slug] = $category->name;
		}
		return $result;
	}

	public function posts_query() {
		$query_args = array(
			'post_status'    => 'publish',
			'posts_per_page' => $this->get_settings( 'number' ),
			'order'          => $this->get_settings( 'order' ),
		);

		if ( '' !== $this->get_settings( 'post_type' ) ) {
			$query_args['post_type'] = $this->get_settings( 'post_type' );
		}

		if('post' === $this->get_settings( 'post_type' )) {
			switch($this->get_settings( 'posts_query_post')) {
				case 'category':
					if('' !== $this->get_settings('post_cat')) {
						$result = array();
						foreach ($this->get_settings('post_cat') as $category) {
							$result[] = $category;
						}
						$query_args['category__in'] = $result;
					}
				break;
				case 'ids':
					if('' !== $this->get_settings('post_ids')) {
						$query_args['post__in'] = explode(',', str_replace(' ', '', $this->get_settings('post_ids')));
					}
				break;
			}
		} elseif('page' === $this->get_settings( 'post_type' )) {
			if('' !== $this->get_settings('posts_query_page')) {
				$query_args['page_id'] = $this->get_settings('posts_query_page');
			}
		} elseif('projects' === $this->get_settings( 'post_type' )) {
			if('' !== $this->get_settings('posts_query_projects')) {
				$query_args['tax_query'] = array(
					'relation'   => 'OR',
					array(
						'taxonomy' => 'projects_category',
						'field'    => 'slug',
						'terms'    => $this->get_settings('posts_query_projects')
					)
				);
			}
		} elseif('team' === $this->get_settings( 'post_type' )) {
			if('' !== $this->get_settings('posts_query_team')) {
				$query_args['tax_query'] = array(
					'relation'   => 'OR',
					array(
						'taxonomy' => 'group',
						'field'    => 'slug',
						'terms'    => $this->get_settings('posts_query_team')
					)
				);
			}
		} elseif('cherry-services' === $this->get_settings( 'post_type' )) {
			if('' !== $this->get_settings('posts_query_services')) {
				$query_args['tax_query'] = array(
					'relation'   => 'OR',
					array(
						'taxonomy' => 'cherry-services_category',
						'field'    => 'slug',
						'terms'    => $this->get_settings('posts_query_services')
					)
				);
			}
		} elseif('tm-testimonials' === $this->get_settings( 'post_type' )) {
			if('' !== $this->get_settings('posts_query_testimonials')) {
				$query_args['tax_query'] = array(
					'relation'   => 'OR',
					array(
						'taxonomy' => 'tm-testimonials_category',
						'field'    => 'slug',
						'terms'    => $this->get_settings('posts_query_testimonials')
					)
				);
			}
		}
		return new \WP_Query( $query_args );
	}

	protected function owl_settings_callback( $content = null, $settings = array() ) {
		if('yes' !== $settings['owl_carousel']) {
			$current_template_name = $this->get_current_template_name();

			if ( $current_template_name === ' template-gallery-modern ' ) {
				return '<div class="custom_posts_wrapper hoverdir ' . $current_template_name . '" data-lightgallery="group">' . $content . '</div>';
			}

			return '<div class="custom_posts_wrapper' . $current_template_name . '">' . $content . '</div>';
		}
		
		$opts_array = array(
			'responsive' => array(
				'0'                => array('items' => absint( $settings['columns_mobile'] )),
				'767'              => array('items' => absint( $settings['columns_tablet'] )),
				'1025'             => array('items' => absint( $settings['columns'] )),
			),
			'navText'            => '',
			'margin'             => absint( $settings['owl_margin_slide'] ),
			'navSpeed'           => absint( $settings['animation_speed'] ),
			'dotsSpeed'          => absint( $settings['animation_speed'] ),
			'autoplaySpeed'      => absint( $settings['animation_speed'] ),
			'autoplayTimeout'    => absint( $settings['autoplay_timeout'] ),
			'loop'               => filter_var( $settings['infinite_loop'], FILTER_VALIDATE_BOOLEAN ),
			'nav'                => filter_var( $settings['show_arrows'], FILTER_VALIDATE_BOOLEAN ),
			'dots'               => filter_var( $settings['show_dots'], FILTER_VALIDATE_BOOLEAN ),
			'autoplay'           => filter_var( $settings['owl_autoplay'], FILTER_VALIDATE_BOOLEAN ),
			'autoplayHoverPause' => filter_var( $settings['pause_on_hover'], FILTER_VALIDATE_BOOLEAN ),
			'dotsEach'           => filter_var( $settings['dots_each'], FILTER_VALIDATE_BOOLEAN ),
		);

		$current_template_name = $this->get_current_template_name();
		if ( $current_template_name === ' template-service-creative ' ) {
			return sprintf(
				'<div class="custom_posts_wrapper owl-carousel owl-style-3 dots-style-2' . $current_template_name . '" data-owl-options="%1$s">%2$s</div>',
				htmlspecialchars( json_encode( $opts_array ) ), $content
			);
		}

		if ( $current_template_name === ' template-project-featured ' ) {
			return sprintf(
				'<div class="owl-style-4"><div class="custom_posts_wrapper owl-carousel dots-style-2' . $current_template_name . '" data-owl-options="%1$s">%2$s</div></div>',
				htmlspecialchars( json_encode( $opts_array ) ), $content
			);
		}

		return sprintf(
			'<div class="custom_posts_wrapper owl-carousel owl-theme' . $current_template_name . '" data-owl-options="%1$s">%2$s</div>',
			htmlspecialchars( json_encode( $opts_array ) ), $content
		);
	}

	protected function render() {
		$settings = $this->get_settings();
		echo $this->owl_settings_callback( $this->do_shortcode(), $settings );
	}

	public function do_shortcode() {
		if('' !== $this->get_settings('post_layout')) {
			$template_name = $this->get_settings('post_layout');
		}
		$template = get_template_directory() . '/elementor-ext/widgets/post-templates/' . $template_name . '.php';
		if (file_exists($template)) {
			return require $template;
		} else {
			return $this->get_default_template();
		}
	}

	public function get_classes( $columns = array() ) {
		if('yes' === $this->get_settings('owl_carousel')) {
			return;
		}
		$columns = wp_parse_args( $columns, array(
			'desk' => 1,
			'tab'  => 1,
			'mob'  => 1,
		));
		$classes = array();
		foreach ( $columns as $device => $cols ) {
			if ( ! empty( $cols ) ) {
				$classes[] = sprintf( 'col-%1$s-%2$s', $device, $cols );
			}
		}
		return implode( ' ' , $classes );
	}

	public function get_templates_names() {
		$result = array();
		$scandir = scandir(get_template_directory() . '/elementor-ext/widgets/post-templates/');
		foreach($scandir as $dir) {
			if($dir == '.' || $dir == '..') {
				continue;
			} else {
				$dir = str_replace('.php', '', $dir);
				$result[$dir] = $dir;
			}
		}
		return $result;
	}

	public function get_current_template_name() {
		if('' !== $this->get_settings('post_layout')) {
			$template_name = $this->get_settings('post_layout');
			if(file_exists(get_template_directory() . '/elementor-ext/widgets/post-templates/' . $template_name . '.php')) {
				$result = 'template-' . strtolower($template_name);
				$result = str_replace(' ', '', $result);
				$result = ' ' . $result . ' ';
				return $result;
			}
			return ' template-default ';
		}
		return ' template-default ';
	}

	public function get_images() {
		global $_wp_additional_image_sizes;
		$sizes = get_intermediate_image_sizes();
		$result = array();
		foreach($sizes as $size) {
			if( in_array( $size, array('thumbnail', 'medium', 'medium_large', 'large' ) ) ) {
				$result[ $size ] = ucwords( trim( str_replace( array( '-', '_' ), array( ' ', ' ' ), $size ) ) );
			} else {
				$result[ $size ] = sprintf(
					'%1$s (%2$sx%3$s)',
					ucwords( trim( str_replace( array( '-', '_' ), array( ' ', ' ' ), $size ) ) ),
					$_wp_additional_image_sizes[ $size]['width'],
					$_wp_additional_image_sizes[ $size]['height']
				);
			}
		}
		return array_merge( array( 'full' => esc_html__( 'Full', 'jet-elements' ), ), $result );
	}
			
	public function get_image_url( $current_img = false ) {
		if($current_img) {
			$img_size = $current_img;
		} elseif ('' !== $this->get_settings('query_image') && !$current_img) {
			$img_size = $this->get_settings('query_image');
		} else {
			$img_size = 'thumbnail';
		}
		$thumb_id  = get_post_thumbnail_id();
		$image_url = wp_get_attachment_image_url( $thumb_id, $img_size );
		return $image_url;
	}

	public function get_image_url_thumb_full( $current_img = false ) {
		$thumb_id  = get_post_thumbnail_id();
		$image_url = wp_get_attachment_image_url( $thumb_id, 'full' );
		return $image_url;
	}

	public function get_posts_content() {
		$content = get_the_content();
		$content = strip_tags(strip_shortcodes($content));
		if('yes' !== $this->get_settings('excerpt_show')) {
			return;
		}
		$length = $this->get_settings('excerpt_length');
		$after = $this->get_settings('excerpt_ending_text');
		$content = wp_trim_words($content, $length, $after);
		return $content;
	}

	public function get_posts_title() {
		$title = get_the_title();
		if('yes' !== $this->get_settings('title_trimmed')) {
			return $title;
		}
		$length = $this->get_settings('title_length');
		$after = $this->get_settings('title_trimmed_ending_text');
		$title = wp_trim_words($title, $length, $after);
		return $title;
	}

	protected function content_template() {}

	public function render_plain_content($instance = []) {}

	public function get_default_template() {
		ob_start();
		$query = $this->posts_query();
		if ( ! $query->have_posts() ) {
			echo 'Posts Not Found!';
		}
		while ( $query->have_posts() ) {
			$query->the_post();
			/*==============================================================*/
				$date              = get_the_date('d / F / Y');
				$permalink         = get_the_permalink();
				$img_url           = $this->get_image_url();
				$img_url_cust_size = $this->get_image_url('full');
				$title             = $this->get_posts_title();
				$content           = $this->get_posts_content();
				$category          = $this->get_settings('post_cat');
				$comments          = wp_count_comments(get_the_ID())->total_comments;
				$author            = get_the_author();
				$author_email      = get_the_author_meta('email');
				$author_img        = get_avatar_url($author_email, 69);
				$custom_field      = get_post_meta(get_the_ID(), 'value', true);
				$columns           = $this->get_classes(array(
					'desk' => $this->get_settings('columns'),
					'tab'  => $this->get_settings('columns_tablet'),
					'mob'  => $this->get_settings('columns_mobile'),
				));
			/*==============================================================*/
			?>
			<div class="custom_posts_item <?php echo $columns; ?>">

				<!-- ---------------------- Template Start ---------------------- -->
				<img src="<?php echo $img_url; ?>" alt="<?php echo $title; ?>">
				<h3><?php echo $title; ?></h3>
				<p><?php echo $content; ?></p>
				<div class="time"><time><?php echo $date; ?></time></div>
				<a class="btn" href="<?php echo $permalink; ?>"><?php _e('Read More', 'wp_51405'); ?></a>
				<!-- ---------------------- Template End ------------------------ -->

			</div>
			<?php
		}
		wp_reset_postdata();
		return ob_get_clean();
	}

}
	Plugin::instance()->widgets_manager->register_widget_type(new Widget_Custom_Post_Layout);
?>