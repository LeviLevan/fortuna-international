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

		$position = '';
		$social_list = '';	

		if ( get_post_type() === 'team' ){
			$position = get_post_meta(get_the_ID(), 'cherry-team-position', true);
			$social_list_meta = get_post_meta(get_the_ID(), 'cherry-team-social', true);

			if ( !empty( $social_list_meta ) && is_array( $social_list_meta ) ) {
				foreach ($social_list_meta as $item) {
					$social_list .= '<li><a class="icon '. esc_attr($item['icon']) .'" href="'. esc_url($item['url']) .'"></a></li>';
				}
			}
		}
		
		/*==============================================================*/
		?>
		<div class="custom_posts_item <?php echo $columns; ?>">

			<!-- ---------------------- Template Start ---------------------- -->

			<article class="team-modern">
			    <a class="team-modern-figure" href="<?php echo $permalink; ?>">
			        <img src="<?php echo $image_url; ?>" alt="" />
			    </a>
			    <div class="team-modern-caption">
			        <h6 class="team-modern-name">
			            <a href="<?php echo $permalink; ?>"><?php echo $title; ?></a>
			        </h6>
			        <div class="team-modern-status"><?php echo $position; ?></div>
			        <ul class="list-inline team-modern-social-list">
			            <?php echo $social_list; ?>
			        </ul>
			    </div>
			</article>

			<!-- ---------------------- Template End ------------------------ -->

		</div>
		<?php
	}
	wp_reset_postdata();
	return ob_get_clean();