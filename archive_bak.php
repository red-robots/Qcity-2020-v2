<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package ACStarter
 */

get_header(); 
get_template_part('template-parts/banner-category');
?>
<div class="wrapper">
	<div class="listing-header">
		<div class="content-area-title">
			<header class="section-title ">
				<h1 class="dark-gray"><?php the_archive_title(); ?></h1>
			</header>
		</div>
	</div>
</div>
<div class="wrapper">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<div class="archive-content-page">
				
			
			
				<?php if ( have_posts() ) : ?>
					<!-- <header class="page-header">
						<?php
							//the_archive_title( '<h1 class="page-title">', '</h1>' );
							//the_archive_description( '<div class="taxonomy-description">', '</div>' );
						?>
					</header>.page-header -->

					<?php
					$i=0;
					/* Start the Loop */
					while ( have_posts() ) : the_post(); 
						if( !is_paged() ) : $i++;
							if( $i == 1 ) {
								get_template_part( 'template-parts/story-block' );
								echo '<div class="second-row ">';
								
							} else {
								get_template_part( 'template-parts/story-block' );
							}
						else : $i++;
							if( $i == 1 ) {
								echo '<div class="second-row ">';
							}
							get_template_part( 'template-parts/story-block' );
						endif;

					endwhile;

					echo '</div>';

					pagi_posts_nav();

				else :

					get_template_part( 'template-parts/content', 'none' );

				endif; ?>

			</div>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
</div>
<?php get_footer();
