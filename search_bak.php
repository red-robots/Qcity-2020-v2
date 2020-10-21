<?php
/**
 * Template Name: Custom Search Bak
 * 
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package ACStarter
 */

get_header(); 
$value = '';

if( $_GET['search_text'] && !empty($_GET['search_text']) ){
	$value = trim($_GET['search_text']);
}

if( $_GET['type'] && !empty($_GET['type']) ){
	$type = $_GET['type'];
}

if( $type == 'business_listing' ) {
	$title = 'Featured Businesses';
} elseif(  $type == 'church_listing' ) {
	$title = 'All Churches';
} elseif( $type == 'event' ) {
	$title = 'All Events';
}else {
	$title = 'All Posts';
}


?>

<div class="wrapper" style="margin-top: 25px;">
	<div class="content-area-title">
		<header class="section-title ">
			<h2 class="dark-gray"><?php echo $title; ?> | Searching: <?php echo $value; ?></h2>
		</header>
	</div>
</div>
<div class="wrapper">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php

			$args = array(
		        'post_type'         => $type, 
		        //'post_status'       => 'publish',
		        //'order'             => 'ASC',
		        //'orderby'           => 'title',
		        'posts_per_page'    => 15,
		        's'                 => $value        
		    );

			$query = new WP_Query( $args );

			//var_dump($query);

		if ( $query->have_posts() ) : ?>

			<header class="page-header" style="margin-bottom: 10px">
				<h3 class="page-title"><?php printf( esc_html__( 'Search Results for: %s', 'acstarter' ), '<span>' . $value . '</span>' ); ?></h3>
			</header>

			<?php
				if( $type == 'business_listing' ) {
					echo '<div class="qcity-news-container">
								<section class="sponsored">';
				} elseif( $type == 'church_listing' ) {
					echo '<section class="church-list">';
				} elseif( $type == 'event' ) {
					echo '<section class="events">';
				} else {
					echo '<section class="qcity-news-container">';
				}

			?>

			<?php
			
			while ( $query->have_posts() ) : $query->the_post();

				if( $type == 'business_listing' ) {

					include(locate_template('template-parts/business-block.php')) ;

				} elseif( $type == 'church_listing' ) {

					include(locate_template('template-parts/church.php')) ;

				} elseif( $type == 'event' ) {
					include( locate_template('template-parts/sponsored-block.php') );
				} else {
					get_template_part( 'template-parts/content', 'search' );
				}
				

			endwhile;

			pagi_posts_nav();


			if( $type == 'business_listing' ) {
				echo '</section></div>';
			} elseif( $type == 'church_listing' ) {
				echo '</section>';
			} elseif( $type == 'event' ) {
				echo '</section>';
			} else {
				echo '</section>';
			}

			

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; wp_reset_query();  ?>

		</main>
	</div>
</div>
<?php
get_sidebar();
get_footer(); 
