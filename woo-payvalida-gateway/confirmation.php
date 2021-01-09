<?php
	$data = json_decode(file_get_contents('php://input'), true);
	if(isset($data)){
		$_POST = $data;
	}
	if(isset($_POST)){
		$po_id = $_POST['po_id'];
		$status = $_POST['status'];
		$amount = $_POST['amount'];
        $pv_checksum = $_POST['pv_checksum'];
        if(!isset($po_id) || !isset($status) || !isset($pv_checksum)){
			echo '{
				"status":"error"
				"type":"empty po_id or status or pv_checksum"
			}';
			exit;
		}
		require_once '../../../wp-blog-header.php';
		require_once './payvalida-authorize-woocommerce-gateway.php';
		$payvalida = new WC_Payvalida(false);
		$FIXED_HASH_NOTIFICACION=$payvalida->get_api_key();
		$pv_checksum_c = hash(sha256, $po_id . $status . $FIXED_HASH_NOTIFICACION);
	
		if(!($pv_checksum_c == $pv_checksum)){
			echo '{
				"status":"error"
				"type":"pv_checksum invalid"
			}';
			exit;
		}
		$order = new WC_Order($po_id);
		if(!isset($order)){
			echo '{
				"status":"error"
				"type":"order not exist"
			}';
			exit;
		}
		switch ($status) {
			case "approved":
				$order->update_status("processing", "Pago aceptado", false);
				echo '{
					"status":"ok"
					"type":"update_status processing"
				}';
				break;
			case "cancelled":
				$order->update_status("cancelled", "Pago cancelado", false);
				echo '{
					"status":"ok"
					"type":"update_status cancelled"
				}';
				break;
		}
		exit;
	}
?>