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
			<h2 class="dark-gray">Sponsor Events</h2>
		</header>

		<div class="outerwrap">
			<div class="flexwrap">
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
						<span class="imageDiv" style="background-image:url('<?php echo $imgSRC?>')">
							<img src="<?php echo $defaultImg ?>" alt="" aria-hidden="true" class="placeholder">
						</span>
						<span class="info">
							<span class="date">
								<?php echo $date->format('D | M j, Y'); ?>	
							</span>
							<h3><?php the_title(); ?></h3>
						</span>
						<?php if ($img) { ?>
						<span class="imgOverlay" style="background-image:url('<?php echo $img['url']?>')"></span>
						<?php } ?>
					</a>
				</div>
				<?php endwhile; ?>
				
				<?php /* Last Box */ ?>
				<div class="block last-block desktop-version">
					<div class="inner" style="background-image: url('<?php bloginfo('stylesheet_directory'); ?>/images/city.jpg');">
						<div class="overlayz">
							<a href="<?php bloginfo('url'); ?>/events"></a>
						</div>
						<div class="more">
							More Events
						</div>
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
 
