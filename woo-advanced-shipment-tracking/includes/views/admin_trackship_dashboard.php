<section id="content_trackship_dashboard" class="inner_tab_section">
	<div class="tab_inner_container">	
		<table class="form-table heading-table">
			<tbody>				
				<tr valign="top">
					<td><h3 style=""><?php _e( 'Connection status', 'woo-advanced-shipment-tracking' ); ?></h3></td>					
				</tr>
			</tbody>
		</table>	
		<table class="form-table">
			<tbody>
				<tr valign="top">
					<td><label><?php _e( 'TrackShip Connection Status', 'woo-advanced-shipment-tracking' ); ?></label></td>
					<td class="forminp">
						<fieldset>
							<a href="https://my.trackship.info/" target="_blank">
								<span class="api_connected"><label><?php _e( 'Connected', 'woo-advanced-shipment-tracking' ); ?></label><span class="dashicons dashicons-yes"></span></span>
							</a>
						</fieldset>						
					</td>					
				</tr>
				<tr valign="top">
					<td><label><?php _e( 'Trackers Balance', 'woo-advanced-shipment-tracking' ); ?></label></td>
					<td class="forminp">
						<fieldset>
							<strong><?php echo get_option('trackers_balance'); ?></strong>
						</fieldset>						
					</td>					
				</tr>
				<tr valign="top">
					<td><label><?php _e( 'Current Plan', 'woo-advanced-shipment-tracking' ); ?></label></td>
					<td class="forminp">
						<fieldset>
							<strong>
								<?php 									
									if(isset($plan_data->subscription_plan)){
										echo $plan_data->subscription_plan;
									}
								?>
							</strong>	
						</fieldset>						
					</td>					
				</tr>						
				<tr valign="top">										
					<td colspan="2">
						<?php _e( 'You are now connected with TrackShip! TrackShip makes it effortless to automate your post shipping operations and get tracking and delivery status updates directly in the WooCommerce admin.', 'woo-advanced-shipment-tracking' ); ?>					
					</td>					
				</tr>
				<tr valign="top">										
					<td colspan="2">
						<a href="https://trackship.info/documentation/" class="" style="margin-right: 10px;" target="blank"><?php _e( 'Documentation', 'woo-advanced-shipment-tracking' ); ?></a>
						<a href="https://my.trackship.info/" class="" target="blank"><?php _e( 'TrackShip Dashboard', 'woo-advanced-shipment-tracking' ); ?></a>						
					</td>					
				</tr>
			</tbody>
		</table>							
	
		<table class="form-table heading-table">
			<tbody>
				<tr valign="top">
					<td>
						<h3 style=""><?php _e( 'General Settings', 'woo-advanced-shipment-tracking' ); ?></h3>
					</td>					
				</tr>
			</tbody>
		</table>		
		<?php $this->get_html( $this->get_trackship_general_data() ); ?>
		<table class="form-table">
			<tbody>
				<tr valign="top">						
					<td class="button-column">
						<div class="submit">								
							<button name="save" class="button-primary woocommerce-save-button btn_ast2 btn_large" type="submit" value="Save changes"><?php _e( 'Save Changes', 'woo-advanced-shipment-tracking' ); ?></button>
							<div class="spinner"></div>								
							<?php wp_nonce_field( 'wc_ast_trackship_form', 'wc_ast_trackship_form' );?>
							<input type="hidden" name="action" value="wc_ast_trackship_form_update">
						</div>	
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<?php include 'zorem_admin_sidebar.php'; ?>	
</section>