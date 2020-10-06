<?php
/*
	Sponsored Row
*/
$i = 0;
$day = date('d');
$day2 = $day - 1;
$day_plus = sprintf('%02s', $day2);
$today = date('Ym') . $day_plus;
	
$box_rectangle = get_bloginfo("template_url") . "/images/boxr.png";
$wp_query = new WP_Query();

$wp_query->query(array(
	'post_type'			=>'event',
	'post_status'		=>'publish',
	'posts_per_page' 	=> 5,
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
	if ($wp_query->have_posts()) : 
	$totalpost = $wp_query->found_posts;  ?>
	<section class="home-sponsored v2 numItems<?php echo $totalpost?>">
		<header class="section-title ">
			<h2 class="dark-gray">Sponsored Events</h2>
		</header>

		<div class="outerwrap">
			<div class="flexwrap2">
				<?php while ($wp_query->have_posts()) : $wp_query->the_post(); 
					$img 		= get_field('event_image');
					$date 		= get_field("event_date", false, false);
					$date 		= new DateTime($date);
					$enddate 	= get_field("end_date", false, false);
					$enddate 	= new DateTime($enddate);
					$defaultImg = get_bloginfo("template_url") . "/images/event-placeholder.png";
					$imgSRC = ($img) ? $img['url'] : $defaultImg;
				
				?>
				<div class="block sponsored_post_block">
					<a href="<?php the_permalink(); ?>" class="boxLink">
						<span class="wrap" style="background-image:url('<?php echo $defaultImg?>')">
							<span class="image" style="background-image:url('<?php echo $imgSRC?>')"></span>
							<img src="<?php echo $box_rectangle ?>" alt="" aria-hidden="true" class="placeholder">
						</span>
						<span class="info js-blocks">
							<span class="info-inner">
								<span class="date">
									<?php echo $date->format('D | M j, Y'); ?>	
								</span>
								<h3><?php the_title(); ?></h3>
							</span>
						</span>
						
					</a>
				</div>
				<?php endwhile; ?>
				
				<?php /* Last Box */ ?>
				<div class="block last-block desktop-version">
					<div class="inner" style="background-image: url('<?php bloginfo('stylesheet_directory'); ?>/images/city.jpg');">
						<a href="<?php bloginfo('url'); ?>/events">
							<span class="more">More Events</span>
							<img src="<?php echo $box_rectangle ?>" alt="" aria-hidden="true" class="placeholder">
						</a>
					</div>
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
 
