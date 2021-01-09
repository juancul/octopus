<?php
/*
Plugin Name: WooPayvalida Payment
Plugin URI: https://es.wordpress.org/plugins/woo-payvalida-gateway/
Description: Pague sus pedidos utilizando Payvalida Procesadora de pagos
Version: 2.5
Author: Valida SAS
Author URI: https://payvalida.com/
 */

function woocommerce_payvalida_gateway()
{
	if (!class_exists('WC_Payment_Gateway')) return;

	class WC_Payvalida extends WC_Payment_Gateway
	{
		/**
		 * Funcion para enviar informacion del plugin al API
		 *
		 * @access public
		 * @return void
		 */
		public function load_plugin_send_api(){
			$return = ($this->settings['confirmation_page']=="Default")?plugin_dir_url( __FILE__ )."confirmation.php":$this->settings['confirmation_page'];
			$body_json = '
				{
					"Notify": "'.$return.'",
					"Return": "'.$this->response_page.'",
					"Checksum": "'.hash('SHA256',$this->merchant_id.$return.$this->fixed_hash).'",
					"Name": "'.$this->merchant_id.'"
				}
			';
			$curl = curl_init();
		
			curl_setopt_array($curl, array(
			CURLOPT_URL => "https://api.payvalida.com/services/services/cambioUrlMerchant",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS =>$body_json,
			CURLOPT_HTTPHEADER => array(
				"Content-Type: application/json",
				"Cookie: __cfduid=dd176ec8bd918186258d0349983a6ca9b1594948465"
			),
			));
		
			$response = curl_exec($curl);
		
			curl_close($curl);
			if($_GET["page"]=="wc-settings" && $this->settings['show_api']=="yes"){
				echo "<div style='background:#fff;padding:10px;' >";
				echo "SEND\n";
				echo "<pre>".($body_json)."</pre>";
				echo "RESPOND\n";
				echo "<pre>".($response)."</pre>";
				echo "</div>";
			}
		}

		/**
		 * Constructor de la pasarela de pago
		 *
		 * @access public
		 * @return void
		 */
		public function __construct($show_load=true)
		{
			$this->id = 'payvalida';
			$this->icon = apply_filters('woocomerce_payvalida_icon', plugins_url('/assets/Logo2.jpg', __FILE__));
			$this->has_fields = false;
			$this->method_title = 'Payvalida';
			$this->method_description = '
				<img src="'.plugin_dir_url( __FILE__ ).'assets/payvalida.png" style="width: 100px;"/>
				<br/>
				Integración de Woocommerce a la pasarela de pagos de Payvalida
			';
			$this->plugin_name = plugin_basename(__FILE__);

			$this->init_form_fields();
			$this->init_settings();

			$this->title = $this->settings['title'];
			$this->icon = plugin_dir_url( __FILE__ )."assets/Logo2.jpg";

			
			
			$this->merchant_id = $this->settings['api_login'];
			$this->api_key = (isset($this->settings['api_key']))?$this->settings['api_key']:"";
			$this->fixed_hash = $this->settings['fixed_hash'];
			$this->fixed_hash_test = $this->settings['fixed_hash_notificacion'];
			$this->gateway_url = 'https://checkout.payvalida.com/';

			$this->response_page = plugin_dir_url( __FILE__ )."response.php";
			$this->environment = $this->settings['environment'];
			$this->confirmation_page = plugin_dir_url( __FILE__ )."confirmation.php";

			if (version_compare(WOOCOMMERCE_VERSION, '2.0.0', '>=')) {
				add_action('woocommerce_update_options_payment_gateways_' . $this->id, array(&$this, 'process_admin_options'));
			} else {
				add_action('woocommerce_update_options_payment_gateways', array(&$this, 'process_admin_options'));
			}
			add_action('woocommerce_receipt_payvalida', array(&$this, 'receipt_page'));

			/*send info API */
			//if($show_load)
				//$this->load_plugin_send_api();
		}

		public function action_links($links)
    	{
			$customLinks = [
				'settings' => sprintf(
					'<a href="%s">%s</a>',
					admin_url('admin.php?page=wc-settings&tab=checkout&section=payvalida'),
					__('Settings', 'payvalida')
				)
			];

			return array_merge($links, $customLinks);
		}

		/**
		 * Funcion que define los campos que iran en el formulario en la configuracion
		 * de la pasarela de payvalida
		 *
		 * @access public
		 * @return void
		 */
		function init_form_fields()
		{

			$url = home_url();
			$pages = get_pages();
			$option_pages = array(
				"Default" => "Default"
			);
			foreach ($pages as $key => $page) {
				$option_pages[$page->guid] = $page->post_title;
			}
			$this->form_fields = array(
				'enabled' => array(
					'title' => __('Habilitar / Deshabilitar', 'payvalida'),
					'label' => __('Habilite esta pasarela de pago', 'payvalida'),
					'type' => 'checkbox',
					'default' => 'no',
				),
				'title' => array(
					'title' => __('Título', 'payvalida'),
					'type' => 'text',
					'default' => 'Payvalida',
					'desc_tip' => __('Este es título que se mostrará en la página de checkout para identificar el método de pago', 'payvalida'),
				),
				'description' => array(
					'title' => __('Descripción', 'payvalida'),
					'type' => 'textarea',
					'desc_tip' => __('Título del pago del proceso de pago.', 'payvalida'),
					'default' => __('Comienza hoy mismo a vender tus productos o servicios en línea.', 'payvalida'),
					'css' => 'max-width:450px;'
				),
				'api_login' => array(
					'title' => __('Payvalida merchant ID', 'payvalida'),
					'type' => 'text',
					'desc_tip' => __('Esta es la identificación proporcionada por Payvalida cuando creas una cuenta', 'payvalida'),
				),
				'api_iva' => array(
					'title' => __('Merchant IVA', 'payvalida'),
					'type' => 'text',
					'default' => __('0', 'payvalida'),
					'desc_tip' => __('Esta es la identificación proporcionada por Payvalida cuando creas una cuenta', 'payvalida'),
				),
				'fixed_hash' => array(
					'title' => __('Payvalida FIXED_HASH', 'payvalida'),
					'type' => 'text',
					'desc_tip' => __('Este es el FIXED_HASH proporcionado por Payvalida cuando creas una cuenta.', 'payvalida'),
				),
				'fixed_hash_notificacion' => array(
					'title' => __('Payvalida FIXED_HASH_NOTIFICACION', 'payvalida'),
					'type' => 'text',
					'desc_tip' => __('Este es el FIXED_HASH de ambiente de pruebas proporcionado por Payvalida cuando creas una cuenta.', 'payvalida'),
				),
				'confirmation_page' => array(
					'title' => __('Thanks page'),
					'type' => 'select',
					'desc_tip' => __('Thanks page', 'payvalida'),
					'default' => "Default",
					'options' => $option_pages
				),
				'environment' => array(
					'title' => __('Modo de prueba Payvalida', 'payvalida'),
					'label' => __('Habilitar modo de prueba', 'payvalida'),
					'type' => 'checkbox',
					'desc_tip' => __('Este es el modo de prueba de Payvalida.', 'payvalida'),
					'description' => __('Este es el modo de prueba de Payvalida.', 'payvalida'),
					'default' => 'no',
				),
				'show_api' => array(
					'title' => __('Parametros del API', 'payvalida'),
					'label' => __('Habilitar depuracion del API', 'payvalida'),
					'type' => 'checkbox',
					'desc_tip' => __('Muestra envio y respuesta del API', 'payvalida'),
					'description' => __('Muestra envio y respuesta del API', 'payvalida'),
					'default' => 'no',
				),
			);
		}	

		/**
		 *
		 * @access public
		 * @return void
		 */
		public function admin_options()
		{
			echo '<h3>' . __('Payvalida Payment Gateway', 'payvalida') . '</h3>';
			echo '<table class="form-table">';
			$this->generate_settings_html();
			
			echo '</table>';
			$this->load_plugin_send_api();
		}

		/**
		 *
		 * @access public
		 * @return void
		 */
		public function receipt_page($order_id)
		{
			echo '<p>' . __('Gracias por su pedido, de clic en el botón que aparece para continuar el pago con Payvalida.', 'payvalida') . '</p>';
			echo $this->generate_payvalida_form($order_id);

			// Change order status to notify that user is being redirected and invalidates the shopping cart
			// $order = new WC_Order($order_id);
			// $order->update_status('on-hold', __('Redirecting to Payvalida', 'payvalida'));

			$url = $_REQUEST['redirect-url'];

			// redirect user to Payvalida
			$code = 'jQuery("body").block({
				message: "' . esc_js(__("Te estamos redirigiendo a Payvalida para finalizar el pago, si no eres redireccionado en un momento por favor presiona el botón.",
				'payvalida')) . '",
				baseZ: 99999,
				overlayCSS: { background: "#fff", opacity: 0.6 },
				css: {
					padding:        "20px",
					zindex:         "9999999",
					textAlign:      "center",
					color:          "#555",
					border:         "3px solid #aaa",
					backgroundColor:"#fff",
					cursor:         "wait",
					lineHeight:		"24px",
				}
			});

			setTimeout( function() {
				window.location.href = decodeURIComponent("' . $_REQUEST['redirect-url'] . '");
			}, 1000 );

			';
			
			if (defined('WOOCOMMERCE_VERSION') && version_compare(
                WOOCOMMERCE_VERSION,
                '2.1',
                '>='
            )) {
				wc_enqueue_js($code);
			} else {
				WC()->add_inline_js($code);
			}
		}

		/**
		 *
		 * @access public
		 * @return void
		 */
		public function get_params_post($order_id)
		{
			global $woocommerce;



			$order = new WC_Order($order_id);
			$currency = get_woocommerce_currency();
			$amount = number_format(($order->get_total()), 2, '.', '');
			$signature = hash(sha256, $order->id . '' . $currency . '' . $amount . '' . $this->api_key);
			$description = "";
			$products = $order->get_items();
			foreach ($products as $product) {
				$description .= $product['name'] . ',';
			}
			$tax = number_format(($order->get_total_tax()), 2, '.', '');
			$taxReturnBase = number_format(($amount - $tax), 2, '.', '');
			if ($tax == 0) $taxReturnBase = 0;

			$test = 0;
			if ($this->test == 'yes') $test = 1;

			$parameters_args = array(
				'merchant_id' => $this->merchant_id,
				'po_id' => $order->id,
				'iso_currency' => $currency,
				'amount' => $amount,
				'brief' => trim($description, ','),
				'pv_checksum' => $signature
			);
			return $parameters_args;
		}

		/**
		 * Submit payment and handle response
		 * @access public
		 * @return void
		 */
		public function generate_payvalida_form($order_id)
		{
			global $woocommerce;
			$customer_order = new WC_Order($order_id);
			$environment = ($this->environment == "yes") ? 'TRUE' : 'FALSE';
			// Decide which URL to post to
			$environment_orders = ("FALSE" == $environment)
				? 'https://api.payvalida.com/api/v3/porders'
				: 'https://api-test.payvalida.com/api/v3/porders';
			$ambient = ("FALSE" == $environment)
				? 'Produccion'
				: 'Desarrollo';	
			$fished = $this->fixed_hash;
			if (!function_exists('get_woocommerce_currency')) {
				require_once '/includes/wc-core-functions.php';
			}
			$currency_pv = strval(get_woocommerce_currency()); 
			//Add Payment Order
			//Send this payload to Payvalida for processing
			//Calculate checksum =  SHA512(email + country + order + money + amount + FIXED_HASH)
			$key = $customer_order->billing_email . strval(343) . strval($order_id) . $currency_pv . strval($customer_order->order_total) . $fished;
			$checksum = hash('sha512', $key);
			//Register payment order
			if (!is_object($myOrder)) {
				$myOrder = new stdClass;
			}
			$myOrder->country = 343;
			$myOrder->email = $customer_order->billing_email;
			$myOrder->merchant = $this->merchant_id;
			$myOrder->order = strval($order_id);
			$myOrder->money = $currency_pv;
			$myOrder->iva = "0";
			$myOrder->amount = $customer_order->order_total;
			$myOrder->description = "Pedido #" . strval($order_id);
			$myOrder->language = "es";
			$myOrder->recurrent = false;
			$myOrder->expiration = strval(date("d/m/Y", strtotime("+1 Months")));
			$myOrder->checksum = $checksum;
			$data = json_encode($myOrder);
			$curl = curl_init($environment_orders);
			curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type:application/json']);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_POST, true);
			$response = curl_exec($curl);
			curl_close($curl);
			$obj = json_decode($response, true);
			$referenceCode = $obj['DATA'];
			$chekout = $obj['DATA']['checkout'];
			$url_sandbox = "https://sandbox-checkout.payvalida.com";
			$url_prod = "https://secure-checkout.payvalida.com";
			$code = $obj['CODE'];
			$descrip = $obj['DESC'];
			$navegador = $_SERVER['HTTP_USER_AGENT'];
			$token = "7fa9f9a33add4d269b587adcb5cd54c2";
			//lanzamiento de error
			if ($code != "0000") {
				$arr = array(
					"access_token" => $token,
					"data" => array(
						"environment" => $ambient,
						"body" => array(
							"message" => array(
								"body" => $descrip,
								"json" => $data,
								"process" => "creacion del checkout"
							)
						),
						"person" => array(
							"id" => $this->merchant_id,
							"username" => $this->merchant_id
						),
						"client" => array(
							"javascript" => array(
								"browser" => $navegador,
								"code_version" => "2"
							)
						)
					)
				);
				$json = json_encode($arr);
				$curl = curl_init("https://api.rollbar.com/api/1/item/");
				curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type:application/json']);
				curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($curl, CURLOPT_POST, true);
				$respuesta = curl_exec($curl);
				curl_close($curl);
			}
			if ($environment == "FALSE") {
				$result = preg_split("/=/", $chekout);
				if ($result[0] != 'secure-checkout.payvalida.com?token') {
					$url_prod = "https://checkout.payvalida.com";
				}
				$params_chekout = $result[1];
				$pay_args_array[] = "<input type='hidden' name='token' value='$params_chekout'/>";
				return '<form action="' . $url_prod . '" method="get" id="payvalida_form">' . implode('', $pay_args_array) . '<input type="submit" id="submit_payvalida_latam" class="btn btn-primary btn-block " value="' . __('Pagar ahora', 'payvalida') . '" /></form>';
			} else {
				$result = preg_split("/=/", $chekout);
				$params_chekout = $result[1];
				$pay_args_array[] = "<input type='hidden' name='token' value='$params_chekout'/>";
				return '<form action="' . $url_sandbox . '" method="get" id="payvalida_form" >' . implode('', $pay_args_array) . '<input type="submit" id="submit_payvalida_latam" class="btn btn-primary btn-block " value="' . __('Pagar ahora', 'payvalida') . '" /></form>';
			}
		}

		/**
		 * Generate the url to process payvalida payment regarding an order id
		 * @access public
		 * @return string
		 */
		public function generate_redirect_url($order_id)
		{
			global $woocommerce;
			$customer_order = new WC_Order($order_id);
			$environment = ($this->environment == "yes") ? 'TRUE' : 'FALSE';
			// Decide which URL to post to
			$environment_orders = ("FALSE" == $environment)
				? 'https://api.payvalida.com/api/v3/porders'
				: 'https://api-test.payvalida.com/api/v3/porders';
			$ambient = ("FALSE" == $environment)
				? 'Produccion'
				: 'Desarrollo';	
			$fished = $this->fixed_hash;
			if (!function_exists('get_woocommerce_currency')) {
				require_once '/includes/wc-core-functions.php';
			}
			$currency_pv = strval(get_woocommerce_currency()); 
			//Add Payment Order
			//Send this payload to Payvalida for processing
			//Calculate checksum =  SHA512(email + country + order + money + amount + FIXED_HASH)
			$key = $customer_order->billing_email . strval(343) . strval($order_id) . $currency_pv . strval($customer_order->order_total) . $fished;
			$checksum = hash('sha512', $key);
			//Register payment order
			if (!is_object($myOrder)) {
				$myOrder = new stdClass;
			}
			$myOrder->country = 343;
			$myOrder->email = $customer_order->billing_email;
			$myOrder->merchant = $this->merchant_id;
			$myOrder->order = strval($order_id);
			$myOrder->money = $currency_pv;
			$myOrder->iva = "0";
			$myOrder->amount = $customer_order->order_total;
			$myOrder->description = "Pedido #" . strval($order_id);
			$myOrder->language = "es";
			$myOrder->recurrent = false;
			$myOrder->expiration = strval(date("d/m/Y", strtotime("+1 Months")));
			$myOrder->checksum = $checksum;
			$data = json_encode($myOrder);
			$curl = curl_init($environment_orders);
			curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type:application/json']);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_POST, true);
			$response = curl_exec($curl);
			curl_close($curl);
			$obj = json_decode($response, true);
			$referenceCode = $obj['DATA'];
			$chekout = $obj['DATA']['checkout'];
			$url_sandbox = "https://sandbox-checkout.payvalida.com";
			$url_prod = "https://secure-checkout.payvalida.com";
			$code = $obj['CODE'];
			$descrip = $obj['DESC'];
			$navegador = $_SERVER['HTTP_USER_AGENT'];
			$token = "7fa9f9a33add4d269b587adcb5cd54c2";
			//lanzamiento de error
			if ($code != "0000") {
				$arr = array(
					"access_token" => $token,
					"data" => array(
						"environment" => $ambient,
						"body" => array(
							"message" => array(
								"body" => $descrip,
								"json" => $data,
								"process" => "creacion del checkout"
							)
						),
						"person" => array(
							"id" => $this->merchant_id,
							"username" => $this->merchant_id
						),
						"client" => array(
							"javascript" => array(
								"browser" => $navegador,
								"code_version" => "2"
							)
						)
					)
				);
				$json = json_encode($arr);
				$curl = curl_init("https://api.rollbar.com/api/1/item/");
				curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type:application/json']);
				curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($curl, CURLOPT_POST, true);
				$respuesta = curl_exec($curl);
				curl_close($curl);
			}
			if ($environment == "FALSE") {
				$result = preg_split("/=/", $chekout);
				if ($result[0] != 'secure-checkout.payvalida.com?token') {
					$url_prod = "https://checkout.payvalida.com";
				}
				$params_chekout = $result[1];
				return $url_prod . "?token=" . $params_chekout;
			} else {
				$result = preg_split("/=/", $chekout);
				$params_chekout = $result[1];
				$pay_args_array[] = "<input type='hidden' name='token' value='$params_chekout'/>";
				return $url_sandbox . "?token=" . $params_chekout;
			}
		}


		/**
		 *
		 * @access public
		 * @return void
		 */
		function process_payment($order_id)
		{
			global $woocommerce;
			$order = new WC_Order($order_id);
			$woocommerce->cart->empty_cart();
			if (version_compare(WOOCOMMERCE_VERSION, '2.0.19', '<=')) {
				return array('result' => 'success', 'redirect' => add_query_arg(
					'order',
					$order->id,
					add_query_arg('key', $order->order_key, get_permalink(get_option('woocommerce_pay_page_id')))
				));
			} else {

				$parameters_args = $this->get_params_post($order_id);

				$pay_args_array = array();
				foreach ($parameters_args as $key => $value) {
					$pay_args_array[] = $key . '=' . $value;
				}
				$params_post = implode('&', $pay_args_array);
				// generate Payvalida redirect URL and add it to checkout URL
				$redirect_url = urlencode($this->generate_redirect_url($order_id));
				return array(
					'result' => 'success',
					'redirect' => add_query_arg('redirect-url', $redirect_url, $order->get_checkout_payment_url(true))
				);
			}
		}


		function get_api_key()
		{

			$fished = $this->fixed_hash_test;

			return $fished;
		}
		function get_merchant_id()
		{
			return $this->merchant_id;
		}
		function get_envi()
		{
			$environment_pv = ($this->environment == "yes") ? 'TRUE' : 'FALSE';
			return $environment_pv;
		}
		function get_envi_name()
		{
			$environment_pv_name = ($this->environment == "yes") ? 'Sandbox' : 'Produccion';
			return $environment_pv_name;
		}

		function get_fixedH()
		{
			return $this->fixed_hash;
		}

	}

	function add_payvalida($methods)
	{
		$methods[] = 'WC_Payvalida';
		return $methods;
	}
	add_filter('woocommerce_payment_gateways', 'add_payvalida');
}
add_action('plugins_loaded', 'woocommerce_payvalida_gateway', 0);