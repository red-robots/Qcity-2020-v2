<section class="ads-home">

    <?php $right_rail =  get_ads_script('right-rail');   ?>
    <?php if ( isset($right_rail['ad_script']) && $right_rail['ad_script'] ) { ?>
    <!-- Right Rail Home -->
    <div class="desktop-version align-center"> <!-- Right Rail Home -->
        <?php  echo $right_rail['ad_script']; ?>
    </div>
    <?php } ?>
    
    <?php /* West Side Connect  or Hearken Subscription Form */ ?>
    <!-- <script async src="https://modules.wearehearken.com/wndr/embed/868.js"></script> -->
    
    <!-- <div class="desktop-version" style="margin-bottom: 20px">
        <script async src="https://modules.wearehearken.com/qcitymetro/embed/4551.js"></script>
    </div> -->

    <?php $ad_right = get_ads_script('small-ad-right');  ?>
    <?php if ( isset($ad_right['ad_script']) && $ad_right['ad_script'] ) { ?>
    <div class="desktop-version align-center">
        <?php echo $ad_right['ad_script']; ?>
    </div>
    <?php } ?>
    <!-- Small Optional Ad Right -->

    <?php 
    $args = array(     
        'category_name'     => 'offers-invites+sponsored-post',        
        'post_type'         => 'post',        
        'post_status'       => 'publish',
        'posts_per_page'    => 3,
        'orderby'           => 'rand',
        'meta_query'        => array(
            array(
                'key'       => 'sponsored_content_post',
                'compare'   => '=',
                'value'     => 1,
            ),      
        ),
    );
    $sponsors = new WP_Query($args);
    if( $sponsors->have_posts() ) { ?>
    <div class="sidebar-sponsored-posts">
        <div class="sbTitle">Sponsored Content</div>
        <?php while( $sponsors->have_posts() ):   $sponsors->the_post(); ?>
            <?php
            $sp_id = get_the_ID();
            $sponsorCompanies = get_field('sponsors');
            $info = get_field("spcontentInfo","option");
            if($info) {
                $i_title = $info['title'];
                $i_text = $info['text'];
                $i_display = ($info['display'] && $info['display']=='on') ?  true : false;
            } else {
                $i_title = '';
                $i_text = '';
                $i_display = '';
            }
            $sponsorsList = '';
            if($sponsorCompanies) {
                $n=1; foreach($sponsorCompanies as $s) {
                    $comma = ($n>1) ? ', ':'';
                    $sponsorsList .= $comma . $s->post_title;
                    $n++;
                }
            }
            $default = get_template_directory_uri() . '/images/right-image-placeholder.png';
            $featImage =  ( has_post_thumbnail() ) ? wp_get_attachment_image_src( get_post_thumbnail_id(), 'large') : '';
            $bgImg = ($featImage) ? $featImage[0] : $default;
            ?>
        <article id="sponsoredPost<?php echo $sp_id?>">
            <div class="inside">
                <a href="<?php echo get_the_permalink();?>" class="thumb">
                    <img src="<?php echo get_template_directory_uri() . '/images/right-image-placeholder.png'; ?>" alt="" aria-hidden="true">
                    <?php if ($featImage) { ?>
                    <span class="featImage" style="background-image:url('<?php echo $bgImg?>')"></span> 
                    <?php } ?>
                </a>

                <a href="<?php echo get_the_permalink();?>" class="titlediv">
                    <?php if ($sponsorsList) { ?>
                    <span class="t1"><?php echo $sponsorsList ?></span>
                    <?php } ?>
                    <span class="t2"><?php echo get_the_title(); ?></span>
                </a>
            </div>
        </article>
        <?php endwhile; wp_reset_postdata(); ?>
    </div>  
    <?php } ?>
</section>
