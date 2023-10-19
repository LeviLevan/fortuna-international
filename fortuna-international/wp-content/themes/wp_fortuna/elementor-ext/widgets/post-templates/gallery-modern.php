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
		$category     = $this->get_settings('post_type');
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

		$bigImageAttr = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'thumbnail-1200-800' );
		$bigImgUrl = $bigImageAttr ? $bigImageAttr[0] : '';

		/*==============================================================*/
		?>
		<div class="custom_posts_item <?php echo $columns; ?>">

			<!-- --------------------- Template Start ---------------------- -->

			<article class="thumbnail thumbnail-modern wow slideInUp hoverdir-item" data-hoverdir-target=".thumbnail-modern-caption">
				<a class="thumbnail-modern-figure" href="<?php echo esc_url($bigImgUrl); ?>" data-lightgallery="item">
					<img src="<?php echo $image_url; ?>" alt="" />
				</a>
                <div class="thumbnail-modern-caption">
                    <h5 class="thumbnail-modern-title">
                    	<a href="<?php echo $permalink; ?>"><?php echo $title; ?></a>
                    </h5>
					<?php if ( !empty( $category ) ) { ?>
			            <div class="thumbnail-modern-badge"><?php echo $category; ?></div>
		            <?php } ?>
                </div>
            </article>

			<!-- ---------------------- Template End ------------------------ -->

		</div>
		<?php
	}
	wp_reset_postdata();
	return ob_get_clean();