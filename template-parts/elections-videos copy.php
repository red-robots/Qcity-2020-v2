<?php
$whichCatId = get_field("elect_which_category","option");
$queried = get_queried_object();
$current_term_id = ( isset($queried->term_id) && $queried->term_id ) ? $queried->term_id : '';
$current_term_name = ( isset($queried->name) && $queried->name ) ? $queried->name : '';
$current_term_slug = ( isset($queried->slug) && $queried->slug ) ? $queried->slug : '';
$current_term_link = get_term_link($queried);
$perpage_mobile = 2;
$has_videos = false;

if($whichCatId==$current_term_id) {
	$term = get_term($whichCatId);
	$page_term = $term->slug;
	?>
	<div id="carousel-container" class="wrapper">

		<?php  
			/* SHOW POSTS WITH VIDEOS */
			$video_perpage_desktop = get_field("elect_video_perpage_desktop","option");
			$video_perpage_mobile = get_field("elect_video_perpage_mobile","option");
			$perpage_desktop = ($video_perpage_desktop) ? $video_perpage_desktop : 4;
			$perpage_mobile = ($video_perpage_mobile) ? $video_perpage_mobile : 2;

			// $perpage = 12;
			$perpage = ( isset($_GET['perpage']) &&  $_GET['perpage'] ) ? $_GET['perpage'] : $perpage_desktop;
			$excludePosts = array();

			$paged = ( get_query_var( 'pg' ) ) ? absint( get_query_var( 'pg' ) ) : 1;
			$i = 0;
			$day = date('d');
			$day2 = $day - 1;
			$day_plus = sprintf('%02s', $day2);
			$today = date('Ym') . $day_plus;
			$video_args = array(
				'post_type'				=>'post',
				'post_status'			=>'publish',
				'orderby'     		=> 'rand',
				'order' 					=> 'ASC',
				'posts_per_page' 	=> $perpage,
				'paged'			  	 	=> $paged,
				'meta_query' 			=> array(
						array(
							'key'				=> 'video_single_post',
							'compare'		=> '!=',
							'value'			=> '',
						)			
				),
				'tax_query' 			=> array(
					array(
						'taxonomy' 		=> 'category', 
						'field' 			=> 'slug',
						'terms' 			=> array($page_term) 
					)
				)
			);

			$videos = new WP_Query($video_args);
			//$count = $custom_posts->found_posts;
			$video_placeholder = THEMEURI . "images/video-helper.png";
			$video_section_title = get_field("elect_video_section_title","option");
		?>

		<?php if ( $videos->have_posts() ) { 
			$count = $videos->found_posts; 
			$has_videos = true;
			?>
			<div class="carousel-posts-wrap">
				<div class="mobile-carousel-posts" data-perpage-desktop="<?php echo $perpage_desktop ?>" data-perpage-mobile="<?php echo $perpage_mobile ?>">
					
					<div class="carousel-posts-inner" data-total="<?php echo $count ?>">
						<div class="carousel-posts">
							<div id="carouselPosts" class="slider posts-group">
								<?php
									$v=1; while ( $videos->have_posts() ) : $videos->the_post(); ?>
									<?php 
										$title = get_the_title();
										$post_date = get_the_date();
										$excludePosts[] = get_the_ID();
										$videoLink = get_field("video_single_post"); 
										$youtubeLink = ($videoLink) ? youtube_setup($videoLink):'';
										$hide_items = '';
										if($v>$perpage_mobile && $paged==1) {
											//$hide_items = ' hide-item';
										}
									?>
									<?php if ($youtubeLink) { ?>
									<div id="entryNum<?php echo $v;?>" class="entry<?php echo $hide_items ?>">
										<div class="inside">
											<div class="video-iframe">
												<img src="<?php echo $video_placeholder ?>" alt="" aria-hidden="true" class="video-helper">
											</div>	
											<div class="video-info">
												<h3 class="title"><?php echo $title ?></h3>
												<!-- <p class="postdate"><?php //echo $post_date ?></p> -->
												<?php if ( get_the_excerpt() ) { ?>
												<p class="excerpt"><?php echo get_the_excerpt(); ?></p>
												<?php } ?>
											</div>
										</div>
									</div>	
									<?php } ?>
								<?php $v++; endwhile; wp_reset_postdata(); ?>
							</div>
						</div>

						<div id="hiddenItems" style="display:none;"><!-- DO NOT DELETE --></div>

						<?php
			        $total_pages = $videos->max_num_pages;
			        if ($total_pages > 1){ ?>
			            <div id="more-video-btn" data-perpage-mobile="<?php echo $perpage_mobile ?>">
			            	<div class="more"> 
						            <a href="#" id="more-elections-videos" class="red" data-totalpages="<?php echo $total_pages ?>" data-baseurl="<?php echo $current_term_link; ?>" data-page="2">        
						                <span class="load-text">Load More</span>
						                <span class="load-icon"><svg class="svg-inline--fa fa-sync-alt fa-w-16 spin" aria-hidden="true" data-prefix="fas" data-icon="sync-alt" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M370.72 133.28C339.458 104.008 298.888 87.962 255.848 88c-77.458.068-144.328 53.178-162.791 126.85-1.344 5.363-6.122 9.15-11.651 9.15H24.103c-7.498 0-13.194-6.807-11.807-14.176C33.933 94.924 134.813 8 256 8c66.448 0 126.791 26.136 171.315 68.685L463.03 40.97C478.149 25.851 504 36.559 504 57.941V192c0 13.255-10.745 24-24 24H345.941c-21.382 0-32.09-25.851-16.971-40.971l41.75-41.749zM32 296h134.059c21.382 0 32.09 25.851 16.971 40.971l-41.75 41.75c31.262 29.273 71.835 45.319 114.876 45.28 77.418-.07 144.315-53.144 162.787-126.849 1.344-5.363 6.122-9.15 11.651-9.15h57.304c7.498 0 13.194 6.807 11.807 14.176C478.067 417.076 377.187 504 256 504c-66.448 0-126.791-26.136-171.315-68.685L48.97 471.03C33.851 486.149 8 475.441 8 454.059V320c0-13.255 10.745-24 24-24z"></path></svg><!-- <i class="fas fa-sync-alt spin"></i> --></span>
						            </a>
						        </div>
			            </div>	
			            <?php
			        } ?>
					</div>

				</div>
			</div>

		<?php } ?>

	</div><!-- end of .wrapper -->
<?php } ?>

