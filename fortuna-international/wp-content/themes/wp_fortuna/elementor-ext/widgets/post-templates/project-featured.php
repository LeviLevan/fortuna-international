<?php
	ob_start();
	$query = $this->posts_query();
	if ( ! $query->have_posts() ) {
		echo 'Posts Not Found!';
	}

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

		$location = '';
		$descr = '';

		if ( get_post_type( get_the_ID() ) === 'projects' ) {
			$location = esc_html( get_post_meta(get_the_ID(), 'cherry_projects_location', true) );
			$descr = wp_kses_post( get_post_meta(get_the_ID(), 'cherry_projects_descr', true) );
		}
		
		/*==============================================================*/
		?>
		<div class="custom_posts_item <?php echo $columns; ?>">

			<!-- ---------------------- Template Start ---------------------- -->

			<article class="project-classic">
				<a class="project-classic-figure" href="<?php echo $permalink; ?>">
					<img src="<?php echo $image_url; ?>" alt="<?php echo $title; ?>" />
				</a>
		        <div class="project-classic-caption">
		            <h5 class="project-classic-title">
		            	<a href="<?php echo $permalink; ?>"><?php echo $title; ?></a>
		            </h5>
		            <?php if ( !empty( $location ) ) { ?>
			            <div class="project-classic-location">
			            	<span class="icon mdi mdi-map-marker"></span>
			            	<span><?php echo $location; ?></span>
			            </div>
		            <?php } ?>
		            <?php if ( !empty( $descr ) ) { ?>
			            <p class="project-classic-text"><?php echo $descr ?></p>
		            <?php } ?>
		        </div>
		    </article>

			<!-- ---------------------- Template End ------------------------ -->

		</div>
		<?php
	}
	wp_reset_postdata();
	return ob_get_clean();