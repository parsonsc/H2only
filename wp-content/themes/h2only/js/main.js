var meanmenuWidth = 480;
Date.now = Date.now || function() { return +new Date; }; 
jQuery.noConflict();

(function($){
$(document).ready(function ($) {

	$('.styled2').on('focus', function() {
        $( this ).parents('.selectStyle').css('background-position','100% 100%');
	    }).on('blur', function() {
	        $( this ).parents('.selectStyle').css('background-position','100% 100%');
	}).on('change', function() {
	        $( this ).parents('.selectStyle').css('background-position','100% 100%');
	});


	//$('<div class="water-line-bottom"></div>').insertAfter(".water-line-top.3");


    $('#nav-bar nav').meanmenu({meanScreenWidth: meanmenuWidth,meanMenuContainer: '#mean-nav-target'});
    new HomeCarousel();
    externalLinks.init();
    /*
	jQuery('input', '.sign-up-invite').iCheck({
		checkboxClass: 'icheckbox_square-red',
		radioClass: 'icheckbox_square-red'
	});*/
    var isFileInputSupported = (function () {
        // Handle devices which falsely report support
        if (navigator.userAgent.match(/(Android (1.0|1.1|1.5|1.6|2.0|2.1))|(Windows Phone (OS 7|8.0))|(XBLWP)|(ZuneWP)|(w(eb)?OSBrowser)|(webOS)|(Kindle\/(1.0|2.0|2.5|3.0))/)) {
          return false;
        }
        // Create test element
        var el = document.createElement("input");
        el.type = "file";
        return !el.disabled;
    })();    
    if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
        $('.flickr-upload').hide();
    }
    $('iframe').each(function(){
          var url = $(this).attr("src");
          var char = "?";
          if(url.indexOf("?") != -1){
                  var char = "&";
          }         
          $(this).attr("src",url+char+"wmode=transparent");
    });
});

$(window).load(function() {
    
    $('.grid-parent').each(function() {
        var maxHeight = 0;
        $('.equal', this).each(function(){
            maxHeight = Math.max(maxHeight, $(this).outerHeight());
        }).height(maxHeight);
    }); 
});

var externalLinks = {
	init:function(){
        var filetypes = /\.(zip|exe|dmg|pdf|doc.*|xls.*|ppt.*|mp3|txt|rar|wma|mov|avi|wmv|flv|wav)$/i;
        $('a').each(function() {		
            if(window.location.hostname && window.location.hostname !== this.hostname) {
                $(this).attr('target','_blank');
            }
            if ($(this).attr('href').match(filetypes)){
                $(this).attr('target','_blank');
            }
            if ($(this).attr('target') =='_blank'){
                if (jQuery(this).attr("title")) {
                    jQuery(this).attr("title", $(this).attr("title") + ' [opens in a new window]' );
                }else $(this).attr("title", '[opens in a new window]' ); 
            }
        });     
        var baseHref = '';
        if ($('base').attr('href') != undefined) baseHref = $('base').attr('href');
        if ($("iframe").length > 0){
            var frame = $("iframe").attr("src");
            var elEv = []; elEv.value=0, elEv.non_i=false;
            var extension = (/[.]/.exec(frame)) ? /[^.]+$/.exec(frame) : undefined;
            elEv.category = "download";
            elEv.action = "auto-" + extension[0];
            elEv.label = frame.replace(/ /g,"-");
            elEv.loc = baseHref + frame;
            ///alert(elEv.value);
            if (typeof(_gaq) !== 'undefined') {
                ga(['send', 'event', elEv.category.toLowerCase(), elEv.action.toLowerCase(), elEv.label.toLowerCase(), elEv.value, elEv.non_i]);
            }
        }
        $('.showhide').hide();
        if (typeof(ga) !== 'undefined') {
            $('a').on('click', function(event) {
              var el = jQuery(this);
              var track = true;
              var href = (typeof(el.attr('href')) != 'undefined' ) ? el.attr('href') :"";
              var isThisDomain = true;
              if (href.match(/^https?\:/i)) {
                var domain = href.match(/http[s]?\:\/\/(.*?)[\/$]/)[1]
                var isThisDomain = (window.location.hostname && window.location.hostname == domain) ? true : false;
              } 
              if (!href.match(/^javascript:/i)) {
                var elEv = []; elEv.value=0, elEv.non_i=false;
                if (href.match(/^mailto\:/i)) {
                  elEv.category = "email";
                  elEv.action = "click";
                  elEv.label = href.replace(/^mailto\:/i, '');
                  elEv.loc = href;
                }
                else if (href.match(filetypes)) {
                  var extension = (/[.]/.exec(href)) ? /[^.]+$/.exec(href) : undefined;
                  elEv.category = "download";
                  elEv.action = "click-" + extension[0];
                  elEv.label = href.replace(/ /g,"-");
                  elEv.loc = baseHref + href;
                }
                else if (href.match(/^https?\:/i) && !isThisDomain) {
                  elEv.category = "external";
                  elEv.action = "click";
                  elEv.label = href.replace(/^https?\:\/\//i, '');
                  elEv.non_i = true;
                  elEv.loc = href;
                }
                else if (href.match(/^tel\:/i)) {
                  elEv.category = "telephone";
                  elEv.action = "click";
                  elEv.label = href.replace(/^tel\:/i, '');
                  elEv.loc = href;
                }
                else track = false;
         
                if (track) {
                  ga(['send', 'event', elEv.category.toLowerCase(), elEv.action.toLowerCase(), elEv.label.toLowerCase(), elEv.value, elEv.non_i]);
                  if ( el.attr('target') == undefined || el.attr('target').toLowerCase() != '_blank') {
                    setTimeout(function() { location.href = elEv.loc; }, 400);
                    return false;
                  }
                }
              }
            });
        }
	}
};

function HomeCarousel(){
    var that = this;
	this.display = $('#home-carousel-container ul');
    
    this.init = function(){
		if(!$('#home-carousel-container ul').length) return;

		this.createCarousel();
		this.addListeners(); 
		$(window).resize(function() {
			that.destroyCarousel();
			that.createCarousel();
		});
    }
	
	this.createCarousel = function(){
		this.display.carouFredSel({
            width: '100%',
            height: '100%',
            items: 1,
            scroll: {
                fx: 'cover',
                items: 1
            },
            auto: {
                    timeoutDuration: 4000,
                    delay: 1000
            },
            pagination: '#home-carousel-pagination',
        });
	}
	
	this.addListeners = function(){ 
		$('iframe', '#home-carousel-container').hover(function(){ 
			$('#home-carousel-container ul').trigger('pause'); 
			$('#home-carousel-container ul').trigger('configuration', ['auto', false]); 
		}); 
		$('#home-carousel-pagination').click(function(){ 
			$('#home-carousel-container ul').trigger('configuration', ['auto', false]); 
		}); 
	} 
	
	this.destroyCarousel = function(){
		this.display.trigger("destroy", true);
	}
    
    this.init();
}

// RANGE SLIDERS
    if ($('.cost_slider').length > 0){
	$("#pints").noUiSlider({
		start: 0,
		connect: false,
		steps: 1,
		range: {
			'min': 0,
			'max': 20
		},
		serialization: {
			format: {
				decimals: 0
			}
		}
	});
	$("#pop").noUiSlider({
		start: 0,
		connect: false,
		steps: 1,
		range: {
			'min': 0,
			'max': 20
		},
		serialization: {
			format: {
				decimals: 0
			}
		}
	});
	$("#wine").noUiSlider({
		start: 0,
		connect: false,
		steps: 1,
		range: {
			'min': 0,
			'max': 18
		},
		serialization: {
			format: {
				decimals: 0
			}
		}
	});
	$("#tea").noUiSlider({
		start: 0,
		connect: false,
		steps: 1,
		range: {
			'min': 0,
			'max': 100
		},
		serialization: {
			format: {
				decimals: 0
			}
		}
	});
	$("#coffee").noUiSlider({
		start: 0,
		connect: false,
		steps: 1,
		range: {
			'min': 0,
			'max': 60
		},
		serialization: {
			format: {
				decimals: 0
			}
		}
	});
	// SET INITIAL CALCULATED CALORIES
	setCalories()

	// SET INITIAL COUNTER UNITS
	setCalorieCounter();

	// SET INITIAL COST
	setCost();
    }
	function setCalories(){
	// UPDATE CALORIES	

		// USES '+'' before to convert to numeric value otherwise use parseInt()

		// SET CALORIES
		// http://www.weightlossresources.co.uk/calories/calorie_counter/alcohol.htm
		//http://www.weightlossresources.co.uk/calories/calorie_counter/drinks.htm


		var pints 	= 	+$("#pints").val() * 195;
		var pop 	= 	+$("#pop").val() * 139;
		var wine 	= 	+$("#wine").val() * 111;
		var tea 	=	+$("#tea").val() * 2;
		var coffee	= 	+$("#coffee").val() * 190;

		var calories = pints + pop + wine + tea + coffee;

        
		$(".calories-count").text('Calories: ' + calories);
	}

    function updateURLParameter(url, param, paramVal){
        var newAdditionalURL = "";
        var tempArray = url.split("?");
        var baseURL = tempArray[0];
        var additionalURL = tempArray[1];
        var temp = "";
        if (additionalURL) {
            tempArray = additionalURL.split("&");
            for (i=0; i<tempArray.length; i++){
                if(tempArray[i].split('=')[0] != param){
                    newAdditionalURL += temp + tempArray[i];
                    temp = "&";
                }
            }
        }

        var rows_txt = temp + "" + param + "=" + paramVal;
        return baseURL + "?" + newAdditionalURL + rows_txt;
    }    
    
	function setCost(){
	// UPDATE COST	

		var pints 	= 	+jQuery("#pints").val() * 3.90;
		var pop 	= 	+jQuery("#pop").val() * 1.50;
		var wine 	= 	+jQuery("#wine").val() * 3.50;
		var tea 	=	+jQuery("#tea").val() * 2.00;
		var coffee	= 	+jQuery("#coffee").val() * 2.45;

		var cost = pints + pop + wine + tea + coffee;

		jQuery(".calories-cost").text('£' + cost.toFixed(2));
        
        var newURL = updateURLParameter(jQuery('.slider_total_box a').attr('href'), 'amount', cost.toFixed(2));
        jQuery('.slider_total_box a').attr('href', newURL);
	}


	function setCalorieCounter() {
		// SET CALORIE COUNTERS

		var pints 	= 	$("#pints").val();
		$(".pint.counter").text('PINTS' + ' ' + pints);

		var pop 	= 	+$("#pop").val();
		$(".pop.counter").text('POP' + ' ' + pop);

		var wine 	= 	+$("#wine").val();
		$(".wine.counter").text('WINE' + ' ' + wine);

		var tea 	=	+$("#tea").val();
		$(".tea.counter").text('TEA' + ' ' + tea);

		var coffee	= 	+$("#coffee").val();
		$(".coffee.counter").text('COFFEE' + ' ' + coffee);
	}

	// UPDATE CALORIES
    if($('.slide').length > 0){
        var sliders = $('.slide');
        sliders.on('slide', setCalories);

        // SET COST
        sliders.on('slide', setCost);

        // UPDATE COUNTER UNITS
        sliders.on('slide', setCalorieCounter);
    }

	// EQUAL HEIGHTS
	equalheight = function(container){
	var currentTallest = 0,
	     currentRowStart = 0,
	     rowDivs = new Array(),
	     $el,
	     topPosition = 0;
	 $(container).each(function() {
	   $el = $(this);
	   $($el).height('auto')
	   topPostion = $el.position().top;

	   if (currentRowStart != topPostion) {
	     for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
	       rowDivs[currentDiv].height(currentTallest);
	     }
	     rowDivs.length = 0; // empty the array
	     currentRowStart = topPostion;
	     currentTallest = $el.height();
	     rowDivs.push($el);
	   } else {
	     rowDivs.push($el);
	     currentTallest = (currentTallest < $el.height()) ? ($el.height()) : (currentTallest);
	  }
	   for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
	     rowDivs[currentDiv].height(currentTallest);
	   }
	 });
	}

	$(window).load(function() {
	  equalheight('.grid_copy, .intro_block, .select_challenge article, .challenge_block, .h2only_kit');
	});
	$(window).resize(function(){
	  equalheight('.grid_copy, .intro_block, .select_challenge article, .challenge_block, .h2only_kit');
	});

	$('.grid_copy > .absolute').each(function() {
    $(this).parent().height('+=' + $(this).height());
    $(this).css('position', 'absolute');
});
    // if ($('.countdown_tagline').length > 0){
    //     var divs = $(".countdown_tagline div").get().sort(function(){ 
    //       return Math.round(Math.random())-0.5; //random so we get the right +/- combo
    //     }).slice(0,1)
    //     $(divs).appendTo(divs[0].parentNode).show();
    // }
})(jQuery);

