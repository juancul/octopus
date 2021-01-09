<?php

use TOT\Settings;
use TOT\User;

add_action('template_redirect', 'tot_verification_gates', 99);

function tot_verification_gates()
{
    // echo '<pre>tot_verification_gates</pre>';

    tot_check_for_time_based_cookie('verification_gates_enabled');
    tot_check_verification_required();
}
add_action('init', tot_add_query_params('verification_gates_enabled'));

/**
 * By default no verification is done. Override with filter 'tot_get_verification_requirement' to require page, order or user verification.
 * Use 'tot_build_verification_requirement' to build a requirement when verification is required.
 *
 * @return array
 */
function tot_get_verification_requirement()
{
    $slug = basename(get_permalink());
    if ($slug == 'verification-required') {
        return tot_build_verification_requirement('none');
    }

    if ($slug == basename(tot_verification_required_default_url()) || tot_is_page_white_listed()) {
        return tot_build_verification_requirement('none'); // null or
    }
    return apply_filters('tot_get_verification_requirement', tot_build_verification_requirement('none'));
}

// Example Override: tot_override_get_verification_requirements
//
//add_filter('tot_get_verification_requirement', 'tot_override_get_verification_requirements');
//function tot_override_get_verification_requirements ($current) {
//    if (is_page('some-page')) {
//        return tot_build_verification_requirement('redirect', array('redirectUrl' => 'someurl'));
//    }
//    return $current;
//}

/**
 * Only 'redirect' is supported today. In the future we will add others.
 *
 * @param $action - 'redirect' will cause wordpress to redirect to a verification page. Anything else will be ignored.
 * @return array
 */
function tot_build_verification_requirement($action = 'none', $args = array())
{
    $requirements = array('action' => $action);
    switch ($action) {
        case 'none':
        default:
            return new Null_Verification($args);
        case 'redirect':
            return new Redirect_Verification($args);
    }
}

class Verification_Requirement
{
    protected $args;
    protected $name;

    public function __construct($name, $args = array())
    {
        $this->args = $args;
        $this->name = $name;
    }

    public function executeAction()
    {
    }

    public function is_met()
    {
        $wpUserid = isset($this->args['wpUserid']) ? $this->args['wpUserid'] : get_current_user_id();
        $default_is_met = false;
        $reasons = null;

        if ($wpUserid) {
            $tot_user = new User($wpUserid);
            $reasons = $tot_user->get_reputation_reasons();
            $hasReasons = isset($reasons) && !is_wp_error($reasons);
            $default_is_met = $hasReasons && $reasons->is_positive('govtIdPositiveReview');
        }

        $is_met = apply_filters('tot_verification_gates_is_met', $default_is_met, $wpUserid, $reasons);

//        $pendingReview = $hasReasons && $reasons->is_positive('govtIdPendingReview');
//        $rejected = $hasReasons && $reasons->is_negative($is_met_positive_reason);

        return $is_met;
    }

    public function name()
    {
        return $this->name;
    }
}

class Null_Verification extends Verification_Requirement
{
    public function __construct($args)
    {
        parent::__construct('none', $args);
    }

    public function is_met()
    {
        return true;
    }
}

class Redirect_Verification extends Verification_Requirement
{

    public function __construct($args)
    {
        parent::__construct('redirect', $args);
    }

    public function executeAction()
    {
        $redirectUrl = $this->get_redirect_url();
        if (isset($redirectUrl) && $redirectUrl) {
            wp_redirect($redirectUrl);
        } else {
            wp_redirect(home_url('/?tot_verification_is_required=true'));
        }
        exit();
    }

    public function get_redirect_url()
    {
        return isset($this->args['redirectUrl']) ? $this->args['redirectUrl'] : tot_verification_required_default_url();
    }
}

/**
 * By default home page and verification page are white listed - others can be
 * added by overriding the filter tot_is_page_white_listed.
 * @return mixed
 */
function tot_is_page_white_listed()
{
    return apply_filters('tot_is_page_white_listed', is_home() || is_page(tot_verification_required_default_url()));
}

// Example Override: tot_override_get_verification_requirements
//
//add_filter('tot_is_page_white_listed', 'tot_override_is_page_white_listed');
//function tot_override_is_page_white_listed ($current) {
//    if (is_page('some-page')) {  // or you can say NOT some-pages...
//        return true;
//    }
//    return $current;
//}

/**
 * By default home page and verification page are white listed - others can be
 * added by overriding the filter tot_is_page_white_listed.
 * @return mixed
 */
function tot_is_verification_enabled()
{
    return Settings::get_setting('verification_gates_enabled');
}

function tot_check_verification_required()
{

    // Is verification enabled?
    if (tot_is_verification_enabled()) {
//        echo '<pre>tot_check_verification_required()</pre>';

        // Does this page require verification?
        $verification_requirement = tot_get_verification_requirement();
        if (empty($verification_requirement)) {
//            echo '<pre>no verification_requirement</pre>';
        } else {
            if (!empty($verification_requirement->is_met())) {
//                echo '<pre>tot_check_verification_requirement is NOT met</pre>';
                $verification_requirement->executeAction();
            } else {
//                echo '<pre>verification_requirement is_met</pre>';
            }
        }
    }
}


// Example Override: tot_override_get_verification_requirements
//
//add_filter('tot_verification_required_default_url', 'tot_override_verification_required_default_url');
//function tot_override_verification_required_default_url($current)
//{
//    return 'alternative-verification-page';
//}

function tot_verification_required_default_url()
{
    return apply_filters('tot_verification_required_default_url', site_url('verification-required'));
}