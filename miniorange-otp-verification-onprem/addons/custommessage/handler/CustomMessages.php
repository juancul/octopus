<?php


namespace OTP\Addons\CustomMessage\Handler;

use OTP\Helper\MoConstants;
use OTP\Helper\MoMessages;
use OTP\Helper\MoUtility;
use OTP\Objects\BaseAddOnHandler;
use OTP\Objects\BaseMessages;
use OTP\Traits\Instance;
class CustomMessages extends BaseAddOnHandler
{
    use Instance;
    public $_adminActions = array("\155\x6f\x5f\143\165\163\164\x6f\155\x65\x72\137\166\x61\x6c\151\144\x61\x74\151\157\x6e\137\x61\144\x6d\x69\156\x5f\x63\x75\x73\164\157\x6d\x5f\160\x68\157\156\145\137\156\x6f\x74\x69\x66" => "\x5f\x6d\x6f\137\166\x61\x6c\151\x64\x61\164\151\157\156\137\x73\x65\156\144\x5f\163\155\163\137\x6e\x6f\x74\x69\146\x5f\x6d\x73\147", "\155\157\137\x63\x75\163\x74\157\155\x65\162\x5f\x76\141\154\x69\144\141\x74\x69\x6f\156\x5f\x61\x64\155\x69\156\x5f\143\165\163\x74\x6f\x6d\x5f\145\155\x61\x69\154\x5f\x6e\157\x74\x69\x66" => "\x5f\x6d\x6f\x5f\166\141\x6c\x69\x64\141\x74\151\x6f\x6e\x5f\163\145\x6e\x64\137\145\x6d\x61\151\x6c\x5f\x6e\157\164\x69\146\137\155\x73\147");
    function __construct()
    {
        parent::__construct();
        $this->_nonce = "\155\157\x5f\141\144\x6d\x69\x6e\x5f\141\143\164\151\157\156\163";
        if ($this->moAddOnV()) {
            goto ha;
        }
        return;
        ha:
        foreach ($this->_adminActions as $Gd => $bS) {
            add_action("\167\x70\x5f\141\x6a\x61\170\x5f{$Gd}", array($this, $bS));
            add_action("\x61\x64\155\151\156\x5f\160\x6f\163\x74\x5f{$Gd}", array($this, $bS));
            IB:
        }
        va:
    }
    public function _mo_validation_send_sms_notif_msg()
    {
        $rH = MoUtility::sanitizeCheck("\141\152\141\170\x5f\x6d\x6f\144\145", $_POST);
        $rH ? $this->isValidAjaxRequest("\163\145\143\x75\x72\151\x74\x79") : $this->isValidRequest();
        $Px = explode("\x3b", $_POST["\155\x6f\137\160\150\157\x6e\145\x5f\x6e\165\155\142\145\162\163"]);
        $Tg = $_POST["\x6d\x6f\137\x63\165\x73\x74\157\x6d\145\162\137\x76\141\154\x69\x64\x61\x74\x69\157\x6e\x5f\143\x75\x73\164\157\x6d\137\163\x6d\x73\x5f\155\163\147"];
        $H1 = null;
        foreach ($Px as $l1) {
            $H1 = MoUtility::send_phone_notif($l1, $Tg);
            Va:
        }
        tc:
        $rH ? $this->checkStatusAndSendJSON($H1) : $this->checkStatusAndShowMessage($H1);
    }
    public function _mo_validation_send_email_notif_msg()
    {
        $rH = MoUtility::sanitizeCheck("\141\x6a\x61\x78\137\155\x6f\144\145", $_POST);
        $rH ? $this->isValidAjaxRequest("\163\145\x63\x75\162\151\164\171") : $this->isValidRequest();
        $Bj = explode("\73", $_POST["\x74\157\105\155\x61\151\154"]);
        $H1 = null;
        foreach ($Bj as $Vy) {
            $H1 = MoUtility::send_email_notif($_POST["\146\x72\x6f\155\x45\155\x61\x69\154"], $_POST["\x66\x72\157\155\x4e\141\155\x65"], $Vy, $_POST["\163\165\x62\152\145\x63\164"], stripslashes($_POST["\143\157\156\x74\x65\x6e\164"]));
            n2:
        }
        yv:
        $rH ? $this->checkStatusAndSendJSON($H1) : $this->checkStatusAndShowMessage($H1);
    }
    private function checkStatusAndShowMessage($H1)
    {
        if (!is_null($H1)) {
            goto cJ;
        }
        return;
        cJ:
        $Zw = $H1 ? MoMessages::showMessage(BaseMessages::CUSTOM_MSG_SENT) : MoMessages::showMessage(BaseMessages::CUSTOM_MSG_SENT_FAIL);
        $fG = $H1 ? MoConstants::SUCCESS : MoConstants::ERROR;
        do_action("\x6d\x6f\x5f\x72\145\147\151\x73\x74\x72\141\164\x69\157\x6e\x5f\163\150\x6f\167\137\155\145\163\163\141\x67\145", $Zw, $fG);
        wp_safe_redirect(wp_get_referer());
    }
    private function checkStatusAndSendJSON($H1)
    {
        if (!is_null($H1)) {
            goto Yq;
        }
        return;
        Yq:
        if ($H1) {
            goto Yc;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(BaseMessages::CUSTOM_MSG_SENT_FAIL), MoConstants::ERROR_JSON_TYPE));
        goto Tk;
        Yc:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(BaseMessages::CUSTOM_MSG_SENT), MoConstants::SUCCESS_JSON_TYPE));
        Tk:
    }
    function setAddonKey()
    {
        $this->_addOnKey = "\143\x75\163\164\157\155\137\x6d\x65\163\163\141\x67\x65\163\x5f\141\x64\x64\157\156";
    }
    function setAddOnDesc()
    {
        $this->_addOnDesc = mo_("\123\145\156\x64\40\x43\x75\x73\164\x6f\155\151\x7a\x65\144\40\x6d\145\163\163\141\147\145\x20\x74\157\40\141\156\171\40\x70\150\x6f\156\145\40\157\x72\x20\145\155\x61\151\154\x20\x64\151\x72\x65\143\164\154\171\40\x66\x72\157\155\40\x74\x68\145\x20\x64\x61\163\150\142\x6f\141\x72\144\56");
    }
    function setAddOnName()
    {
        $this->_addOnName = mo_("\x43\165\x73\164\157\x6d\x20\x4d\145\163\163\x61\x67\145\x73");
    }
    function setSettingsUrl()
    {
        $this->_settingsUrl = add_query_arg(array("\141\x64\x64\x6f\x6e" => "\x63\165\163\164\157\155"), $_SERVER["\122\105\x51\125\x45\123\124\137\x55\122\x49"]);
    }
}
