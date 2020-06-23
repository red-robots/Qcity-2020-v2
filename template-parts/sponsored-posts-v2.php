<?php
/*
	Sponsored Row
*/
	$i = 0;
	$today = date('Ymd');
	

$wp_query = new WP_Query();

$wp_query->query(array(
	'post_type'			=>'event',
	'post_status'		=>'publish',
	'posts_per_page' 	=> 4,
	'order' 			=> 'ASC',
	'meta_key' 			=> 'event_date',
	'orderby' 			=> 'event_date',
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
));
	if ($wp_query->have_posts()) : ?>
	<section class="home-sponsored">
		<header class="section-title ">
			<h2 class="dark-gray">Sponsor Events</h2>
		</header>
		<div class="flexwrap">
			<?php while ($wp_query->have_posts()) : $wp_query->the_post(); 
				$img 		= get_field('event_image');
				$date 		= get_field("event_date", false, false);
				$date 		= new DateTime($date);
				$enddate 	= get_field("end_date", false, false);
				$enddate 	= new DateTime($enddate);
				
			?>
				<div class="block sponsored_post_block" style="background-image: url(<?php echo $img['url']; ?>);">
					<a href="<?php the_permalink(); ?>">
						<div class="info js-blocks">
							<div class="date">
								<?php echo $date->format('D | M j, Y'); ?>	
							</div>
							<h3><?php the_title(); ?></h3>
						</div>
					</a>
				</div>
			<?php endwhile; ?>

			
			<div class="block last-block desktop-version" style="background-image: url('<?php bloginfo('stylesheet_directory'); ?>/images/city.jpg');">
				<div class="overlayz">
					<a href="<?php bloginfo('url'); ?>/events"></a>
				</div>
				<div class="more">
					More Events
				</div>
			</div>

			<div class="mobile-version">
				<div class="more">
					<a class="red" href="<?php bloginfo('url'); ?>/events">More Events</a>
				</div>
			</div>		

		</div>
	</section>
<?php 
endif;
wp_reset_postdata();
 
