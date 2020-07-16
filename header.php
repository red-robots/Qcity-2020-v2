<?php
/**
 * The header for theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package ACStarter
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700&display=swap" rel="stylesheet">


<script defer src="<?php bloginfo( 'template_url' ); ?>/assets/svg-with-js/js/fontawesome-all.js"></script>

<script async='async' src='https://www.googletagservices.com/tag/js/gpt.js'></script>
<script>
  var googletag = googletag || {};
  googletag.cmd = googletag.cmd || [];
</script>
<script>
window.googletag = window.googletag || {cmd: []};
  googletag.cmd.push(function() {
    googletag.defineSlot('/1009068/In-Story_Gutenbers', [300, 250], 'div-gpt-ad-1563273598512-0').addService(googletag.pubads());
    googletag.pubads().enableSingleRequest();
    googletag.enableServices();
  });
  
 window.googletag = window.googletag || {cmd: []};
  googletag.cmd.push(function() {
    googletag.defineSlot('/1009068/Gutenburg_720x90', [728, 90], 'div-gpt-ad-1563293411913-0').addService(googletag.pubads());
    googletag.pubads().enableSingleRequest();
    googletag.enableServices();
  });

    window.googletag = window.googletag || {cmd: []};
  googletag.cmd.push(function() {
    googletag.defineSlot('/1009068/600x200', [600, 200], 'div-gpt-ad-1563224728772-0').addService(googletag.pubads());
    googletag.pubads().enableSingleRequest();
    googletag.pubads().collapseEmptyDivs();
    googletag.enableServices();
  });
</script>

<script async src="https://securepubads.g.doubleclick.net/tag/js/gpt.js"></script>
<script>
  window.googletag = window.googletag || {cmd: []};
  googletag.cmd.push(function() {
    googletag.defineSlot('/1009068/In-Story_Gutenbers', [[300, 250], [600, 200], [728, 90]], 'div-gpt-ad-1565127901858-0').addService(googletag.pubads());
    googletag.pubads().enableSingleRequest();
    googletag.enableServices();
  });
</script>
<script>
    var ajaxURL = "<?php echo admin_url('admin-ajax.php'); ?>";
</script>
<!--
<script type="text/javascript"async src="https://launch.newsinc.com/js/embed.js" id="_nw2e-js"></script>
-->


<?php wp_head(); ?>
<style>
  .gform_wrapper ul li.gfield{
    clear: none !important;
  }
</style>
<script>
var currentURL = '<?php echo get_permalink();?>';
var params={};location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(s,k,v){params[k]=v});
</script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'acstarter' ); ?></a>

	<header id="masthead" class="site-header " role="banner" >

        <div class="mobile-stick" id="fixed" >
			<div class="wrapper-header ">
		            <div class="logo">
		            	<a href="<?php bloginfo('url'); ?>" style="background: transparent;">
			            	<img src="<?php bloginfo('template_url'); ?>/images/qc-logo.png" alt="<?php bloginfo('name'); ?>">
			            </a>
		            </div>

                <?php $instagram = get_field("instagram_link_short","option"); ?>
                <div class="newsletter-link" >
                    <?php if ($instagram) { ?>
                    <a href="<?php echo $instagram?>" target="_blank" class="news-letter-btn btn2">Instagram</a>
                    <?php } else { ?>
                    <a href="<?php bloginfo('url'); ?>/email-signup/" class="news-letter-btn">Newsletter</a>
                    <?php } ?>
                </div>
	        </div>

	        <section class="red-band">
	        	<div class="wrapper">
	        		Join our community to receive email updates from QCityMetro > 
	        		<a href="<?php bloginfo('url'); ?>/email-signup">Subscribe</a>
	        	</div>
	        </section>

            

	        <div class="mainnav-wrap">
	        	<div class="wrapper-mnav">
					<nav id="site-navigation" class="main-navigation " role="navigation">
                        
						<div class="wrapper" >
                            
							<div class="burger">
							  <span></span>
							</div>
							<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu', 'menu_class'=>'desktop-version' ) ); ?>
              <?php //get_search_form(); ?>
						</div>
					</nav><!-- #site-navigation -->
				</div>
			</div>
			<nav class="mobilemenu">
				<div class="mobilemain">
					<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' ) ); ?>
				</div>
				<?php wp_nav_menu(array('theme_location'=>'burger','menu_class'=>'main','container'=>'ul')); ?>
			</nav>

        <script>
        jQuery(document).ready(function($){
          $('a').filter(function(){
              return $(this).text() === "Jobs";
          }).append('<span class="menu-counter menu-badge">'+ <?php echo get_category_counter('job'); ?> +'</span>');
          
          $('a').filter(function(){
              return $(this).text() === "Events";
          }).append('<span class="menu-counter menu-badge">'+ <?php echo get_category_counter('event'); ?> +'</span>');
        });    
        </script>

        </div>        
	
	</header><!-- #masthead -->

	<div id="content" class="site-content mobile-body" >

   
  <div class="ads_home_leaderboard">
    <?php 
        $ads_header = get_ads_script('leaderboard-ad-home');
        echo $ads_header['ad_script'];
     ?>       
  </div>
   
