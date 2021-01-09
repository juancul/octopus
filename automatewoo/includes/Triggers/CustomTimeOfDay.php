<?php

namespace AutomateWoo\Triggers;

use AutomateWoo\Fields\Time as TimeField;

/**
 * Trait CustomTimeOfDayTrait
 *
 * @since 5.1.0
 */
trait CustomTimeOfDay {

	/**
	 * Register hooks.
	 */
	public function register_hooks() {
		// This action only needs to be added once for all custom time of day triggers
		if ( ! has_action( 'automatewoo/custom_time_of_day_workflow', [ 'AutomateWoo\Workflow_Background_Process_Helper', 'init_process' ] ) ) {
			add_action( 'automatewoo/custom_time_of_day_workflow', [ 'AutomateWoo\Workflow_Background_Process_Helper', 'init_process' ], 10, 2 );
		}
	}

	/**
	 * Returns the time of day field.
	 *
	 * @return TimeField
	 */
	protected function get_field_time_of_day() {
		$time = new TimeField();
		$time->set_title( __( 'Time of day', 'automatewoo' ) );
		$time->set_description( __( "Set the time in your site's timezone that the workflow will be triggered. If no time is set the workflow will run at midnight. If you set a time that has already passed for today the workflow will not run until tomorrow. The workflow will never be run twice in the same day. It's not possible to set a time after 23:00 which gives the background processor at least 1 hour to run any tasks.", 'automatewoo' ) );

		// Set the max hours value to 22 to prevent scheduling workflows in the last hour of the day
		// This way we always have at least 1 hour to run the tasks for the current day
		$time->max_hours = 22;

		return $time;
	}

	/**
	 * Get description text explaining the workflow is not run immediately.
	 *
	 * @return string
	 */
	protected function get_description_text_workflow_not_immediate() {
		return __( 'This workflow will not run immediately after it is saved. It will run daily in the background at the time set in the <strong>Time of day</strong> field. If no time is set it will run at midnight.', 'automatewoo' );
	}

}