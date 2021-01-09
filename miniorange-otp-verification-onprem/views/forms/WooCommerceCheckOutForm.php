<?php

use OTP\Helper\MoMessages;

echo' 	<div class="mo_otp_form" id="'.get_mo_class($handler).'">
 	        <input  type="checkbox" '.$i4.' 
 	                id="wc_checkout" 
 	                data-toggle="wc_checkout_options" 
 	                class="app_enable" 
 	                name="mo_customer_validation_wc_checkout_enable" 
 	                value="1" 
 	                '.$wc_checkout.' />
            <strong>'.$form_name. '</strong>';

echo'		<div class="mo_registration_help_desc" '.$wc_checkout_hidden.' id="wc_checkout_options">
				<b>'. mo_( "Choose between Phone or Email Verification" ).'</b>
				<p>
				    <input  type="radio" '.$i4.' 
				            id="wc_checkout_phone" 
				            class="app_enable" 
				            data-toggle="wc_checkout_phone_options"
				            name="mo_customer_validation_wc_checkout_type" 
				            value="'.$wc_type_phone.'"
						    '.($wc_checkout_enable_type == $wc_type_phone ? "checked" : "" ).' />
                    <strong>'. mo_( "Enable Phone Verification" ).'</strong>
				</p>
				<div    '.($wc_checkout_enable_type != $wc_type_phone  ? "hidden" :"").' 
                        class="mo_registration_help_desc" 
						id="wc_checkout_phone_options" >
                    <input  type="checkbox" '.$i4.' 
                            name="mo_customer_validation_wc_checkout_restrict_duplicates" 
                            value="1"
                            '.$restrict_duplicates.' />
                    <strong>'. mo_( "Do not allow users to use the same phone number for multiple accounts." ).'</strong>
				</div>
				<p>
				    <input  type="radio" '.$i4.' 
				            id="wc_checkout_email" 
				            class="app_enable" 
				            name="mo_customer_validation_wc_checkout_type" 
				            value="'.$wc_type_email.'"
						    '.($wc_checkout_enable_type == $wc_type_email ? "checked" : "" ).' />
                    <strong>'. mo_( "Enable Email Verification" ).'</strong>
				</p>
				<p style="margin-top:3%;">
					<input  type="checkbox" 
					        '.$i4.' 
					        '.$guest_checkout.' 
					        class="app_enable" 
					        name="mo_customer_validation_wc_checkout_guest" 
					        value="1" >
                    <b>'. mo_( "Enable Verification only for Guest Users." ).'</b>';

                mo_draw_tooltip(
                    MoMessages::showMessage(MoMessages::WC_GUEST_CHECKOUT_HEAD),
                    MoMessages::showMessage(MoMessages::WC_GUEST_CHECKOUT_BODY)
                );

echo'
				</p>
				<p>
					<input  type="checkbox" 
					        '.$i4.' 
					        '.$disable_autologin .' 
					        class="app_enable" 
					        name="mo_customer_validation_wc_checkout_disable_auto_login" 
					        value="1" 
					        type="checkbox">
                    <b>'. mo_( "Disable Auto Login after checkout." ).'</b>
                    <br/>
				</p>
				<p>
					<input  type="checkbox" 
					        '.$i4.' 
					        '.$checkout_button .' 
					        class="app_enable" 
					        name="mo_customer_validation_wc_checkout_button" 
					        value="1" 
					        type="checkbox">
                    <b>'. mo_( "Show a verification button instead of a link on the WooCommerce Checkout Page." ).'</b>
                    <br/>
				</p>
				<p>
					<input  type="checkbox" 
					        '.$i4.' 
					        '.$checkout_popup.' 
					        class="app_enable" 
					        name="mo_customer_validation_wc_checkout_popup" 
					        value="1" 
					        type="checkbox">
                    <b>'. mo_( "Show a popup for validating OTP." ).'</b>
                    <br/>
				</p>
				<p>
					<input  type="checkbox" 
					        '.$i4.'
					        '.$checkout_selection.' 
					        class="app_enable" 
					        data-toggle="selective_payment" 
					        name="mo_customer_validation_wc_checkout_selective_payment" 
					        value="1" 
					        type="checkbox">
                    <b>'. mo_( "Validate OTP for selective Payment Methods." ).'</b>
                    <br/>
				</p>
				<div id="selective_payment" class="mo_registration_help_desc" 
				     '.$checkout_selection_hidden.' style="padding-left:3%;">
					<b>
					    <label for="wc_payment" style="vertical-align:top;">'.
                            mo_("Select Payment Methods (Hold Ctrl Key to Select multiple):").
                        '</label> 
                    </b>
                    

				';

                get_wc_payment_dropdown($i4,$checkout_payment_plans);

echo			'
				</div>
				<b>
                    Enter the following code on the page to enable users to send messages:
                    </b>
                    <b>
	                   <pre>&lt;div id="custom_sms_box"&gt;
&lt;table style="width:100%"&gt;
	&lt;tr&gt;
	    &lt;td"&gt;
	         &lt;b&gt;Phone Number:&lt;/b&gt;&lt;input class="mo_registration_table_textbox" style="border:1px solid #ddd;width:100%;height:37px;"name="mo_phone_numbers"placeholder="Enter semicolon(;) separated Phone Numbers"value="" required=""&gt;&lt;br/&gt;&lt;br/&gt;		
	  &lt;/td&gt;
	&lt;/tr&gt;
	&lt;tr&gt;
	  &lt;td&gt;
		  &lt;b&gt;Message&lt;/b&gt;
		  &lt;span id="characters"&gt;Remaining Characters : &lt;span id="remaining"&gt;&lt;/span&gt; &lt;/span&gt;
		  &lt;textarea  id="custom_sms_msg" class="mo_registration_table_textbox" name="mo_customer_validation_custom_sms_msg" placeholder="Enter OTP SMS Message" required/&gt;
		  &lt;/textarea&gt;
		  &lt;div class="mo_otp_note"&gt;
			 You can have new line characters in your sms text body.To enter a new line character use the &lt;b&gt;&lt;i&gt;%0a&lt;/i&gt;&lt;/b&gt; symbol.To enter a "#" character you can use the &lt;b&gt;&lt;i&gt;%23&lt;/i&gt;&lt;/b&gt; symbol.
		  &lt;/div&gt;
		 &lt;/td&gt;
		&lt;/tr&gt;
&lt;/table&gt;
&lt;/div&gt;
					</pre>
                    </b>
                    <b>Add the shortcode: [mo_custom_sms]</b>

                <p>
					<i><b>'.mo_("Enter redirect URL for the guest user:").':</b></i>
					<input  class="mo_registration_table_textbox" 
					        name="mo_customer_validation_custom_messages_redirect_url" 
					        type="text" 
					        value="'.$redirect_url.'">					
				</p>
				<p>
					<i><b>'.mo_("Verification Button text").':</b></i>
					<input  class="mo_registration_table_textbox" 
					        name="mo_customer_validation_wc_checkout_button_link_text" 
					        type="text" 
					        value="'.$button_text.'">					
				</p>
			</div>
		</div>';