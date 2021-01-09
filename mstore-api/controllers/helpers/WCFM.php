<?php

class FlutterWCFMHelper {
    public function flutter_get_wcfm_stores($request) {
		//print_r('testing');
		global $WCFM;
		$_POST["controller"] = 'wcfm-vendors';
		$_POST['length'] = !empty($request['per_page']) ? intval($request['per_page']) : 10;
		$_POST['start'] = !empty($request['page']) ? ( intval($request['page']) - 1 ) * $_POST['length'] : 0;
		$_POST['filter_date_form'] = !empty($request['after']) ? $request['after'] : '';
		$_POST['filter_date_to'] = !empty($request['before']) ? $request['before'] : '';
		define('WCFM_REST_API_CALL', TRUE);
		$WCFM->init();
		$wcfm_vendors_array = array();
		$wcfm_vendors_json_arr = array();
		$response = array();
		$wcfm_vendors_array = $WCFM->ajax->wcfm_ajax_controller();
		
		if( !empty($wcfm_vendors_array) ) {
		  $index = 0;
		  foreach($wcfm_vendors_array as $wcfm_vendors_id => $wcfm_vendors_name ) {
			if(!isset($request['search']) || empty($request['search']) || strpos(strtolower($wcfm_vendors_name), strtolower($request['search'])) > -1){
				$response[$index] = $this->get_formatted_item_data( $wcfm_vendors_id, $wcfm_vendors_json_arr , $wcfm_vendors_name, $_POST['filter_date_form'], $_POST['filter_date_to']  );
				$index++;
			}
		  }
		  //print_r($response);
		  return apply_filters( "wcfmapi_rest_prepare_store_vendors_objects", $response, $request );
		} else {
		  return rest_ensure_response( $response );
		}
	  }
    
      public function flutter_get_wcfm_stores_by_id($wcfm_vendors_id)
      {
		$wcfm_vendors_json_arr = array();
        $response = $this->get_formatted_item_data( $wcfm_vendors_id, $wcfm_vendors_json_arr ,null, null, null );
        return rest_ensure_response( $response );
      }

	  public function get_formatted_item_data( $wcfm_vendors_id, $wcfm_vendors_json_arr , $wcfm_vendors_name, $filter_date_form, $filter_date_to ) {
		global $WCFM;
		$admin_fee_mode = apply_filters( 'wcfm_is_admin_fee_mode', false );
		$price_decimal = get_option('woocommerce_price_num_decimals', 2);
		$report_for = 'month';
	
		$wcfm_vendors_json_arr['vendor_id'] = $wcfm_vendors_id;
		$wcfm_vendors_json_arr['vendor_display_name'] =  $wcfm_vendors_name;
		$wcfm_vendors_json_arr['vendor_shop_name'] = $WCFM->wcfm_vendor_support->wcfm_get_vendor_store_name_by_vendor( $wcfm_vendors_id );
	
		$store_user  = wcfmmp_get_store( absint( $wcfm_vendors_id ) );
		$email       = $store_user->get_email();
		$phone       = $store_user->get_phone(); 
		$address     = $store_user->get_address_string();
	
		if($email) {
		  $wcfm_vendors_json_arr['vendor_email'] =  $email;
		}
	
		if($address) {
		  $wcfm_vendors_json_arr['vendor_address'] =  $address;
		}
	
		if($phone) {
		  $wcfm_vendors_json_arr['vendor_phone'] =  $phone;
		}
		
		$wcfm_vendors_json_arr['vendor_shop_name'] = $WCFM->wcfm_vendor_support->wcfm_get_vendor_store_name_by_vendor( $wcfm_vendors_id );
		$disable_vendor = get_user_meta( $wcfm_vendors_id, '_disable_vendor', true );
		$is_store_offline = get_user_meta( $wcfm_vendors_id, '_wcfm_store_offline', true );
		$wcfm_vendors_json_arr['disable_vendor'] = $disable_vendor == "1";
		$wcfm_vendors_json_arr['is_store_offline'] = $is_store_offline;
		if( apply_filters( 'wcfm_is_allow_email_verification', true ) ) {
		  $email_verified = false;
		  $vendor_user = get_userdata( $wcfm_vendors_id );
		  $user_email = $vendor_user->user_email;
		  $email_verified = get_user_meta( $wcfm_vendors_id, '_wcfm_email_verified', true );
		  $wcfm_email_verified_for = get_user_meta( $wcfm_vendors_id, '_wcfm_email_verified_for', true );
		  if( $email_verified && ( $user_email != $wcfm_email_verified_for ) ) $email_verified = false;
		  $wcfm_vendors_json_arr['email_verified'] = $email_verified;
		}
	
		// $wcfm_vendors_json_arr['additional_data'] = apply_filters( 'wcfm_vendors_additonal_data', '&ndash;', $wcfm_vendors_id );
        $vendor_id = $wcfm_vendors_id;
        $vendor_settings = $this->get_vendor_settings_by_id($vendor_id);
        $wcfm_vendors_json_arr["settings"] = $vendor_settings;

		$wcfmvm_registration_custom_fields = get_option( 'wcfmvm_registration_custom_fields', array() );
			$wcfmvm_custom_infos = get_user_meta( $vendor_id, 'wcfmvm_custom_infos', true );
	
			$wcfm_vendors_json_arr['vendor_additional_info'] = array();
	
		if(!empty($wcfmvm_registration_custom_fields)) {
		  foreach( $wcfmvm_registration_custom_fields as $key => $wcfmvm_registration_custom_field ) {
			$wcfmvm_registration_custom_field['name'] = sanitize_title( $wcfmvm_registration_custom_field['label'] );
			if( !empty( $wcfmvm_custom_infos ) ) {
			  if( $wcfmvm_registration_custom_field['type'] == 'checkbox' ) {
				$field_value = isset( $wcfmvm_custom_infos[$wcfmvm_registration_custom_field['name']] ) ? $wcfmvm_custom_infos[$wcfmvm_registration_custom_field['name']] : 'no';
			  } elseif( $wcfmvm_registration_custom_field['type'] == 'upload' ) {
				$field_name  = 'wcfmvm_custom_infos[' . $wcfmvm_registration_custom_field['name'] . ']';
				$field_id    = md5( $field_name );
				$field_value = isset( $wcfmvm_custom_infos[$field_id] ) ? $wcfmvm_custom_infos[$field_id] : '';
			  } else {
				$field_value = isset( $wcfmvm_custom_infos[$wcfmvm_registration_custom_field['name']] ) ? $wcfmvm_custom_infos[$wcfmvm_registration_custom_field['name']] : '';
			  }
			}
			if(isset($field_value)){
				$wcfm_vendors_json_arr['vendor_additional_info'][$key] = $wcfmvm_registration_custom_field;
				$wcfm_vendors_json_arr['vendor_additional_info'][$key]['value'] = $field_value;
			}
		  }
	
		} else {
		  $wcfm_vendors_json_arr['vendor_additional_info'] = array();
		}
	
		$wcfm_membership = get_user_meta( $wcfm_vendors_id, 'wcfm_membership', true );
		  //print_r($wcfm_membership);
		if( $wcfm_membership && function_exists( 'wcfm_is_valid_membership' ) && wcfm_is_valid_membership( $wcfm_membership ) ) {
			$wcfm_vendors_json_arr['membership_details']['membership_title'] = get_the_title( $wcfm_membership );
			$wcfm_vendors_json_arr['membership_details']['membership_id'] = $wcfm_membership;
			
			$next_schedule = get_user_meta( $wcfm_vendors_id, 'wcfm_membership_next_schedule', true );
			if( $next_schedule ) {
			  $subscription = (array) get_post_meta( $wcfm_membership, 'subscription', true );
			  $is_free = isset( $subscription['is_free'] ) ? 'yes' : 'no';
			  $subscription_type = isset( $subscription['subscription_type'] ) ? $subscription['subscription_type'] : 'one_time';
				  
			  if( ( $is_free == 'no' ) && ( $subscription_type != 'one_time' ) ) {
				  $wcfm_vendors_json_arr['membership_details']['membership_next_payment'] = date_i18n( wc_date_format(), $next_schedule );
			  }
			  
			  $member_billing_period = get_user_meta( $wcfm_vendors_id, 'wcfm_membership_billing_period', true );
			  $member_billing_cycle = get_user_meta( $wcfm_vendors_id, 'wcfm_membership_billing_cycle', true );
			  if( $member_billing_period && $member_billing_cycle ) {
				  $billing_period = isset( $subscription['billing_period'] ) ? $subscription['billing_period'] : '1';
				  $billing_period_count = isset( $subscription['billing_period_count'] ) ? $subscription['billing_period_count'] : '';
				  $billing_period_type = isset( $subscription['billing_period_type'] ) ? $subscription['billing_period_type'] : 'M';
				  $period_options = array( 'D' => 'days', 'M' => 'months', 'Y' => 'years' );
				  
				  if( $billing_period_count ) {
					  if( $member_billing_period ) $member_billing_period = absint( $member_billing_period );
					  else $member_billing_period = absint( $billing_period_count );
					  if( !$member_billing_cycle ) $member_billing_cycle = 1;
					  $remaining_cycle = ( $member_billing_period - $member_billing_cycle );
					  if( $remaining_cycle == 0 ) {
						  $wcfm_vendors_json_arr['membership_details']['membership_expiry_on'] = date_i18n( wc_date_format(), $next_schedule );
					  } else {
						  $expiry_time = strtotime( '+' . $remaining_cycle . ' ' . $period_options[$billing_period_type], $next_schedule );
						  $wcfm_vendors_json_arr['membership_details']['membership_expiry_on'] = date_i18n( wc_date_format(), $expiry_time );
					  }
				  } else { 
					  
					  if( $is_free == 'yes' ) {
						  $wcfm_vendors_json_arr['membership_details']['membership_expiry_on'] = date_i18n( wc_date_format(), $next_schedule );
					  } else {
						  $wcfm_vendors_json_arr['membership_details']['membership_expiry_on'] = __( 'Never Expire', 'wc-frontend-manager' );
					  }
				  }
				  
			  } else {
				  $wcfm_vendors_json_arr['membership_details']['membership_expiry_on'] = __( 'Never Expire', 'wc-frontend-manager' );
			  }
				
			}
		}
	
		return $wcfm_vendors_json_arr;
	  }

	  protected function get_vendor_settings_by_id( $vendor_id ) {
        $vendor_settings_data = get_user_meta( $vendor_id, 'wcfmmp_profile_settings', true );
        if ($vendor_settings_data != "" && isset($vendor_settings_data)) {
			if(isset($vendor_settings_data["gravatar"])){
				$gravatar_image_url = wp_get_attachment_image_src( $vendor_settings_data["gravatar"], 'full' );
				if ( !empty( $gravatar_image_url ) ) {
					$vendor_settings_data["gravatar"] = $gravatar_image_url[0];
				}
			}
			
			if(isset($vendor_settings_data["banner"])){
				$banner_image_url = wp_get_attachment_image_src( $vendor_settings_data["banner"], 'full' );
				if ( !empty( $banner_image_url ) ) {
					$vendor_settings_data["banner"] = $banner_image_url[0];
				}
			}
            
			if(isset($vendor_settings_data["mobile_banner"])){
				$mobile_banner_image_url = wp_get_attachment_image_src( $vendor_settings_data["mobile_banner"], 'full' );
				if ( !empty( $mobile_banner_image_url ) ) {
					$vendor_settings_data["mobile_banner"] = $mobile_banner_image_url[0];
				}
			}
        }else{
            $vendor_settings_data = null;
        }
        
		return $vendor_settings_data;
	  }
}