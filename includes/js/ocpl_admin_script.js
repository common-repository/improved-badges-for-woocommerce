//jquery tab
jQuery(document).ready(function() {
    //slider setting options by tabbing
    jQuery('ul.ocpl_tabs li').click(function() {
        var tab_id = jQuery(this).attr('data-tab');
        jQuery('ul.ocpl_tabs li').removeClass('current');
        jQuery('.tab-content').removeClass('current');
        jQuery(this).addClass('current');
        jQuery("#"+tab_id).addClass('current');
    })

    jQuery('#ibfw_select_product').select2({
  	    ajax: {
    			url: ajaxurl,
    			dataType: 'json',
    			allowClear: true,
    			data: function (params) {
    				return {
        				q: params.term,
        				action: 'ibfw_product_ajax'
      				};
      			},
    			processResults: function( data ) {
  					var options = [];
  					if ( data ) {
  	 					jQuery.each( data, function( index, text ) { 
  							options.push( { id: text[0], text: text[1], 'price': text[2]} );
  						});
  	 				}
  					return {
  						results: options
  					};
				},
				cache: true
		},
		minimumInputLength: 3
	});

    var pro_con = jQuery('.ocpl_pro_condition').find(":selected").val();
    if(pro_con == "") {
    	jQuery('.ocpl_price_div').hide();
    	jQuery('.ocpl_category_div').hide();
    	jQuery('.ocpl_tag_div').hide();
    	jQuery('.ocpl_onsale_div').hide();
    	jQuery('.ocpl_product_div').hide();
    }
    if(pro_con == "all_products") {
    	jQuery('.ocpl_price_div').hide();
    	jQuery('.ocpl_category_div').hide();
    	jQuery('.ocpl_tag_div').hide();
    	jQuery('.ocpl_onsale_div').hide();
    	jQuery('.ocpl_product_div').hide();
    }
    if(pro_con == "selected_products") {
    	jQuery('.ocpl_product_div').show();
    	jQuery('.ocpl_price_div').hide();
    	jQuery('.ocpl_category_div').hide();
    	jQuery('.ocpl_tag_div').hide();
    	jQuery('.ocpl_onsale_div').hide();
    }
    if(pro_con == "price") {
    	jQuery('.ocpl_price_div').show();
    	jQuery('.ocpl_category_div').hide();
    	jQuery('.ocpl_tag_div').hide();
    	jQuery('.ocpl_onsale_div').hide();
    	jQuery('.ocpl_product_div').hide();
    }
    if(pro_con == "category") {
    	jQuery('.ocpl_category_div').show();
    	jQuery('.ocpl_price_div').hide();
    	jQuery('.ocpl_tag_div').hide();
    	jQuery('.ocpl_onsale_div').hide();
    	jQuery('.ocpl_product_div').hide();
    }
    if(pro_con == "tag") {
    	jQuery('.ocpl_tag_div').show();
    	jQuery('.ocpl_category_div').hide();
    	jQuery('.ocpl_price_div').hide();
    	jQuery('.ocpl_onsale_div').hide();
    	jQuery('.ocpl_product_div').hide();
    }
    if(pro_con == "onsale") {
    	jQuery('.ocpl_onsale_div').show();
    	jQuery('.ocpl_tag_div').hide();
    	jQuery('.ocpl_category_div').hide();
    	jQuery('.ocpl_price_div').hide();
    	jQuery('.ocpl_product_div').hide();
    }


    var price_con = jQuery('.ocpl_price_condition').find(":selected").val();
    if(price_con == "between") {
    	jQuery('.ocpl_price_between_div').show();
    	jQuery('.ocpl_price_single_div').hide();
    }
    if(price_con == "lessthan") {
    	jQuery('.ocpl_price_single_div').show();
    	jQuery('.ocpl_price_between_div').hide();
    }
    if(price_con == "greaterthan") {
    	jQuery('.ocpl_price_single_div').show();
    	jQuery('.ocpl_price_between_div').hide();
    }

	jQuery('.ocpl_pro_condition').change(function() {
	    var option = jQuery(this).find('option:selected');
	    var val = option.val();

	   	if(val == "") {
	    	jQuery('.ocpl_price_div').hide();
	    	jQuery('.ocpl_category_div').hide();
	    	jQuery('.ocpl_tag_div').hide();
	    	jQuery('.ocpl_onsale_div').hide();
	    	jQuery('.ocpl_product_div').hide();
	    }
	    if(val == "all_products") {
	    	jQuery('.ocpl_price_div').hide();
	    	jQuery('.ocpl_category_div').hide();
	    	jQuery('.ocpl_tag_div').hide();
	    	jQuery('.ocpl_onsale_div').hide();
	    	jQuery('.ocpl_product_div').hide();
	    }
	    if(val == "selected_products") {
	    	jQuery('.ocpl_product_div').show();
	    	jQuery('.ocpl_price_div').hide();
	    	jQuery('.ocpl_category_div').hide();
	    	jQuery('.ocpl_tag_div').hide();
	    	jQuery('.ocpl_onsale_div').hide();
	    }
	    if(val == "price") {
	    	jQuery('.ocpl_price_div').show();
	    	jQuery('.ocpl_category_div').hide();
	    	jQuery('.ocpl_tag_div').hide();
	    	jQuery('.ocpl_onsale_div').hide();
	    	jQuery('.ocpl_product_div').hide();
	    }
	    if(val == "category") {
	    	jQuery('.ocpl_category_div').show();
	    	jQuery('.ocpl_price_div').hide();
	    	jQuery('.ocpl_tag_div').hide();
	    	jQuery('.ocpl_onsale_div').hide();
	    	jQuery('.ocpl_product_div').hide();
	    }
	    if(val == "tag") {
	    	jQuery('.ocpl_tag_div').show();
	    	jQuery('.ocpl_category_div').hide();
	    	jQuery('.ocpl_price_div').hide();
	    	jQuery('.ocpl_onsale_div').hide();
	    	jQuery('.ocpl_product_div').hide();
	    }
	    if(val == "onsale") {
	    	jQuery('.ocpl_onsale_div').show();
	    	jQuery('.ocpl_tag_div').hide();
	    	jQuery('.ocpl_category_div').hide();
	    	jQuery('.ocpl_price_div').hide();
	    	jQuery('.ocpl_product_div').hide();
	    }
	    
	});



	jQuery('.ocpl_price_condition').change(function() {
	    var option = jQuery(this).find('option:selected');
	    var val = option.val();

	    if(val == "between") {
	    	jQuery('.ocpl_price_between_div').show();
	    	jQuery('.ocpl_price_single_div').hide();
	    }
	    if(val == "lessthan") {
	    	jQuery('.ocpl_price_single_div').show();
	    	jQuery('.ocpl_price_between_div').hide();
	    }	    
	    if(val == "greaterthan") {
	    	jQuery('.ocpl_price_single_div').show();
	    	jQuery('.ocpl_price_between_div').hide();
	    }
	});

        if(ibfwDATA.badge_define == "or_text_badge" || ibfwDATA.badge_define == ""){
               jQuery("#tab-image").hide(); 
       			jQuery("#tab-text").show(); 
        }else{
                jQuery("#tab-image").show();
         		jQuery("#tab-text").hide();
        }
        if(ibfwDATA.ibfw_background == "or_badge_image" || ibfwDATA.ibfw_background == ""){
               	jQuery(".ibfw_back_badge").show();
         		jQuery(".ocpsw_back_img_class").hide();
        }else{
                jQuery(".ibfw_back_badge").hide(); 
       			jQuery(".ocpsw_back_img_class").show(); 
        }

	jQuery('.radioBtnClass_badge').click(function(){

		var radioValue = jQuery("input[name='ibfw_background']:checked").val();

        	if(radioValue == "or_badge_image"){
         		jQuery(".ibfw_back_badge").show();
         		jQuery(".ocpsw_back_img_class").hide();
       		}else{
       			jQuery(".ibfw_back_badge").hide(); 
       			jQuery(".ocpsw_back_img_class").show(); 
       		}

	});
	jQuery('.badge_define').click(function(){
		var radioValue = jQuery("input[name='badge_define']:checked").val();
        	if(radioValue == "or_text_badge"){
        		jQuery("#tab-image").hide(); 
       			jQuery("#tab-text").show(); 
       		}else{
       			jQuery("#tab-image").show();
         		jQuery("#tab-text").hide();
       		}
	});

	if(ibfwDATA.ocpl_image_position == "custom_position"){
		jQuery(".custom_position").show(); 	
	}
	jQuery('.ocpl_image_position').on('change', function() {
	  	if(this.value == "custom_position"){
	  		jQuery(".custom_position").show(); 
	  	}else{
	  		jQuery(".custom_position").hide();
	  	}
	});
})

