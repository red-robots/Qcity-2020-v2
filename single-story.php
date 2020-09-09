<?php
$story_powered_by_text = get_field("story_powered_by_text","option");
$story_sponsor_logo = get_field("story_sponsor_logo","option");
$story_sponsor_website = get_field("story_sponsor_website","option");
$story_main_title = get_field("story_main_title","option");
get_header(); ?>

<?php while ( have_posts() ) : the_post(); 
	$job_title = get_field("job_title");
	$location = get_field("location");
	$age = get_field("age");
	$info = array($job_title,$location,$age);
	$articles = get_field("story_article");
?>
<div class="new-page-fullwrap story-single-content">
	<div class="top-page">
		<div class="pageWrap">
			<div class="sponsor-info">
				<?php if ($story_powered_by_text) { ?>
				<div class="poweredbytext"><?php echo $story_powered_by_text ?></div>	
				<?php } ?>
				<?php if ($story_sponsor_logo) { ?>
				<div class="sponsor-logo">
					<?php if ($story_sponsor_website) { ?>
						<a href="<?php echo $story_sponsor_website ?>" target="_blank"><img src="<?php echo $story_sponsor_logo['url'] ?>" alt="<?php echo $story_sponsor_logo['title'] ?>"></a>
					<?php } else { ?>
						<img src="<?php echo $story_sponsor_logo['url'] ?>" alt="<?php echo $story_sponsor_logo['title'] ?>">
					<?php } ?>
				</div>	
				<?php } ?>
			</div>

			<div class="share-link">
				<?php if ($story_main_title) { ?>
					<a href="<?php echo get_site_url() ?>/category/stories/" class="back"><i class="fas fa-share"></i> Back to <?php echo $story_main_title ?></a>
				<?php } ?>
				<?php if ( do_shortcode('[social_warfare]') ) { ?>
				<a href="#" id="sharerLink"><i class="fas fa-share"></i> <span>Share</span></a>
				<div class="share">
					<?php echo do_shortcode('[social_warfare]'); ?>
				</div>
				<?php } ?>
			</div>
		</div>
		<div class="arrow-down"><span></span></div>
	</div>

	<div class="new-page-content">
		<div class="new-page-wrapper">
			<div class="head">
				<h1 class="page-title"><?php the_title(); ?></h1>
				<?php if ( $info && array_filter($info) ) { ?>
				<div class="post-info">
					<?php echo implode('<span>&bull;</span>',array_filter($info)); ?>
				</div>	
				<?php } ?>
			</div>

			<?php if ($articles) { ?>
			<div class="articles-wrapper">
				<?php $i=1; foreach ($articles as $a) { 
					$title = $a['post_title'];
					$date =  $a['post_date'];
					$content = $a['post_content'];
					$images = $a['images'];
					$photos = ( isset($images['photos']) && $images['photos'] ) ? $images['photos']:"";
					$photo_caption = ( isset($images['caption']) && $images['caption'] ) ? $images['caption']:"";
					if($i==1) { ?>
					
					<article class="storypost first">
						<?php if ($photos) { 
						$countImg = count($photos); 
						$morepics = ($countImg>1) ? ' morepics':'';
						?>
						<div class="photo-wrap">
							<div class="spImages count<?php echo  $countImg?><?php echo $morepics?>">
								<?php foreach ($photos as $img) { ?>
									<div class="frame-photo">
										<img src="<?php echo $img['url'] ?>" alt="<?php echo $img['title'] ?>" class="story-image">
									</div>
								<?php } ?>
							</div>	
							<?php if ($photo_caption) { ?>
							<div class="photo-caption"><?php echo $photo_caption ?></div>	
							<?php } ?>
						</div>
						<?php } ?>

						<?php if ($date) { ?>
							<div class="story-post-date"><span><?php echo $date ?></span></div>	
						<?php } ?>

						<?php if ($title) { ?>
							<h2 class="sptitle"><?php echo $title ?></h2>	
						<?php } ?>
						
						<?php if ($content) { ?>
							<div class="spcontent"><?php echo $content ?></div>	
						<?php } ?>	
					</article>
					
					<?php } else { ?>

					<article class="storypost more">

						<?php if ($date) { ?>
							<div class="story-post-date"><span><?php echo $date ?></span></div>	
						<?php } ?>

						<?php if ($title) { ?>
							<h2 class="sptitle"><?php echo $title ?></h2>	
						<?php } ?>

						<?php if ($photos) { 
						$countImg = count($photos); 
						$morepics = ($countImg>1) ? ' morepics':''; ?>
						<div class="photo-wrap">
							<div class="spImages count<?php echo  $countImg?><?php echo $morepics?>">
								<?php foreach ($photos as $img) { ?>
									<div class="frame-photo">
										<img src="<?php echo $img['url'] ?>" alt="<?php echo $img['title'] ?>" class="story-image">
									</div>
								<?php } ?>
							</div>	
							<?php if ($photo_caption) { ?>
							<div class="photo-caption"><?php echo $photo_caption ?></div>	
							<?php } ?>
						</div>
						<?php } ?>

						<?php if ($content) { ?>
							<div class="spcontent"><?php echo $content ?></div>	
						<?php } ?>	
					</article>

					<?php } ?>
					
				<?php $i++; } ?>
			</div>	
			<?php } ?>
		</div>
	</div>
</div>
<?php endwhile; ?>

<?php 
get_footer();
