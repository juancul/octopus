<?php


namespace OTP\Objects;

use OTP\Helper\MoConstants;
use OTP\Helper\MoMessages;
use OTP\Helper\MoUtility;
if (defined("\x41\102\123\120\101\124\x48")) {
    goto IU;
}
die;
IU:
abstract class Template extends BaseActionHandler implements MoITemplate
{
    protected $key;
    protected $templateEditorID;
    protected $nonce;
    protected $preview = FALSE;
    protected $jqueryUrl;
    protected $img;
    public $paneContent;
    public $messageDiv;
    protected $successMessageDiv;
    public static $templateEditor = array("\x77\x70\141\x75\164\157\x70" => false, "\155\145\x64\x69\141\x5f\x62\x75\x74\x74\x6f\x6e\163" => false, "\x74\x65\170\x74\141\162\x65\141\137\162\x6f\167\x73" => 20, "\x74\x61\x62\151\x6e\144\145\x78" => '', "\x74\141\x62\x66\157\x63\165\163\x5f\x65\x6c\145\x6d\145\156\164\x73" => "\x3a\160\162\x65\166\x2c\72\x6e\145\x78\x74", "\x65\x64\151\164\x6f\x72\137\x63\163\x73" => '', "\145\144\x69\x74\157\x72\x5f\x63\x6c\x61\x73\163" => '', "\x74\145\145\156\x79" => false, "\144\x66\167" => false, "\x74\151\156\x79\155\x63\145" => false, "\x71\x75\x69\143\153\x74\141\147\163" => true);
    protected $requiredTags = array("\x7b\173\x4a\121\125\105\122\x59\175\x7d", "\x7b\x7b\x47\117\137\x42\x41\x43\x4b\137\101\103\124\111\x4f\x4e\x5f\103\x41\114\x4c\x7d\x7d", "\x7b\173\106\x4f\x52\115\137\111\104\x7d\175", "\x7b\173\122\x45\121\125\111\122\105\x44\x5f\106\111\105\x4c\x44\123\x7d\x7d", "\x7b\173\122\x45\x51\x55\111\x52\x45\x44\137\106\x4f\122\115\123\x5f\x53\x43\x52\111\120\124\x53\x7d\175");
    protected function __construct()
    {
        parent::__construct();
        $this->jqueryUrl = "\x3c\163\x63\162\151\x70\x74\40\163\x72\143\x3d\x22\150\x74\x74\x70\163\x3a\x2f\57\x61\x6a\141\170\56\147\x6f\157\x67\x6c\x65\141\x70\x69\163\56\x63\x6f\155\x2f\141\x6a\141\170\57\154\x69\142\163\x2f\152\161\165\145\162\171\57\x31\56\61\62\x2e\x34\x2f\x6a\161\x75\145\x72\171\x2e\155\x69\x6e\x2e\x6a\x73\x22\x3e\74\57\163\x63\x72\151\160\164\x3e";
        $this->img = "\74\144\151\166\40\x73\164\171\154\x65\x3d\x27\144\151\x73\x70\154\141\x79\x3a\164\141\x62\154\145\x3b\164\x65\x78\x74\x2d\141\x6c\x69\x67\156\72\143\x65\156\164\x65\162\73\47\76" . "\74\x69\x6d\147\x20\x73\162\143\75\47\x7b\x7b\114\x4f\101\x44\x45\x52\137\103\123\126\x7d\175\x27\x3e" . "\x3c\57\x64\151\x76\76";
        $this->paneContent = "\x3c\x64\x69\166\x20\163\164\171\x6c\x65\75\x27\164\145\x78\x74\x2d\141\x6c\151\x67\156\72\143\x65\156\x74\145\x72\x3b\167\x69\144\x74\150\x3a\x20\x31\x30\60\45\73\150\x65\x69\147\150\x74\72\40\64\x35\60\160\170\x3b\x64\x69\163\160\154\x61\171\72\40\142\154\x6f\143\x6b\73" . "\x6d\141\x72\x67\151\156\55\x74\157\160\x3a\x20\x34\60\45\x3b\166\x65\x72\164\151\143\141\154\55\x61\x6c\151\x67\x6e\72\40\x6d\151\x64\x64\154\145\73\47\x3e" . "\x7b\x7b\103\117\116\124\x45\116\124\175\175" . "\x3c\x2f\144\151\166\76";
        $this->messageDiv = "\74\144\x69\166\x20\163\164\171\x6c\x65\75\47\x66\157\x6e\x74\55\163\x74\x79\x6c\145\x3a\x20\151\164\141\154\x69\x63\73\146\x6f\x6e\164\55\x77\x65\x69\147\x68\164\72\40\x36\x30\60\73\x63\157\154\x6f\x72\x3a\x20\43\x32\x33\62\x38\x32\144\73" . "\146\157\x6e\164\55\x66\141\155\x69\x6c\x79\x3a\x53\145\147\157\145\40\x55\x49\x2c\x48\145\x6c\166\145\x74\151\x63\141\x20\x4e\145\x75\x65\x2c\x73\x61\x6e\163\x2d\163\x65\x72\151\146\x3b" . "\x63\x6f\x6c\x6f\x72\72\43\71\x34\62\x38\62\x38\73\47\x3e" . "\x7b\173\115\x45\123\123\101\x47\x45\x7d\175" . "\x3c\57\x64\151\166\x3e";
        $this->successMessageDiv = "\x3c\144\151\x76\40\x73\x74\171\154\145\75\x27\x66\x6f\156\x74\55\163\164\171\154\x65\72\40\x69\164\x61\x6c\x69\143\x3b\x66\157\x6e\164\55\167\x65\x69\147\150\x74\x3a\40\x36\60\60\x3b\x63\157\154\157\x72\x3a\x20\x23\x32\x33\62\x38\x32\x64\x3b" . "\146\x6f\x6e\x74\55\146\141\155\x69\154\x79\x3a\x53\x65\x67\x6f\145\40\x55\x49\54\110\x65\x6c\166\x65\x74\151\x63\x61\x20\x4e\145\x75\x65\54\163\x61\156\163\x2d\x73\145\162\x69\x66\73\143\157\154\157\x72\72\43\x31\63\70\x61\63\x64\x3b\x27\x3e" . "\x7b\173\115\105\123\x53\101\x47\105\x7d\175" . "\74\x2f\x64\151\166\76";
        $this->img = str_replace("\x7b\x7b\114\117\101\104\105\122\137\x43\x53\x56\175\x7d", MOV_LOADER_URL, $this->img);
        $this->_nonce = "\155\157\137\x70\157\x70\x75\x70\x5f\x6f\x70\x74\x69\x6f\x6e\163";
        add_filter("\x6d\x6f\137\164\145\x6d\160\154\x61\x74\x65\137\x64\145\146\141\x75\x6c\x74\x73", array($this, "\147\145\x74\x44\x65\x66\x61\x75\x6c\164\163"), 1, 1);
        add_filter("\155\157\x5f\164\145\x6d\160\154\x61\164\x65\137\142\x75\151\x6c\144", array($this, "\142\x75\151\x6c\x64"), 1, 5);
        add_action("\141\x64\x6d\151\x6e\137\x70\157\x73\164\x5f\155\157\x5f\160\x72\145\166\151\145\x77\x5f\x70\157\160\x75\x70", array($this, "\163\x68\x6f\x77\120\x72\145\166\x69\145\167"));
        add_action("\x61\x64\155\151\x6e\x5f\160\157\x73\164\x5f\155\x6f\x5f\x70\157\x70\165\x70\137\x73\x61\166\x65", array($this, "\163\141\166\x65\x50\x6f\x70\165\x70"));
    }
    public function showPreview()
    {
        if (!(array_key_exists("\160\x6f\x70\165\x70\164\x79\160\x65", $_POST) && $_POST["\160\x6f\x70\165\160\164\171\160\145"] != $this->getTemplateKey())) {
            goto kF;
        }
        return;
        kF:
        if ($this->isValidRequest()) {
            goto qr;
        }
        return;
        qr:
        $Tg = "\74\x69\76" . mo_("\x50\x6f\160\125\x70\x20\115\x65\x73\x73\141\147\145\x20\163\x68\x6f\x77\x73\40\x75\160\40\150\145\162\x65\x2e") . "\x3c\57\x69\76";
        $Rn = VerificationType::TEST;
        $wD = stripslashes($_POST[$this->getTemplateEditorId()]);
        $P8 = false;
        $this->preview = TRUE;
        wp_send_json(MoUtility::createJson($this->parse($wD, $Tg, $Rn, $P8), MoConstants::SUCCESS_JSON_TYPE));
    }
    public function savePopup()
    {
        if (!(!$this->isTemplateType() || !$this->isValidRequest())) {
            goto Aq;
        }
        return;
        Aq:
        $wD = stripslashes($_POST[$this->getTemplateEditorId()]);
        $this->validateRequiredFields($wD);
        $Ha = maybe_unserialize(get_mo_option("\x63\x75\x73\164\157\155\x5f\160\157\x70\x75\x70\x73"));
        $Ha[$this->getTemplateKey()] = $wD;
        update_mo_option("\143\165\x73\164\157\155\x5f\160\x6f\x70\x75\160\x73", $Ha);
        wp_send_json(MoUtility::createJson($this->showSuccessMessage(MoMessages::showMessage(MoMessages::TEMPLATE_SAVED)), MoConstants::SUCCESS_JSON_TYPE));
    }
    public function build($wD, $oY, $Tg, $Rn, $P8)
    {
        if (!(strcasecmp($oY, $this->getTemplateKey()) != 0)) {
            goto JP;
        }
        return $wD;
        JP:
        $Ha = maybe_unserialize(get_mo_option("\143\x75\163\x74\x6f\155\x5f\x70\x6f\160\165\x70\163"));
        $wD = $Ha[$this->getTemplateKey()];
        return $this->parse($wD, $Tg, $Rn, $P8);
    }
    protected function validateRequiredFields($wD)
    {
        foreach ($this->requiredTags as $Xr) {
            if (!(strpos($wD, $Xr) === FALSE)) {
                goto fj;
            }
            $Tg = str_replace("\173\x7b\115\105\x53\x53\101\107\105\x7d\x7d", MoMessages::showMessage(MoMessages::REQUIRED_TAGS, array("\124\x41\x47" => $Xr)), $this->messageDiv);
            wp_send_json(MoUtility::createJson(str_replace("\173\x7b\103\117\116\x54\105\x4e\124\x7d\x7d", $Tg, $this->paneContent), MoConstants::ERROR_JSON_TYPE));
            fj:
            cA:
        }
        FK:
    }
    protected function showSuccessMessage($Tg)
    {
        $Tg = str_replace("\x7b\x7b\115\105\x53\x53\101\x47\x45\x7d\x7d", $Tg, $this->successMessageDiv);
        return str_replace("\x7b\x7b\x43\x4f\116\124\105\116\124\175\x7d", $Tg, $this->paneContent);
    }
    protected function showMessage($Tg)
    {
        $Tg = str_replace("\173\173\115\105\123\123\101\107\105\x7d\175", $Tg, $this->messageDiv);
        return str_replace("\x7b\173\103\117\x4e\124\x45\116\124\x7d\175", $Tg, $this->paneContent);
    }
    protected function isTemplateType()
    {
        return array_key_exists("\x70\x6f\x70\x75\x70\x74\x79\160\x65", $_POST) && strcasecmp($_POST["\160\x6f\160\x75\160\164\x79\160\x65"], $this->getTemplateKey()) == 0;
    }
    public function getTemplateKey()
    {
        return $this->key;
    }
    public function getTemplateEditorId()
    {
        return $this->templateEditorID;
    }
}
