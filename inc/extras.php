<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package ACStarter
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function acstarter_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	return $classes;
}
add_filter( 'body_class', 'acstarter_body_classes' );


function search_filter_church($query) {
    if ( ! is_admin() && $query->is_main_query() ) {
        if ( $query->is_search ) {
            $query->set( 'post_type', 'church_listing' );
        }
    }
}
add_action( 'pre_get_posts', 'search_filter_church' );

function search_filter_business($query) {
    if ( ! is_admin() && $query->is_main_query() ) {
        if ( $query->is_search ) {
            $query->set( 'post_type', 'business_listing' );
        }
    }
}
add_action( 'pre_get_posts', 'search_filter_business' );


function email_obfuscator($string) {
    $output = '';
    if($string) {
        $emails_matched = ($string) ? extract_emails_from($string) : '';
        if($emails_matched) {
            foreach($emails_matched as $em) {
                $encrypted = antispambot($em,1);
                $replace = 'mailto:'.$em;
                $new_mailto = 'mailto:'.$encrypted;
                $string = str_replace($replace, $new_mailto, $string);
                $rep2 = $em.'</a>';
                $new2 = antispambot($em).'</a>';
                $string = str_replace($rep2, $new2, $string);
            }
        }
        $output = apply_filters('the_content',$string);
    }
    return $output;
}


add_filter( 'taxonomy_archive ', 'slug_tax_event_category' );
function slug_tax_event_category( $template ) {
    if ( is_tax( 'event_cat' ) ) {
         global $wp_query;
         $page = $wp_query->query_vars['paged'];
        if ( $page = 0 ) {
            $template = get_stylesheet_directory(). '/taxonomy-event-category.php';
        }
    }

    return $template;

}


/*
*   Related Posts by category
*/

function qcity_related_posts() {
 
    $post_id = get_the_ID();
    $cat_ids = array();
    $categories = get_the_category( $post_id );
 
    if ( $categories && !is_wp_error( $categories ) ) {
 
        foreach ( $categories as $category ) {
 
            array_push( $cat_ids, $category->term_id );
 
        }
 
    }

    $current_post_type = get_post_type( $post_id );
     
    $args = array(
        'category__in'      => $cat_ids,
        'post_type'         => $current_post_type,
        'post_status'       => 'publish',
        'posts_per_page'    => '5',
        'post__not_in'      => array( $post_id )
    );

    $query = new WP_Query( $args );
 
    if ( $query->have_posts() ) :   ?>
        <aside class="related-posts">
            <h3>
                <?php _e( 'Related Posts', 'qcity' ); ?>
            </h3>
            <ul class="related-posts">
                <?php
     
                    while ( $query->have_posts() ) :
     
                        $query->the_post();
     
                        ?>
                        <li>
                            <a href="<?php the_permalink(); ?>">
                                <?php the_title(); ?>
                            </a>
                        </li>
                        <?php
     
                    endwhile;
     
                ?>
            </ul>
        </aside>
        <?php
     
    endif;
     
    wp_reset_postdata();
 
}


/*
*   Youtube iframe setup
*/

function youtube_setup( $src ){
    
    parse_str( parse_url( $src, PHP_URL_QUERY), $query);
    $id = $query['v'];
    $url = "https://www.youtube.com/embed/" . $id;
    
    return $url;
}

/*
*   Advertisements
*/

function get_ads_script($slug)
{
    $ad_script = '';
    $ads_params = array();

    $ad_post = get_page_by_path( $slug, OBJECT, 'ad' );

    $args = array(       
        'post_type'         => 'ad',
        'post_status'       => 'publish',
        'p'                 => $ad_post->ID,        
    );

    $query = new WP_Query( $args );

    if ( $query->have_posts() ) :   

         while ( $query->have_posts() ) :
     
            $query->the_post();

            $ad_enable = get_field('enable_ad');
            if( $ad_enable == 'Yes' ):

                $ad_script      = get_field('ad_script');
                $ads_label      = get_field('ads_label');
                $ads_link_text  = get_field('ads_link_text');
                $ads_link_url   = get_field('ads_link_url');

                $ads_params = array(
                    'ad_script'     => $ad_script,
                    'ads_label'     => $ads_label,
                    'ads_link_text' => $ads_link_text,
                    'ads_link_url'  => $ads_link_url
                );            
            endif;

        endwhile;

    endif;

    wp_reset_postdata();

    return $ads_params;
}

/*
*   Search for Jobs content
*/

function have_content( $term_id )
{
    $content = false;
    $args = array(
            'post_type'     => 'job',
            'post_status'   => 'publish',
            'tax_query' => array( 
                    array(
                        'taxonomy' => 'job_cat',
                        'field' => 'id',
                        'terms' => $term_id,
                        'include_children' => false,
                        'operator' => 'IN'
                      )
            )

    );

    $query = new WP_Query( $args );

    if( $query->have_posts() ):

        $content = true;

    else:  

        $content = false;

    endif;
    wp_reset_postdata();

    return $content;
}

/*
*   Adding Ads inside single article
*/


add_filter('the_content', 'qcity_add_incontent_ad');
function qcity_add_incontent_ad( $content )
{   
    $hide_ads = (defined('HIDE_ADS') && HIDE_ADS ) ? true : false;
    if( is_single() && ( get_post_type() === 'post' ) && !$hide_ads ){
        $content_block  = explode('<p>',$content);
        $ads_6th        = get_ads_script('single-article-after-6th-paragraph');
        $ads_12th       = get_ads_script('single-article-after-12th-paragraph');
        if( !empty($content_block[5]) && $ads_6th)
        {               
            $content_block[5] .= '</div>
                            <div class="brown-bar"><div class="qcity-ads-label">'. $ads_6th['ads_label'] .' <a href="'. $ads_6th['ads_link_url'] .'">'. $ads_6th['ads_link_text'] .'</a> </div>'. $ads_6th['ad_script'] .'</div>
                            <div class="content-single-page">';
        }
        if( !empty($content_block[11]) && $ads_12th)
        {               
            $content_block[11] .= '</div>
                            <div class="brown-bar"><div class="qcity-ads-label">'. $ads_12th['ads_label'] .' <a href="'. $ads_12th['ads_link_url'] .'">'. $ads_12th['ads_link_text'] .'</a> </div>'. $ads_12th['ad_script'] .'</div>
                            <div class="content-single-page">';
        }
        for($i=1; $i<count($content_block); $i++)
        {   
            $content_block[$i] = '<p>'.$content_block[$i];
        }
        $content = implode('',$content_block);
    } elseif( is_page('business-directory-sign-up') ){

        //add_filter( 'gform_pre_render', 'qcity_insert_packages' );

        $content_block  = explode('<p>',$content);

        //r_dump($content_block);

        if( !empty($content_block[2])){

            $packages = get_field('packages');

            if( $packages ): 
                    $content_block[2] .= '<section class="tiers membership-thirds pricing-grid signup">';
                foreach( $packages as $package): 
                        
                        $title  = $package['package_title'];
                        $desc   = $package['package_details'];

                        if( $title ):
                            $content_block[2] .= '<div class="third plan">
                            <h3>'. $title .'</h3> '. $desc .'
                            </div>
                            ';
                        endif;                         
                endforeach;
                $content_block[2] .= '</section>';     
                ?>
            <?php endif; ?>    

        <?php }

            for($i=1; $i<count($content_block); $i++)
            {   
                $content_block[$i] = '<p>'.$content_block[$i];
            }
            $content = implode('',$content_block);   

    }
    return $content;    
}

function qcity_insert_packages()
{
    $content_block = '';
    if( is_page('business-directory-sign-up') ){

        $packages = get_field('packages');

        $content_block = '<section class="tiers membership-thirds pricing-grid signup">';

        foreach( $packages as $package): 
                        
                        $title  = $package['package_title'];
                        $desc   = $package['package_details'];

                        if( $title ):
                            $content_block .= '<div class="third plan">
                            <h3>'. $title .'</h3> '. $desc .'
                            </div>
                            ';
                        endif;                         
        endforeach;
        $content_block .= '</section>';
    } // page 
    return $content_block;
}

add_filter( 'rp4wp_append_content', '__return_false' );


function returnlimit( $limit ) {
    return "LIMIT 3";
}

/*
function qcity_add_sticky_custom_box()
{       
        add_meta_box(
            'qcity_sticky_box_id',           
            'Stick On Right Side',  
            'qcity_custom_box_html',  
            'post',                  
            'side', 'high'
        );   
}
//add_action('add_meta_boxes', 'qcity_add_sticky_custom_box', 2);

function qcity_custom_box_html( $post )
{
    $value = get_post_meta( $post->ID, '_qcity_meta_key', true );
    if (get_post_type( $post->ID ) != 'post') {
        return;
    }
    
    ?>
    <label for="qcity_custom_stick_right">
    <input type="checkbox" id="qcity_custom_stick_right" name="qcity_custom_stick_right" value="1" <?php  echo (( $value == 1 ) ) ? ' checked ' : ''; ?>> Stick on right side
    </label>    
    <?php
}

function qcity_save_postdata($post_id)
{
    //if (array_key_exists('qcity_custom_stick_right', $_POST)) {        
         update_post_meta(
            $post_id,
            '_qcity_meta_key',
            $_POST['qcity_custom_stick_right']
        );

    //}

}
//add_action('save_post', 'qcity_save_postdata');
*/


function get_posts_ids($right_posts) {
    $ids = array();
    if($right_posts) {
        foreach($right_posts as $post){
            if( isset($post->ID) ) {
                $ids[] = $post->ID;
            }
        }
    }
    
    return $ids;
}


/* This custom field will show up under 'Status & Visibility' meta box */
function custom_meta_post_visibility_box($object) {
    wp_nonce_field(basename(__FILE__), "custom_meta_post_visibility-nonce");
    $display_post = get_post_meta($object->ID, "custom_meta_post_visibility", true);
    $selected = ($display_post==1) ? 1 : 0;
    $screen = get_current_screen();
    $action = ( isset($screen->action) && $screen->action=='add' ) ? 'add':'edit';
    $is_selected = ($display_post==1) ? ' checked':'';
    ?>
    <div class="components-panel__row">
        <div class="components-base-control">
            <div class="components-base-control__field">
                <label for="meta_display_post<?php echo $val; ?>" class="components-checkbox-control__input-container">
                    <span class="inputlabel">Stick On Right Side</span>
                    <input type="checkbox" id="meta_display_post1" name="custom_meta_post_visibility" class="components-checkbox-control__input cmeta_display_post meta_display_post1" value="1"<?php echo $is_selected?>>
                    <i class="chxboxstat"></i>
                </label>
            </div>
        </div>
    </div>
    <?php  
}

function add_custom_meta_box() {
    add_meta_box("display-post-meta-box", "Post Visibility", "custom_meta_post_visibility_box", "post", "side", "high", null);
}
add_action("add_meta_boxes", "add_custom_meta_box");

function save_custom_meta_post_visibility_box($post_id, $post, $update) {
    if (!isset($_POST["custom_meta_post_visibility-nonce"]) || !wp_verify_nonce($_POST["custom_meta_post_visibility-nonce"], basename(__FILE__)))
        return $post_id;

    if(!current_user_can("edit_post", $post_id))
        return $post_id;

    if(defined("DOING_AUTOSAVE") && DOING_AUTOSAVE)
        return $post_id;

    $slug = "post";
    if($slug != $post->post_type)
        return $post_id;

    $post_visibility = "";
    if(isset($_POST["custom_meta_post_visibility"]))
    {
        $post_visibility = $_POST["custom_meta_post_visibility"];
    }   
    update_post_meta($post_id, "custom_meta_post_visibility", $post_visibility);
}
add_action("save_post", "save_custom_meta_post_visibility_box", 10, 3);

function jupload_scripts() { 
$screen = get_current_screen();
$is_post = ( isset($screen->base) && $screen->base=='post' ) ? true:false; 
if($is_post) { ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script>
    jQuery.noConflict();
    jQuery(document).ready(function($){
        var selectedVal = ( typeof $("#display-post-meta-box input.cmeta_display_post:checked").val() !== 'undefined' ) ? $("#display-post-meta-box input.cmeta_display_post:checked").val() : '';
        var postmetaForm = $("#display-post-meta-box .components-base-control").clone();
        $(postmetaForm).addClass('display-post-meta-box-control');
        $(postmetaForm).insertAfter(".edit-post-sidebar .edit-post-post-schedule");
        if(selectedVal) {
            $(".display-post-meta-box-control input.cmeta_display_post").attr("checked",true);
        } else {
            $(".display-post-meta-box-control input.cmeta_display_post").attr("checked",false);
        }
        
        $(document).on("click",".display-post-meta-box-control input.cmeta_display_post",function(){
            if(this.checked) {
                $("input.cmeta_display_post").attr("checked",true);
            } else {
                $("input.cmeta_display_post").attr("checked",false);
            }
        });
    });
    </script>
<?php
    }
}
add_action( 'admin_print_scripts', 'jupload_scripts' );

add_action( 'admin_head', 'post_visibility_head_scripts' );
function post_visibility_head_scripts(){ ?>
    <style>
        .display-post-meta-box-control {
            margin-top: 15px;
        }
        .display-post-meta-box-control label {
            display: block;
            width: 100%;
        }
        .display-post-meta-box-control .components-base-control__field label.components-checkbox-control__input-container {
            display: block;
            width: 100%;
            position: relative;
            margin: 0 0;
            padding: 0 0 0 22px;
        }
        .display-post-meta-box-control .components-base-control__field input {
            margin-right: 2px;
            position: absolute;
            top: 1px;
            left: 0;
            z-index: 5;
            background: transparent!important;
        }
        .display-post-meta-box-control .components-base-control__field .chxboxstat {
            display: block;
            width: 16px;
            height: 16px;
            position: absolute;
            top: 1px;
            left: 0;
            z-index: 3;
            border: 2px solid transparent;
            border-radius:2px;
            transition: none;
            font-style: normal;
        }
        .display-post-meta-box-control .components-base-control__field input:checked + .chxboxstat {
            background: #11a0d2;
            border-color: #11a0d2;
        }.display-post-meta-box-control .components-base-control__field input:checked + .chxboxstat:before {
            content: "\2714";
            display: inline-block;
            position: absolute;
            top: 0px;
            left: 1px;
            color: #FFF;
            font-size: 12px;
            line-height: 1;
        }
        #display-post-meta-box label.components-checkbox-control__input-container {
            width: 100%!important;
            position: relative;
            padding-left: 22px;
        }
        #display-post-meta-box .components-base-control__field input {
            visibility: visible;
            position: absolute;
            top: 1px;
            left: 0;
        }
        /* This is the actual meta box. This will do the trick. */
        .metabox-location-side #display-post-meta-box{display:none!important;}
    </style>
<?php
}
/* end of meta box custom field */


// Save the comment meta data along with comment

add_action( 'comment_post', 'save_custom_comment_meta_data' );
function save_custom_comment_meta_data( $comment_id ) {

    if ( ( isset( $_POST['city'] ) ) && ( $_POST['city'] != ’) )
    $rating = wp_filter_nohtml_kses($_POST['city']);
    add_comment_meta( $comment_id, 'city', $rating );

    if ( ( isset( $_POST['phone'] ) ) && ( $_POST['phone'] != ’) )
    $phone = wp_filter_nohtml_kses($_POST['phone']);
    add_comment_meta( $comment_id, 'phone', $phone );
  
}

add_action( 'edit_comment', 'extend_comment_edit_metafields' );
function extend_comment_edit_metafields( $comment_id ) {
    //if( ! isset( $_POST['extend_comment_update'] ) || ! wp_verify_nonce( $_POST['extend_comment_update'], 'extend_comment_update' ) ) return;

    if ( ( isset( $_POST['phone'] ) ) && ( $_POST['phone'] != ’) ) :
    $phone = wp_filter_nohtml_kses($_POST['phone']);
    update_comment_meta( $comment_id, 'phone', $phone );
    else :
    delete_comment_meta( $comment_id, 'phone');
    endif;

    if ( ( isset( $_POST['city'] ) ) && ( $_POST['city'] != ’) ):
    $city = wp_filter_nohtml_kses($_POST['city']);
    update_comment_meta( $comment_id, 'city', $city );
    else :
    delete_comment_meta( $comment_id, 'city');
    endif;
}


if( isset($_GET['action']) && $_GET['action']=='editcomment' ) {
function action_admin_footer( $array ) { 
    $comment_id = ( isset($_GET['c']) && $_GET['c'] ) ? $_GET['c'] : '';
    if($comment_id) {
        $phone = get_comment_meta( $comment_id, 'phone', true );
        $city = get_comment_meta( $comment_id, 'city', true );
        $author_ip = get_comment_author_IP($comment_id);
        ?>
        <script>
        jQuery(document).ready(function($){
            var info_container = $("#namediv");
            var city = '<?php echo $city;?>';
            var phone = '<?php echo $phone;?>';
            var author_ip = '<?php echo $author_ip;?>';
            var fields = '<tr><td class="first"><label for="phone">Daytime Phone:</label></td><td><input type="text" id="phone" name="phone" value="'+phone+'"></td></tr>';
                fields += '<tr><td class="first"><label for="city">City:</label></td><td><input type="text" id="city" name="city" value="'+city+'"></td></tr>';
                fields += '<tr><td class="first"><label for="authorip">User IP:</label></td><td><input type="text" value="'+author_ip+'" disabled></td></tr>';
            $("#namediv .editcomment tbody").append(fields);
        });
        </script>
    <?php
    }
}; 
add_action( 'admin_footer', 'action_admin_footer', 10, 1 ); 
}


function get_the_user_ip() {
if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
//check ip from share internet
$ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
//to check ip is pass from proxy
$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
$ip = $_SERVER['REMOTE_ADDR'];
}
return apply_filters( 'wpb_get_ip', $ip );
}
 
add_shortcode('show_ip', 'get_the_user_ip');


