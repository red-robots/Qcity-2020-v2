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
	$postType = get_post_type();
	//$caption 	= get_the_post_thumbnail_caption();
	
?>

<?php if($sponsors) { ?>
<div class="wrapper cf wrap-mob sponsor-post-wrap">		
	<div id="primary" class="content-area full" style="<?php echo ($sponsors) ? '': ' margin: 0 auto; float:none; '; ?>">
		
		<div class="single-page">
			<div class="sponsor-top">
				<div class="category ">
					<?php get_template_part('template-parts/primary-category'); ?>
					<?php 
					$info = get_field("spcontentInfo","option");
	        if($info) {
	            $i_title = $info['title'];
	            $i_text = $info['text'];
	            $i_display = ($info['display'] && $info['display']=='on') ?  true : false;
	        } else {
	            $i_title = '';
	            $i_text = '';
	            $i_display = '';
	        } ?>	
  				<?php if ($i_display && $i_title && $i_text) { ?>
            <span class="whatisThis" style="padding-left:4px"> - <a href="#" id="sponsorToolTip"><?php echo $i_title ?></a></span>
            <div class="whatIsThisTxt"><?php echo $i_text ?></div>
        	<?php } ?>
				</div>
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
	<?php if ($sponsors) { ?>
	<div class="fullSb"><?php get_sidebar(); ?></div>
	<?php } ?>
</div>
<?php  } else { ?>
		<div id="primary" class="content-area-full">
			<main id="main" class="site-main" role="main">

				<div class="single-page">

					<div class="content-single-page">
			
						<div  class="content-inner-wrap">
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

				<?php get_sidebar('single-post'); ?>

			</main>
		</div>
<?php } ?>

	<div id="beforeFooter" class="items-before-footer">
		<div class="content-area-full">			
			<?php get_template_part( 'template-parts/single-footer-bottom');	?>
		</div>
		<div class="clear"></div>
	</div>
<?php 
get_footer();
