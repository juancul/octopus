<?php


namespace OTP\Handler;

if (defined("\101\x42\x53\120\101\x54\x48")) {
    goto Mi4;
}
die;
Mi4:
use OTP\Helper\CountryList;
use OTP\Helper\GatewayFunctions;
use OTP\Helper\MoConstants;
use OTP\Helper\MocURLOTP;
use OTP\Helper\MoMessages;
use OTP\Helper\MoUtility;
use OTP\Objects\BaseActionHandler;
use OTP\Objects\PluginPageDetails;
use OTP\Objects\TabDetails;
use OTP\Objects\Tabs;
use OTP\Traits\Instance;
class MoOTPActionHandlerHandler extends BaseActionHandler
{
    use Instance;
    function __construct()
    {
        parent::__construct();
        $this->_nonce = "\155\x6f\x5f\x61\144\x6d\151\156\x5f\x61\x63\x74\x69\x6f\x6e\163";
        add_action("\141\x64\x6d\151\156\x5f\151\156\x69\164", array($this, "\x5f\x68\141\x6e\x64\x6c\x65\x5f\x61\x64\x6d\151\x6e\x5f\141\143\x74\151\157\x6e\163"), 1);
        add_action("\141\144\155\x69\156\137\x69\x6e\x69\x74", array($this, "\155\157\123\143\x68\145\144\165\154\x65\124\x72\x61\x6e\x73\141\x63\x74\151\x6f\156\123\x79\x6e\x63"), 1);
        add_action("\141\x64\x6d\x69\156\137\x69\x6e\151\164", array($this, "\143\150\145\x63\153\x49\x66\x50\x6f\x70\x75\x70\124\145\x6d\160\154\x61\164\145\101\162\145\123\145\164"), 1);
        add_filter("\x64\141\163\x68\142\x6f\x61\162\x64\137\x67\154\141\x6e\143\145\137\151\164\145\155\x73", array($this, "\157\x74\160\137\164\162\141\x6e\x73\141\x63\x74\x69\157\156\x73\x5f\147\x6c\x61\x6e\x63\x65\x5f\x63\157\165\156\x74\145\162"), 10, 1);
        add_action("\141\144\x6d\151\x6e\x5f\x70\x6f\x73\x74\x5f\155\x69\156\151\157\x72\141\x6e\x67\x65\137\x67\145\x74\x5f\x66\x6f\162\x6d\x5f\x64\x65\x74\x61\x69\154\163", array($this, "\x73\x68\157\x77\x46\157\x72\155\110\124\x4d\114\x44\141\x74\141"));
    }
    function _handle_admin_actions()
    {
        if (isset($_POST["\x6f\160\x74\x69\x6f\x6e"])) {
            goto TdY;
        }
        return;
        TdY:
        switch ($_POST["\157\160\x74\x69\157\x6e"]) {
            case "\155\x6f\137\x63\x75\x73\x74\x6f\x6d\145\162\137\x76\x61\154\x69\x64\x61\x74\x69\157\x6e\137\x73\145\164\x74\x69\156\x67\x73":
                $this->_save_settings($_POST);
                goto Ks3;
            case "\155\x6f\x5f\x63\x75\x73\x74\157\x6d\x65\x72\x5f\x76\141\x6c\x69\x64\x61\x74\151\x6f\156\x5f\155\145\163\163\141\147\x65\163":
                $this->_handle_custom_messages_form_submit($_POST);
                goto Ks3;
            case "\x6d\x6f\x5f\x76\141\154\x69\144\141\x74\x69\x6f\156\137\143\157\156\164\x61\x63\x74\x5f\165\163\137\161\165\145\162\x79\x5f\x6f\160\164\151\157\x6e":
                $this->_mo_validation_support_query($_POST);
                goto Ks3;
            case "\x6d\x6f\137\157\164\x70\137\145\x78\164\x72\x61\137\x73\145\x74\x74\x69\x6e\x67\x73":
                $this->_save_extra_settings($_POST);
                goto Ks3;
            case "\155\x6f\137\x6f\164\x70\x5f\x66\145\145\144\x62\x61\143\153\137\x6f\160\x74\x69\157\x6e":
                $this->_mo_validation_feedback_query();
                goto Ks3;
            case "\x63\x68\x65\x63\x6b\137\155\x6f\x5f\x6c\156":
                $this->_mo_check_l();
                goto Ks3;
            case "\155\x6f\137\143\x75\x73\164\157\155\x65\x72\x5f\166\x61\154\x69\x64\141\164\151\157\x6e\x5f\163\x6d\163\137\x63\x6f\156\146\151\147\165\x72\x61\164\151\x6f\156":
                $this->_mo_configure_sms_template($_POST);
                goto Ks3;
            case "\x6d\157\x5f\x63\165\x73\x74\157\x6d\145\x72\137\166\141\154\x69\144\x61\x74\x69\x6f\156\x5f\145\x6d\141\151\x6c\137\143\x6f\156\146\x69\147\x75\162\x61\164\151\157\x6e":
                $this->_mo_configure_email_template($_POST);
                goto Ks3;
        }
        I9b:
        Ks3:
    }
    function _handle_custom_messages_form_submit($post)
    {
        $this->isValidRequest();
        update_mo_option("\x73\165\143\143\145\163\163\137\x65\x6d\x61\x69\154\x5f\x6d\145\163\163\x61\147\x65", MoUtility::sanitizeCheck("\157\164\x70\137\163\x75\x63\x63\x65\163\163\137\145\x6d\x61\151\x6c", $post), "\155\x6f\137\157\164\x70\137");
        update_mo_option("\x73\165\143\x63\145\x73\163\137\x70\150\157\x6e\x65\x5f\155\x65\x73\163\x61\x67\x65", MoUtility::sanitizeCheck("\157\x74\160\137\x73\165\143\143\x65\163\x73\x5f\160\x68\157\156\145", $post), "\x6d\x6f\137\157\164\160\x5f");
        update_mo_option("\145\x72\x72\157\162\x5f\160\150\157\x6e\145\137\x6d\x65\x73\163\141\147\x65", MoUtility::sanitizeCheck("\157\164\160\x5f\x65\162\x72\x6f\x72\x5f\x70\150\157\x6e\x65", $post), "\x6d\157\137\x6f\164\x70\137");
        update_mo_option("\145\x72\x72\157\x72\x5f\x65\x6d\141\x69\154\137\155\x65\163\163\141\147\x65", MoUtility::sanitizeCheck("\x6f\x74\x70\137\x65\x72\x72\157\162\x5f\145\155\x61\x69\x6c", $post), "\x6d\x6f\x5f\x6f\x74\160\137");
        update_mo_option("\x69\156\x76\141\154\151\144\137\x70\x68\157\156\145\x5f\155\145\x73\x73\141\147\x65", MoUtility::sanitizeCheck("\x6f\x74\160\137\x69\x6e\166\x61\x6c\x69\x64\x5f\160\x68\157\x6e\145", $post), "\155\x6f\137\x6f\164\160\x5f");
        update_mo_option("\x69\x6e\166\x61\x6c\x69\x64\137\x65\155\141\x69\x6c\137\155\145\x73\x73\x61\x67\145", MoUtility::sanitizeCheck("\157\x74\x70\x5f\x69\156\166\x61\x6c\151\144\x5f\145\x6d\141\x69\x6c", $post), "\x6d\157\137\157\x74\160\x5f");
        update_mo_option("\x69\x6e\x76\x61\154\x69\x64\x5f\155\x65\x73\163\x61\x67\145", MoUtility::sanitizeCheck("\x69\x6e\166\x61\x6c\x69\144\x5f\157\164\x70", $post), "\155\157\137\157\164\160\x5f");
        update_mo_option("\142\154\x6f\143\153\x65\x64\x5f\x65\x6d\x61\x69\154\137\x6d\x65\163\163\141\147\x65", MoUtility::sanitizeCheck("\157\x74\160\137\142\x6c\x6f\x63\153\x65\144\137\145\x6d\141\x69\154", $post), "\155\157\x5f\x6f\x74\x70\x5f");
        update_mo_option("\142\x6c\x6f\x63\x6b\145\144\137\x70\x68\x6f\x6e\x65\137\x6d\145\163\163\x61\x67\x65", MoUtility::sanitizeCheck("\157\x74\x70\137\142\154\157\143\153\145\144\137\160\150\x6f\156\145", $post), "\x6d\x6f\137\157\x74\160\x5f");
        do_action("\155\157\137\x72\145\x67\x69\163\x74\162\141\x74\x69\157\x6e\137\163\x68\x6f\167\x5f\x6d\x65\163\x73\x61\147\145", MoMessages::showMessage(MoMessages::MSG_TEMPLATE_SAVED), "\x53\x55\103\103\x45\x53\x53");
    }
    function _save_settings($T3)
    {
        $l4 = TabDetails::instance();
        $b6 = $l4->_tabDetails[Tabs::FORMS];
        $this->isValidRequest();
        if (!(MoUtility::sanitizeCheck("\x70\x61\x67\145", $_GET) !== $b6->_menuSlug && $T3["\145\x72\x72\157\162\x5f\155\145\x73\x73\x61\147\145"])) {
            goto xZA;
        }
        do_action("\x6d\x6f\137\x72\x65\147\151\163\164\x72\141\x74\151\x6f\156\137\x73\150\x6f\167\137\155\145\163\163\141\147\145", MoMessages::showMessage($T3["\x65\162\x72\157\162\x5f\x6d\145\163\163\141\x67\145"]), "\x45\122\122\117\122");
        xZA:
    }
    function _save_extra_settings($T3)
    {
        $this->isValidRequest();
        delete_site_option("\144\145\x66\141\x75\154\164\x5f\143\x6f\x75\156\x74\162\x79\137\143\157\144\145");
        $FD = isset($T3["\144\145\x66\141\165\x6c\164\x5f\x63\157\165\x6e\x74\x72\171\x5f\143\157\144\145"]) ? $T3["\x64\145\146\141\165\x6c\x74\x5f\143\x6f\x75\x6e\x74\x72\x79\137\143\157\x64\x65"] : '';
        update_mo_option("\x64\145\x66\141\165\x6c\164\x5f\x63\x6f\165\156\164\162\x79", maybe_serialize(CountryList::$countries[$FD]));
        update_mo_option("\x62\154\x6f\143\153\x65\x64\137\144\x6f\x6d\141\x69\x6e\x73", MoUtility::sanitizeCheck("\155\x6f\x5f\157\x74\160\x5f\142\x6c\157\x63\153\x65\144\x5f\145\x6d\141\151\x6c\137\144\157\155\141\151\156\x73", $T3));
        update_mo_option("\142\x6c\157\143\x6b\x65\x64\137\160\x68\157\156\145\x5f\156\x75\x6d\x62\145\162\163", MoUtility::sanitizeCheck("\x6d\x6f\x5f\157\164\160\x5f\142\x6c\157\x63\x6b\145\x64\137\160\150\x6f\156\145\x5f\x6e\x75\155\142\x65\162\x73", $T3));
        update_mo_option("\163\150\157\167\137\162\x65\x6d\141\x69\x6e\x69\x6e\x67\x5f\x74\x72\141\156\x73", MoUtility::sanitizeCheck("\x6d\x6f\137\163\x68\157\167\137\162\x65\x6d\141\151\x6e\151\156\x67\x5f\164\x72\141\x6e\163", $T3));
        update_mo_option("\163\150\157\167\137\x64\162\x6f\160\x64\157\x77\x6e\137\157\x6e\137\x66\157\x72\155", MoUtility::sanitizeCheck("\x73\x68\157\x77\x5f\x64\x72\157\x70\x64\157\167\x6e\x5f\157\x6e\137\x66\157\x72\x6d", $T3));
        update_mo_option("\157\x74\160\137\154\x65\x6e\147\x74\150", MoUtility::sanitizeCheck("\x6d\x6f\x5f\157\x74\160\137\154\x65\x6e\x67\x74\x68", $T3));
        update_mo_option("\157\164\160\x5f\166\141\154\x69\144\x69\x74\171", MoUtility::sanitizeCheck("\155\x6f\x5f\x6f\164\160\x5f\166\x61\154\x69\144\x69\x74\171", $T3));
        do_action("\155\x6f\137\162\x65\x67\x69\163\x74\x72\141\164\151\x6f\156\x5f\x73\150\x6f\167\137\155\145\x73\x73\x61\x67\145", MoMessages::showMessage(MoMessages::EXTRA_SETTINGS_SAVED), "\x53\125\x43\x43\105\x53\123");
    }
    function _mo_validation_support_query($Ir)
    {
        $Vy = MoUtility::sanitizeCheck("\x71\165\145\x72\171\x5f\x65\x6d\141\x69\154", $Ir);
        $Zy = MoUtility::sanitizeCheck("\161\165\145\162\171", $Ir);
        $l1 = MoUtility::sanitizeCheck("\x71\165\145\162\x79\137\x70\150\x6f\156\x65", $Ir);
        if (!(!$Vy || !$Zy)) {
            goto Ah0;
        }
        do_action("\155\x6f\137\x72\x65\147\x69\163\x74\x72\141\x74\151\x6f\156\x5f\163\150\x6f\x77\x5f\155\145\163\163\141\x67\x65", MoMessages::showMessage(MoMessages::SUPPORT_FORM_VALUES), "\105\122\x52\117\x52");
        return;
        Ah0:
        $Kl = MocURLOTP::submit_contact_us($Vy, $l1, $Zy);
        if (!(json_last_error() == JSON_ERROR_NONE && $Kl)) {
            goto v8K;
        }
        do_action("\155\x6f\137\x72\145\x67\151\163\164\162\x61\164\151\x6f\156\x5f\163\150\157\x77\x5f\155\145\163\163\141\x67\145", MoMessages::showMessage(MoMessages::SUPPORT_FORM_SENT), "\x53\x55\x43\103\105\x53\x53");
        return;
        v8K:
        do_action("\155\157\x5f\162\x65\147\151\163\164\x72\x61\164\151\x6f\156\x5f\x73\x68\157\x77\137\x6d\145\163\x73\x61\147\x65", MoMessages::showMessage(MoMessages::SUPPORT_FORM_ERROR), "\105\122\122\117\x52");
    }
    public function otp_transactions_glance_counter()
    {
        if (!(!MoUtility::micr() || !MoUtility::isMG())) {
            goto N9W;
        }
        return;
        N9W:
        $Vy = get_mo_option("\145\x6d\x61\x69\x6c\x5f\164\162\141\156\163\141\x63\164\151\157\156\163\x5f\x72\x65\x6d\141\x69\156\151\x6e\147");
        $l1 = get_mo_option("\160\x68\157\x6e\145\137\164\162\141\x6e\x73\141\143\x74\151\157\x6e\163\x5f\x72\145\155\x61\x69\156\151\x6e\147");
        echo "\74\154\151\x20\x63\x6c\x61\163\163\75\47\x6d\x6f\x2d\x74\162\141\x6e\x73\x2d\143\157\165\x6e\x74\x27\x3e\74\141\x20\150\x72\x65\x66\75\47" . admin_url() . "\141\x64\x6d\x69\156\x2e\x70\150\x70\77\160\x61\147\x65\x3d\x6d\157\163\x65\164\164\151\156\147\x73\x27\76" . MoMessages::showMessage(MoMessages::TRANS_LEFT_MSG, array("\x65\x6d\x61\x69\x6c" => $Vy, "\160\150\x6f\x6e\145" => $l1)) . "\x3c\x2f\141\76\x3c\57\x6c\x69\76";
    }
    public function checkIfPopupTemplateAreSet()
    {
        $Ha = maybe_unserialize(get_mo_option("\x63\x75\x73\x74\x6f\x6d\x5f\160\x6f\160\x75\x70\x73"));
        if (!empty($Ha)) {
            goto Sws;
        }
        $JA = apply_filters("\155\157\137\x74\x65\155\x70\x6c\x61\164\145\137\x64\145\146\x61\165\x6c\x74\163", array());
        update_mo_option("\143\x75\163\x74\x6f\155\x5f\160\157\x70\165\x70\163", maybe_serialize($JA));
        Sws:
    }
    public function showFormHTMLData()
    {
        $this->isValidRequest();
        $x0 = $_POST["\146\x6f\x72\x6d\137\156\141\155\145"];
        $PX = MOV_DIR . "\143\157\156\164\162\x6f\154\x6c\x65\162\163\x2f";
        $i4 = !MoUtility::micr() ? "\x64\x69\x73\x61\142\x6c\x65\x64" : '';
        $Vx = admin_url() . "\x65\144\151\x74\56\160\150\160\77\x70\157\163\x74\x5f\164\171\160\x65\x3d\160\141\147\145";
        ob_start();
        include $PX . "\x66\x6f\x72\x6d\163\x2f" . $x0 . "\x2e\x70\150\160";
        $GM = ob_get_clean();
        wp_send_json(MoUtility::createJson($GM, MoConstants::SUCCESS_JSON_TYPE));
    }
    function moScheduleTransactionSync()
    {
        if (!(!wp_next_scheduled("\150\157\x75\162\x6c\x79\123\x79\156\x63") && MoUtility::micr())) {
            goto Oxy;
        }
        wp_schedule_event(time(), "\x64\x61\x69\154\x79", "\150\x6f\165\x72\x6c\x79\x53\171\156\x63");
        Oxy:
    }
    function _mo_validation_feedback_query()
    {
        $this->isValidRequest();
        $gp = $_POST["\x6d\x69\x6e\x69\157\x72\141\156\147\145\137\146\x65\x65\x64\142\x61\143\x6b\x5f\163\165\142\x6d\x69\164"];
        if (!($gp === "\123\x6b\x69\x70\40\x26\x20\x44\145\141\x63\x74\x69\166\141\164\145")) {
            goto FaI;
        }
        deactivate_plugins(array(MOV_PLUGIN_NAME));
        return;
        FaI:
        $xc = strcasecmp($_POST["\160\154\165\147\151\156\137\x64\145\x61\143\x74\x69\x76\x61\164\x65\144"], "\x74\x72\x75\x65") == 0;
        $qf = !$xc ? mo_("\133\x20\x50\x6c\165\147\151\156\x20\106\145\x65\144\142\141\x63\153\x20\135\x20\x3a\40") : mo_("\x5b\x20\120\154\x75\147\151\x6e\x20\104\x65\x61\143\x74\151\166\x61\164\145\x64\40\135");
        $rl = sanitize_text_field($_POST["\x71\x75\145\162\171\137\x66\x65\x65\x64\142\141\143\x6b"]);
        $YZ = file_get_contents(MOV_DIR . "\151\x6e\x63\x6c\165\x64\145\163\57\150\x74\x6d\154\x2f\146\x65\x65\x64\x62\141\143\153\56\155\151\x6e\56\x68\164\155\x6c");
        $current_user = wp_get_current_user();
        $zV = MoUtility::micv() ? "\x50\x72\x65\x6d\x69\165\x6d" : "\106\x72\145\145";
        $Vy = get_mo_option("\x61\144\155\151\x6e\x5f\x65\x6d\x61\x69\x6c");
        $YZ = str_replace("\x7b\173\106\111\x52\123\124\137\x4e\x41\x4d\x45\x7d\175", $current_user->first_name, $YZ);
        $YZ = str_replace("\173\173\x4c\x41\123\x54\137\116\x41\115\x45\x7d\175", $current_user->last_name, $YZ);
        $YZ = str_replace("\x7b\x7b\x50\114\125\107\111\x4e\137\124\131\x50\x45\175\x7d", MOV_TYPE . "\x3a" . $zV, $YZ);
        $YZ = str_replace("\173\173\123\x45\122\x56\x45\122\175\175", $_SERVER["\x53\105\x52\x56\x45\x52\137\x4e\x41\x4d\105"], $YZ);
        $YZ = str_replace("\173\173\x45\115\x41\111\114\175\x7d", $Vy, $YZ);
        $YZ = str_replace("\173\x7b\120\x4c\125\107\x49\116\x7d\x7d", MoConstants::AREA_OF_INTEREST, $YZ);
        $YZ = str_replace("\173\173\x56\105\x52\123\111\117\x4e\x7d\x7d", MOV_VERSION, $YZ);
        $YZ = str_replace("\173\x7b\x54\x59\x50\x45\x7d\175", $qf, $YZ);
        $YZ = str_replace("\x7b\x7b\x46\105\x45\x44\x42\101\x43\x4b\x7d\x7d", $rl, $YZ);
        $Ji = MoUtility::send_email_notif($Vy, "\130\x65\143\x75\162\151\146\x79", MoConstants::FEEDBACK_EMAIL, "\127\157\x72\144\120\162\145\163\163\40\x4f\x54\x50\x20\x56\145\x72\151\146\x69\x63\x61\x74\151\157\156\40\x50\154\x75\x67\151\x6e\x20\x46\x65\x65\144\142\x61\143\x6b", $YZ);
        if ($Ji) {
            goto AeX;
        }
        do_action("\155\x6f\x5f\162\x65\147\151\x73\x74\162\x61\164\x69\157\156\137\163\x68\157\167\137\x6d\x65\x73\x73\x61\147\x65", MoMessages::showMessage(MoMessages::FEEDBACK_ERROR), "\x45\x52\122\x4f\122");
        goto Val;
        AeX:
        do_action("\155\157\x5f\x72\x65\x67\151\163\164\x72\141\x74\151\x6f\x6e\x5f\163\x68\157\167\137\x6d\x65\x73\x73\x61\x67\x65", MoMessages::showMessage(MoMessages::FEEDBACK_SENT), "\x53\x55\103\103\105\x53\x53");
        Val:
        if (!$xc) {
            goto gC1;
        }
        deactivate_plugins(array(MOV_PLUGIN_NAME));
        gC1:
    }
    function _mo_check_l()
    {
        $this->isValidRequest();
        MoUtility::_handle_mo_check_ln(true, get_mo_option("\141\x64\155\151\156\x5f\143\165\163\x74\157\x6d\145\x72\137\x6b\145\171"), get_mo_option("\x61\x64\x6d\151\156\137\141\160\151\x5f\x6b\145\x79"));
    }
    function _mo_configure_sms_template($T3)
    {
        $vx = GatewayFunctions::instance();
        $vx->_mo_configure_sms_template($T3);
    }
    function _mo_configure_email_template($T3)
    {
        $vx = GatewayFunctions::instance();
        $vx->_mo_configure_email_template($T3);
    }
}
