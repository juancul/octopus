<?php
require 'educational-content-div.php';

if (isset($_GET['settings-updated'])) {
    $tot_admin_connection_test = tot_get_admin_access_token(true);
} else {
    $tot_admin_connection_test = tot_get_admin_access_token();
}
$tot_keys = tot_get_keys();
$test_keys_work = !is_wp_error(tot_keys_work('test'));
$live_keys_work = !is_wp_error(tot_keys_work('live'));
$tot_is_production = tot_is_production();

tot_add_educational_div($tot_admin_connection_test, $tot_keys, $test_keys_work, $live_keys_work, $tot_is_production);