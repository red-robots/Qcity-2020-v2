<?php
$queried = get_queried_object();
$current_term_id = ( isset($queried->term_id) && $queried->term_id ) ? $queried->term_id : '';
$current_term_name = ( isset($queried->name) && $queried->name ) ? $queried->name : '';
$current_term_slug = ( isset($queried->slug) && $queried->slug ) ? $queried->slug : '';
$current_term_link = get_term_link($queried);
$page_term = 'elections';

$elect_quicklinks = get_field("elect_quicklinks","option");
$banner_image = get_field("elect_banner_image","option");
$banner_link = get_field("elect_banner_link","option");
$banner_description = get_field("elect_banner_description","option");
$link_target = ( isset($banner_link['target']) && $banner_link['target'] ) ? $banner_link['target']:'_self';
$wrap_class = ($elect_quicklinks) ? 'has-sidebar':'no-sidebar';
?>
<div id="section1" class="fw-left category-elections <?php echo $wrap_class ?>">
	<div class="wrapper">
		<?php if ($banner_image || $banner_description) { ?>
		<div class="page-top-area">
			<?php if ($banner_image) { ?>
				<div class="e-banner-image">
					<?php if ($banner_link) { ?>
						<a href="<?php echo $banner_link['url'] ?>" target="<?php echo $link_target ?>">
							<img src="<?php echo $banner_image['url'] ?>" alt="<?php echo $banner_image['title'] ?>">
						</a>
					<?php } else { ?>
						<img src="<?php echo $banner_image['url'] ?>" alt="<?php echo $banner_image['title'] ?>">
					<?php } ?>
				</div>
			<?php } ?>

			<?php if ($banner_description) { ?>
				<div class="e-description">
					<?php echo $banner_description ?>
				</div>
			<?php } ?>
		</div>	
		<?php } ?>

		<div class="main-content-wrap">
			<?php  
			/* SHOW POSTS WITH VIDEOS */
			$excludePosts = array();
			$perpage = 12;
			$paged = ( get_query_var( 'pg' ) ) ? absint( get_query_var( 'pg' ) ) : 1;
			$i = 0;
			$day = date('d');
			$day2 = $day - 1;
			$day_plus = sprintf('%02s', $day2);
			$today = date('Ym') . $day_plus;
			$video_args = array(
				'post_type'				=>'post',
				'post_status'			=>'publish',
				'orderby'     		=> 'rand',
				'order' 					=> 'ASC',
				'posts_per_page' 	=> $perpage,
				'paged'			  	 	=> $paged,
				'meta_query' 			=> array(
						array(
							'key'				=> 'video_single_post',
							'compare'		=> '!=',
							'value'			=> '',
						)			
				),
				'tax_query' 			=> array(
					array(
						'taxonomy' 		=> 'category', 
						'field' 			=> 'slug',
						'terms' 			=> array($page_term) 
					)
				)
			);

			$videos = new WP_Query($video_args);
			//$count = $custom_posts->found_posts;
			$video_placeholder = THEMEURI . "images/video-helper.png";
			?>

			<div class="elect-videos-wrapper">
				<?php if ( $videos->have_posts() ) { $count = $videos->found_posts; ?>

				<div class="elect-videos" data-total="<?php echo $count ?>">
					<div id="videos-container" class="videos-inner">
						<div id="vid-group1" class="videos-group fadeIn animated">
							<?php while ( $videos->have_posts() ) : $videos->the_post(); ?>
								<?php 
									$title = get_the_title();
									$post_date = get_the_date();
									$excludePosts[] = get_the_ID();
									$videoLink = get_field("video_single_post"); 
									$youtubeLink = ($videoLink) ? youtube_setup($videoLink):'';
								?>
								<?php if ($youtubeLink) { ?>
								<div class="entry">
									<div class="inside">
										<div class="video-iframe">
											<iframe class="video-iframe-elections"  src="<?php echo $youtubeLink; ?>"></iframe>
											<img src="<?php echo $video_placeholder ?>" alt="" aria-hidden="true" class="video-helper">
										</div>	
										<div class="video-info">
											<h3 class="title"><?php echo $title ?></h3>
											<p class="postdate"><?php echo $post_date ?></p>
										</div>
									</div>
								</div>	
								<?php } ?>
							<?php endwhile; wp_reset_postdata(); ?>
						</div>
					</div>

					<div id="hiddenItems" style="display:none;"><!-- DO NOT DELETE --></div>

					<?php
		        $total_pages = $videos->max_num_pages;
		        if ($total_pages > 1){ ?>
		            <div id="more-video-btn">
		            	<div class="more"> 
					            <a href="#" id="more-elections-videos" class="red" data-totalpages="<?php echo $total_pages ?>" data-baseurl="<?php echo $current_term_link; ?>" data-page="2">        
					                <span class="load-text">Load More</span>
					                <span class="load-icon"><svg class="svg-inline--fa fa-sync-alt fa-w-16 spin" aria-hidden="true" data-prefix="fas" data-icon="sync-alt" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M370.72 133.28C339.458 104.008 298.888 87.962 255.848 88c-77.458.068-144.328 53.178-162.791 126.85-1.344 5.363-6.122 9.15-11.651 9.15H24.103c-7.498 0-13.194-6.807-11.807-14.176C33.933 94.924 134.813 8 256 8c66.448 0 126.791 26.136 171.315 68.685L463.03 40.97C478.149 25.851 504 36.559 504 57.941V192c0 13.255-10.745 24-24 24H345.941c-21.382 0-32.09-25.851-16.971-40.971l41.75-41.749zM32 296h134.059c21.382 0 32.09 25.851 16.971 40.971l-41.75 41.75c31.262 29.273 71.835 45.319 114.876 45.28 77.418-.07 144.315-53.144 162.787-126.849 1.344-5.363 6.122-9.15 11.651-9.15h57.304c7.498 0 13.194 6.807 11.807 14.176C478.067 417.076 377.187 504 256 504c-66.448 0-126.791-26.136-171.315-68.685L48.97 471.03C33.851 486.149 8 475.441 8 454.059V320c0-13.255 10.745-24 24-24z"></path></svg><!-- <i class="fas fa-sync-alt spin"></i> --></span>
					            </a>
					        </div>
		            </div>	
		            <?php
		        } ?>

				</div>

				<?php } ?>
			</div>
		</div>

		<?php if ($elect_quicklinks) { ?>
			<?php $elect_widget_title = get_field("elect_widget_title","option"); ?>
		<aside class="quick-links">
			<div class="inside">
				<h3 class="q-title"><?php echo $elect_widget_title ?></h3>
				<ul class="qlinks">
				<?php foreach ($elect_quicklinks as $q) { 
					$eq = $q['link'];
					if($eq) {
						$target = ( isset($eq['target']) && $eq['target'] ) ? $eq['target'] : '_self'; ?>
						<li><a href="<?php echo $eq['url'] ?>" target="<?php echo $target; ?>"><?php echo $eq['title'] ?></a></li>
					<?php } ?>
				<?php } ?>
				</ul>
			</div>
		</aside>	
		<?php } ?>

	</div><!-- end of .wrapper -->
</div><!-- end of #section1 -->

<?php $brownBar = get_field("elect_brownbar_text","option"); ?>
<?php if ($brownBar) { ?>
<div class="fullwidthBar">
	<div class="wrapper"><?php echo $brownBar ?></div>
</div>
<?php } ?>


<?php /* MORE ELECTIONS POSTS */ ?>
<?php
$paged2 = ( get_query_var( 'page' ) ) ? absint( get_query_var( 'page' ) ) : 1;

$args_first = array(
  'post_type'             =>'post',
  'post_status'           => 'publish',       
  'posts_per_page'        => 1,     
  'tax_query' 			=> array(
		array(
			'taxonomy' 		=> 'category', 
			'field' 			=> 'slug',
			'terms' 			=> array($page_term) 
		)
	) 
);

if($excludePosts) {
  $args_first['post__not_in'] = $excludePosts;
}
$first = new WP_Query($args_first);
$firstItem = get_posts($args_first);
if($firstItem) {
	$fpost = $firstItem[0];
	$ex = ($excludePosts) ? count($excludePosts) : 0;
	$excludePosts[$ex] = $fpost->ID;
}

$args1 = array(
    'post_type'             =>'post',
    'post_status'           => 'publish',       
    'posts_per_page'        => 10,    
    'paged'                 => $paged2,  
    'tax_query' 			=> array(
			array(
				'taxonomy' 		=> 'category', 
				'field' 			=> 'slug',
				'terms' 			=> array($page_term) 
			)
		) 
);


if($excludePosts) {
  $args1['post__not_in'] = $excludePosts;
}
$items = new WP_Query($args1);
if ( $items->have_posts() || $first->have_posts() ) { ?>
<div id="section2" class="fw-left cf category-elections">
	<div class="wrapper">
		<div class="category-post fw-left">	
			<div id="catContentLeft" class="content-left">

				<div id="posts-inner" class="fadeIn animated">
					<header class="section-title ">
						<h1 class="dark-gray"><?php echo $current_term_name ?></h1>
					</header>

					<div class="second-row">

						<?php /* Fullwidth Photo */ ?>
						<?php if ( $first->have_posts() ) { ?>
							<?php if ($paged2==1) { ?>
								<?php while ( $first->have_posts() ) : $first->the_post(); ?>
								<div class="entry fullwidth">
									<?php get_template_part( 'template-parts/story-block-category' ); ?>
								</div>
								<?php endwhile; wp_reset_postdata(); ?>
							<?php } ?>
						<?php } ?>

						<?php if ( $items->have_posts() ) { ?>
							<?php while ( $items->have_posts() ) : $items->the_post(); ?>

								<div class="mobile-separator"></div>
								<div class="entry">
									<?php get_template_part( 'template-parts/story-block-category' ); ?>
								</div>

							<?php endwhile; wp_reset_postdata(); ?>
						<?php } ?>
					</div>

					<?php
	          $total_pages = $items->max_num_pages;
	          if ($total_pages > 1){ ?>
	              <div id="navigation" class="navigation navigation2" data-baseurl="<?php echo $current_term_link; ?>">
	                  <?php
	                      $pagination = array(
	                          'base' => @add_query_arg('page','%#%'),
	                          'format' => '?paged=%#%',
	                          'current' => $paged2,
	                          'total' => $total_pages,
	                          'prev_text' => __( 'Previous Page &laquo;', 'acstarter' ),
	                          'next_text' => __( 'Next Page &raquo;', 'acstarter' ),
	                          'type' => 'list'
	                      );
	                      echo paginate_links($pagination);
	                  ?>
	              </div>
	              <?php
	          } ?>
	      </div>

			</div>
			<?php get_sidebar(); ?>
		</div>

		
	</div>
</div>
<?php } ?>

<script type="text/javascript">
jQuery(document).ready(function($){

	/* Category Pagination */
	$(document).on("click","#navigation a",function(e){
		e.preventDefault();
		var baseURL = $("#navigation").attr("data-baseurl");
		var link = $(this).attr("href");
		var parts = link.split("?page=");
		var pageNum = parts[1];
		var nextPageURL = baseURL + "?page=" + pageNum;
		$("#catContentLeft").load(nextPageURL + " #posts-inner",function(){});
	});

	$(document).on("click","#more-elections-videos",function(e){
		e.preventDefault();
		var moreBtn = $(this);
		var page = $(this).attr("data-page");
		var totalpages = $(this).attr("data-totalpages");
		var next = parseInt(page) + 1;
		var currentURL = $(this).attr("data-baseurl");
		var nextPageURL = currentURL + '?pg=' + page;
		moreBtn.attr("data-page",next);
		moreBtn.find(".load-text").hide();
		moreBtn.find(".load-icon").show();
		
		$("#hiddenItems").load(nextPageURL + " .videos-group",function(){
			if( $(this).find(".videos-group").length > 0 ) {
				var items = $(this).find(".videos-group").html();
				var next_items = '<div id="vid-group'+page+'" class="videos-group fadeIn animated">'+items+'</div>';
				
				setTimeout(function(){
					moreBtn.find(".load-text").show();
					moreBtn.find(".load-icon").hide();
					$("#videos-container").append(next_items);

					if(page==totalpages) {
						var noMore = '<span class="nomore fadeIn animated">No more post to load.</span>';
						$("#more-video-btn .more").html(noMore);
					}

				},500);
			} else {
				moreBtn.hide();
			}
		});
	});
});
</script>