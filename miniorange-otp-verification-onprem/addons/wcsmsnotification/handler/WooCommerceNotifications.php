<?php


namespace OTP\Addons\WcSMSNotification\Handler;

use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnMessages;
use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnUtility;
use OTP\Addons\WcSMSNotification\Helper\WcOrderStatus;
use OTP\Addons\WcSMSNotification\Helper\WooCommerceNotificationsList;
use OTP\Helper\MoConstants;
use OTP\Helper\MoUtility;
use OTP\Objects\BaseAddOnHandler;
use OTP\Objects\SMSNotification;
use OTP\Traits\Instance;
use WC_Emails;
use WC_Order;
class WooCommerceNotifications extends BaseAddOnHandler
{
    use Instance;
    private $notificationSettings;
    function __construct()
    {
        parent::__construct();
        if ($this->moAddOnV()) {
            goto uG;
        }
        return;
        uG:
        $this->notificationSettings = get_wc_option("\x6e\157\x74\151\x66\151\143\x61\x74\151\x6f\x6e\x5f\x73\x65\164\164\x69\x6e\x67\163") ? get_wc_option("\x6e\157\164\x69\146\x69\143\141\x74\151\x6f\x6e\137\x73\145\164\x74\x69\x6e\147\x73") : WooCommerceNotificationsList::instance();
        add_action("\167\x6f\157\x63\x6f\x6d\x6d\x65\x72\x63\x65\x5f\x63\x72\x65\141\164\145\144\137\x63\x75\x73\164\157\x6d\x65\x72\137\156\x6f\164\x69\146\151\x63\x61\164\x69\157\156", array($this, "\155\157\x5f\x73\145\x6e\144\x5f\156\145\167\x5f\143\x75\163\164\x6f\x6d\145\162\137\x73\x6d\x73\x5f\x6e\x6f\x74\x69\x66"), 1, 3);
        add_action("\167\x6f\x6f\143\157\x6d\155\x65\162\143\145\137\x6e\145\x77\x5f\x63\x75\163\x74\157\155\145\x72\137\156\x6f\x74\145\x5f\156\x6f\x74\x69\x66\x69\x63\141\x74\151\x6f\156", array($this, "\x6d\157\137\163\145\x6e\144\x5f\x6e\145\167\x5f\143\x75\163\x74\x6f\155\x65\x72\137\163\155\x73\x5f\156\157\x74\x65"), 1, 1);
        add_action("\167\x6f\x6f\x63\x6f\155\155\x65\162\x63\x65\x5f\x6f\x72\144\145\162\137\x73\x74\141\x74\165\x73\137\143\150\141\156\x67\x65\x64", array($this, "\x6d\157\137\x73\145\156\144\137\x61\144\155\151\156\x5f\157\162\144\145\162\137\163\x6d\x73\137\x6e\157\164\x69\146"), 1, 3);
        add_action("\167\x6f\157\143\x6f\155\x6d\x65\162\143\x65\137\157\162\x64\x65\x72\137\163\x74\x61\164\165\x73\137\x63\150\141\x6e\x67\145\x64", array($this, "\x6d\157\137\143\165\x73\x74\157\155\145\x72\x5f\157\162\144\x65\x72\137\x68\157\154\144\137\x73\155\x73\x5f\x6e\x6f\164\151\x66"), 1, 3);
        add_action("\x61\144\x64\x5f\x6d\145\x74\x61\137\142\157\170\145\163", array($this, "\141\x64\x64\x5f\x63\165\163\x74\157\155\137\155\x73\147\x5f\x6d\145\164\x61\137\142\x6f\x78"), 1);
        add_action("\x61\x64\x6d\x69\156\x5f\x69\x6e\x69\164", array($this, "\x5f\x68\141\156\144\154\145\x5f\141\144\x6d\x69\x6e\137\x61\x63\x74\x69\157\156\x73"));
    }
    function _handle_admin_actions()
    {
        
        if (!(array_key_exists("\157\x70\x74\x69\157\156", $_GET) && $_GET["\157\x70\x74\151\157\x6e"] == "\x6d\157\137\163\145\156\144\137\x6f\162\144\145\x72\137\x63\x75\x73\164\157\x6d\x5f\155\x73\x67")) {
            goto Gh;
        }
        $this->_send_custom_order_msg($_POST);
        Gh:
    }
    function mo_send_new_customer_sms_notif($Op, $sH = array(), $up = false)
    {
        $this->notificationSettings->getWcNewCustomerNotif()->sendSMS(array("\x63\165\163\x74\x6f\x6d\145\162\137\x69\x64" => $Op, "\x6e\x65\167\x5f\143\x75\163\x74\x6f\x6d\x65\x72\x5f\144\x61\164\x61" => $sH, "\160\141\163\163\167\157\x72\144\x5f\x67\145\156\145\162\141\164\145\x64" => $up));
    }
    function mo_send_new_customer_sms_note($Kc)
    {
        $this->notificationSettings->getWcCustomerNoteNotif()->sendSMS(array("\x6f\162\x64\145\162\104\x65\x74\x61\x69\x6c\x73" => wc_get_order($Kc["\157\x72\x64\x65\x72\137\x69\144"])));
    }
    function mo_send_admin_order_sms_notif($B7, $Q_, $Xq)
    {
        $uR = new WC_Order($B7);
        if (is_a($uR, "\x57\x43\x5f\117\x72\144\145\162")) {
            goto Pu;
        }
        return;
        Pu:
        $this->notificationSettings->getWcAdminOrderStatusNotif()->sendSMS(array("\x6f\x72\144\x65\162\x44\145\x74\x61\151\154\x73" => $uR, "\156\x65\167\x5f\163\x74\141\x74\165\x73" => $Xq, "\x6f\154\x64\137\163\x74\141\x74\165\163" => $Q_));
    }
    function mo_customer_order_hold_sms_notif($B7, $Q_, $Xq)
    {
        $uR = new WC_Order($B7);
        if (is_a($uR, "\x57\x43\x5f\117\x72\x64\x65\162")) {
            goto vM;
        }
        return;
        vM:
        if (strcasecmp($Xq, WcOrderStatus::ON_HOLD) == 0) {
            goto lZ;
        }
        if (strcasecmp($Xq, WcOrderStatus::PROCESSING) == 0) {
            goto F4;
        }
        if (strcasecmp($Xq, WcOrderStatus::COMPLETED) == 0) {
            goto wW;
        }
        if (strcasecmp($Xq, WcOrderStatus::REFUNDED) == 0) {
            goto nE;
        }
        if (strcasecmp($Xq, WcOrderStatus::CANCELLED) == 0) {
            goto vD;
        }
        if (strcasecmp($Xq, WcOrderStatus::FAILED) == 0) {
            goto KT;
        }
        if (strcasecmp($Xq, WcOrderStatus::PENDING) == 0) {
            goto po;
        }
        return;
        goto YZ;
        lZ:
        $X_ = $this->notificationSettings->getWcOrderOnHoldNotif();
        goto YZ;
        F4:
        $X_ = $this->notificationSettings->getWcOrderProcessingNotif();
        goto YZ;
        wW:
        $X_ = $this->notificationSettings->getWcOrderCompletedNotif();
        goto YZ;
        nE:
        $X_ = $this->notificationSettings->getWcOrderRefundedNotif();
        goto YZ;
        vD:
        $X_ = $this->notificationSettings->getWcOrderCancelledNotif();
        goto YZ;
        KT:
        $X_ = $this->notificationSettings->getWcOrderFailedNotif();
        goto YZ;
        po:
        $X_ = $this->notificationSettings->getWcOrderPendingNotif();
        YZ:
        $X_->sendSMS(array("\157\x72\144\145\162\x44\145\x74\141\x69\154\x73" => $uR));
    }
    function unhook($gZ)
    {
        $RG = array($gZ->emails["\127\103\137\105\155\141\151\154\137\116\145\x77\x5f\117\x72\x64\x65\162"], "\x74\x72\x69\x67\147\145\162");
        $kK = array($gZ->emails["\127\x43\x5f\x45\x6d\x61\x69\154\x5f\x43\165\x73\x74\x6f\x6d\145\x72\137\x50\162\157\143\145\x73\163\151\156\147\137\117\162\x64\145\162"], "\164\x72\151\147\147\x65\x72");
        $rW = array($gZ->emails["\127\x43\137\105\x6d\x61\x69\x6c\x5f\103\x75\x73\164\157\x6d\x65\162\137\103\x6f\x6d\160\x6c\145\x74\145\x64\x5f\117\x72\144\145\x72"], "\x74\x72\151\x67\147\x65\x72");
        $Vn = array($gZ->emails["\x57\x43\137\x45\155\x61\151\x6c\137\x43\165\x73\164\x6f\155\x65\162\137\116\x6f\164\145"], "\164\x72\x69\147\x67\x65\x72");
        remove_action("\x77\x6f\x6f\x63\x6f\155\x6d\x65\162\x63\x65\137\x6c\x6f\x77\x5f\163\x74\x6f\x63\x6b\137\156\157\164\x69\146\151\143\141\164\151\x6f\x6e", array($gZ, "\154\x6f\x77\137\163\164\x6f\x63\x6b"));
        remove_action("\167\x6f\157\x63\x6f\155\155\145\162\143\x65\137\156\x6f\x5f\163\164\157\x63\153\137\x6e\157\x74\x69\146\x69\143\x61\x74\x69\x6f\x6e", array($gZ, "\156\x6f\x5f\163\164\157\143\153"));
        remove_action("\x77\x6f\x6f\143\x6f\155\x6d\145\x72\x63\145\x5f\160\162\157\144\165\x63\164\x5f\157\x6e\x5f\x62\141\x63\x6b\157\x72\144\145\162\x5f\156\157\x74\x69\146\151\x63\x61\164\151\x6f\156", array($gZ, "\x62\141\143\153\157\x72\144\145\x72"));
        remove_action("\x77\x6f\x6f\143\x6f\155\155\145\x72\143\x65\137\157\162\144\145\162\x5f\x73\164\x61\x74\165\163\x5f\x70\x65\156\144\151\x6e\x67\137\164\157\137\x70\162\x6f\143\145\x73\x73\151\x6e\x67\137\156\x6f\x74\x69\146\151\x63\141\164\x69\x6f\156", $RG);
        remove_action("\x77\x6f\x6f\143\x6f\x6d\155\145\x72\x63\145\137\x6f\x72\x64\x65\162\x5f\x73\x74\x61\164\165\x73\x5f\x70\x65\156\144\151\156\x67\x5f\x74\157\x5f\143\157\155\x70\154\x65\x74\x65\144\137\156\x6f\164\151\146\151\x63\x61\x74\x69\157\x6e", $RG);
        remove_action("\x77\x6f\157\x63\x6f\155\x6d\x65\x72\143\x65\x5f\x6f\162\x64\x65\x72\137\163\164\141\x74\x75\163\137\x70\x65\156\x64\x69\156\x67\137\164\157\137\157\x6e\55\x68\157\x6c\144\137\156\157\x74\151\146\x69\143\141\164\x69\x6f\x6e", $RG);
        remove_action("\x77\157\157\143\x6f\x6d\155\145\x72\143\x65\x5f\x6f\x72\144\145\x72\x5f\163\x74\x61\x74\165\163\x5f\x66\x61\x69\x6c\145\x64\137\x74\x6f\x5f\160\x72\157\x63\145\x73\163\151\156\x67\x5f\156\157\164\151\x66\151\143\141\164\151\x6f\156", $RG);
        remove_action("\167\x6f\x6f\x63\157\155\x6d\x65\162\x63\145\x5f\157\x72\144\x65\x72\137\x73\x74\141\x74\x75\x73\137\x66\141\151\154\145\144\x5f\164\157\x5f\143\x6f\155\160\154\x65\x74\145\x64\x5f\156\x6f\164\151\146\x69\143\x61\164\x69\157\156", $RG);
        remove_action("\x77\157\x6f\x63\x6f\x6d\x6d\x65\x72\x63\145\137\157\x72\x64\x65\x72\137\x73\x74\x61\164\x75\x73\x5f\146\x61\x69\154\145\144\137\x74\x6f\137\x6f\156\x2d\150\x6f\154\x64\x5f\x6e\157\x74\151\x66\x69\x63\x61\x74\x69\x6f\156", $RG);
        remove_action("\167\x6f\x6f\143\157\155\155\x65\162\143\x65\x5f\x6f\x72\x64\145\x72\137\x73\164\x61\x74\x75\163\137\160\145\x6e\x64\151\x6e\147\137\164\x6f\137\160\162\x6f\143\x65\x73\x73\x69\x6e\x67\137\x6e\157\x74\x69\x66\x69\143\141\164\151\157\156", $kK);
        remove_action("\x77\x6f\157\143\x6f\155\155\x65\162\x63\x65\x5f\x6f\x72\x64\x65\x72\x5f\163\x74\141\x74\x75\x73\137\x70\145\156\144\151\x6e\x67\x5f\164\157\x5f\157\x6e\55\150\x6f\x6c\x64\137\156\x6f\164\x69\146\x69\143\141\x74\151\157\156", $kK);
        remove_action("\x77\x6f\157\143\x6f\155\155\145\162\x63\145\137\157\x72\x64\x65\x72\137\x73\x74\x61\164\x75\x73\137\x63\x6f\x6d\x70\154\145\164\x65\144\x5f\156\157\164\151\x66\151\143\141\x74\x69\x6f\x6e", $rW);
        remove_action("\x77\157\157\143\157\x6d\x6d\x65\162\x63\145\x5f\156\145\x77\x5f\x63\x75\163\x74\157\155\145\162\x5f\x6e\157\164\x65\x5f\x6e\x6f\164\x69\x66\x69\x63\141\164\151\157\x6e", $Vn);
    }
    function add_custom_msg_meta_box()
    {
        add_meta_box("\155\x6f\x5f\x77\143\x5f\x63\x75\163\164\157\155\x5f\x73\155\163\x5f\155\145\164\x61\x5f\142\157\170", "\x43\165\163\x74\157\x6d\40\123\x4d\123", array($this, "\x6d\x6f\137\163\x68\x6f\167\x5f\163\x65\x6e\144\137\x63\x75\163\x74\x6f\155\x5f\155\163\147\137\x62\157\170"), "\x73\150\157\160\137\157\x72\x64\x65\x72", "\x73\x69\x64\x65", "\144\x65\x66\141\x75\154\x74");
    }
    function mo_show_send_custom_msg_box($tT)
    {
        $Je = new WC_Order($tT->ID);
        $Px = MoWcAddOnUtility::getCustomerNumberFromOrder($Je);
        include MSN_DIR . "\x76\x69\x65\x77\163\x2f\x63\x75\x73\x74\157\x6d\x2d\157\x72\144\x65\162\x2d\155\x73\x67\x2e\x70\x68\160";
    }
    function _send_custom_order_msg($g4)
    {
        if (!array_key_exists("\x6e\165\x6d\x62\x65\x72\x73", $g4) || MoUtility::isBlank($g4["\156\165\x6d\x62\x65\x72\x73"])) {
            goto IW;
        }
        foreach (explode("\73", $g4["\156\165\x6d\x62\145\162\x73"]) as $NZ) {
            if (MoUtility::send_phone_notif($NZ, $g4["\x6d\x73\x67"])) {
                goto Jv;
            }
            wp_send_json(MoUtility::createJson(MoWcAddOnMessages::showMessage(MoWcAddOnMessages::ERROR_SENDING_SMS), MoConstants::ERROR_JSON_TYPE));
            goto XB;
            Jv:
            wp_send_json(MoUtility::createJson(MoWcAddOnMessages::showMessage(MoWcAddOnMessages::SMS_SENT_SUCCESS), MoConstants::SUCCESS_JSON_TYPE));
            XB:
            vC:
        }
        Gj:
        goto NX;
        IW:
        MoUtility::createJson(MoWcAddOnMessages::showMessage(MoWcAddOnMessages::INVALID_PHONE), MoConstants::ERROR_JSON_TYPE);
        NX:
    }
    function setAddonKey()
    {
        $this->_addOnKey = "\167\x63\x5f\163\155\163\x5f\x6e\157\x74\151\x66\151\x63\141\164\x69\x6f\156\x5f\141\144\144\157\156";
    }
    function setAddOnDesc()
    {
        $this->_addOnDesc = mo_("\x41\x6c\x6c\x6f\167\163\40\x79\157\x75\x72\x20\x73\x69\164\145\x20\164\x6f\x20\x73\145\156\x64\x20\x6f\162\x64\x65\x72\x20\141\156\144\x20\127\157\157\x43\157\x6d\x6d\145\x72\x63\145\x20\x6e\157\x74\x69\x66\x69\143\x61\x74\151\157\x6e\163\40\164\x6f\x20\x62\165\171\x65\x72\163\x2c\x20" . "\x73\145\154\154\x65\x72\x73\x20\x61\x6e\x64\x20\141\144\155\151\156\x73\x2e\x20\103\154\x69\143\153\40\x6f\156\x20\x74\x68\x65\40\x73\x65\x74\x74\x69\x6e\x67\x73\40\x62\165\x74\164\157\156\40\164\157\40\x74\x68\145\x20\162\x69\x67\150\164\x20\x74\157\40\x73\x65\145\x20\164\150\145\x20\x6c\x69\163\x74\40\157\x66\40\x6e\157\x74\x69\x66\151\x63\141\164\151\x6f\156\x73\40" . "\164\x68\x61\x74\x20\x67\157\40\157\x75\164\x2e");
    }
    function setAddOnName()
    {
        $this->_addOnName = mo_("\x57\x6f\x6f\x43\157\155\x6d\x65\162\x63\145\x20\x53\115\x53\40\116\157\164\151\146\x69\x63\141\164\x69\x6f\x6e");
    }
    function setSettingsUrl()
    {
        $this->_settingsUrl = add_query_arg(array("\141\x64\144\157\x6e" => "\167\157\157\143\157\155\x6d\x65\162\143\x65\137\x6e\157\x74\x69\146"), $_SERVER["\x52\105\x51\x55\x45\123\x54\137\125\x52\111"]);
    }
}