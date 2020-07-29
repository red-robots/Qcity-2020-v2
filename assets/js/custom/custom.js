/**
 *	Custom jQuery Scripts
 *	
 *	Developed by: Austin Crane	
 *	Designed by: Austin Crane
 *  Modified by: Lisa DeBona
 *  Date Modified: 07.28.20
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


    /* Stick To Right Posts */
    adjust_right_side_post_images();
    $(window).on("resize",function(){
        adjust_right_side_post_images();
    });

    function adjust_right_side_post_images() {
        if( $(".stickRight .story-block").length > 0 ) {
            $(".stickRight .story-block").each(function(){
                var target = $(this);
                var photoHeight = $(this).find(".photo").height();
                var descHeight = $(this).find(".desc").height();
                if(descHeight>photoHeight) {
                    target.addClass("photoAbsolute");
                }
            });
        }
    }

	

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
    }
    
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

        $.ajax({
            url: ajaxURL,
            type: 'post',
            data: {
                page: page,
                action: action
            },
            success: function(response){

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
                    }
                });
            }
        });
    });

    // Adding search function in burger
    $('#menu-burger-submenu').append('<li><div class="qcity_search_holder"><input type="text" class="qcity_search_class" name="qcity_search" id="qcity_search" placeholder="Search"><div class="qcity_search_icon"><span ><i class="fas fa-search"></i></span></div></div></li>');
        
    $('.qcity_search_icon').on('click', function(){
        var search_word = $('#qcity_search').val();
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

    if( $("form#commentform").length > 0 ) {
        if( typeof params.recaptcha !=='undefined' ) {
            var error = params.recaptcha;
            var message = '';
            if(error=='invalid') {
                message = '<div id="commentFormResponse">Invalid reCAPTCHA. Please try again.</div>';
            }
            else if(error=='empty') {
                message = '<div id="commentFormResponse">Please enter reCAPTCHA to prove you\'re a human.</div>';
            }
            $(message).prependTo("form#commentform");
            history.replaceState('', document.title, currentURL);
        }
    }

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

    
    /* Homepage Big Photo */
    change_text_height_top_blog();
    $(window).on("resize",function(){
        change_text_height_top_blog();
    });
    function change_text_height_top_blog() {
        var screenWidth = $(window).width();
        if( $(".stickRight .story-block").length > 0 ) {
            if( $(".stickLeft .bigPhoto").length > 0 ) {
                if( screenWidth > 1000 ) {
                    var bigPhotoHeight = $(".stickLeft .bigPhoto").height();
                    var stickLeftHeight = $(".stickLeft").height();
                    var textHeight = stickLeftHeight - bigPhotoHeight;
                    $(".stickLeft .info").css("height",textHeight+"px");
                    $(".stickLeft .info").addClass('absolute');
                } else {
                    $(".stickLeft .info").css("height","auto");
                    $(".stickLeft .info").removeClass('absolute');
                }
            }
        }
    }

    function js_get_start_date() {
      var d = new Date();
      var mo = d.getMonth() + 1;
      var month = (mo.toString().length < 2 ? "0"+mo.toString() : mo);
      var day = (d.getDate().toString().length < 2 ? "0"+d.getDate().toString() :d.getDate());
      var year = d.getFullYear();
      var dateNow = year+month+day;
      return dateNow;
    }

    function js_get_date_range(numDays) {
        var d = new Date();
        var mo = d.getMonth() + 1;
        var month = (mo.toString().length < 2 ? "0"+mo.toString() : mo);
        var day = (d.getDate().toString().length < 2 ? "0"+d.getDate().toString() :d.getDate());
        var year = d.getFullYear();
        var sec = d.getSeconds();
        var min = d.getMinutes();
        var hour = d.getHours();
        var time = hour+'-'+min;
        var date_range = [];
        for(i=0; i<=numDays ;i++) {
            var nth = day + i;
            var nthdate = year+month+nth;
            date_range.push(nthdate);
        }
        var date_string = date_range.join();
        return date_string;
    }

    /* Uncomment to Delete Cookies */
    //Cookies.remove('qcitysubcribedaterange');
    
    /* Temporarily hide subscription pop-up on desktop when user close it. 
     * Display it back after 2 days. 
    */ 
    var dateNow = js_get_start_date();
    var dateRange = js_get_date_range(2);
    var cookieDates = ( typeof Cookies.get('qcitysubcribedaterange')!="undefined" ) ? Cookies.get('qcitysubcribedaterange') : '';
    if( $("#oakland-optin").length > 0 ) {
        if(cookieDates) {
            var arr_dates = cookieDates.split(",");
            if($.inArray(dateNow, arr_dates) !== -1) { /* Do not show signup box */
                document.querySelector(".oakland-lightbox").remove();
            } else {
                /* Show only on News post */
                if( $("body").hasClass("single-post") ) {
                    document.querySelector(".oakland-lightbox").style.display = "block";
                    document.querySelector(".oakland-lightbox").classList.add("show");
                }
            }
        } else {
            /* Show only on News post */
            if( $("body").hasClass("single-post") ) {
                document.querySelector(".oakland-lightbox").style.display = "block";
                document.querySelector(".oakland-lightbox").classList.add("show");
            } else {
                document.querySelector(".oakland-lightbox").style.display = "none";
            }
        }
    }

    /* Uncomment to Delete Cookies */
    //Cookies.remove('qcitysubcribeview');

    /* Mobile Subscription */
    var cookieMobileSubscribe = ( typeof Cookies.get('qcitysubcribeview')!="undefined" ) ? Cookies.get('qcitysubcribeview') : '';
    if( $("#mobileSignUpBox").length > 0 ) {
        if(cookieMobileSubscribe) {

            var arr_dates_mob = cookieMobileSubscribe.split(",");
            if($.inArray(dateNow, arr_dates_mob) !== -1) { /* Do not show signup box */
                document.getElementById("mobileSignUpBox").style.display = "none";
                $("#mobileSignUpBox").remove();
            } else {
                document.getElementById("mobileSignUpBox").style.display = "block";
                $("#mobileSignUpBox").addClass("animated fadeIn");
            }

        } else {
            document.getElementById("mobileSignUpBox").style.display = "block";
            $("#mobileSignUpBox").addClass("animated fadeIn");
        }
    }

    $("#closeSubscribe, .signUpBtn").on("click",function(){
        //Cookies.set('qcitysubcribeview',dateNow);
        Cookies.set('qcitysubcribeview',dateRange);
        $(".mobileSubscribe").remove();
    });

    $(document).on("click",".oakland-lightbox",function(e){
        var container = $("#oakland-optin");
        if (!container.is(e.target) && container.has(e.target).length === 0) {
            set_cookies_subscription_popup();
        }
    });

    $(document).on("click","#oakland-optin .oakland-close",function(e){
        set_cookies_subscription_popup();
    });

    /* Set cookies when subscription is closed (DESKTOP) */
    function set_cookies_subscription_popup() {
        Cookies.set('qcitysubcribedaterange',dateRange);
    }


    /* Move `Sponsored By` Box on top of `Sponsored Content` box (bottom page) */
    if( $(".sponsoredInfoBox").length>0 && $(".sponsored-by").length > 0 ) {
        $(".sponsored-by").appendTo(".sponsoredInfoBox");
    }

    /* Sponsored Content - Tool tip */
    if( $(".whatIsThisTxt").length > 0 && $("#sponsorToolTip").length > 0 ) {
        $(".whatisThis").hover(
            function(){
                $(this).next(".whatIsThisTxt").addClass("show");
            }, function(){
                $(this).next(".whatIsThisTxt").removeClass("show");
            }
        );
    }

    /* Mobile Header - Newsletter Button */
    // adjust_newsLetter_button();
    // $(window).on('resize orientationchange',function(){
    //     adjust_newsLetter_button();
    // });

    // function adjust_newsLetter_button() {
    //     var mobileWidth = $(window).width();
    //     if(mobileWidth<481) {
    //         var mw = mobileWidth - 112;
    //         var logoWidth = $("#masthead .logo img").width();
    //         var newsBtnWidth =  mw - logoWidth;
    //         $(".newsletter-link").css("width",newsBtnWidth+"px");
    //     } else {
    //         $(".newsletter-link").css("width","");
    //     }
    // }
    

});// END #####################################    END