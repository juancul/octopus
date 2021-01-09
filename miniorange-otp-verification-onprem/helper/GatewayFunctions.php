<?php


namespace OTP\Helper;

if (defined("\x41\102\123\x50\101\x54\110")) {
    goto gw;
}
die;
gw:
use OTP\Objects\IGatewayFunctions;
use OTP\Objects\NotificationSettings;
use OTP\Traits\Instance;
class GatewayFunctions implements IGatewayFunctions
{
    use Instance;
    private $gateway;
    private $pluginTypeToClass = array("\x4d\x69\x6e\x69\x4f\162\141\156\147\145\x47\x61\164\145\167\141\x79" => "\117\124\120\134\110\145\x6c\x70\x65\162\x5c\x4d\151\156\151\x4f\x72\141\156\x67\145\x47\x61\x74\x65\x77\x61\x79", "\x43\x75\163\164\157\x6d\x47\141\x74\145\167\x61\171\x57\x69\164\x68\x41\144\144\x6f\x6e\163" => "\x4f\x54\120\x5c\110\145\x6c\160\145\162\134\103\x75\x73\x74\x6f\155\107\x61\x74\x65\x77\x61\171\x57\151\164\x68\x41\144\x64\157\x6e\163", "\103\x75\x73\164\157\155\107\x61\x74\145\x77\x61\x79\127\151\x74\150\x6f\165\164\101\144\144\157\x6e\x73" => "\117\x54\120\134\x48\145\x6c\160\145\162\134\x43\x75\163\x74\x6f\155\107\x61\164\x65\167\141\x79\x57\151\x74\x68\x6f\165\x74\101\x64\144\x6f\156\x73");
    public function __construct()
    {
        $oP = $this->pluginTypeToClass[MOV_TYPE];
        $this->gateway = $oP::instance();
    }
    public function isMG()
    {
        return $this->gateway->isMG();
    }
    public function loadAddons($Ns)
    {
        $this->gateway->loadAddons($Ns);
    }
    function registerAddOns()
    {
        $this->gateway->registerAddOns();
    }
    public function showAddOnList()
    {
        $this->gateway->showAddOnList();
    }
    function hourlySync()
    {
        $this->gateway->hourlySync();
    }
    public function custom_wp_mail_from_name($rS)
    {
        return $this->gateway->custom_wp_mail_from_name($rS);
    }
    public function flush_cache()
    {
        $this->gateway->flush_cache();
    }
    public function _vlk($post)
    {
        $this->gateway->_vlk($post);
    }
    public function _mo_configure_sms_template($T3)
    {
        $this->gateway->_mo_configure_sms_template($T3);
    }
    public function _mo_configure_email_template($T3)
    {
        $this->gateway->_mo_configure_email_template($T3);
    }
    public function mo_send_otp_token($s7, $Vy, $l1)
    {
        return $this->gateway->mo_send_otp_token($s7, $Vy, $l1);
    }
    public function mclv()
    {
        return $this->gateway->mclv();
    }
    public function showConfigurationPage($i4)
    {
        $this->gateway->showConfigurationPage($i4);
    }
    public function mo_validate_otp_token($Cz, $NH)
    {
        return $this->gateway->mo_validate_otp_token($Cz, $NH);
    }
    public function mo_send_notif(NotificationSettings $Sc)
    {
        return $this->gateway->mo_send_notif($Sc);
    }
    public function getApplicationName()
    {
        return $this->gateway->getApplicationName();
    }
    public function getConfigPagePointers()
    {
        return $this->gateway->getConfigPagePointers();
    }
}
