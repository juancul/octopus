<?php
// phpcs:ignoreFile

namespace AutomateWoo\Rules;

use AutomateWoo\Data_Types;

defined( 'ABSPATH' ) || exit;

/**
 * @class Customer_Order_Count
 */
class Customer_Order_Count extends Abstract_Number {

	public $data_item = Data_Types::CUSTOMER;

	public $support_floats = false;


	function init() {
		$this->title = __( 'Customer - Order Count', 'automatewoo' );
	}


	/**
	 * @param $customer \AutomateWoo\Customer
	 * @param $compare
	 * @param $value
	 * @return bool
	 */
	function validate( $customer, $compare, $value ) {
		return $this->validate_number( $customer->get_order_count(), $compare, $value );
	}

}
