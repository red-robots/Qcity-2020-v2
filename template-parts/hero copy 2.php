<?php
/*
	Hero's - Only sticky posts here.
*/
	$slug 	= 'sponsored-post';
	$cat 	= get_category_by_slug($slug); 
	$catID 	= $cat->term_id;

$i = 0;
$postIDs = array();
$wp_query = new WP_Query();
$wp_query->query(array(
	'post_type'				=>'post',
	'posts_per_page' 		=> 1,
	'post_status'  			=> 'publish',
	'post__in' 				=> get_option('sticky_posts'),
	'ignore_sticky_posts' 	=> 1,
	'category__not_in' 		=> array( $catID ),
));
if ($wp_query->have_posts()) : ?>
<section class="stickies-new">
	<div class="left ">

	<?php while ($wp_query->have_posts()) :  $wp_query->the_post(); $i++;
		// collect id's to not repeat below
		$postIDs[] 		= get_the_ID();
		$date 			= get_the_date();
		$img 			= get_field('story_image');		
		$title 			= get_the_title();
		$guest_author 	=  get_field('author_name'); 
		//$title 			= (strlen($title) > 94) ? substr($title, 0, 94) . ' ...' : $title;
		
		//var_dump($img);
		
		// First Post
		
	?>
	
		<article class="big-post">
			<?php if( has_post_thumbnail() ) { 
					the_post_thumbnail(); 
			 } elseif( $img ) { ?>					 
					<img src="<?php echo $img['sizes']['photo']; ?>" alt="<?php echo $img['alt']; ?>">
			<?php } else { ?>
					<img src="<?php bloginfo('stylesheet_directory'); ?>/images/default.png">
			<?php } ?>
			<div class="info">				
				<h3><?php echo $title; ?></h3>
				<div class="desc">
					<?php the_excerpt(); ?>
				</div>
				<div class="by">
					By <?php echo ( $guest_author ) ? $guest_author : get_the_author(); ?> | <?php echo get_the_date(); ?> 
				</div>
			</div>
			<div class="article-link"><a href="<?php the_permalink(); ?>"></a></div>
		</article>		
	</div>
	<?php endwhile;
	wp_reset_postdata();

	endif;   ?>

	

	<div class="right">
		<?php

			//add_filter('post_limits', 'returnlimit');	
			$list_posts = array();

			$args = array(
				'post_type'			=>'post',
				'posts_per_page' 	=> 3,
				'post_status'  		=> 'publish',
				'category__not_in' 	=> array( $catID ),
				'orderby' 			=> 'date', 
			    'order' 			=> 'DESC', 
			    //'nopaging' 			=> true,
			    'meta_query' => array(
							        array(
							            //'key' 		=> '_qcity_meta_key',
							            'key'		=> 'custom_meta_post_visibility',
							            'value' 	=> '1',
							            'compare' 	=> '=',
							        )
							    )		
			);

			if($postIDs) {
				$args['post__not_in'] = $postIDs;
			}

			$right_posts = new WP_Query( $args ); 

			if ( $right_posts->post_count  < 3 ){

				$remaining = 3 - $right_posts->post_count;
				$r_post_ids = array();
				if( $x = get_posts_ids($right_posts->posts) ) {
					$r_post_ids[] = $x;
				}

				$exclude_ids = array();
				if($postIDs && $r_post_ids) {
					foreach($postIDs as $id) {
						if(!in_array($id,$r_post_ids)) {
							$exclude_ids[] = $id;
						}
					}
				}
								
				$args2 = array(
					'post_type'			=>'post',
					'posts_per_page' 	=> $remaining,
					'post_status'  		=> 'publish',
					'category__not_in' 	=> array( $catID ),
					'orderby' 			=> 'date', 
				    'order' 			=> 'DESC',				    	
				);

				if($exclude_ids) {
					$args2['post__not_in'] = $exclude_ids;
				}

				$remaining_posts = new WP_Query( $args2 ); 	
			} 

			$recent_query = new WP_Query();

			if ( $right_posts->post_count  < 3 ){
				$recent_query->posts = array_merge( $right_posts->posts, $remaining_posts->posts );
			} else {
				$recent_query->posts = $right_posts->posts;
			}

			$recent_query->post_count = count( $recent_query->posts );	

		
			
			if( $recent_query->have_posts() ):

				$i = 0;
				while ($recent_query->have_posts()) :  $recent_query->the_post();
					$img 	= get_field('story_image');
					$video 	= get_field('video_single_post');
					$author =  get_field('author_name');

					if( $video ):
						$embed = youtube_setup($video);
					endif;

					//$postIDs[] 	= get_the_ID();
					$pid = get_the_ID();
					$text 		= get_the_excerpt();
					$excerpt 	= ( strlen($text) > 100 ) ? substr($text, 0, 100) . ' ...' : $text;

			?>
					<article class="story-block">
						<div class="photo story-home-right">
							<?php if( $video ): ?>	
								<iframe class="video-homepage"  src="<?php echo $embed; ?>"></iframe>
							<?php elseif( has_post_thumbnail() ): ?>	
								<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
							<?php else: ?>	
								<a href="<?php the_permalink(); ?>">
									<img src="<?php echo get_template_directory_uri() . '/images/default.png'; ?>" alt="">
								</a>
							<?php endif; ?>					
						</div>
									
						<div class="desc">
							<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>	
							<div class="excerpt"><?php echo $excerpt; ?></div>
							<div class="by">
								By <?php echo ( $author ) ? $author : get_the_author(); ?> | <?php echo get_the_date(); ?>
							</div>
						</div>
						
						<!--
						<div class="article-link"><a href="<?php the_permalink(); ?>"></a></div>
						-->
					</article>
					<?php
						$i++;
						if($i < 3){
	                        get_template_part( 'template-parts/separator');
	                    }

	                 if($i == 1){
	                 	$ads_right_hero = get_ads_script('right-rail');
	                 	echo '<div class="mobile-version bottom-20 align-center">'. $ads_right_hero['ad_script'] . '</div>';
	                 }   

			 		endwhile; 
			 		wp_reset_postdata();
				 ?>
			</div>
			</section>
		<?php 
		endif;