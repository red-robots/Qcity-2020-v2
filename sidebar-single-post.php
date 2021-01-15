<?php
$current_post_id = get_the_ID();
$postType = get_post_type();
$max = 5;
$args = array(
	'post_type'			=> 'post',
	'posts_per_page'=> $max,
	'post__not_in'	=> array($current_post_id),
	'post_status'		=> 'publish',	
	'meta_key' 			=> 'views',
	'orderby' 			=> 'post_date meta_value_num',
	'order'					=> 'DESC'
);
$entries = get_posts($args);
$listOrders = array();
if($entries) {
	foreach($entries as $e) {
		$id = $e->ID;
		$views = get_post_meta($id,'views',true);
		$listOrders[$id] = $views;
	}
	arsort($listOrders);
}
// echo "<pre>";
// print_r($entries);
// echo "</pre>";
$trending = new WP_Query( $args );	
$placeholder = get_template_directory_uri() . '/images/rectangle.png';

if($postType=='post') { ?>

<?php if ($entries) { ?>
	
		<aside id="sidebar-single-post" class="trending-sidebar">
			<div id="sbContent">
				<div class="sbWrap">
					<h3 class="sbTitle">Trending</h3>
					<ol class="trending-entries">
						<?php $i=1; foreach($listOrders as $pid=>$v) { 
							$img  = get_field('event_image',$pid);
							$image = '';
							$altImg = '';
							if( $img ){
							  $image = $img['url'];
							  $altImg = ( isset($img['title']) && $img['title'] ) ? $img['title']:'';
							} elseif ( has_post_thumbnail($pid) ) {
								$thumbid = get_post_thumbnail_id($pid);
							  $image = get_the_post_thumbnail_url($pid);
							  $altImg = get_the_title($thumbid);
							} 
							$viewsCount = get_post_meta($pid,'views',true);
							$postDate = get_the_date('d/m/Y',$pid);
							$pagelink = get_permalink($pid);
							$posttitle = get_the_title($pid); ?>
							<li class="entry" data-postdate="<?php echo $postDate ?>" data-views="<?php echo $viewsCount ?>" id="<?php echo $viewsCount ?>">
								<?php if ($i==1) { ?>
									<?php if ($image) { ?>
									<div class="trendImg">
										<img src="<?php echo $image ?>" alt="<?php echo $altImg; ?>">
									</div>	
									<?php } ?>
								<?php } ?>
								<p class="headline"><a href="<?php echo $pagelink; ?>"><?php echo $posttitle; ?></a></p>
							</li>
						<?php $i++; } ?>
					</ol>
				</div>
			</div>
		</aside>
	
<?php } ?>

<?php } ?>