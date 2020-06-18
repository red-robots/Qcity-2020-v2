<?php
/*
	Hero's - Only sticky posts here.
*/
$i = 0;
$postIDs = array();
$wp_query = new WP_Query();
$wp_query->query(array(
	'post_type'				=>'post',
	'posts_per_page' 		=> 1,
	'post_status'  			=> 'publish',
	'post__in' 				=> get_option('sticky_posts'),
	'ignore_sticky_posts' 	=> 1
));
if ($wp_query->have_posts()) : ?>
<section class="stickies">
	<div class="left ">

	<?php while ($wp_query->have_posts()) :  $wp_query->the_post(); $i++;
		// collect id's to not repeat below
		$postIDs[] = get_the_ID();
		$date = get_the_date();
		$img = get_field('story_image');
		
		
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
				<div class="category">
					<?php include( locate_template('template-parts/primary-category.php', false, false) ); ?>
				</div>
				<h3><?php the_title(); ?></h3>
				<div class="desc">
					<?php the_excerpt(); ?>
				</div>
				<div class="by">
					By <?php the_author();?> | <?php echo get_the_date(); ?>
				</div>
			</div>
			<div class="article-link"><a href="<?php the_permalink(); ?>"></a></div>
		</article>		
	</div>
	<?php endwhile;

	endif;  wp_reset_postdata(); ?>

	

	<div class="right">
		<?php
			
			$slug 	= 'offers-invites';
			$cat 	= get_category_by_slug($slug); 
			$catID 	= $cat->term_id;

			$args = array(
				'post_type'			=>'post',
				'posts_per_page' 	=> 2,
				'post_status'  		=> 'publish',
				'post__not_in' 		=> $postIDs,
				'category__not_in' 	=> $catID ,
			);

			$recent_query = new WP_Query( $args ); 

			if( $recent_query->have_posts() ):
		
				while ($recent_query->have_posts()) :  $recent_query->the_post();
					$img 	= get_field('story_image');
					$video 	= get_field('video_single_post');

					$embed = youtube_setup($video);

					$postIDs[] = get_the_ID();

			?>
			<article class="story-block">
				<div class="photo story-home-right">
					<?php if( $video ): ?>	
						<iframe class="video-homepage"  src="<?php echo $embed; ?>"></iframe>
					<?php elseif( has_post_thumbnail() ): ?>	
						<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
					<?php endif; ?>

					<?php /*if( has_post_thumbnail() ) { 
							the_post_thumbnail(); 
						 } elseif( $img ) { ?>					 
								<img src="<?php echo $img['sizes']['thirds']; ?>" alt="<?php echo $img['alt']; ?>">
						<?php } else { ?>
								<img src="<?php bloginfo('stylesheet_directory'); ?>/images/default.png">
						<?php }  */?>
					<div class="category">
						<?php include( locate_template('template-parts/primary-category.php', false, false) ); ?>
					</div>
					
				</div>
				<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>				
				<div class="desc">
					<span class="mobile-toggle"><?php echo get_the_excerpt(); ?></span>
				</div>
				<div class="by">
					By <?php the_author(); ?> | <?php echo get_the_date(); ?>
				</div>
				<!--
				<div class="article-link"><a href="<?php the_permalink(); ?>"></a></div>
				-->
			</article>
		<?php endwhile; ?>
	</div>
	</section>
<?php 
endif;
wp_reset_postdata();
?>