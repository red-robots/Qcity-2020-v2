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

<?php 
$obj = get_queried_object();
$current_term_id = ( isset($obj->term_id) && $obj->term_id ) ? $obj->term_id : '';
$current_term_name = ( isset($obj->name) && $obj->name ) ? $obj->name : '';
$current_term_slug = ( isset($obj->slug) && $obj->slug ) ? $obj->slug : '';
if ( get_post_type()=='story')  { 
$articles = get_field("story_article"); 
if($articles) {
  $story = $articles[0];
  $images = $story['images'];
  $text = ( isset($story['post_content']) && $story['post_content'] ) ? $story['post_content']:'';
  $content = ($text) ? shortenText(strip_tags($text),200," ","...") : '';
  $photos = ( isset($images['photos']) && $images['photos'] ) ? $images['photos']:"";
  $mainPic = ($photos) ? $photos[0] : '';
}
?>
<meta property="og:url"                content="<?php echo get_permalink(); ?>" />
<meta property="og:type"               content="article" />
<meta property="og:title"              content="<?php echo get_the_title(); ?>" />
<meta property="og:description"        content="<?php echo $content ?>" />
<?php if ($mainPic) { ?>
<meta property="og:image"              content="<?php echo $mainPic['url'] ?>" />
<?php } ?>
<?php } ?>


<?php 
/* 
* PARSE.LY METADATA
* Visit: https://www.parse.ly/help/integration/jsonld 
*/

if ( is_singular() ) { 
$ob = get_queried_object();
$defaultAuthId = ( isset($ob->post_author) && $ob->post_author ) ? $ob->post_author:'';
$defaultAuthorName = '';
if($defaultAuthId) {
  $defaultAuthorName = get_the_author_meta('display_name',$defaultAuthId);
}
$img = get_field('story_image'); 
$thumbURL = ($img) ? $img['url'] : '';
$pagetitle = get_the_title();
$pageLink = get_permalink();
$guest_author =  get_field('author_name');
$authorName = ( $guest_author ) ? $guest_author : $defaultAuthorName;
$date = get_the_date('Y-m-d');
$post_id = get_the_ID();
$post_categories = get_the_category( $post_id );
$categories = '';
$tags = '';
$tag_list = get_the_tags($post_id);
$cat_count = ($post_categories) ? count($post_categories) : 0;
if($post_categories){
  
  $catName1 = htmlspecialchars_decode($post_categories[0]->name);
  $categories = $catName1;

  if($cat_count>1) {
    $catsArr = array();
    foreach($post_categories as $c) {
      $catName = htmlspecialchars_decode($c->name);
      $catName = str_replace("'"," ",$catName);
      $catName = str_replace('"','',$catName);
      $catsArr[] = '"'.$catName.'"';
    }
    $tags = ($catsArr) ? implode(",",$catsArr) : '';
  } 

  if($tag_list) {
    $tagsArr = array();
    foreach($tag_list as $t) {
      $tagStr = htmlspecialchars_decode($t->name);
      $tagStr = str_replace("'"," ",$tagStr);
      $tagStr = str_replace('"','',$tagStr);
      $tagsArr[] = '"'.$tagStr.'"';
    }
    $tags = ($tagsArr) ? implode(",",$tagsArr) : '';
  }
}

$type = 'WebPage';
if( is_single() ) {
  $type = 'Article';
  if( is_singular('post') ) {
    $type = 'NewsArticle';
  } else if( is_singular('event') ) {
    $type = 'Article';
  }
}

$authorName = ($authorName) ? '["'.$authorName.'"]':'""';
$tags = ($tags) ? '['.$tags.']':'""';
if($pagetitle) {
$pagetitle = htmlspecialchars_decode($pagetitle);
$pagetitle = str_replace("'"," ",$pagetitle);
$pagetitle = str_replace('"','',$pagetitle);
}

?>
<script type="application/ld+json">
  <?php if( is_single() ) { ?>
    {
      "@context": "https://schema.org",
      "@type": "<?php echo $type?>",
      "headline": "<?php echo $pagetitle?>",
      "url": "<?php echo $pageLink?>",
      "thumbnailUrl": "<?php echo $thumbURL?>",
      "datePublished": "<?php echo $date?>",
      "articleSection": "<?php echo $categories?>",
      "creator": <?php echo $authorName?>,
      "author": <?php echo $authorName?>,
      "keywords": <?php echo $tags?>
    }
  <?php } else if( is_page() ) { 
    if (is_home() || is_front_page()) { 
      $pagetitle = get_bloginfo('name') . " - " . $pagetitle;
    }
    ?>
    {
      "@context": "https://schema.org",
      "@type": "<?php echo $type?>",
      "headline": "<?php echo $pagetitle?>",
      "url": "<?php echo $pageLink?>"
    }
  <?php } ?>
</script>
<?php } ?>

<?php if (is_archive()) { 
$ob = get_queried_object();
$archiveTitle = ( isset($ob->name) && $ob->name ) ? $ob->name : '';
if($archiveTitle) { 
$termLink = get_term_link($ob); ?>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebPage",
  "headline": "<?php echo $archiveTitle?>",
  "url": "<?php echo $termLink?>"
}
</script>
<?php } ?>
<?php } ?>
</head>
<?php
$dd = date('d') - 1;
$day = str_pad($dd,2,'0',STR_PAD_LEFT);
$nexday = str_pad($dd+1,2,'0',STR_PAD_LEFT);
$dateToday = date('Ym') . $day;
$dateRange = '';
for($i=0; $i<3; $i++) {
  $d = $day + $i;
  $days = str_pad($d,2, '0', STR_PAD_LEFT);
  $comma = ($i>0) ? ',':'';
  $dateRange .= $comma . date('Ym'). $days;
}
$start_end = $dateToday . ',' . date('Ym') . $nexday;
?>
<body <?php body_class(); ?> data-today="<?php echo date('Ymd') ?>" data-dates="<?php echo $start_end ?>" data-range="<?php echo $dateRange ?>">
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

          <?php  
          $topSubscribe = get_field("topSubscribe","option");
          $subscribeText = ( isset($topSubscribe['subscribe_text']) && $topSubscribe['subscribe_text'] ) ? $topSubscribe['subscribe_text']:'';
          $subscribeButton = ( isset($topSubscribe['subscribe_button']) && $topSubscribe['subscribe_button'] ) ? $topSubscribe['subscribe_button']:'';
          $subscribeName = ( isset($subscribeButton['title']) && $subscribeButton['title'] ) ? $subscribeButton['title']:'';
          $subscribeURL = ( isset($subscribeButton['url']) && $subscribeButton['url'] ) ? $subscribeButton['url']:'';
          $subscribeTarget = ( isset($subscribeButton['target']) && $subscribeButton['target'] ) ? $subscribeButton['target']:'_self';
          ?>
          <?php if ($subscribeText || $subscribeButton) { ?>
          <section class="red-band">
            <div class="wrapper">
              <?php echo $subscribeText ?>
              <?php if ($subscribeButton) { ?>
                <a href="<?php echo $subscribeURL ?>" target="<?php echo $subscribeTarget ?>" class="topSubscribeBtn"><?php echo $subscribeName ?></a>
              <?php } ?>
            </div>
          </section>
          <?php } ?>

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
          
          // $('a').filter(function(){
          //     return $(this).text() === "Events";
          // }).append('<span class="menu-counter menu-badge">'+ <?php //echo get_category_counter('event'); ?> +'</span>');


          $('a').filter(function(){
              return $(this).text() === "Events";
          }).append('<span class="menu-counter menu-badge">'+ <?php echo get_total_events_by_date(); ?> +'</span>');

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
   
