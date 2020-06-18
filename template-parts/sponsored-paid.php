<?php

    $args = array(     
            'category_name'     => 'offers-invites+sponsored-post',        
            'post_type'         => 'post',        
            'post_status'       => 'publish',
            'posts_per_page'    => 1,
            'orderby'           => 'rand',
        );

    $sponsored = new WP_Query($args);


    if( $sponsored->have_posts() ):
        $img = "";
         while( $sponsored->have_posts() ):   $sponsored->the_post();

            $sponsors = get_field('sponsors');
            

?>

<section class="c-sponsor-block c-sponsor-block--filled">
    <div class="c-sponsor-block__text">
        <span class="c-sponsor-block__label t-uppercase t-lsp-b has-text-gray-dark t-size-xs has-xxs-btm-marg sponsored-title"><strong>Sponsored Content</strong></span>
        <div class="c-sponsor-block__main">
            <p class="c-sponsor-block__sponsor has-text-sponsor t-uppercase t-lsp-m t-size-xs has-xxs-btm-marg"><strong><?php echo ($sponsors) ? $sponsors[0]->post_title: '' ?></strong></p>
            <h3 class="c-sponsor-block__headline c-sponsor-block__static-text t-lh-s has-xxxs-btm-marg"><a target="_parent" href="<?php echo get_the_permalink();  ?>" class="has-text-black-off has-text-hover-black"><?php echo get_the_title(); ?></a></h3>
            <p class="c-sponsor-block__desc c-sponsor-block__static-text t-lh-m"><?php echo get_the_excerpt(); ?></p>
        </div>
    </div>
    <a target="_parent" href="<?php echo get_the_permalink();  ?>" class="c-sponsor-block__image-wrap l-display-block">
        <?php
            if( has_post_thumbnail() ): ?>

                <?php the_post_thumbnail('thirds', array('class' => 'l-width-full c-sponsor-block__image')); ?>

            <?php else: ?>
                <img src="<?php echo get_template_directory_uri() . '/images/default.png'; ?>" class="l-width-full c-sponsor-block__image" alt="">
        <?php endif; ?>
        
        
    </a>
</section>


<?php
        endwhile;

    endif;
    wp_reset_postdata();

