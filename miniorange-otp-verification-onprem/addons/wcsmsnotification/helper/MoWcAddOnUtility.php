<?php


namespace OTP\Addons\WcSMSNotification\Helper;

use OTP\Helper\MoUtility;
use WC_Order;
use WP_User_Query;
class MoWcAddOnUtility
{
    public static function getAdminPhoneNumber()
    {
        $user = new WP_User_Query(array("\x72\157\x6c\145" => "\101\144\x6d\151\156\x69\163\164\162\141\x74\x6f\x72", "\x73\145\x61\162\x63\150\x5f\143\x6f\x6c\165\155\x6e\x73" => array("\111\x44", "\x75\163\145\162\137\154\x6f\147\x69\x6e")));
        return !empty($user->results[0]) ? get_user_meta($user->results[0]->ID, "\142\x69\x6c\154\151\x6e\x67\x5f\x70\x68\157\x6e\145", true) : '';
    }
    public static function getCustomerNumberFromOrder($uR)
    {
        $wc = $uR->get_user_id();
        $l1 = $uR->get_billing_phone();
        return !empty($l1) ? $l1 : get_user_meta($wc, "\x62\x69\x6c\154\151\156\x67\x5f\160\150\x6f\x6e\145", true);
    }
    public static function is_addon_activated()
    {
        MoUtility::is_addon_activated();
    }
}
