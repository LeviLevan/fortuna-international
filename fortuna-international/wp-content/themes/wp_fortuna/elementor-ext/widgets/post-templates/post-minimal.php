<?php
	ob_start();
	$query = $this->posts_query();
	if ( ! $query->have_posts() ) {
		echo 'Posts Not Found!';
	}
	while ( $query->have_posts() ) {
		$query->the_post();
		/*==============================================================*/
		$date         = get_the_date('Y-m-d');
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
		
		/*==============================================================*/
		?>
		<div class="custom_posts_item wow fadeInUp <?php echo $columns; ?>">
			<div class="list-popular-post">
                <div class="list-popular-post-item wow fadeInRight">
					<article class="post post-minimal post-minimal-2">
					    <div class="unit unit-spacing-2 align-items-center flex-column text-center flex-sm-row text-sm-left">
					        <div class="unit-left">
					        	<a class="post-minimal-figure" href="<?php echo $permalink; ?>">
					        		<img src="<?php echo $image_url; ?>" alt="<?php echo $title; ?>" width="115" height="89" />
					        	</a>
					        </div>
					        <div class="unit-body">
					            <p class="post-minimal-title">
					            	<a href="<?php echo $permalink; ?>"><?php echo $title; ?></a>
					            </p>
					            <div class="post-minimal-time">
					                <time datetime="<?php echo $date; ?>"><?php echo get_the_date('F d, Y'); ?></time>
					            </div>
					        </div>
					    </div>
					</article>
				</div>
			</div>
		</div>
		<?php
	}
	wp_reset_postdata();
	return ob_get_clean();