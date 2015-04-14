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
	new DonationGrid();
	//new InviteForm();
	//new SignUpValidation();
	//new IdeasSlider();
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
        $('a').each(function() {		
            if(window.location.hostname && window.location.hostname !== this.hostname) {
                $(this).attr('target','_blank');
            }
        });     
        var filetypes = /\.(zip|exe|dmg|pdf|doc.*|xls.*|ppt.*|mp3|txt|rar|wma|mov|avi|wmv|flv|wav)$/i;
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
                _gaq.push(['_trackEvent', elEv.category.toLowerCase(), elEv.action.toLowerCase(), elEv.label.toLowerCase(), elEv.value, elEv.non_i]);
            }
        }
        $('.showhide').hide();
        if (typeof(_gaq) !== 'undefined') {
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
                  _gaq.push(['_trackEvent', elEv.category.toLowerCase(), elEv.action.toLowerCase(), elEv.label.toLowerCase(), elEv.value, elEv.non_i]);
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

function IdeasSlider(){
	var that = this;
	var activities = [];
	var selected_no = -1; 
	this.display = $('#ideas-slider');
	this.slider = $('#slider');
	this.graph = $('#slider-graph');
	this.select = $('#activities-select')
	
	
	this.init = function(){
		if(!$('#activities-container')) return false;
		this.addListeners();
		this.initSlider();
		this.activateActivity(0);
		this.updateSlider(this.slider.slider('value'));
		this.mobileSetup();
	}
	
	this.mobileSetup = function(){
		if(this.select.css('display') == 'none') return;
		//#activities-select .custom-selectInner
		$('select', this.select).customSelect({customClass:'custom-select'});
		$('select', this.select).change(function(){
			that.mobileUpdate($(this).val());
		});
		this.updateSelectText();
	}
	
	this.updateSelectText = function(){
		var html = $('.custom-selectInner', this.select).text().replace('Red', '<span class="the-red">Red</span>');
		setTimeout(function(){
			$('.custom-selectInner', that.select).empty();
			$('.custom-selectInner', that.select).append(html);
		}, 20);
	}
	
	this.mobileUpdate = function(val){
		this.updateSelectText();
		this.activateActivity(val);
	}
	
	this.addListeners = function(){
		$('.activity', '#activities-container').each(function(i){
			$(this).css({
							'z-index': i+1,
							'display': 'none'
						});
			activities.push({
								'menu-list-item': '',
								'activity-item': $(this)
							});
			
			$('.level', $(this)).each(function(i){
				$(this).css({
								'z-index': i+1,
								'display': 'none'
							});
			});
		});
		$('li', '#activites-list').each(function(i){
			var no = i;
			$(this).click(function(){
				that.activateActivity(no);
			});
			activities[i]['menu-list-item'] = $(this);
		});
	}
	
	this.initSlider = function(){
		this.slider.slider({
			value:0,
			min: 0,
			max: 4,
			step: 1,
			slide: function( event, ui ) {
				that.updateSlider(ui.value);
			}
		});
	}
	
	this.activateActivity = function(val){
		if(val == selected_no) return;
		selected_no = val;
		for(var i=0, il=activities.length; i<il; i++){
			activities[i]['menu-list-item'].removeClass('selected');
			activities[i]['activity-item'].css('z-index', 99);
			if(i == selected_no){
				activities[i]['menu-list-item'].addClass('selected');
				activities[i]['activity-item'].css({
														'z-index': 100,
														'display': 'block',
														'opacity': 0
													}).animate({
																	'opacity': 1	
																}, 300);
				$('.level', activities[i]['activity-item']).each(function(j){
					$(this).css('display', 'none');
					if(j == 0) $(this).css('display', 'block');
				});
			}
		}
		this.slider.slider('value', 0);
		this.updateSlider(this.slider.slider('value'));
	}
	
	
	this.updateSlider = function(val){
		this.updateSliderGraph(val)
		this.updateLevels(val);
	}
	
	this.updateLevels = function(val){
		if (activities.length != 0){
			$('.level', activities[selected_no]['activity-item']).each(function(i){
				$(this).css('z-index', 99);
				if(i == val) $(this).css({
											'z-index': 100,
											'display': 'block',
											'opacity': 0
										}).animate({
														'opacity': 1	
													}, 300);
			});
		}
	}
	
	this.updateSliderGraph = function(val){
		$('li', this.graph).each(function(i){
			if(i <= val){
				$(this).addClass('active');
			}else{
				$(this).removeClass('active');
			}
		})
	}
	
	this.init();
}

function SignUpValidation(){
	var that = this;
	this.display = $('#adduser');
	
	this.init = function(){
        //$('#adduser .address1').slideUp('fast');

        $('.form-select21 select').change(function(){
            if(this.value=='Receive my fundraising pack in the post'){                
                $('#adduser .address1').slideDown('fast')
            }else{
                $('#adduser .address1').slideUp('fast');
            }
        });        
        /*
        jQuery.validator.addMethod("notUKPost", function(value, element, param) {
            if ($("#select21 option:selected").text() == "Receive my fundraising pack in the post") {
              if ($("#countrySelect10 option:selected").text() == "United Kingdom") return true;
              else return false;
            }
            else return true;
        }, "We cannot post fundraising packs outside the United Kingdom");
        */
        $('#adduser .form-input13').slideUp('fast');

        $('.form-checkbox11 input').change(function(){
            if(this.checked && (this.value=='School' ||  this.value=='University')  ){                
                $('.form-input13').slideDown('fast')
            }else{
                $('.form-input13').slideUp('fast');
            }
        });
       
		this.display.validate({
            errorClass: "invalid",
			rules: {
				'email': {
					required: true,
					email: true
				},
				'input19': {
					required: true,
					equalTo: '#email'
				},
				'last_name': {
					required: true,
					minlength: 2
				},
				'first_name': {
					required: true,
					minlength: 2
				},
				'select1': 'required',
				'Workplace11[]' : 'required',
				'pass1': {
					required: true,
					minlength: 5
				},
				'pass2': {
					required: true,
					minlength: 5,
					equalTo: '#pass1'
				},
				'agreeToTerms18': 'required',
                'input4': { 
                    required: function(element){
                        return $("#select21 option:selected").text() == "Receive my fundraising pack in the post";
                    }
                },
                'input7': { 
                    required: function(element){
                        return $("#select21 option:selected").text() == "Receive my fundraising pack in the post";
                    }
                },  
                'input8': { 
                    required: function(element){
                        return $("#select21 option:selected").text() == "Receive my fundraising pack in the post";
                    }
                }, 
                'input9': { 
					required: true,
					minlength: 5,
					maxlength: 9,                
                },  
                'input22': { 
					required: false,
					digits: true              
                },  
			},
			messages: {
				'email': {
					required: 'Please enter a valid email address'
				},
				'input19': {
					required: 'Please enter a email address',
					equalTo: 'Please enter the same email address as above'
				},
				'first_name': 'Please enter your first name',
				'last_name': 'Please enter your last name',				
				'pass1': {
					required: 'Please provide a password',
					minlength: 'Your password must be at least 5 characters long',
				},
				'pass2': {
					required: 'Please provide a password',
					equalTo: 'Please enter the same password as above'
				},
				'Workplace11[]': {
					required: 'Please select at least one'
				},
				'agreeToTerms18': {
					required: 'Please agree to our terms and conditions'
				},
                'input4' : { 
                    required: "Please provide your address"
                },
                'input7' : { 
                    required: "Please provide a Town/City"
                },
                'input8' : { 
                    required: "Please provide a County"
                },
                'input9' : { 
                    required: "Please provide a Postcode"
                },
			}
		});
	}
	
	this.init();
}

function InviteForm(){
	var that = this;
	this.display = $('#invite-form');

	this.init = function(){
		$('.editable-group', this.display).each(function(i){
			if($(this).hasClass('text')){
				new EditableTextGroup(this);
			}else if($(this).hasClass('date')){
				new EditableDateGroup(this);
			}
		});
	}
	
	function EditableTextGroup(trg){
		var that = this;
		var target = trg;
		var lastFieldValue;
		
		this.init = function(){
			this.addListeners();
		}
		
		this.addListeners = function(){
			$('.edit-icon', target).click(function(){
				that.showInput();
			});
			$('.edit-field', target).blur(function(){
				that.hideInput();
			})
		}
		
		this.showInput = function(){
			lastFieldValue = $('.editable', target).text();
			$('.editable', target).hide();
			$('.edit-icon', target).hide();
			$('.edit-field', target).css('display', 'inline-block');
			$('.edit-field', target).focus();
		}
        
		this.hideInput = function(){
			var newFieldValue = $('.edit-field', target).val();
			if(newFieldValue == '') newFieldValue = lastFieldValue;
			$('.editable', target).css('display', 'inline-block');
			$('.edit-icon', target).css('display', 'inline-block');
			$('.editable', target).text(newFieldValue);
			$('.edit-field', target).hide();
		}
		this.init();
	}
	
	function EditableDateGroup(trg){
		var that = this;
		var target = trg;
		var lastFieldValue;
		
		this.init = function(){
			$('.edit-field', target).datepicker({
				defaultDate: new Date(2014,01,07),
				setDate: new Date(2014,01,07),
				dateFormat: 'DD, d MM yy',				
				minDate: 0,
				onClose: function (dateText){
					that.updateDate(dateText); 
				},
				beforeShow: function (dateText){					
				}
			}).hide();
			this.addListeners();
			this.updateDate()
		}
		
		this.addListeners = function(){
			$('.edit-icon', target).click(function(){
				$('.edit-field', target).datepicker('show');
				$('.edit-field', target).show();
			});
		}
		
		this.updateDate = function(txt, inst){
			if(txt == '' || txt == null) return;
			$('.editable', target).text($.datepicker.formatDate( 'DD, d MM', $('.edit-field', target).datepicker('getDate')));            
            $('.edit-field', target).val(txt);
			$('.edit-field', target).hide();
		}
		
		this.init();
	}
	
	this.init();

}

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

function DonationGrid(){
	var that = this;
	this.display = $('.donation-grid');
	
	this.init = function(){
		this.addListeners();
		this.changed();
	}
	
	this.addListeners = function(){
		$('input[type=radio]', this.display).change(function(){
			that.changed();
		});
		$('input[type=text]', this.display).focus(function(){
			that.inputfocus(this);
		});
	}
	
	this.changed = function(){
		var trg;
		$('input[type=radio]', this.display).each(function(i){
			if($(this).prop('checked')) trg = this; 
		});
		$('.donate-label-wrapper' , this.display).removeClass('selected');
		if(trg != undefined){
            $(trg).parent().addClass('selected');
            $(trg).parent().find('#donate-amount').focus();
        }
	}
	
	this.inputfocus = function(trg){
		$('input[type=radio]', $(trg).parent().parent()).prop('checked', true);
		that.changed();
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
		var wine 	= 	+jQuery("#wine").val() * 6.00;
		var tea 	=	+jQuery("#tea").val() * 1.45;
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
		$(".wine.counter").text('wine' + ' ' + wine);

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
	  equalheight('.grid_copy, .intro_block, .select_challenge article, .challeneg_block');
	});
	$(window).resize(function(){
	  equalheight('.grid_copy, .intro_block, .select_challenge article, .challeneg_block');
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

