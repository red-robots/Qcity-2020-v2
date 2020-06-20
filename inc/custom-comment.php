<?php
/*
*   Additional fields for comment section
*/

function qcity_comment_form_default_fields( $fields ) {
    // $commenter     = wp_get_current_commenter();
    // $user          = wp_get_current_user();
    // $user_identity = $user->exists() ? $user->display_name : '';
    $key = get_recaptcha_api_keys();
    $req           = get_option( 'require_name_email' );
    $aria_req      = ( $req ? " aria-required='true'" : '' );
    $html_req      = ( $req ? " required='required'" : '' );
    $html5         = current_theme_supports( 'html5', 'comment-form' ) ? 'html5' : false;

    $fields = [
        'author' => '<p class="comment-form-author">' . '<label for="author">' . __( 'Name', 'textdomain'  ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
                    '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" maxlength="245"' . $aria_req . $html_req . ' /></p>',
        'email'  => '<p class="comment-form-email"><label for="email">' . __( 'Email', 'textdomain'  ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
                    '<input id="email" name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" maxlength="100" aria-describedby="email-notes"' . $aria_req . $html_req  . ' /></p>',
        /*'url'    => '<p class="comment-form-url"><label for="url">' . __( 'Website', 'textdomain'  ) . '</label> ' .
                    '<input id="url" name="url" ' . ( $html5 ? 'type="url"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" maxlength="200" /></p>',*/
        'city'  => '<p class="comment-form-city"><label for="city">' . __( 'City' ) . '</label> ' .
        '<input id="city" name="city" type="text" size="30" value="" /></p>',
        'phone' => '<p class="comment-form-phone"><label for="city">' . __( 'Daytime Phone' ) . ' </label> ' .
        '<input id="phone" name="phone" type="text" size="30" /></p>',     
        'comment_field' => '<p class="comment-form-comment"><label for="comment">' . _x( 'Comment *', 'noun', 'textdomain' ) . '</label> <textarea id="comment" name="comment" cols="45" rows="8" maxlength="65525" aria-required="true" required="required"></textarea></p>',
        'recaptcha_field' => '<div id="gRecaptcha" class="g-recaptcha" data-sitekey="6LdIC6cZAAAAACYa0mTzi2doOf-2imI3klLa4LV2"></div>',
    ];

    return $fields;
}
add_filter( 'comment_form_default_fields', 'qcity_comment_form_default_fields' );


function qcity_comment_form_defaults( $defaults ) {
    if( !is_user_logged_in() ) {
        if ( isset( $defaults[ 'comment_field' ] ) ) {
            $defaults[ 'comment_field' ] = '';
        }
    } 
    return $defaults;
}
add_filter( 'comment_form_defaults', 'qcity_comment_form_defaults', 10, 1 );




function save_comment_meta_data( $comment_id ) {
    if ( ( isset( $_POST['phone'] ) ) && ( $_POST['phone'] != '') )
        $phone = wp_filter_nohtml_kses($_POST['phone']);
    add_comment_meta( $comment_id, 'phone', $phone );

    if ( ( isset( $_POST['city'] ) ) && ( $_POST['city'] != '') )
        $city = wp_filter_nohtml_kses($_POST['city']);
    add_comment_meta( $comment_id, 'city', $city );

    $email_recipient = 'mailbag@qcitymetro.com';
    //$email_recipient = 'cathy@bellaworksweb.com';
    //$email_recipient = 'hermiebarit@gmail.com';
    $comment = get_comment( $comment_id );
    $postid = $comment->comment_post_ID;
    // if( $email_recipient ):
    //     $message = 'New comment on <a href="' . get_permalink( $postid ) . '">' .  get_the_title( $postid ) . '</a>';
    //     $message .= '<p>Name: '. $comment->comment_author .'</p>';
    //     $message .= '<p>Email: '. $comment->comment_author_email .'</p>';
    //     //$message .= '<p>Website: '. $comment->comment_author_url .'</p>';
    //     if( $city ){
    //         $message .= '<p>City: '. $city .'</p>';
    //     }
    //     if( $phone ){
    //         $message .= '<p>Daytime Phone: '. $phone .'</p>';
    //     }
    //     $message .= '<p>Content: '. $comment->comment_content .'</p>';
          
    //     add_filter( 'wp_mail_content_type', create_function( '', 'return "text/html";' ) );
    //     wp_mail( $email_recipient, 'New Comment from ' . $comment->comment_author, $message );
    // endif;
    return true;
}
add_filter('comment_post','save_comment_meta_data');

add_filter( 'preprocess_comment', 'verify_comment_meta_data' );
function verify_comment_meta_data( $commentdata ) {
    $errors = [];
    $key = get_recaptcha_api_keys();

    if (empty($_POST['g-recaptcha-response'])) {
        exit('Please set recaptcha variable');
    }
    // validate recaptcha
    $response = $_POST['recaptcha'];
    $post = http_build_query(
        array (
            'response' => $response,
            'secret' => '6LdIC6cZAAAAAJvtHZG-Aal_Vyww0NEV4wasRRzP',
            'remoteip' => $_SERVER['REMOTE_ADDR']
        )
    );
    $opts = array('http' => 
        array (
            'method' => 'POST',
            'header' => 'application/x-www-form-urlencoded',
            'content' => $post
        )
    );
    $context = stream_context_create($opts);
    $serverResponse = @file_get_contents('https://www.google.com/recaptcha/api/siteverify', false, $context);
    if (!$serverResponse) {
        exit('Failed to validate Recaptcha');
    }
    $result = json_decode($serverResponse);
    if (!$result ->success) {
        exit('Invalid Recaptcha');
    }
}



function get_recaptcha_api_keys() {
    $key['site_key'] = '6Lf6MqYZAAAAAMad_rrxrHM6qaGOr2wS9sTy-TYu';
    $key['secret_key'] = '6Lf6MqYZAAAAADTI1-nSSS4R0PcKvlxxqdvtIbsD';
    return $key;
}


/*add_filter('wp_mail_from','qcity_wp_mail_from');
function qcity_wp_mail_from( $content_type ) {
  return 'From: QCity Metro <mailbag@qcitymetro.com>';
}*/
