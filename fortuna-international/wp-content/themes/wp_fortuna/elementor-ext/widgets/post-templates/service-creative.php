<?php
	ob_start();
	$query = $this->posts_query();
	if ( ! $query->have_posts() ) {
		echo 'Posts Not Found!';
	}
	$servicesCreativeCounter = 1;

	while ( $query->have_posts() ) {
		$query->the_post();
		/*==============================================================*/
		$date         = get_the_date('F d. Y');
		$permalink    = get_the_permalink();
		$image_url    = $this->get_image_url();
		$title        = $this->get_posts_title();
		$content      = $this->get_posts_content();
		$category     = $this->get_settings('post_cat');
		$comments     = wp_count_comments(get_the_ID())->total_comments;
		$author       = get_the_author();
		$author_email = get_the_author_meta('email');
		$author_name = get_the_author_meta('display_name');
		$author_link  = get_the_author_link();
		$author_id = get_the_author_meta('ID');
    	$author_link  = get_author_posts_url($author_id);
		$author_img   = get_avatar_url($author_email, 69);
		$custom_field = get_post_meta(get_the_ID(), 'value', true);
		$columns      = $this->get_classes(array(
			'desk' => $this->get_settings('columns'),
			'tab'  => $this->get_settings('columns_tablet'),
			'mob'  => $this->get_settings('columns_mobile'),
		));

		$descr = '';

		if ( get_post_type( get_the_ID() ) === 'cherry-services' ) {
			$descr = get_post_meta(get_the_ID(), 'cherry-services-descr', true);
		}
		
		/*==============================================================*/
		?>
		<div class="custom_posts_item <?php echo $columns; ?>">


			<article class="services-creative">
				<a class="services-creative-figure" href="<?php echo $permalink; ?>">
					<img src="<?php echo $image_url; ?>" alt="" />
				</a>
			    <div class="services-creative-caption">
			        <h5 class="services-creative-title">
			        	<a href="<?php echo $permalink; ?>"><?php echo $title; ?></a>
			        </h5>
			        <p class="services-creative-text"><?php echo wp_kses_post($descr); ?></p>
			        <span class="services-creative-counter box-ordered-item">
			        	<?php echo ($servicesCreativeCounter < 10 ? esc_html('0' . $servicesCreativeCounter) : esc_html($servicesCreativeCounter)); ?>
			        </span>
			    </div>
			</article>


		</div>
		<?php
		$servicesCreativeCounter++;
	}
	wp_reset_postdata();
	return ob_get_clean();