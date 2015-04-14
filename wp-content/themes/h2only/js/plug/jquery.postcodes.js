

(function($) {
  "use strict";

  var defaults = {

    // Required Fields to Populate your Form
    // Please enter an appropriate CSS selector that
    // uniquely identifies the input field you wish
    // the result to be piped in
    output_fields: {
      line1: "#line_1",
      line2: "#line_2",
      line3: "#line_3",
      post_town: "#post_town",
      postcode: "#postcode",
      county: "#county",
      mailsort: undefined,
      barcode: undefined,
      is_residential: undefined,
      is_small_organisation: undefined,
      is_large_organisation: undefined,
      line4: undefined,
      line5: undefined,
    },
    
    // Below is not required
    api_endpoint: "./wp-content/themes/rampupthered/address_finder.php",

    // Input Field Configuration
    $input: "",
    input_label: "Please enter your postcode",
    input_muted_style: "color:#CBCBCB;",
    input_class: "",
    input_id: "idpc_input",

    // Button configuration
    $button: "",
    button_id: "idpc_button",
    button_label: "Find my Address",
    button_class: "",

    // Dropdown configuration
    dropdown_id: "idpc_dropdown",
    dropdown_select_message: "Please select your address",
    dropdown_noselect_message: "Add your address manually",
    dropdown_class: "",

    // Error Message Configuration
    $error_message: "",
    error_message_id: "idpc_error_message",
    error_message_invalid_postcode: "Please check your postcode, it seems to be incorrect. Please re-enter or manually input below",
    error_message_not_found: "Your postcode could not be found. Please type in your address",
    error_message_default: "Sorry, we weren't able to get the address you were looking for. Please type your address manually",
    error_message_class: "",

    // Configuration to prevent wasting lookups
    last_lookup: "", // Tracks previous lookup, prevents consecutive lookup of same postcode
    disable_interval: 1000, // Disables lookup button in (ms) after lookup

    // Debug - Set to true to pipe API error messages to client
    debug_mode: false
  };

  var Idpc = {

    // Update defaults and call setup() to begin loading form elements
    init: function (options) {
      $.extend(Idpc, defaults);
      if (options) {
        $.extend(Idpc, options);
      }
      Idpc.rig_output_fields();
    },

    rig_output_fields: function () {
      var $output_fields = {};
      for (var key in Idpc.output_fields) {
        if (Idpc.output_fields[key] !== undefined) {
          $output_fields[key] = $(Idpc.output_fields[key]);
        }
      }
      Idpc.output_fields = $output_fields;
    },
    
    // Create and append postcode input and submit button to specified div context
    setup_dropdown: function (context, options) {
      Idpc.$context = context;

      if (options) {
        $.extend(Idpc, options);
      }

      Idpc.$label = $('<label />', {        
        html: Idpc.input_label+':<span style="color:red" title="This field is marked as required by the administrator.">*</span></label>'
      })
      .attr("for", Idpc.input_id)
      .appendTo(Idpc.$context);
      
      // Introduce user defined input
      Idpc.$input = $('<input />', {
        type: "text",
        id: Idpc.input_id,
        /*value: Idpc.input_label,*/
        
      })
      /*.val(Idpc.input_label)*/
      .attr("class", Idpc.input_class)
      .attr("style", Idpc.input_muted_style)
      .focus(function () {
        Idpc.$input.removeAttr('style').val("");
      })
      /*.blur(function () {
      
        if (!Idpc.$input.val()) {
          Idpc.$input.val(Idpc.input_label);
          Idpc.$input.attr('style', Idpc.input_muted_style);
        }
      })*/
      .submit(function () {
        return false;
      })
      .appendTo(Idpc.$context);

      //Introduce user defined submission
      Idpc.$button = $('<button />', {
        html: Idpc.button_label,
        id: Idpc.button_id,
      })
      .attr("class", Idpc.button_class)
      .attr("type", "button")
      .attr("onclick", "return false;")
      .submit(function () {
        return false;
      })
      .click(function () {        
        var postcode = Idpc.$input.val();        
        $('#input9').val(postcode);
        if (Idpc.last_lookup !== postcode) {
          Idpc.disable_lookup_button();
          Idpc.clear_existing_fields();
          Idpc.lookupPostcode(postcode);
        }
        return false;
      })
      .appendTo(Idpc.$context);
    },

    // Perform AJAX (JSONP) request
    lookupPostcode: function (postcode) {
      if (Idpc.valid_postcode(postcode)) {
        var success = function (data) {
          Idpc.handle_api_success(data);
          $.event.trigger("completedJsonp"); // added for API testing, better solution needed
          // To introduce callback
        };
        var error = function () {
          Idpc.show_error("Unable to connect to server");
          $.event.trigger("completedJsonp");
          // To introduce callback
        };
        $.idealPostcodes.lookupPostcode(postcode, success, error);
      } else {        
        Idpc.show_error(Idpc.error_message_invalid_postcode);
        
        $('.form-input9 input').val($('#idpc_input').val());
        $('#adduser').find('.form-input9 label, .form-input9 input').show();
        /*
        setTimeout(function() {
          $('#postcode_lookup_field').hide("slow", function(){
            
          });
        }, 2000);
        */
      }
    },

    // Disable lookup button to prevent further AJAX requests
    disable_lookup_button: function (message) {
      Idpc.$button.prop('disabled', true).html(message || "Looking up postcode...");
    },

    // Enables lookup button and return it to a normal state after a short interval (see defaults)
    enable_lookup_button: function () {
      setTimeout(function (){
        Idpc.$button.prop('disabled', false).html(Idpc.button_label);
      }, Idpc.disable_interval);
    },

    // Test for valid postcode format
    valid_postcode: function (postcode) {
      var regex = /^[a-zA-Z0-9]{1,4}\s?\d[a-zA-Z]{2}$/;
      return !!postcode.match(regex);
    },

    // Callback if JSONP request returns with code 2000
    handle_api_success: function (data) {
      Idpc.result = data.data;
      Idpc.last_lookup = Idpc.$input.val();
      //Idpc.show_dropdown(Idpc.result, data.length).appendTo(Idpc.$context);
      $("#idpc_input").after(Idpc.show_dropdown(Idpc.result, data.length));
      Idpc.enable_lookup_button();
    },

    // Callback if JSONP request does not return with code 2000
    handle_api_error: function (data) {
      Idpc.show_error(data.message); 
      Idpc.enable_lookup_button();
    },

    // Empties fields including user specified address fields and returns them to normal state
    clear_existing_fields: function () {
      Idpc.clear_dropdown_menu();
      Idpc.clear_error_messages();
      Idpc.clear_input_fields();
    },

    clear_dropdown_menu: function () {
      if (Idpc.$dropdown && Idpc.$dropdown.length) {
        Idpc.$dropdown.remove();
      }
    },

    clear_error_messages: function () {
      if (Idpc.$error_message && Idpc.$error_message.length) {
        Idpc.$error_message.remove();
      }
    },

    clear_input_fields: function () {
      for (var key in Idpc.output_fields) {
        Idpc.output_fields[key].val("");
      }
    },

    // Creates a dropdown menu with address data - selection is forwarded to user form
    show_dropdown: function (data, length) {
      var length = length;
      var dropDown = $('<select />', {
        id: Idpc.dropdown_id,
      })
      .attr("class", Idpc.dropdown_class);

      $('<option />', {
        value: "",
        text: Idpc.dropdown_select_message
      }).appendTo(dropDown);
      for(var i in data)
        $('<option />', {
          value: i,
          text: data[i]
        }).appendTo(dropDown);
      var lnt = parseInt(length) + 2;
      $('<option />', {
        value: lnt,
        text: Idpc.dropdown_noselect_message
      }).appendTo(dropDown);        
      Idpc.link_to_fields(dropDown);
      Idpc.$dropdown = dropDown;
      return dropDown;
    },

    // Creates event handler that pipes selected address to user form
    link_to_fields: function ($address_dropdown) {
      var data = Idpc.result;
      return $address_dropdown.change(function () {
        var index = $(this).val();
        if (index >= 0 || isNaN(index)) {
          if (index == $(this).children('option').length || isNaN(index) ) {
            if (jQuery("#ajaxbhfpayin").length > 0){
             $('.payingin #input9').show();
             $('.payingin #input9').val(Idpc.$input.val());
             $('.payingin .postcode > label').show();
             $('#postcode_lookup_field2').hide();
            }
            if (jQuery("#adduser").length > 0){
             $('#adduser #input9').show();
             $('#adduser #input9').val(Idpc.$input.val());
             $('#adduser .form-input9 > label').show();
             $('#postcode_lookup_field').hide();
            }
            $(this).parents('form').find('.address1').show(); 
          }
          else Idpc.populate_output_fields(index);
        }
      });
    },

    populate_output_fields: function (result_object) {
      var success = function (data) {
        var result = data.data[0];
        for (var key in Idpc.output_fields) {  
            //alert(key +':'+ result[key] );
            Idpc.output_fields[key].val(result[key]);
        }
        $.event.trigger("completedJsonp"); // added for API testing, better solution needed
        // To introduce callback
      };
      var error = function () {
        Idpc.show_error("Unable to connect to server");
        $.event.trigger("completedJsonp");
        // To introduce callback
      };      
      $.idealPostcodes.lookupAddress(result_object, success, error);

    },

    // Puts up an error message if called
    show_error: function (message) {
      Idpc.enable_lookup_button();
      Idpc.$error_message = $('<p />', {
        html: message,
        id: Idpc.error_message_id,
      }).attr("class", Idpc.error_message_class).appendTo(Idpc.$context);
    }

  };

  $.idealPostcodes = {
    // Expost defaults for testing
    defaults: function () {
      return defaults;
    },

    // Call to register key, configure misc options
    setup: function (options) {
      Idpc.init(options);
    },

    // Lookup postcode on API
    lookupPostcode: function (postcode, success, error) {
      var endpoint = Idpc.api_endpoint || defaults.api_endpoint,
          resource = "postcode",
          url = endpoint+'?'+resource+'='+postcode,
          options = {
            url: url,
            dataType: 'json',
            timeout: 5000,
            success: success
          };

      if (error) {
        options.error = error;
      }

      $.ajax(options);
    },
    
    lookupAddress: function (address, success, error) {
      var endpoint = Idpc.api_endpoint || defaults.api_endpoint,
          resource = "address",
          url = endpoint+'?'+resource+'='+address,
          options = {
            url: url,
            dataType: 'json',
            timeout: 5000,
            success: success
          };
      if (error) {
        options.error = error;
      }

      $.ajax(options);
    },
  };

  // Creates Postcode lookup field and button when called on <div>
  $.fn.setupPostcodeLookup = function (options) {
    Idpc.setup_dropdown($(this), options);
    return this;
  };

}(jQuery));
