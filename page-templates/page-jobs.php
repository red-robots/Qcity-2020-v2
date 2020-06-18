<?php
/**
 * Template Name: Jobs
 *
 * 
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package ACStarter
 */

get_header(); 
get_template_part('template-parts/banner-jobs');
?>
<div class="wrapper">
	<div class="listing-header">
		<div class="content-area-title ">
			<header class="section-title ">
				<h1 class="dark-gray"><?php the_title(); ?></h1>
			</header>
		</div>
	</div>
</div>
<div class="wrapper">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<div class="listing_initial">

			<?php
			/*
				Jobs 
			*/
				$i = 0;
				$today = date('Ymd');
				$wp_query = new WP_Query();
				$wp_query->query(array(
					'post_type'=>'job',
					'posts_per_page' => 5,
					// 'meta_query' => array(
					// 	array(
					//         'key'		=> 'event_date',
					//         'compare'	=> '<=',
					//         'value'		=> $today,
					//     ),
				 //    ),
			));
				if ($wp_query->have_posts()) : ?>
					<div class="jobs-page">
						<div class="biz-job-wrap">
						<?php while ($wp_query->have_posts()) : $wp_query->the_post(); 

								include(locate_template('template-parts/jobs-block.php')) ;

							endwhile; ?>
						</div>
					</div>
				<?php endif; wp_reset_postdata(); ?>

			</div>
			
			<div class="listing_search">
				<div class="listing_search_result">				
				</div>				
			</div>

		</main><!-- #main -->
	</div><!-- #primary -->

	<?php get_sidebar(); ?>
</div>
<?php 
get_footer();
