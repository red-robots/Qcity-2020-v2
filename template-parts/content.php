<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package ACStarter
 */
//$storyImage = get_field( 'story_image' );

$mod = the_modified_date('M j, Y', '', '', false);
$the_post_id = get_the_ID();
$guest_author 	= get_field('author_name') ;
$hide_ads 		= get_field('hide_ads');
$chooseAuthor 	= get_field( 'choose_author' );
$single_post_comment_text = get_field('single_post_comment_text', 'option');


if( !defined('HIDE_ADS') ){
	define('HIDE_ADS', $hide_ads);
}


?>


<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">

		<div class="content-single-page">		
			<?php
			if ( 'post' === get_post_type() ) : ?>
				<div class="entry-meta">				
					<div>By <?php echo ( $guest_author ) ? $guest_author : get_the_author(); ?> </div>
					<div><?php echo get_the_date(); ?></div>
				</div><!-- .entry-meta -->
			<?php endif; ?>
		</div>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<div class="content-single-page">
		<?php

			the_content( sprintf(
						 //translators: %s: Name of current post.
						 wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'acstarter' ), array( 'span' => array( 'class' => array() ) ) ),
						the_title( '<span class="screen-reader-text">"', '"</span>', false )
					) );


			
		?>
		</div>
	</div><!-- .entry-content -->

	<div class="content-single-page">

		<?php if ( comments_open() || get_comments_number() ) : ?>

		<div class="comments-section">
			<div class="comments-trigger">
				<div class="logo-holder">
					<img src="<?php bloginfo('template_url'); ?>/images/qc-logo.png" alt="">
				</div>
				<div class="text-holder">
					<p><?php echo $single_post_comment_text; ?>  <a id="commentBtn" class="click_class" >Click here</a></p>
				</div>
			</div>

			<div class="comments-block">
				<?php 
					// If comments are open or we have at least one comment, load up the comment template.
					comments_template();				
				?>
			</div>			
		</div>
		<?php endif;  ?>

		<?php if( has_tag() ): ?>
		<div class="tags">	
			 <?php echo get_the_tag_list(
			 	'<span class="title">This Story is Tagged: </span> ',
			 	', '
			 ); ?>
		</div>
		<?php endif; ?>



		<?php if ( do_shortcode('[social_warfare]') ) { ?>
		<div class="share">
			<?php echo do_shortcode('[social_warfare]'); ?>
		</div>
		<?php } ?>
	
		
		
		<footer class="entry-footer">
			
			<?php if( $chooseAuthor ): ?>
				<div class="author-block">
					<?php 
						$aName 			= get_the_author_meta('display_name');
						$aDesc 			= get_the_author_meta('description');
						$size         	= 'thumbnail';
						$authorPhoto  	= null;							
					?>
					<a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>">
						<div class="left">						
							<div class="photo">
								<?php 
								if ( $chooseAuthor != '' ):
									$authorID   = $chooseAuthor['ID'];
									$authorPhoto = get_field( 'custom_picture', 'user_' . $authorID );
								else:
									$authorPhoto = get_field('custom_picture','user_'.get_the_author_meta('ID'));
								endif;
								if ( $authorPhoto ):
									echo wp_get_attachment_image( $authorPhoto, $size );
								endif; //  if photo  ?>
							</div>
						</div>
						<div class="info">
							<h3><?php echo $aName; ?></h3>
							<?php echo $aDesc; ?>
						</div>
					</a>
				</div>
			<?php endif; ?>
			

			<?php if ( function_exists('rp4wp_children') ) { ?>
				<?php rp4wp_children(); ?>
			<?php } ?>

			<?php get_template_part( 'template-parts/sponsored-paid'); ?>

			<?php /* ?>
			<section class="comments">
				<?php //echo do_shortcode( '[Fancy_Facebook_Comments]' ); ?>
				<div id="disqus_thread"></div>
				<script>
				    
				     // RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
				    //  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables
				     
				    
				    var disqus_config = function () {
				        this.page.url = '<?php echo get_permalink(); ?>';  // Replace PAGE_URL with your page's canonical URL variable
				        this.page.identifier = '<?php echo get_permalink(); ?>'; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
				    };
				    
				    (function() {  // REQUIRED CONFIGURATION VARIABLE: EDIT THE SHORTNAME BELOW
				        var d = document, s = d.createElement('script');
				        
				        s.src = 'https://EXAMPLE.disqus.com/embed.js';  // IMPORTANT: Replace EXAMPLE with your forum shortname!
				        
				        s.setAttribute('data-timestamp', +new Date());
				        (d.head || d.body).appendChild(s);
				    })();
				</script>
				<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript" rel="nofollow">comments powered by Disqus.</a></noscript>
			</section>
			<?php  */ ?>
		</footer><!-- .entry-footer -->

	</div>
</article><!-- #post-## -->
