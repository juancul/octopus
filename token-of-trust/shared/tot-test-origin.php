<?php

function tot_test_origin() {
	$origin = 'https://sandbox.tokenoftrust.com';
	return apply_filters('tot_test_origin', $origin);
}