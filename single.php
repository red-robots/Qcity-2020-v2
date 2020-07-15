<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package ACStarter
 */

	get_header(); 
	$img 		= get_field('story_image');
	$video 		= get_field('video_single_post');
	$sponsors 	= get_field('sponsors');	
	$caption 	= ( $img ) ? $img['caption'] : '';
	//$caption 	= get_the_post_thumbnail_caption();
	


	//var_dump($img);
?>


	
<?php if($sponsors): ?>
<div class="wrapper cf wrap-mob sponsor-post-wrap">		
	<div id="primary" class="content-area" style="<?php echo ($sponsors) ? '': ' margin: 0 auto; float:none; '; ?>">
		
		<div class="single-page">
			<div class="sponsor-top">
				<div class="category "><?php get_template_part('template-parts/primary-category'); ?></div>
				<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
				<div class="single-page-excerpt">
					<?php echo get_the_excerpt(); ?>
				</div>				
			</div>
			

			<?php if( $img ) { ?>
				<div class="story-image s2">
					<img src="<?php echo $img['url']; ?>" alt="<?php echo $img['alt']; ?>">
				</div>
			<?php } /*elseif( has_post_thumbnail() ){ ?>
				<div class="story-image s2">
					<?php the_post_thumbnail(); ?>
				</div>
			<?php } */ ?>

			<?php if( $caption ): ?>
				<div class="entry-meta">
					<div class="post-caption"><?php echo $caption; ?></div>
				</div>
			<?php endif; ?>
		</div>


		<main id="main" class="site-main" role="main">
			<div class="wrapper" >
				<div class="single-page">
					<?php get_template_part( 'template-parts/content', get_post_format() );	?>
				</div>
			</div>
		</main><!-- #main -->
	</div><!-- #primary -->
	<?php ($sponsors) ? get_sidebar() : ''; ?>
</div>

	<?php  else: ?>

		<div id="primary" class="content-area-full">
			<main id="main" class="site-main" role="main">

				<div class="single-page">

					<div class="content-single-page">
			
						<div  style="margin-bottom: 20px;">
							<div class="category "><?php get_template_part('template-parts/primary-category'); ?></div>
							<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
							<div class="single-page-excerpt">
							<?php echo get_the_excerpt(); ?>
							</div>
						</div>
						

						<?php if( $img ) { ?>
							<div class="story-image s2">
								<img src="<?php echo $img['url']; ?>" alt="<?php echo $img['alt']; ?>">
							</div>
						<?php } /*elseif( has_post_thumbnail() ){ ?>
							<div class="story-image s2">
								<?php the_post_thumbnail(); ?>
							</div>
						<?php }*/  ?>

						<?php if( $caption ): ?>
							<div class="entry-meta">
								<div class="post-caption"><?php echo $caption; ?></div>
							</div>
						<?php endif; ?>

					</div>

					<?php get_template_part( 'template-parts/content', get_post_format() );	?>

				</div>

			</main>
		</div>

	<?php endif; ?>

	<?php
				/*$tags = get_the_tags( $post->ID );
				foreach ($tags as $tag) {
					echo "ID: " . $tag->term_id . ", Name: " . $tag->name . " | ";
				}*/

				
			?>

	<div class="items-before-footer">
		<div class="content-area-full">			
			<?php get_template_part( 'template-parts/single-footer-bottom');	?>
		</div>
		<div class="clear"></div>
	</div>
<?php 
get_footer();
