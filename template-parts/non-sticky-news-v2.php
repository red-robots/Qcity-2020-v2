<?php
/*
	Non Sticky News.
*/  

    $excludePosts = ( isset($featured_posts) && $featured_posts ) ? $featured_posts : '';
    $cat_id = ( isset($excludeCatID) && $excludeCatID ) ? $excludeCatID : '';
    //$cat_id = get_category_by_slug( 'sponsored-post' ); 

    $args1 = array(
        'post_type'             =>'post',
        'post_status'           => 'publish',       
        'posts_per_page'        => 6,    
        'paged'                 => 1,    
    );

    if($cat_id) {
        $args1['tax_query'] = array(
            array(
                'taxonomy' => 'category',
                'field'    => 'id',
                'terms'    => $cat_id,
                'operator' => 'NOT IN'
            )
        );
    }

    if($excludePosts) {
        $args1['post__not_in'] = $excludePosts;
    }
	
	$wp_query = new WP_Query($args1);
    
	?>
	
	<section class="news-home newsHomeV2">

        <div class="mobile-version" style="margin-bottom: 20px; text-align: center;"> <!-- Small Optional Ad Right -->
                <?php $small_ad =  get_ads_script('small-ad-right'); echo $small_ad['ad_script']; ?>
        </div> <!-- Small Optional Ad Right -->

		<section class="twocol qcity-news-container">	

    		<?php 
            $i = 0;
           
                if ( $wp_query->have_posts() ) : 	
                    $total = $wp_query->found_posts;	
    				 while ( $wp_query->have_posts() ) :  $wp_query->the_post();

                        if($i == 2){
                            get_template_part( 'template-parts/sponsored-paid');
                        }

    		    		//include( locate_template('template-parts/story-block.php', false, false) );
    		    		get_template_part( 'template-parts/story-block');
                        $i++;

                        if($i != 2){
                            get_template_part( 'template-parts/separator');
                        }


    		    	
    			 	endwhile; 
    			endif;
    			wp_reset_postdata();
    		?>	 	
		 </section>
		 <section class="ads-home">

            <div class="desktop-version align-center"> <!-- Right Rail Home -->
                <?php $right_rail =  get_ads_script('right-rail'); 
                        echo $right_rail['ad_script'];
                ?>
            </div> <!-- Right Rail Home -->
            
            <!--
            <script async src="https://modules.wearehearken.com/wndr/embed/868.js"></script>
            -->
            <div class="desktop-version" style="margin-bottom: 20px">
                <script async src="https://modules.wearehearken.com/qcitymetro/embed/4551.js"></script>
            </div>

            <div class="desktop-version align-center"> <!-- Small Optional Ad Right -->
                <?php $ad_right = get_ads_script('small-ad-right'); 
                        echo $ad_right['ad_script'];
                ?>
            </div> <!-- Small Optional Ad Right -->
            
		 </section>


         <div class="more"> 
            <a class="red qcity-load-more" data-page="1" data-action="qcity_load_more" data-basepoint="10" data-except="<?php echo implode(',', $postID); ?>" data-perpage="6">        
                <span class="load-text">Load More</span>
                <span class="load-icon"><i class="fas fa-sync-alt spin"></i></span>
            </a>
        </div>

	 </section>


