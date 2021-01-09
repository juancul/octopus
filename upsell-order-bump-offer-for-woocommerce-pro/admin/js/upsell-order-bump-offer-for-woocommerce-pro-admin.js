jQuery(document).ready(function($){

	// License.
	jQuery( '#mwb_bump_offer_license_key' ).on( 'click',function(e){
		jQuery( '#mwb_upsell_bump_offer_license_activation_status' ).html('');
	});

	jQuery( 'form#mwb_upsell_bump_license_form' ).on( 'submit',function(e) {

		e.preventDefault();	

	    $('#mwb_upsell_bump_license_ajax_loader').css("display", "flex");

		var license_key =  $('#mwb_bump_offer_license_key').val();

		mwb_upsell_bump_send_license_request(license_key);
	});

	function mwb_upsell_bump_send_license_request( license_key ) {

		$.ajax({
	        type:'POST',
	        dataType:'JSON',
	        url :mwb_upsell_bump_ajaxurl.ajaxurl,
	        data:{nonce :mwb_upsell_bump_ajaxurl.auth_nonce,action:'mwb_upsell_bump_validate_license_key',purchase_code:license_key},

	        success:function(data) {

	        	$('#mwb_upsell_bump_license_ajax_loader').hide();

	        	if( data.status == true ) {

	        		$("#mwb_upsell_bump_offer_license_activation_status").css("color", "#42b72a");

	        		jQuery('#mwb_upsell_bump_offer_license_activation_status').html(data.msg);

					location = mwb_upsell_bump_ajaxurl.mwb_upsell_bump_location;
	        	}

	        	else {

	        		$("#mwb_upsell_bump_offer_license_activation_status").css("color", "#ff3333");

	        		jQuery('#mwb_upsell_bump_offer_license_activation_status').html(data.msg);

	        		jQuery('#mwb_bump_offer_license_key').val("");
	        	}
	        }
		});
	}

	// After v1.2.0
	jQuery( '#mwb_ubo_offer_replace_target' ).on( 'click',function(e){

		var is_update_needed = jQuery( '#is_update_needed' ).val();

		if( 'true' == is_update_needed ) {

			jQuery(this).prop( 'checked', false );
			jQuery('.mwb_ubo_update_popup_wrapper').addClass( 'mwb_ubo_lite_update_popup_show' );
			jQuery('body').addClass( 'mwb_ubo_lite_go_pro_popup_body' );
		}
	});

	// Onclick outside the div close for Update popup.
	jQuery('body').click( function(e) {

		if( e.target.className == 'mwb_ubo_update_popup_wrapper mwb_ubo_lite_update_popup_show' ) {

			jQuery( '.mwb_ubo_update_popup_wrapper' ).removeClass( 'mwb_ubo_lite_update_popup_show' );
			jQuery( 'body' ).removeClass( 'mwb_ubo_lite_go_pro_popup_body' );
		}
	});

	// Close popup on clicking buttons.
	jQuery('.mwb_ubo_update_yes, .mwb_ubo_update_no').click( function(e) {

		jQuery( '.mwb_ubo_update_popup_wrapper' ).removeClass( 'mwb_ubo_lite_update_popup_show' );
		jQuery( 'body' ).removeClass( 'mwb_ubo_lite_go_pro_popup_body' );

	});

	// If org is not updated then you might not use multischedule.
	if( 'true' == mwb_upsell_bump_ajaxurl.is_org_needs_update ) {

		jQuery('.wc-bump-schedule-search').hide();
		jQuery('.wc-bump-schedule-search').closest( 'td' ).html( '<i>Please update the plugin to use our new features.</i>' );
	
		// Show a notice to update org plugin.
		jQuery('.mwb_ubo_update_popup_wrapper').addClass( 'mwb_ubo_lite_update_popup_show' );
		jQuery('body').addClass( 'mwb_ubo_lite_go_pro_popup_body' );
	}

// End of function for validations.
});