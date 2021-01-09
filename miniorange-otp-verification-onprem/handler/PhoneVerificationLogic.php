<?php


namespace OTP\Handler;

if (defined("\x41\x42\x53\x50\101\124\110")) {
    goto wl;
}
die;
wl:
use OTP\Helper\FormSessionVars;
use OTP\Helper\GatewayFunctions;
use OTP\Helper\MoConstants;
use OTP\Helper\MoMessages;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\FormSessionData;
use OTP\Objects\VerificationLogic;
use OTP\Traits\Instance;
final class PhoneVerificationLogic extends VerificationLogic
{
    use Instance;
    public function _handle_logic($wE, $MQ, $TB, $Rn, $P8)
    {
        $FH = MoUtility::validatePhoneNumber($TB);
        switch ($FH) {
            case 0:
                $this->_handle_not_matched($TB, $Rn, $P8);
                goto O4;
            case 1:
                $this->_handle_matched($wE, $MQ, $TB, $Rn, $P8);
                goto O4;
        }
        I7:
        O4:
    }
    public function _handle_matched($wE, $MQ, $TB, $Rn, $P8)
    {
        $Tg = str_replace("\x23\43\x70\150\x6f\x6e\x65\x23\x23", $TB, $this->_get_is_blocked_message());
        if ($this->_is_blocked($MQ, $TB)) {
            goto in;
        }
        $this->_start_otp_verification($wE, $MQ, $TB, $Rn, $P8);
        goto CT;
        in:
        if ($this->_is_ajax_form()) {
            goto TW;
        }
        miniorange_site_otp_validation_form(null, null, null, $Tg, $Rn, $P8);
        goto WW;
        TW:
        wp_send_json(MoUtility::createJson($Tg, MoConstants::ERROR_JSON_TYPE));
        WW:
        CT:
    }
    public function _start_otp_verification($wE, $MQ, $TB, $Rn, $P8)
    {
        $vx = GatewayFunctions::instance();
        $H1 = $vx->mo_send_otp_token("\123\115\x53", '', $TB);
        switch ($H1["\x73\x74\x61\164\165\x73"]) {
            case "\123\125\103\103\x45\123\123":
                $this->_handle_otp_sent($wE, $MQ, $TB, $Rn, $P8, $H1);
                goto j0;
            default:
                $this->_handle_otp_sent_failed($wE, $MQ, $TB, $Rn, $P8, $H1);
                goto j0;
        }
        Iu:
        j0:
    }
    public function _handle_not_matched($TB, $Rn, $P8)
    {
        $Tg = str_replace("\x23\43\160\x68\x6f\x6e\145\x23\x23", $TB, $this->_get_otp_invalid_format_message());
        if ($this->_is_ajax_form()) {
            goto TE;
        }
        miniorange_site_otp_validation_form(null, null, null, $Tg, $Rn, $P8);
        goto ZR;
        TE:
        wp_send_json(MoUtility::createJson($Tg, MoConstants::ERROR_JSON_TYPE));
        ZR:
    }
    public function _handle_otp_sent_failed($wE, $MQ, $TB, $Rn, $P8, $H1)
    {
        $Tg = str_replace("\43\43\x70\150\x6f\156\x65\x23\x23", $TB, $this->_get_otp_sent_failed_message());
        if ($this->_is_ajax_form()) {
            goto sG;
        }
        miniorange_site_otp_validation_form(null, null, null, $Tg, $Rn, $P8);
        goto Da;
        sG:
        wp_send_json(MoUtility::createJson($Tg, MoConstants::ERROR_JSON_TYPE));
        Da:
    }
    public function _handle_otp_sent($wE, $MQ, $TB, $Rn, $P8, $H1)
    {
        SessionUtils::setPhoneTransactionID($H1["\x74\170\x49\144"]);
        if (!(MoUtility::micr() && MoUtility::isMG())) {
            goto Kc;
        }
        $Nl = get_mo_option("\x70\x68\x6f\x6e\145\137\164\x72\141\x6e\x73\x61\143\164\x69\157\156\163\137\162\145\x6d\141\151\156\x69\156\x67");
        if (!($Nl > 0)) {
            goto Ja;
        }
        update_mo_option("\160\x68\x6f\156\145\137\x74\162\x61\156\x73\141\x63\x74\x69\x6f\x6e\163\x5f\162\145\x6d\x61\151\156\151\x6e\147", $Nl - 1);
        Ja:
        Kc:
        $Tg = str_replace("\43\x23\x70\x68\157\156\x65\43\43", $TB, $this->_get_otp_sent_message());
        if ($this->_is_ajax_form()) {
            goto EI;
        }
        miniorange_site_otp_validation_form($wE, $MQ, $TB, $Tg, $Rn, $P8);
        goto TA;
        EI:
        wp_send_json(MoUtility::createJson($Tg, MoConstants::SUCCESS_JSON_TYPE));
        TA:
    }
    public function _get_otp_sent_message()
    {
        $bO = get_mo_option("\163\165\143\x63\145\163\163\x5f\x70\150\157\x6e\145\x5f\x6d\x65\163\x73\141\147\x65", "\x6d\157\x5f\157\164\160\137");
        return $bO ? $bO : MoMessages::showMessage(MoMessages::OTP_SENT_PHONE);
    }
    public function _get_otp_sent_failed_message()
    {
        $Jw = get_mo_option("\145\x72\162\157\x72\137\x70\150\x6f\156\x65\x5f\x6d\x65\x73\x73\x61\x67\145", "\155\157\x5f\157\x74\x70\137");
        return $Jw ? $Jw : MoMessages::showMessage(MoMessages::ERROR_OTP_PHONE);
    }
    public function _get_otp_invalid_format_message()
    {
        $sO = get_mo_option("\x69\x6e\x76\141\154\151\x64\x5f\x70\150\157\x6e\145\x5f\155\x65\x73\163\141\147\x65", "\155\x6f\137\157\164\160\x5f");
        return $sO ? $sO : MoMessages::showMessage(MoMessages::ERROR_PHONE_FORMAT);
    }
    public function _is_blocked($MQ, $TB)
    {
        $pz = explode("\73", get_mo_option("\x62\154\x6f\143\x6b\145\144\137\160\150\157\156\145\137\156\165\155\142\x65\x72\x73"));
        $pz = apply_filters("\x6d\157\x5f\x62\x6c\157\143\153\x65\x64\137\x70\x68\157\x6e\x65\163", $pz);
        return in_array($TB, $pz);
    }
    public function _get_is_blocked_message()
    {
        $ce = get_mo_option("\142\x6c\x6f\x63\x6b\145\144\137\x70\x68\x6f\x6e\x65\137\155\x65\x73\x73\x61\x67\x65", "\155\157\x5f\x6f\x74\x70\137");
        return $ce ? $ce : MoMessages::showMessage(MoMessages::ERROR_PHONE_BLOCKED);
    }
}
