<?php


namespace OTP\Handler;

if (defined("\101\x42\x53\x50\101\124\x48")) {
    goto sqt;
}
die;
sqt:
use OTP\Helper\FormSessionVars;
use OTP\Helper\GatewayFunctions;
use OTP\Helper\MoConstants;
use OTP\Helper\MoMessages;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\VerificationLogic;
use OTP\Traits\Instance;
final class EmailVerificationLogic extends VerificationLogic
{
    use Instance;
    public function _handle_logic($wE, $MQ, $TB, $Rn, $P8)
    {
        if (is_email($MQ)) {
            goto xuc;
        }
        $this->_handle_not_matched($MQ, $Rn, $P8);
        goto RV5;
        xuc:
        $this->_handle_matched($wE, $MQ, $TB, $Rn, $P8);
        RV5:
    }
    public function _handle_matched($wE, $MQ, $TB, $Rn, $P8)
    {
        $Tg = str_replace("\43\x23\145\x6d\141\151\x6c\43\x23", $MQ, $this->_get_is_blocked_message());
        if ($this->_is_blocked($MQ, $TB)) {
            goto LEw;
        }
        $this->_start_otp_verification($wE, $MQ, $TB, $Rn, $P8);
        goto aCI;
        LEw:
        if ($this->_is_ajax_form()) {
            goto Dbx;
        }
        miniorange_site_otp_validation_form(null, null, null, $Tg, $Rn, $P8);
        goto eqj;
        Dbx:
        wp_send_json(MoUtility::createJson($Tg, MoConstants::ERROR_JSON_TYPE));
        eqj:
        aCI:
    }
    public function _handle_not_matched($MQ, $Rn, $P8)
    {
        $Tg = str_replace("\x23\x23\145\155\x61\x69\154\43\x23", $MQ, $this->_get_otp_invalid_format_message());
        if ($this->_is_ajax_form()) {
            goto QPT;
        }
        miniorange_site_otp_validation_form(null, null, null, $Tg, $Rn, $P8);
        goto w68;
        QPT:
        wp_send_json(MoUtility::createJson($Tg, MoConstants::ERROR_JSON_TYPE));
        w68:
    }
    public function _start_otp_verification($wE, $MQ, $TB, $Rn, $P8)
    {
        $vx = GatewayFunctions::instance();
        $H1 = $vx->mo_send_otp_token("\x45\x4d\101\x49\x4c", $MQ, '');
        switch ($H1["\x73\164\141\164\x75\x73"]) {
            case "\123\125\x43\x43\105\x53\x53":
                $this->_handle_otp_sent($wE, $MQ, $TB, $Rn, $P8, $H1);
                goto XZk;
            default:
                $this->_handle_otp_sent_failed($wE, $MQ, $TB, $Rn, $P8, $H1);
                goto XZk;
        }
        YLB:
        XZk:
    }
    public function _handle_otp_sent($wE, $MQ, $TB, $Rn, $P8, $H1)
    {
        SessionUtils::setEmailTransactionID($H1["\164\x78\x49\144"]);
        if (!(MoUtility::micr() && MoUtility::isMG())) {
            goto o1f;
        }
        $eE = get_mo_option("\x65\x6d\x61\x69\154\x5f\x74\162\141\x6e\x73\141\143\164\x69\x6f\x6e\163\137\162\x65\x6d\x61\151\x6e\151\156\147");
        if (!($eE > 0)) {
            goto els;
        }
        update_mo_option("\145\155\x61\x69\154\x5f\x74\162\x61\156\163\x61\x63\164\151\157\156\x73\137\x72\145\155\141\151\156\x69\x6e\147", $eE - 1);
        els:
        o1f:
        $Tg = str_replace("\x23\x23\x65\155\141\x69\154\x23\x23", $MQ, $this->_get_otp_sent_message());
        if ($this->_is_ajax_form()) {
            goto rIh;
        }
        miniorange_site_otp_validation_form($wE, $MQ, $TB, $Tg, $Rn, $P8);
        goto blF;
        rIh:
        wp_send_json(MoUtility::createJson($Tg, MoConstants::SUCCESS_JSON_TYPE));
        blF:
    }
    public function _handle_otp_sent_failed($wE, $MQ, $TB, $Rn, $P8, $H1)
    {
        $Tg = str_replace("\43\43\x65\155\141\x69\154\43\x23", $MQ, $this->_get_otp_sent_failed_message());
        if ($this->_is_ajax_form()) {
            goto Du6;
        }
        miniorange_site_otp_validation_form(null, null, null, $Tg, $Rn, $P8);
        goto kzv;
        Du6:
        wp_send_json(MoUtility::createJson($Tg, MoConstants::ERROR_JSON_TYPE));
        kzv:
    }
    public function _get_otp_sent_message()
    {
        $OA = get_mo_option("\163\165\x63\143\x65\163\163\x5f\x65\155\x61\151\x6c\137\x6d\x65\163\163\141\x67\x65", "\x6d\x6f\x5f\157\164\x70\x5f");
        return $OA ? $OA : MoMessages::showMessage(MoMessages::OTP_SENT_EMAIL);
    }
    public function _get_otp_sent_failed_message()
    {
        $Jw = get_mo_option("\x65\162\x72\157\162\x5f\145\155\141\x69\x6c\137\x6d\145\163\163\x61\147\x65", "\155\157\137\x6f\164\x70\x5f");
        return $Jw ? $Jw : MoMessages::showMessage(MoMessages::ERROR_OTP_EMAIL);
    }
    public function _is_blocked($MQ, $TB)
    {
        $c1 = explode("\x3b", get_mo_option("\x62\x6c\157\143\x6b\145\x64\137\x64\157\x6d\x61\151\x6e\163"));
        $c1 = apply_filters("\x6d\x6f\137\x62\x6c\157\143\x6b\x65\x64\x5f\x65\155\141\x69\x6c\137\x64\157\x6d\x61\x69\x6e\163", $c1);
        return in_array(MoUtility::getDomain($MQ), $c1);
    }
    public function _get_is_blocked_message()
    {
        $Wj = get_mo_option("\142\x6c\157\143\x6b\x65\144\137\145\155\x61\151\x6c\137\x6d\x65\163\163\141\x67\145", "\155\157\x5f\157\x74\160\137");
        return $Wj ? $Wj : MoMessages::showMessage(MoMessages::ERROR_EMAIL_BLOCKED);
    }
    public function _get_otp_invalid_format_message()
    {
        $Tg = get_mo_option("\151\x6e\166\141\x6c\x69\x64\137\145\x6d\x61\x69\154\137\155\x65\163\x73\141\147\x65", "\155\157\137\157\164\x70\x5f");
        return $Tg ? $Tg : MoMessages::showMessage(MoMessages::ERROR_EMAIL_FORMAT);
    }
}
