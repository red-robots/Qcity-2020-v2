<?php
/**
 * Template Name: Front Page 
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package ACStarter
 */

get_header(); ?>
<div class="wrapper">
	<div id="primary" class="content-area-full">
		<main id="main" class="site-main" role="main">

		<?php 
		$subscribe_text         = get_field('subscribe_text');
		$subscribe_link         = get_field('subscribe_link');
		$subscribe_button_name  = get_field('subscribe_button_name');
		$show_instagram_feeds  = get_field('show_instagram_feeds','option');

		include( locate_template('template-parts/hero.php') ); 
		include( locate_template('template-parts/sponsored-posts.php') );
		include( locate_template('template-parts/subscribe-bar.php') ); 
		if($show_instagram_feeds=='on') {
			include( locate_template('template-parts/instagram-feeds.php') );
		}
		include( locate_template('template-parts/non-sticky-news.php') );
		include( locate_template('template-parts/home-bottom.php') );
		?>
			
		</main><!-- #main -->
	</div><!-- #primary -->
</div>

<script type="text/javascript">
jQuery(document).ready(function($){
	if( $("#sponsoredPosts").length>0 ) {
		$("#sponsoredPosts").on('init', function(event, slick, direction){
		  $('.carouselText').matchHeight();
		});
		$("#sponsoredPosts").slick({
	    dots: true,
	    infinite: false,
	    variableWidth: true,
	  });
	}
});
</script>
<?php
get_footer();
