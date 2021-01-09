<?php


namespace OTP\Addons\UmSMSNotification\Helper;

use OTP\Helper\MoUtility;
use WP_User_Query;
class UltimateMemberSMSNotificationUtility
{
    public static function getAdminPhoneNumber()
    {
        $user = new WP_User_Query(array("\x72\157\x6c\x65" => "\101\144\x6d\151\156\x69\163\x74\162\x61\x74\x6f\x72", "\x73\x65\x61\162\143\x68\137\143\x6f\154\x75\x6d\156\163" => array("\x49\104", "\165\x73\145\x72\137\x6c\x6f\147\151\156")));
        return !empty($user->results[0]) ? array(get_user_meta($user->results[0]->ID, "\x6d\x6f\142\151\154\x65\137\x6e\165\x6d\142\x65\162", true)) : '';
    }
    public static function is_addon_activated()
    {
        MoUtility::is_addon_activated();
    }
}
