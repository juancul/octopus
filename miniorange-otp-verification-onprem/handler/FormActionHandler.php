<?php


namespace OTP\Handler;

if (defined("\x41\x42\123\x50\101\124\x48")) {
    goto sBi;
}
die;
sBi:
use OTP\Helper\FormSessionVars;
use OTP\Helper\GatewayFunctions;
use OTP\Helper\MoMessages;
use OTP\Helper\MoPHPSessions;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\BaseActionHandler;
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
class FormActionHandler extends BaseActionHandler
{
    use Instance;
    function __construct()
    {
        parent::__construct();
        $this->_nonce = "\x6d\x6f\137\x66\157\x72\x6d\x5f\141\143\164\x69\157\x6e\x73";
        add_action("\151\156\151\164", array($this, "\150\141\x6e\x64\154\145\x46\157\x72\155\101\143\x74\x69\157\x6e\163"), 1);
        add_action("\x6d\157\137\166\x61\x6c\x69\144\141\x74\145\137\x6f\164\160", array($this, "\166\141\x6c\x69\x64\x61\x74\x65\x4f\124\x50"), 1, 3);
        add_action("\x6d\x6f\137\147\145\x6e\145\x72\141\x74\145\137\x6f\x74\160", array($this, "\x63\x68\x61\154\154\x65\x6e\x67\x65"), 2, 8);
        add_filter("\x6d\x6f\x5f\x66\x69\154\164\x65\162\137\x70\150\x6f\x6e\145\137\x62\x65\x66\157\162\145\137\141\x70\151\x5f\x63\141\x6c\x6c", array($this, "\x66\151\x6c\164\145\x72\x50\150\157\156\x65"), 1, 1);
    }
    public function challenge($wE, $MQ, $errors, $TB = null, $Rn = "\145\155\141\x69\x6c", $eW = '', $HL = null, $P8 = false)
    {
        $TB = MoUtility::processPhoneNumber($TB);
        MoPHPSessions::addSessionVar("\143\x75\x72\x72\x65\x6e\x74\x5f\x75\x72\x6c", MoUtility::currentPageUrl());
        MoPHPSessions::addSessionVar("\165\x73\145\162\137\x65\x6d\x61\x69\154", $MQ);
        MoPHPSessions::addSessionVar("\165\163\x65\162\137\x6c\x6f\147\x69\x6e", $wE);
        MoPHPSessions::addSessionVar("\165\163\x65\x72\137\x70\141\x73\x73\x77\157\162\144", $eW);
        MoPHPSessions::addSessionVar("\160\x68\157\156\145\137\x6e\165\x6d\142\145\162\x5f\155\x6f", $TB);
        MoPHPSessions::addSessionVar("\145\x78\164\162\x61\x5f\x64\x61\x74\141", $HL);
        $this->handleOTPAction($wE, $MQ, $TB, $Rn, $P8, $HL);
    }
    private function handleResendOTP($Rn, $P8)
    {
        $MQ = MoPHPSessions::getSessionVar("\165\x73\x65\x72\137\145\155\141\151\154");
        $wE = MoPHPSessions::getSessionVar("\165\163\145\162\137\154\x6f\147\151\x6e");
        $TB = MoPHPSessions::getSessionVar("\160\x68\x6f\x6e\x65\x5f\x6e\x75\155\x62\145\162\137\x6d\157");
        $HL = MoPHPSessions::getSessionVar("\145\170\x74\x72\141\x5f\144\x61\164\x61");
        $this->handleOTPAction($wE, $MQ, $TB, $Rn, $P8, $HL);
    }
    function handleOTPAction($wE, $MQ, $TB, $Rn, $P8, $HL)
    {
        global $phoneLogic, $emailLogic;
        switch ($Rn) {
            case VerificationType::PHONE:
                $phoneLogic->_handle_logic($wE, $MQ, $TB, $Rn, $P8);
                goto LBm;
            case VerificationType::EMAIL:
                $emailLogic->_handle_logic($wE, $MQ, $TB, $Rn, $P8);
                goto LBm;
            case VerificationType::BOTH:
                miniorange_verification_user_choice($wE, $MQ, $TB, MoMessages::showMessage(MoMessages::CHOOSE_METHOD), $Rn);
                goto LBm;
            case VerificationType::EXTERNAL:
                mo_external_phone_validation_form($HL["\143\165\162\154"], $MQ, $HL["\x6d\x65\x73\163\x61\x67\145"], $HL["\146\157\162\155"], $HL["\x64\141\x74\x61"]);
                goto LBm;
        }
        rPr:
        LBm:
    }
    function handleGoBackAction()
    {
        $u1 = MoPHPSessions::getSessionVar("\143\165\162\x72\145\x6e\164\x5f\165\x72\x6c");
        do_action("\x75\156\163\x65\164\137\163\145\x73\163\151\157\x6e\x5f\166\141\x72\x69\x61\x62\154\145");
        header("\x6c\x6f\x63\x61\x74\x69\157\x6e\x3a" . $u1);
    }
    function validateOTP($au, $z4, $fk)
    {
        $wE = MoPHPSessions::getSessionVar("\165\163\x65\162\137\154\x6f\147\151\156");
        $MQ = MoPHPSessions::getSessionVar("\165\163\x65\x72\137\145\x6d\141\x69\154");
        $TB = MoPHPSessions::getSessionVar("\x70\x68\x6f\156\x65\137\x6e\x75\x6d\x62\145\x72\137\155\x6f");
        $eW = MoPHPSessions::getSessionVar("\x75\x73\x65\x72\x5f\x70\141\x73\163\x77\157\x72\144");
        $HL = MoPHPSessions::getSessionVar("\x65\170\164\162\x61\x5f\x64\x61\164\141");
        $QA = Sessionutils::getTransactionId($au);
        $P6 = MoUtility::sanitizeCheck($z4, $_REQUEST);
        $P6 = !$P6 ? $fk : $P6;
        if (is_null($QA)) {
            goto vC2;
        }
        $vx = GatewayFunctions::instance();
        $H1 = $vx->mo_validate_otp_token($QA, $P6);
        switch ($H1["\163\164\141\x74\x75\x73"]) {
            case "\123\125\x43\x43\105\123\x53":
                $this->onValidationSuccess($wE, $MQ, $eW, $TB, $HL, $au);
                goto Xdi;
            default:
                $this->onValidationFailed($wE, $MQ, $TB, $au);
                goto Xdi;
        }
        Auf:
        Xdi:
        vC2:
    }
    private function onValidationSuccess($wE, $MQ, $eW, $TB, $HL, $au)
    {
        $WE = array_key_exists("\162\145\x64\x69\x72\145\143\164\137\164\157", $_POST) ? $_POST["\x72\145\144\x69\x72\145\143\164\137\164\157"] : '';
        do_action("\157\164\160\137\166\145\x72\151\x66\x69\x63\x61\164\x69\x6f\156\137\x73\165\143\143\145\163\x73\x66\165\x6c", $WE, $wE, $MQ, $eW, $TB, $HL, $au);
    }
    private function onValidationFailed($wE, $MQ, $TB, $au)
    {
        do_action("\157\164\160\137\166\x65\x72\151\x66\151\x63\x61\x74\151\157\x6e\137\146\141\x69\154\145\x64", $wE, $MQ, $TB, $au);
    }
    private function handleOTPChoice($Ir)
    {
        $gr = MoPHPSessions::getSessionVar("\x75\163\145\x72\x5f\x6c\157\x67\151\156");
        $W8 = MoPHPSessions::getSessionVar("\x75\x73\x65\x72\x5f\x65\x6d\x61\151\154");
        $hN = MoPHPSessions::getSessionVar("\160\150\157\x6e\145\137\156\x75\x6d\142\145\x72\137\x6d\157");
        $x6 = MoPHPSessions::getSessionVar("\x75\x73\145\x72\x5f\x70\x61\163\x73\x77\157\x72\x64");
        $lx = MoPHPSessions::getSessionVar("\x65\170\x74\x72\141\137\x64\141\164\x61");
        $CN = strcasecmp($Ir["\x6d\x6f\137\143\x75\x73\x74\157\155\145\162\137\166\x61\154\x69\144\x61\164\x69\x6f\x6e\x5f\157\x74\160\137\143\150\x6f\151\143\x65"], "\x75\x73\x65\162\137\x65\155\141\151\154\x5f\x76\x65\x72\x69\146\151\143\141\x74\151\157\156") == 0 ? VerificationType::EMAIL : VerificationType::PHONE;
        $this->challenge($gr, $W8, null, $hN, $CN, $x6, $lx, true);
    }
    function filterPhone($l1)
    {
        return str_replace("\53", '', $l1);
    }
    function handleFormActions()
    {
        if (!(array_key_exists("\157\x70\164\151\x6f\156", $_REQUEST) && MoUtility::micr())) {
            goto J0k;
        }
        $P8 = MoUtility::sanitizeCheck("\x66\x72\157\x6d\137\x62\157\x74\x68", $_POST);
        $au = MoUtility::sanitizeCheck("\x6f\164\x70\x5f\x74\x79\x70\145", $_POST);
        switch (trim($_REQUEST["\x6f\x70\x74\x69\157\156"])) {
            case "\166\x61\x6c\x69\x64\x61\164\151\157\156\x5f\147\157\102\141\x63\x6b":
                $this->handleGoBackAction();
                goto Ar1;
            case "\x6d\x69\x6e\x69\157\x72\x61\156\147\x65\x2d\166\141\154\x69\x64\x61\164\x65\x2d\x6f\x74\160\x2d\x66\x6f\162\x6d":
                $this->validateOTP($au, "\x6d\x6f\x5f\x6f\164\160\137\164\157\x6b\145\x6e", null);
                goto Ar1;
            case "\166\x65\x72\151\x66\151\x63\x61\x74\151\x6f\156\137\162\145\163\x65\x6e\144\x5f\157\164\x70":
                $this->handleResendOTP($au, $P8);
                goto Ar1;
            case "\155\x69\156\151\157\x72\141\x6e\x67\145\55\166\141\x6c\151\144\141\x74\x65\55\x6f\x74\160\x2d\x63\x68\x6f\151\x63\145\x2d\x66\x6f\162\155":
                $this->handleOTPChoice($_POST);
                goto Ar1;
        }
        nO4:
        Ar1:
        J0k:
    }
}
