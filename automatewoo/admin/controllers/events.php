<?php
// phpcs:ignoreFile

namespace AutomateWoo\Admin\Controllers;

use AutomateWoo\Report_Events;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * @class Events
 */
class Events extends Base {


	function handle() {
		if ( aw_request( 'did-action' ) ) {
			$this->load_stored_responses();
		}
		$this->output_list_table();
	}


	private function output_list_table() {
		$table = new Report_Events();
		$table->prepare_items();
		$table->nonce_action = $this->get_nonce_action();

		$this->output_view( 'page-table-with-sidebar', [
			'table' => $table
		]);
	}

}

return new Events();
