<?php
/**
 * Template Name: Events
 *
 * 
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package ACStarter
 */

get_header(); 
get_template_part('template-parts/banner-events');
$currentURL = get_permalink();
?>

<div class="">

	<div class="single-page-event">

		<?php
		/* SPONSORED EVENTS */
		$i = 0;
		$day = date('d');
		$day_plus = $day - 1;
		$today = date('Ym') . $day_plus;

		$postID = array();
		$args = array(
			'post_type'			=>'event',
			'post_status'		=>'publish',
			'posts_per_page' 	=> -1,
			'order' 			=> 'ASC',
			'meta_key' 		=> 'event_date',
			'orderby'     => 'meta_value_num',
			'meta_query' 		=> array(
				array(
					'key'		=> 'event_date',
					'compare'	=> '>=',
					'value'		=> $today,
				),		
			),
			'tax_query' => array(
				array(
					'taxonomy' 	=> 'event_category', 
					'field' 	=> 'slug',
					'terms' 	=> array( 'premium' ) 
				)
			)
		);

		$sponsored = new WP_Query($args);
		if ($sponsored->have_posts()) { ?>
		<div class="qcity-sponsored-container">
			<header class="section-title ">
				<h1 class="dark-gray">Sponsored</h1>
			</header>
			<section class="events">
				<?php while ($sponsored->have_posts()) : $sponsored->the_post(); 
					$date 		= get_field("event_date", false, false);
					$date 		= new DateTime($date);
					$enddate 	= get_field("end_date", false, false);
					$enddate 	= ( !empty($enddate) ) ? new DateTime($enddate) : $date;

					$date_start 	= strtotime($date->format('Y-m-d'));
					$date_stop 		= strtotime($enddate->format('Y-m-d')); 
					$postID[] = get_the_ID();
					include( locate_template('template-parts/sponsored-block.php') );
				endwhile; ?>
			</section>
		</div>
		<?php } ?>

			


		<?php 
		/* MORE EVENTS */
		$i = 0;
		$events = array();
		$paged = ( get_query_var( 'pg' ) ) ? absint( get_query_var( 'pg' ) ) : 1;
		$more_args = array(
			'post_type'			=>'event',
			'paged'			   => $paged,
			'post_status'		=>'publish',
			'posts_per_page' 	=> 6,
			'order' 			=> 'ASC',
			'meta_key' 		=> 'event_date',
			'orderby'     => 'meta_value_num',
			'meta_query' 		=> array(
				array(
					'key'		=> 'event_date',
					'compare'	=> '>=',
					'value'		=> $today,
				),		
			)
		);

		if($postID) {
			$more_args['post__not_in'] = $postID;
		}
		$more_events = new WP_Query($more_args);
		?>

		<header class="section-title qcity-more-happen">
			<h1 class="dark-gray">More Happenings</h1>
		</header>
		<div id="primary" class="content-area-event">
				<main id="main" class="site-main" role="main">
					<div class="page-event-list">
						<?php if ( $more_events->have_posts() )  { ?>
						<div class="listing_initial more-events-section">
							<div class="qcity-news-container">
								<section class="events more-events-posts">
									<?php while ($more_events->have_posts()) : $more_events->the_post(); 
											$date 		= get_field("event_date", false, false);
											$date 		= new DateTime($date);
											$enddate 	= get_field("end_date", false, false);
											$enddate 	= ( !empty($enddate) ) ? new DateTime($enddate) : $date;

											$date_start 	= strtotime($date->format('Y-m-d'));
											$date_stop 		= strtotime($enddate->format('Y-m-d'));
											$now 			= strtotime(date('Y-m-d'));
											include( locate_template('template-parts/sponsored-block.php') );
										endwhile; ?>
								</section>
							</div>
							<div id="more-posts-hidden" style="display:none;"><!-- DO NOT DELETE ME! --></div>

							<?php
                $total_pages = $more_events->max_num_pages;
                if ($total_pages > 1){ ?>

                    <div id="pagination" class="pagination" style="display:none;">
                        <?php
											    $pagination = array(
														'base' => @add_query_arg('pg','%#%'),
														'format' => '?pg=%#%',
														'mid-size' => 1,
														'current' => $paged,
														'total' => $total_pages,
														'prev_next' => True,
														'prev_text' => __( '<span class="fa fa-arrow-left"></span>' ),
														'next_text' => __( '<span class="fa fa-arrow-right"></span>' )
											    );
											    echo paginate_links($pagination);
											  ?>
                    </div>

                    <div id="more-bottom-button" class="more">	
										 	<a href="#" id="load-more-action" class="red" data-permalink="<?php echo $currentURL; ?>" data-next-page="2" data-total-pages="<?php echo $total_pages; ?>">		
										 		<span class="load-text">Load More</span>
												<span class="load-icon"><i class="fas fa-sync-alt spin"></i></span>
										 	</a>
										</div>

                    <?php
            	} ?>

            	



						</div>
						<?php } else { ?>
							<div>No Events available.</div>
						<?php } ?>
					</div>

					<div class="listing_search" style="margin-bottom: 20px; padding: 0 0 40px;">
						<div class="listing_search_result"></div>				
					</div>
				</main>
		</div>

	</div>

</div>


<?php get_footer();
