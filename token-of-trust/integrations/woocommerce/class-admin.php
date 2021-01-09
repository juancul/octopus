<?php

namespace TOT\Integrations\WooCommerce;

use TOT\Current_User;
use TOT\Settings;
use TOT\User;
use TOT\Integrations\WooCommerce\Checkout;

class Admin {

	public function __construct() {
	}

	public function register_wordpress_hooks() {
		add_action( 'plugins_loaded', array( $this, 'register_wordpress_hooks_after_load' ) );
	}

	public function register_wordpress_hooks_after_load() {
		if ( ! class_exists( 'WooCommerce' ) ) {
			return;
		}

		add_action( 'add_meta_boxes', array( $this, 'order_detail_meta_boxes' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'wp_ajax_tot_wc_order_unquarantine', array( $this, 'order_unquarantine' ) );
		add_action( 'wp_ajax_tot_wc_email_reminder', array( $this, 'email_reminder' ) );
	}

	public function order_detail_meta_boxes() {

		// https://developer.wordpress.org/reference/functions/add_meta_box/
		add_meta_box(
			'tot_order_detail_verification_details_meta_box',
			__( 'Identity Verification', 'token-of-trust' ),
			array( $this, 'render_order_detail_verification_details_meta_box_content' ),
			'shop_order',
			'normal',
			'default'
		);

		if ( $this->is_order_quarantined() ) {
            add_meta_box(
				'tot_order_detail_quarantine_meta_box_display',
				__( 'Order is Awaiting Verification', 'token-of-trust' ),
				array( $this, 'render_order_detail_quarantine_meta_box_content' ),
				'shop_order',
				'normal',
				'high'
			);
		}

	}

	public function is_order_quarantined() {
		global $post;
		if ( ! isset( $post ) || ( 'shop_order' !== $post->post_type ) ) {
			return false;
		}

		$quarantined = get_post_meta( $post->ID, 'tot_quarantined', true );
        return tot_option_has_a_value( $quarantined );
	}

	public function render_order_detail_verification_details_meta_box_content() {

		global $post;
		$order_id = $post->ID;
		$out      = '';


		$out .= $this->receipt_link( $order_id );
		$out .= '<br>';
		$out .= $this->receipt_summary_embed( $order_id );

		$this->reload_page_listener();

		echo $out;

	}

	public function receipt_summary_embed( $order_id ) {

		$tot_transaction_id = get_post_meta( $order_id, 'tot_transaction_id', true );
		if ( ! $tot_transaction_id ) {
			return '';
		}

		return do_shortcode(
			'[tot-wp-embed'
			. ' tot-widget="reputationSummary"'
			. ' tot-transaction-id="' . $tot_transaction_id . '"'
			. ' show-admin-buttons="true"][/tot-wp-embed]'
		);

	}

	public function reload_page_listener() {

		// @codingStandardsIgnoreStart
		?>
		<script>
            (function () {
                var somethingHappened = false;
                tot('bind', 'modalFormSubmitted', function () {
                    somethingHappened = true;
                });
                tot('bind', 'modalClose', function () {
                    setTimeout(function(){
                        if( ! somethingHappened ) {
                            return;
                        }

	                    var promptResponse = confirm(
	                        'Do you want to reload the page to see the updated status?'
	                        + ' Any in-progress changes will be lost.'
	                    );
	                    if ( promptResponse ) {
	                        window.location.reload();
	                    }
                    }, 500);
                });
            })();
		</script>
		<?php
		// @codingStandardsIgnoreEnd
	}

	public function receipt_link( $order_id ) {

		global $tot_plugin_text_domain;
		$order = wc_get_order( $order_id );

		return '<a href="' . $order->get_checkout_order_received_url() . '" target="_blank">'
			. __( 'View Receipt', $tot_plugin_text_domain )
			. '</a>';

	}

	public function render_order_detail_quarantine_meta_box_content() {
		global $post;
		$order_id = $post->ID;

		echo '<p>';
		echo __( 'This order is awaiting verification.', 'token-of-trust' );
		echo '</p>';
		echo '<ul class="tot-meta-box-actions">';
		echo '<li><a href="#tot_order_detail_verification_details_meta_box" class="button">' . __( 'View Details', 'token-of-trust' ) . '</a></li>';
		// Todo: Verification reminder from admin
		// echo '<li><a href="#tot_order_detail_verification_reminder" class="button" data-order="'.$order_id.'">' . __('Email user reminder', 'token-of-trust') . '</a></li>';
		echo '<li class="tot-meta-box-actions-right">';
		echo '<a href="#tot_remove_quarantine" class="button" data-order="' . $order_id . '">' . __( 'Remove Verification Hold', 'token-of-trust' ) . '</a>';
		echo '</li>';
		echo '</ul>';
	}

	public function enqueue_scripts() {
		wp_enqueue_style( 'token-of-trust-wc-admin-css', plugins_url( '/wc-admin.css', __FILE__ ) );
		wp_enqueue_script( 'token-of-trust-wc-admin-js', plugins_url( '/wc-admin.js', __FILE__ ), array( 'jquery' ) );
	}

	public function order_unquarantine() {

		$order_id = intval( $_POST['order_id'] );
		$order    = wc_get_order( $order_id );

		if ( ! current_user_can( 'manage_woocommerce' ) ) {
			wp_send_json_error( array() );
			wp_die();

			return;
		}

		if ( ! isset( $order ) || is_wp_error( $order ) || ( false == $order ) ) {
			wp_send_json_error( array() );
			wp_die();

			return;
		}

		$tot_user = Current_User::instance();

		$order->add_order_note( __( 'Verification Hold manually removed by ', 'token-of-trust' ) . $tot_user->wordpress_user->data->user_login . ' (ID: ' . $tot_user->wordpress_user->ID . ')' );
		update_post_meta( $order_id, 'tot_last_updated', current_time( 'mysql' ) );
		update_post_meta( $order_id, 'tot_quarantined', false );
		update_post_meta( $order_id, 'tot_quarantine_manually_removed', true );
		wp_send_json( array() );
		wp_die();

	}

	public function email_reminder() {

		$order_id = intval( $_POST['order_id'] );
		$order    = wc_get_order( $order_id );

		if ( ! current_user_can( 'manage_woocommerce' ) ) {
			wp_send_json_error( array() );
			wp_die();

			return;
		}

		if ( ! isset( $order ) || is_wp_error( $order ) || ( false == $order ) ) {
			wp_send_json_error( array() );
			wp_die();

			return;
		}

		$to      = $order->billing_email;
		$subject = 'Please verify your order';
		$body    = '<a href="' . $order->get_checkout_order_received_url() . '">verify</a>';
		$headers = array( 'Content-Type: text/html; charset=UTF-8' );

		wp_mail( $to, $subject, $body, $headers );

		wp_send_json( array() );
		wp_die();
	}

}