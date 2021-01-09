<?php
/**
 * html code for admin sidebar
 */
?>
<div class="zorem_admin_sidebar">
	<div class="zorem_admin_sidebar_inner">
		<?php $wc_ast_api_key = get_option('wc_ast_api_key'); ?>
		<div class="zorem-sidebar__section">
			<h3>AST Add-ons</h3>
			<div class="sidebar_addon_inner">
				<img src="<?php echo wc_advanced_shipment_tracking()->plugin_dir_url()?>assets/images/Tracking-Per-Item-addon-sidebar.png" class="sidebar_addon_logo">
				<div class="addon_button_div">	
					<?php if ( !is_plugin_active( 'ast-tracking-per-order-items/ast-tracking-per-order-items.php' ) ) { ?>
						<a href="https://www.zorem.com/shop/tracking-per-item-ast-add-on/?utm_source=wp-admin&utm_medium=sidebar&utm_campaign=upgrade" target="blank" class="button button-primary btn_ast2  addon_widget_button"><?php _e( 'Get This Add-on >', 'woo-advanced-shipment-tracking' ); ?></a>	
					<?php } else{ 
						if($this->licence_valid()){  ?>
							<a href="https://www.zorem.com/my-account/manage-license-key/?utm_source=wp-admin&utm_medium=sidebar&utm_campaign=upgrade" class="button button-primary btn_green2  addon_widget_button" target="blank"><?php _e('Active','woo-advanced-shipment-tracking');?> <span class="dashicons dashicons-yes"></span></a>
						<?php } else{ ?>
							<a href="https://www.zorem.com/shop/tracking-per-item-ast-add-on/?utm_source=wp-admin&utm_medium=sidebar&utm_campaign=upgrade" target="blank" class="button button-primary btn_ast2  addon_widget_button"><?php _e( 'Get This Add-on >', 'woo-advanced-shipment-tracking' ); ?></a>
						<?php }
					} ?>
				</div>	
			</div>
			<div class="sidebar_addon_inner">
				<img src="<?php echo wc_advanced_shipment_tracking()->plugin_dir_url()?>assets/images/trackship-sidebar-addons.png" class="sidebar_addon_logo">
				<div class="addon_button_div">	
					<?php if(!$wc_ast_api_key){ ?>				
						<a href="https://trackship.info/?utm_source=wp-admin&utm_medium=sidebar&utm_campaign=upgrade" class="button button-primary btn_ast2  addon_widget_button" target="_blank"><span><?php _e( 'Upgrade to PRO', 'woo-advanced-shipment-tracking' ); ?></span><i class="icon-angle-right"></i></a>
					<?php } else{ ?>
						<a href="https://my.trackship.info/?utm_source=wp-admin&utm_medium=sidebar&utm_campaign=upgrade" class="button button-primary btn_green2 addon_widget_button" target="_blank"><span><?php _e( 'Connected', 'woo-advanced-shipment-tracking' ); ?></span><i class="icon-angle-right"></i></a>	
					<?php } ?>
				</div>
			</div>					
		</div>
		<div class="zorem-sidebar__section">                    	
			<h3 class="top-border">Your opinion matters to us!</h3>
			<p>If you enjoy using The Advanced Shipment Tracking plugin, please take a minute and <a href="https://wordpress.org/support/plugin/woo-advanced-shipment-tracking/reviews/#new-post" target="_blank">share your review</a>		
			</p>        
		</div>    	
			
		<div class="zorem-sidebar__section">
			<h3 class="top-border">More plugins by zorem</h3>
			<?php
				$plugin_list = $this->get_zorem_pluginlist();
			?>	
			<ul>
				<?php foreach($plugin_list as $plugin){ 
					if( 'Advanced Shipment Tracking for WooCommerce' != $plugin->title && 'Tracking Per Item Add-on' != $plugin->title) { 
				?>
					<li><img class="plugin_thumbnail" src="<?php echo $plugin->image_url; ?>"><a class="plugin_url" href="<?php echo $plugin->url; ?>" target="_blank"><?php echo $plugin->title; ?></a></li>
				<?php }
				}?>
			</ul>  			
		</div>
	</div>
</div>