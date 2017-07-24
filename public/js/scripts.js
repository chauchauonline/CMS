var backtotop = function(){
	$(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            $('.backtotop').fadeIn();
        } else {
            $('.backtotop').fadeOut();
        }
    });

    $('.backtotop').click(function () {
        $("html, body").animate({
            scrollTop: 0
        }, 600);
        return false;
    });
};

var menumobile = function(){
	$('.loged-profile .contact').click(function(){
		if ( $('.loged-submenu').is(':visible') ) {
	      $('.loged-submenu').hide();
	    } else {
	      $('.loged-submenu').show();
	    }
	});
    $('.btn-menumobile').click(function(){
        $(this).parents('.menu-mobile').find('.mainmenu').toggleClass('active');
        $(this).parents('.templ, .header').toggleClass('active');
        $(this).parents('.menu-mobile').toggleClass('overflow');

          $('.btn-closemenu').click(function(){
            if( $('.mainmenu').hasClass('active') ){
              $('.mainmenu,.templ,.header').removeClass('active');
              $('.menu-mobile').removeClass('overflow');
            }
          })
        return false;
    });

   var swidth = $(window).width();
   if(swidth < 769){
     $('.parents > a').click(function(){
      $(this).next('.submenu').toggle();
      return false;
    })
   }
};

var run_scrollToFix = function(){
    var swidth = $(window).width();
    if( swidth < 769 ){
      $('.style').scrollToFixed();
    }
}

var temp = function(){
    $('.disabled a').click(function(){
      return false;
    });
};

var slide = function(){
    var mySwiper = new Swiper ('.hightlight .swiper-container', {
      // Optional parameters
      direction: 'horizontal',
      loop: true,
      autoplay: 4000,
      paginationClickable: true,
      pagination: '.hightlight .swiper-pagination'
    })
}

var ceoSlide = function(){
	var swiper = new Swiper('.ceo_member .swiper-container', {
			nextButton: '.swiper-button-next',
      prevButton: '.swiper-button-prev',
			slidesPerView: 4,
			spaceBetween: 0,
			breakpoints: {
					1024: {
							slidesPerView: 4,
							spaceBetween: 10
					},
					768: {
							slidesPerView: 2,
							spaceBetween: 20
					},
					640: {
							slidesPerView: 1,
							spaceBetween: 0
					}
			}
	});
}

var slide2 = function(){
    var swidth = $(window).width();
    // create a make_point
    $('.news').find('.wauto').addClass('pc_slide');
    $('.news').find('.wauto').after('<div class="mobile_slide"></div>');
    $('.news').find('.pc_slide').children().clone().appendTo('.mobile_slide');

    //load slide on screen < 640
    var mySwiper = new Swiper ('.mobile_slide .swiper-container', {
      // Optional parameters
      direction: 'horizontal',
      loop: true,
      autoplay: 4000,
      paginationClickable: true,
      pagination: '.mobile_slide .swiper-pagination'
    });
};

var inclueregion = function(){
   $("header").load("header.html");
   $("footer").load("footer.html");
};

var search = function(){
  var abc = $('.searchform');
  var btnContact = $('.contact');
  var swidth = $(document).width();
  if(swidth > 768){
	  
    if(abc.hasClass('active')){

    }else {
      abc.on('click',function(event){
        event.stopPropagation();
        $(this).addClass('active');
        $('.searchform.active .btnsearch').click(function(){
          return false;
        });
        $('.contact').css('margin-left', '250px');
      });

      $(document).click( function(){
          abc.removeClass('active');
          $('.contact').css('margin-left', '50px');
      });
    };

  }
};

var validate_form = function(){
  $(".selector").validate({
    rules: {
      name: "required",
      email: {
        required: true,
        email: true
      }
    },
    messages: {
      name: "Please specify your name",
      email: {
        required: "We need your email address to contact you",
        email: "Your email address must be in the format of name@domain.com"
      }
    }
  });
};
var verticalslide = function(){
	if($(".vertical-slide").length > 0){
		 $(".vertical-slide").slick({
		     dots: false,
		     infinite: true,
		     slidesToShow: 5,
		     slidesToScroll:1,
		     vertical: true,
		     autoplay: true,
		     autoplaySpeed: 4000,
		     prevArrow:false,
		     nextArrow:false,
		      });
			}
}
var show_name_before_uploadFile = function(){
  $('input[type="file"]').change(function(){
    var showname = $('.formupload span');
    var file = this.files[0];
    showname.text('' + file.name + '');
  });
};
var colorbox=function(){

  var swidth = $(document).width();
  if( swidth < 769 ){
    $(".group").colorbox({rel:'group',innerWidth: '90%'});
    $('.non-retina').colorbox({rel:'group'});
  }
  else {
    $(".group").colorbox({rel:'group'});
   $('.non-retina').colorbox({rel:'group', transition:'none'});
  }
}
//set equal height for responsive
var equal_height = function(){
  setHeights = function(){
    var a = $('.contents .topnews .bgnew');
    var b = a.parents('.topnews');
    // var c = a.find('h3').find('a');
    var a_height = a.outerHeight();
    b.css('min-height',a_height);
  }

  $(window).load(function() {
    setHeights();
  });
  $( window ).on( 'resize', setHeights );
}

$(document).ready(function(){
    backtotop();
    colorbox();
    menumobile();
    slide();
    slide2();
    temp();
    search();
    show_name_before_uploadFile();
    equal_height();
    verticalslide();
    ceoSlide();
});

// customize js
(function($) {

    var ceoFn = window.ceoFn || {};

    $.extend(ceoFn, {

        version : 0.1,
        context : null,

        init : function() {
//            $("form").first().find('input[type=text]').first().focus();
            $(".mainmenu li a").each(function() {
                var current = $(this);
                var current_url = current.attr("href");
                if( document.location.href.indexOf(current_url) == 0 ){
                    $(".mainmenu li a").removeClass("active");
                    current.addClass("active");
                    return true;
                }
            });
            var str = location.href.toLowerCase();
            $(".submenu li a").each(function () {
                if (str.indexOf(this.href.toLowerCase()) > -1) {
                    $(".submenu li.active").removeClass("active");
                    $(document).find(".parents a").addClass("active");
                }
            });
        }
    });

    window.ceoFn = ceoFn;

})(jQuery);

$(document).ready(function() {
    ceoFn.init();
});
