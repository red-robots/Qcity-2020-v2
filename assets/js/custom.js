/**
 *	Custom jQuery Scripts
 *	
 *	Developed by: Austin Crane	
 *	Designed by: Austin Crane
 */

jQuery(document).ready(function ($) {
	
	/*
	*
	*	Current Page Active
	*
	------------------------------------*/
	$("[href]").each(function() {
        
            if (this.href == window.location.href) {
                $(this).addClass("active");
            }
       
	});

	

	/*
	*
	*   Mobile Nav
	*
	------------------------------------*/
	$('.burger, .overlay').click(function(){
		$('.burger').toggleClass('clicked');
		$('.overlay').toggleClass('show');
		$('nav').toggleClass('show');
		$('body').toggleClass('overflow');
	});
	$('nav.mobilemenu li').click(function() {
		$('nav.mobilemenu ul.dropdown').removeClass('active');
		$(this).find('ul.dropdown').toggleClass('active');
	});
	/*
        FAQ dropdowns
	__________________________________________
	*/
	$('.question').click(function() {
	 
	    $(this).next('.answer').slideToggle(500);
	    $(this).toggleClass('close');
	    $(this).find('.plus-minus-toggle').toggleClass('collapsed');
	    $(this).parent().toggleClass('active');
	 
	});

	/*
	*
	*	Responsive iFrames
	*
	------------------------------------*/
	var $all_oembed_videos = $("iframe[src*='youtube']");
	
	$all_oembed_videos.each(function() {
	
		$(this).removeAttr('height').removeAttr('width').wrap( "<div class='embed-container'></div>" );
 	
 	});
	
	/*
	*
	*	Flexslider
	*
	------------------------------------*/
	$('.flexslider').flexslider({
		animation: "slide",
	}); // end register flexslider
	
	/*
	*
	*	Colorbox
	*
	------------------------------------*/
	$('a.popup').colorbox({
		width: '80%', 
		inline: true
		// height: '80%'
	});
	
	/*
	*
	*	Isotope with Images Loaded
	*
	------------------------------------*/
	var $container = $('#container').imagesLoaded( function() {
  	$container.isotope({
    // options
	 itemSelector: '.item',
		  masonry: {
			gutter: 15
			}
 		 });
	});

	/*
	*
	*	Smooth Scroll to Anchor
	*
	------------------------------------*/
	 /*$('a').click(function(){
	    $('html, body').animate({
	        scrollTop: $('[name="' + $.attr(this, 'href').substr(1) + '"]').offset().top
	    }, 500);
	    return false;
	});*/

    /*
    *   Slider
    */

	
	/*
	*
	*	Equal Heights Divs
	*
	------------------------------------*/
	$('.js-blocks').matchHeight();

	/*
	*
	*	Navigation Jobs Count

		local = 58030
		site = 58030
	*
	------------------------------------*/

    
    var $img_width = $('section.c-sponsor-block').width();

    if( $img_width < 700) {
        $('.c-sponsor-block__image').css('height', '170px');
        console.log('Sponsor paid image is 160 px ...' + $img_width);
    }
    
    
	/*(function(){
        $.post(
            bellaajaxurl.url,
            {
                'action': 'bella_get_jobs_count',
            },
            function (response) {
				var $response = $(response);
				if ($response.find("response_data").length > 0) {
                    $text = $response.find("response_data").eq(0).text();
					$('.menu-item-58030').append('<span class="splat">'+$text+'</span>');
                }
            }
        );
	})();*/

	/*
	*
	*	Navigation Events Count

		local = 63042
		site = 67367
	*
	------------------------------------*/

	/*(function(){
        $.post(
            bellaajaxurl.url,
            {
                'action': 'bella_get_events_count',
            },
            function (response) {
				var $response = $(response);
				if ($response.find("response_data").length > 0) {
                    $text = $response.find("response_data").eq(0).text();
					$('.menu-item-67367').append('<span class="splat">'+$text+'</span>');
                }
            }
        );
	})(); */
	/*
	*
	*	Video
	*
	------------------------------------*/
	var $video_wrapper = $('.template-video .video-holder .video-wrapper');
    if($video_wrapper.length>0){
        var $window = $(window);
        var $video_holder = $('.template-video .video-holder');
        var $site_nav = $('#site-navigation');
        function video_check(){
            var anchor = $video_holder.offset().top;
            var offset_y = 10;
            var offset_x = 10;
            if($site_nav.length>0){
                offset_y = offset_y + $site_nav.height();
            }
            if($window.scrollTop()>anchor && window.innerWidth > 600){
                $video_wrapper.css({
                    position:'fixed',
                    top: offset_y + "px",
                    right: offset_x+"px",
                    width: '350px',
                    height: '196px'
                });
            } else {
                $video_wrapper.css({
                    position:'',
                    top: '',
                    right: '',
                    width: '',
                    height: ''
                });
            }
        }
        video_check();
        $window.on("scroll",video_check);
        $window.on("resize",video_check);
    }

	/*
	*
	*	Popular Posts
	*
	------------------------------------*/
	(function(){
		//this is for wp most popular posts compatability since they don't run title through appropriate filters
		$('.small-post .small-post-content h2').each(function(i,el){
			var $el = $(el);
			var regex = new RegExp('<i\\sclass="fa\\sfa-play-circle-o"></i>');
			if(regex.test($el.text())){
				$el.text($el.text().replace(regex,""));
				$el.append($('<i class="fa fa-play-circle-o"></i>'));
			}
		});
	})();

	// not working below...

	/*
	*
	*	JObs Banner
	*
	------------------------------------*/
	$('.jobs-banner >.row-2 .find').click(function(){
		$('.jobs-banner >.row-3 form >.row-1 input').eq(0).focus();
	});

	//ajaxLock is just a flag to prevent double clicks and spamming.
    /*
	var ajaxLock = false;

	var postOffset = parseInt(jQuery( '#offset' ).text());
	//Change that to your right site url unless you've already set global ajaxURL
	var ajaxURL = bellaajaxurl.url;
	function ajax_next_event() {
		if( ! ajaxLock && postOffset != NaN) {
			ajaxLock = true;
			
			//Parameters you want to pass to query
			ajaxData = {};
			ajaxData.post_offset= postOffset;
			ajaxData.action = 'bella_ajax_next_event';
			if(bellaajaxurl.date!=null){
				ajaxData.date = bellaajaxurl.date;
			}
			if(bellaajaxurl.category!=null){
				ajaxData.category =bellaajaxurl.category;
			}
			if(bellaajaxurl.search!=null){
				ajaxData.search = bellaajaxurl.search;
			}
			if(bellaajaxurl.tax!=null){
				ajaxData.tax = bellaajaxurl.tax;
			}
			if(bellaajaxurl.term!=null){
				ajaxData.term = bellaajaxurl.term;
			}

			//Ajax call itself
			jQuery.ajax({
				type: 'post',
				url:  ajaxURL,
				data: ajaxData,
				dataType: 'json',

				//Ajax call is successful
				success: function ( response ) {
					if(parseInt(response[1])!==0){
						$els = $(response[0]).filter('.tile');
						$els.css("opacity","0");
						$tracking.append($els);
						setTimeout(function(){
							$('.bottom-blocks').matchHeight();
							$('.blocks').matchHeight();
							$els.css("opacity","");
						},200);
						postOffset+=parseInt(response[1]);
						ajaxLock = false;
					}
				},

				//Ajax call is not successful, still remove lock in order to try again
				error: function (err) {
					ajaxLock = false;
				}
			});
		}
	}
    */

	var $window = $(window);
	var $document = $(document);
	var $tracking = $('.tracking');
	
	if($tracking.length>0){

		$window.scroll(function(){
			var top = $tracking.offset().top;
			var height = $tracking.height();
			var w_height = $window.height();
			var d_scroll = $document.scrollTop();
			if(w_height+d_scroll+500>height+top){
				ajax_next_event();
			}
		});
	}

    /*
    *   Category Counter Jobs
    */

    

    $(document).on('click', '.qcity-load-more:not(.loading)', function(){

        var that    = $(this);
        var page    = $(this).data('page');
        var perPage = $(this).data('perpage');
        var newPage = page + 1;
        var action  = $(this).data('action');
        var basepoint = $(this).data('basepoint');
        var newBasepoint = basepoint + perPage;
        var postID = $(this).data('except')        

        that.addClass('loading').find('.load-text').hide();        
        that.find('.load-icon').show();

        //console.log('postID: ' + postID);

        $.ajax({
            url: ajaxURL,
            type: 'post',
            data: {
                page: page,
                action: action,
                basepoint: basepoint,
                postID: postID,
                perPage: perPage
            },
            success: function(response){

                //console.log('Response: ' + response);

                if( response == 0){
                    $('.qcity-news-container').append('<p>No more post to load!</p>');
                    that.hide();
                } else {

                    that.data('page', newPage);
                    that.data('basepoint', newBasepoint);
                    $('.qcity-news-container').slideDown(2000).append(response);

                    setTimeout(function(){
                        that.removeClass('loading');
                        that.find('.load-text').show();
                        that.find('.load-icon').hide();
                    }, 500);

                }
                
            }, 
            error: function(response){
                console.log('Error: ');
                console.log(response);
            }
        });

    });


    /*
    *   Load MOre Sidebar
    */

    $(document).on('click', '.qcity-sidebar-load-more:not(.loading)', function(){

        var that    = $(this);
        var page    = $(this).data('page');
        var newPage = page + 1;
        var action  = $(this).data('action');
        var qp      = $(this).data('qp');
        var postid  = $(this).data('postid');
        //var ajaxUrl = that.data('url');

        that.addClass('loading').find('.load-text').hide();        
        that.find('.load-icon').show();

        //console.log('Page: ' + newPage);

        $.ajax({
            url: ajaxURL,
            type: 'post',
            data: {
                page: page,
                action: action,
                qp: qp,
                postid: postid
            },
            success: function(response){

                //console.log('Response: ' + response);

                if( response == 0){
                    $('.sidebar-container').append('<p>No more post to load!</p>');
                    that.hide();
                } else {

                    that.data('page', newPage);
                    $('.sidebar-container').slideDown(2000).append(response);

                    setTimeout(function(){
                        that.removeClass('loading');
                        that.find('.load-text').show();
                        that.find('.load-icon').hide();
                    }, 500);

                }
                
            }, 
            error: function(response){
                console.log('Error: ');
                console.log(response);
            }
        });

    });

    /*
    *   Business Directory load more footer section
    */

       $(document).on('click', '.qcity-business-directory-load-more:not(.loading)', function(){

        var that    = $(this);
        var page    = $(this).data('page');
        var newPage = page + 1;
        var action  = $(this).data('action');
        //var container = $(this).data('')
        //var ajaxUrl = that.data('url');

        that.addClass('loading').find('.load-text').hide();        
        that.find('.load-icon').show();

        //console.log('Page: ' + newPage);

        $.ajax({
            url: ajaxURL,
            type: 'post',
            data: {
                page: page,
                action: action
            },
            success: function(response){

                //console.log('Response: ' + response);

                if( response == 0){
                    $('.business-directory-table').append('<p>No more post to load!</p>');
                    that.hide();
                } else {

                    that.data('page', newPage);
                    $('.business-directory-table').slideDown(2000).append(response);

                    setTimeout(function(){
                        that.removeClass('loading');
                        that.find('.load-text').show();
                        that.find('.load-icon').hide();
                    }, 500);

                }
                
            }, 
            error: function(response){
                console.log('Error: ');
                console.log(response);
            }
        });

    });


   /*
   *    Church Listing Search
   */

   var searchRequest = null;

    $(function () {
        var minlength = 3;

        $("#form_search").submit(function ( event ) {
            event.preventDefault();
            var that    = $('.searchfield'),
            value       = $('.searchfield').val();
            var action  = 'qcity_church_search';
            var post_type = $('.post_type').val();

            //console.log('Action: ' + action);
            $('.qcity-sponsored-container').hide();
            $('.listing_initial').hide();
            $('.listing_search').show();
            $('.listing_search_result').html('<a class="red"><span class="load-icon"><i class="fas fa-sync-alt spin"></i></span></a>');
            

            if (value.length >= minlength ) {
                if (searchRequest != null) 
                    searchRequest.abort();
                searchRequest = $.ajax({
                    type: "GET",
                    url: ajaxURL,
                    data: {
                        'search_keyword' : value,
                        'action': action,
                        'post_type': post_type
                    },                    
                    success: function( response ){         
                        $('.listing_search_result span.load-icon').hide();              
                        if ( response != 0 ) {
                            $('.listing_search_result').html(response);
                        } else {
                            message = '<h4>'+ value + ' not found! </h4>';
                            $('.listing_search_result').html(message);
                        }
                    },
                    error: function( response ) {
                        $('.listing_search_result span.load-icon').hide();
                        message = '<h4>Oops! Something went wrong. Please try again later. </h4>';
                        $('.listing_search_result').html(message);
                        console.log( response );
                    }
                });
            }
        });
    });

    // Adding search function in burger
    $('#menu-burger-submenu').append('<li><div class="qcity_search_holder"><input type="text" class="qcity_search_class" name="qcity_search" id="qcity_search" placeholder="Search"><div class="qcity_search_icon"><span ><i class="fas fa-search"></i></span></div></div></li>');
        
    $('.qcity_search_icon').on('click', function(){
        var search_word = $('#qcity_search').val();
        console.log('Search clicked! Looking for ' + search_word);
        if( search_word != '' ){
            window.location.href = '/?s=' + search_word + '&pg=1&perpage=20';
        }
        
    });

    $('#qcity_search').keypress(function(e){
        if( e.which == 13 ){            
            $('.qcity_search_icon').click();
        }
    });


    /*
    *   Comments Section
    */

    $('.click_class').on('click', function(){
        // $('.comments-trigger').hide();
        // $('.comments-block').show();
        // $(".comment-form-comment textarea#comment").focus();
        $('.comments-trigger').hide();
        $("#comments .comment-respond").show();
    });

    // $(document).on("click","#commentBtn",function(e){
    //     e.preventDefault();
    //     alert("TEST!");
    //     $(".comments-block").show();
    // });

    /*
    *   Stripe Payment Section
    */

    $('span.pay_amount').on('click', function(){
        $('section.gravityform').show();
    });

	/*
	*
	*	Wow Animation
	*
	------------------------------------*/
	new WOW().init();

    




});// END #####################################    END