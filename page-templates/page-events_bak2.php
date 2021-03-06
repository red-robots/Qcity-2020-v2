<?php
/**
 *
 */

get_header(); 
get_template_part('template-parts/banner-events');
?>

<div class="">

	<div class="single-page-event">

			<div class="qcity-sponsored-container">

				
				<?php				
					$i = 0;
					$postID = array();
					$today = date('Ymd');
					$wp_query = new WP_Query();
					$wp_query->query(array(
						'post_type'		=>'event',
						'post_status'	=>'publish',
						'order' 		=> 'ASC',
						'meta_key' 		=> 'event_date',
						'orderby' 		=> 'event_date',
						'posts_per_page' => -1,
						/*'meta_query' => array(
							array(
						        'key'		=> 'event_date',
						        'compare'	=> '>=',
						        'value'		=> $today,
						    ),
					    ),*/
					    'tax_query' => array(
							array(
								'taxonomy' 	=> 'event_category', 
								'field' 	=> 'slug',
								'terms' 	=> array( 'premium' ) 
							)
						)
				));
				if ($wp_query->have_posts()) : ?>
					<header class="section-title ">
						<h1 class="dark-gray">Sponsored</h1>
					</header>
					<section class="events">
					<?php while ($wp_query->have_posts()) : $wp_query->the_post(); 

								$date 		= get_field("event_date", false, false);
								$date 		= new DateTime($date);
								$enddate 	= get_field("end_date", false, false);
								$enddate 	= ( !empty($enddate) ) ? new DateTime($enddate) : $date;

								$date_start 	= strtotime($date->format('Y-m-d'));
								$date_stop 		= strtotime($enddate->format('Y-m-d'));
								$day = date('d');
								$day_plus = $day - 1;
								$today = date('Y-m-') . '-' . $day_plus;

								$now 			= strtotime(date('Y-m-d'));
								//$now 			= strtotime($today);

								if( $date_stop >= $now ){									

									$postID[] = get_the_ID();
									include( locate_template('template-parts/sponsored-block.php') );
								}
								
						endwhile; ?>
					</section>
				<?php endif; wp_reset_postdata();  ?>
			</div>

		<header class="section-title qcity-more-happen">
			<h1 class="dark-gray">More Happenings</h1>
		</header>

		<div id="primary" class="content-area-event">
			<main id="main" class="site-main" role="main">
				<div class="page-event-list">

					<div class="listing_initial">

						<div class="qcity-news-container">

							<?php
							/*
								The Rest of the Events 
							*/
								$i = 0;
								$events = array();
								$today = date('Ymd');
								$query = new WP_Query();
								$query->query(array(
									'post_type'			=>'event',
									'post_status'		=>'publish',
									'posts_per_page' 	=> 27,
									'post__not_in' 		=> $postID,
									'order' 			=> 'ASC',
									'meta_key' 			=> 'event_date',
									'orderby' 			=> 'event_date',
									'paged'             => 1,
									'meta_query' 		=> array(
															'relation' => 'OR',
															array(
														        'key'		=> 'event_date',
														        'compare'	=> '>=',
														        'value'		=> $today,
														    ),
														    array(
														        'key'		=> 'end_date',
														        'compare'	=> '>=',
														        'value'		=> $today,
														    ),
								    ),							   
								));
								if ( $query->have_posts() ) : ?>
									
									<section class="events">
										<?php while ($query->have_posts()) : $query->the_post(); 

											$date 		= get_field("event_date", false, false);
											$date 		= new DateTime($date);
											$enddate 	= get_field("end_date", false, false);
											$enddate 	= ( !empty($enddate) ) ? new DateTime($enddate) : $date;

											$date_start 	= strtotime($date->format('Y-m-d'));
											$date_stop 		= strtotime($enddate->format('Y-m-d'));
											$now 			= strtotime(date('Y-m-d'));							
										
											if( $date_stop > $now ){									
												include( locate_template('template-parts/sponsored-block.php') );
											}

										endwhile; ?>
									</section>									
								<?php else: ?>
									<div>No Events available.</div>
								<?php endif; wp_reset_postdata(); ?>

						</div>

						<?php if( $query->have_posts()  ): ?>
							<div class="more ">	
							 	<a class="red qcity-load-more" data-page="1" data-action="qcity_events_load_more" data-except="<?php echo implode(',', $postID); ?>" data-basepoint="27" data-perpage="9" >		
							 		<span class="load-text">Load More</span>
									<span class="load-icon"><i class="fas fa-sync-alt spin"></i></span>
							 	</a>
							</div>
						<?php endif; ?>

						

					</div>

					

				</div>

				<div class="listing_search" style="margin-bottom: 20px; padding: 0 0 40px;">
							<div class="listing_search_result">				
							</div>				
				</div>


			</main><!-- #main -->
		</div><!-- #primary -->

	</div>

</div>


<?php get_footer();
