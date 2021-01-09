<?php


namespace OTP;

use OTP\Handler\EmailVerificationLogic;
use OTP\Handler\FormActionHandler;
use OTP\Handler\MoOTPActionHandlerHandler;
use OTP\Handler\MoRegistrationHandler;
use OTP\Handler\PhoneVerificationLogic;
use OTP\Helper\CountryList;
use OTP\Helper\GatewayFunctions;
use OTP\Helper\MenuItems;
use OTP\Helper\MoConstants;
use OTP\Helper\MoDisplayMessages;
use OTP\Helper\MoMessages;
use OTP\Helper\MoUtility;
use OTP\Helper\MOVisualTour;
use OTP\Helper\PolyLangStrings;
use OTP\Helper\Templates\DefaultPopup;
use OTP\Helper\Templates\ErrorPopup;
use OTP\Helper\Templates\ExternalPopup;
use OTP\Helper\Templates\UserChoicePopup;
use OTP\Objects\PluginPageDetails;
use OTP\Objects\TabDetails;
use OTP\Objects\Tabs;
use OTP\Traits\Instance;
use OTP\Helper\MoAddonListContent;
if (defined("\x41\102\x53\x50\x41\x54\x48")) {
    goto v2;
}
die;
v2:
final class MoOTP
{
    use Instance;
    private function __construct()
    {
        $this->initializeHooks();
        $this->initializeGlobals();
        $this->initializeHelpers();
        $this->initializeHandlers();
        $this->registerPolyLangStrings();
        $this->registerAddOns();
    }
    private function initializeHooks()
    {
        add_action("\160\x6c\165\147\x69\x6e\x73\x5f\154\157\141\x64\145\144", array($this, "\157\164\x70\x5f\154\x6f\141\144\x5f\x74\x65\x78\164\144\x6f\x6d\x61\151\156"));
        add_action("\141\144\155\x69\156\137\x6d\145\156\x75", array($this, "\x6d\151\156\x69\x6f\162\141\x6e\147\x65\x5f\x63\x75\x73\x74\157\155\145\162\137\x76\x61\154\151\x64\141\164\151\x6f\x6e\x5f\155\x65\x6e\165"));
        add_action("\141\144\155\151\x6e\x5f\x65\156\161\165\x65\x75\x65\x5f\x73\x63\162\x69\160\x74\163", array($this, "\x6d\157\x5f\162\145\147\x69\x73\x74\162\141\164\x69\157\156\137\x70\154\x75\x67\x69\x6e\x5f\x73\145\x74\164\151\x6e\147\163\x5f\163\x74\171\x6c\145"));
        add_action("\x61\144\155\x69\156\137\145\x6e\161\165\x65\165\145\x5f\163\143\162\151\160\x74\163", array($this, "\155\x6f\137\x72\145\x67\151\x73\x74\x72\141\x74\x69\x6f\156\137\x70\154\x75\x67\x69\x6e\137\x73\145\164\164\151\156\x67\x73\x5f\x73\143\162\x69\160\164"));
        add_action("\x77\160\x5f\145\x6e\161\165\145\x75\x65\x5f\163\143\x72\x69\x70\164\163", array($this, "\x6d\x6f\x5f\162\145\147\151\163\164\x72\141\164\x69\x6f\156\x5f\x70\x6c\x75\x67\151\x6e\137\x66\162\x6f\156\164\x65\x6e\x64\x5f\163\x63\x72\151\160\x74\x73"), 99);
        add_action("\154\157\147\151\x6e\x5f\x65\x6e\161\x75\x65\x75\x65\137\x73\143\x72\x69\x70\164\x73", array($this, "\155\157\137\162\x65\x67\151\x73\x74\162\x61\x74\x69\157\156\x5f\160\154\x75\147\151\156\137\x66\x72\x6f\x6e\164\x65\156\144\137\x73\143\x72\x69\160\164\163"), 99);
        add_action("\x6d\157\x5f\x72\145\147\151\x73\164\162\x61\164\x69\x6f\x6e\x5f\163\150\157\x77\137\155\145\163\163\141\147\x65", array($this, "\x6d\157\x5f\163\x68\157\x77\137\x6f\164\160\x5f\155\145\163\x73\141\147\145"), 1, 2);
        add_action("\150\x6f\165\x72\x6c\x79\123\171\156\x63", array($this, "\150\157\165\162\x6c\171\123\x79\156\143"));
        add_action("\x61\x64\x6d\x69\156\137\146\157\x6f\164\x65\162", array($this, "\146\x65\x65\x64\142\x61\143\x6b\x5f\x72\x65\161\x75\145\x73\x74"));
        add_filter("\x77\160\x5f\x6d\x61\x69\x6c\137\146\x72\x6f\x6d\x5f\156\x61\x6d\x65", array($this, "\x63\165\x73\x74\x6f\x6d\x5f\x77\160\137\155\141\x69\154\137\146\162\157\x6d\x5f\156\141\155\145"));
        add_filter("\160\x6c\165\x67\x69\x6e\137\x72\x6f\x77\x5f\155\145\x74\x61", array($this, "\x6d\157\137\x6d\x65\164\x61\x5f\154\x69\x6e\x6b\163"), 10, 2);
        add_action("\x77\x70\x5f\145\x6e\x71\165\x65\x75\x65\137\163\x63\x72\x69\160\164\x73", array($this, "\154\157\141\x64\137\152\161\x75\145\x72\x79\137\157\x6e\x5f\146\x6f\x72\x6d\163"));
        add_action("\160\154\x75\147\x69\x6e\x5f\x61\143\164\x69\157\156\x5f\154\x69\x6e\153\163\137" . MOV_PLUGIN_NAME, array($this, "\160\154\165\147\x69\156\x5f\141\x63\x74\151\157\x6e\137\154\x69\x6e\153\x73"), 10, 1);
    }
    function load_jquery_on_forms()
    {
        if (wp_script_is("\152\x71\165\x65\x72\x79", "\145\156\161\x75\145\165\x65\x64")) {
            goto M5;
        }
        wp_enqueue_script("\x6a\x71\165\145\x72\171");
        M5:
    }
    private function initializeHelpers()
    {
        MoMessages::instance();
        MoAddonListContent::instance();
        PolyLangStrings::instance();
        MOVisualTour::instance();
    }
    private function initializeHandlers()
    {
        FormActionHandler::instance();
        MoOTPActionHandlerHandler::instance();
        DefaultPopup::instance();
        ErrorPopup::instance();
        ExternalPopup::instance();
        UserChoicePopup::instance();
        MoRegistrationHandler::instance();
    }
    private function initializeGlobals()
    {
        global $phoneLogic, $emailLogic;
        $phoneLogic = PhoneVerificationLogic::instance();
        $emailLogic = EmailVerificationLogic::instance();
    }
    function miniorange_customer_validation_menu()
    {
        MenuItems::instance();
    }
    function mo_customer_validation_options()
    {
        include MOV_DIR . "\x63\157\156\x74\x72\x6f\154\154\x65\162\x73\x2f\155\x61\151\156\55\143\157\x6e\x74\162\x6f\x6c\154\145\162\56\160\150\160";
    }
    function mo_registration_plugin_settings_style()
    {
        wp_enqueue_style("\155\x6f\137\x63\x75\x73\x74\157\x6d\x65\162\137\x76\141\x6c\151\x64\141\x74\151\x6f\156\x5f\141\144\x6d\x69\x6e\x5f\163\x65\x74\x74\x69\156\x67\x73\137\163\164\x79\154\145", MOV_CSS_URL);
        wp_enqueue_style("\155\x6f\x5f\x63\165\163\x74\157\x6d\x65\162\137\166\141\154\151\x64\x61\x74\x69\157\156\x5f\151\156\x74\164\x65\x6c\x69\156\160\165\164\137\x73\x74\x79\x6c\145", MO_INTTELINPUT_CSS);
    }
    function mo_registration_plugin_settings_script()
    {
        wp_enqueue_script("\x6d\157\x5f\143\x75\163\x74\x6f\155\x65\162\137\166\141\154\151\144\141\x74\151\157\x6e\137\x61\x64\155\x69\x6e\x5f\163\145\164\164\151\x6e\147\163\x5f\x73\143\x72\151\x70\x74", MOV_JS_URL, array("\152\x71\165\145\162\x79"));
        wp_enqueue_script("\155\x6f\137\143\165\x73\164\x6f\x6d\x65\162\137\x76\x61\154\x69\x64\x61\x74\151\x6f\x6e\137\x66\157\x72\155\137\166\141\154\151\144\141\x74\151\x6f\x6e\137\163\x63\x72\x69\160\x74", VALIDATION_JS_URL, array("\152\161\165\145\x72\x79"));
        wp_enqueue_script("\x6d\157\137\143\165\x73\164\x6f\x6d\145\x72\137\166\141\x6c\x69\x64\141\x74\151\x6f\156\137\x69\x6e\x74\x74\145\x6c\151\x6e\x70\x75\x74\137\163\143\x72\x69\x70\x74", MO_INTTELINPUT_JS, array("\152\x71\165\x65\x72\x79"));
    }
    function mo_registration_plugin_frontend_scripts()
    {
        if (get_mo_option("\163\x68\157\x77\x5f\144\x72\x6f\160\x64\x6f\167\x6e\x5f\157\156\x5f\146\x6f\x72\155")) {
            goto EZ;
        }
        return;
        EZ:
        $sq = apply_filters("\x6d\x6f\x5f\x70\x68\x6f\156\x65\137\144\x72\x6f\x70\144\157\x77\x6e\x5f\163\145\x6c\145\x63\164\157\162", array());
        if (!MoUtility::isBlank($sq)) {
            goto cH;
        }
        return;
        cH:
        $sq = array_unique($sq);
        wp_enqueue_script("\155\157\137\x63\x75\x73\164\x6f\x6d\145\x72\137\166\141\154\151\144\141\164\x69\x6f\156\137\x69\156\x74\164\145\154\151\x6e\x70\x75\x74\137\x73\x63\162\x69\x70\164", MO_INTTELINPUT_JS, array("\x6a\161\165\145\162\x79"));
        wp_enqueue_style("\x6d\x6f\x5f\x63\165\x73\x74\157\155\145\162\137\166\x61\154\x69\144\x61\x74\151\157\x6e\137\x69\156\164\164\145\x6c\x69\156\160\165\x74\137\163\164\171\x6c\x65", MO_INTTELINPUT_CSS);
        wp_register_script("\x6d\157\x5f\x63\165\x73\x74\157\155\145\162\x5f\166\141\x6c\151\144\141\x74\151\157\x6e\x5f\144\x72\x6f\160\x64\157\167\156\137\x73\x63\x72\x69\x70\x74", MO_DROPDOWN_JS, array("\152\x71\x75\145\162\171"), MOV_VERSION, true);
        wp_localize_script("\x6d\x6f\137\x63\x75\x73\164\x6f\x6d\x65\162\x5f\166\141\x6c\x69\x64\141\x74\151\157\156\137\144\x72\x6f\160\144\157\x77\156\137\x73\x63\x72\151\x70\x74", "\x6d\157\x64\162\x6f\x70\144\157\x77\x6e\x76\141\162\x73", array("\163\x65\x6c\145\143\164\157\162" => json_encode($sq), "\x64\145\x66\x61\x75\x6c\164\x43\157\165\x6e\164\162\171" => CountryList::getDefaultCountryIsoCode(), "\157\x6e\x6c\171\x43\x6f\165\156\164\162\x69\x65\163" => CountryList::getOnlyCountryList()));
        wp_enqueue_script("\x6d\x6f\137\143\165\x73\164\x6f\x6d\145\x72\x5f\x76\x61\154\151\144\141\x74\x69\157\156\137\x64\x72\157\x70\144\x6f\167\x6e\x5f\163\143\162\x69\x70\164");
    }
    function mo_show_otp_message($H1, $qf)
    {
        new MoDisplayMessages($H1, $qf);
    }
    function otp_load_textdomain()
    {
        load_plugin_textdomain("\x6d\151\x6e\x69\x6f\x72\141\156\x67\145\55\x6f\x74\x70\x2d\x76\145\162\x69\x66\151\143\x61\x74\x69\157\156", FALSE, dirname(plugin_basename(__FILE__)) . "\x2f\154\141\x6e\147\x2f");
        do_action("\155\157\137\x6f\164\x70\x5f\166\x65\162\x69\146\151\x63\x61\x74\151\x6f\x6e\137\x61\144\x64\137\157\x6e\137\154\x61\x6e\147\x5f\x66\x69\x6c\x65\163");
    }
    private function registerPolylangStrings()
    {
        if (MoUtility::_is_polylang_installed()) {
            goto mi;
        }
        return;
        mi:
        foreach (unserialize(MO_POLY_STRINGS) as $O5 => $Xd) {
            pll_register_string($O5, $Xd, "\155\151\156\x69\157\x72\141\x6e\x67\x65\x2d\x6f\x74\x70\55\166\145\162\x69\146\x69\x63\x61\164\151\x6f\156");
            DE:
        }
        IH:
    }
    private function registerAddOns()
    {
        $vx = GatewayFunctions::instance();
        $vx->registerAddOns();
    }
    function feedback_request()
    {
        include MOV_DIR . "\x63\157\x6e\164\x72\157\154\x6c\145\x72\x73\x2f\146\145\x65\x64\142\141\x63\x6b\x2e\x70\150\x70";
    }
    function mo_meta_links($E4, $t0)
    {
        if (!(MOV_PLUGIN_NAME === $t0)) {
            goto PA;
        }
        $E4[] = "\74\163\160\x61\x6e\40\x63\x6c\x61\163\163\75\x27\x64\x61\x73\x68\x69\143\157\156\163\x20\144\x61\x73\150\x69\143\x6f\x6e\x73\55\x73\x74\x69\x63\x6b\x79\47\76\x3c\57\163\x70\x61\156\x3e\xd\xa\x20\40\40\x20\x20\x20\x20\40\40\x20\40\x20\74\141\40\150\162\145\146\x3d\x27" . MoConstants::FAQ_URL . "\47\x20\164\x61\x72\147\x65\164\x3d\x27\137\x62\154\141\156\x6b\x27\76" . mo_("\106\x41\121\x73") . "\x3c\x2f\x61\76";
        PA:
        return $E4;
    }
    function plugin_action_links($Fi)
    {
        $l4 = TabDetails::instance();
        $b6 = $l4->_tabDetails[Tabs::FORMS];
        if (!is_plugin_active(MOV_PLUGIN_NAME)) {
            goto bh;
        }
        $Fi = array_merge(array("\74\141\x20\x68\x72\x65\146\75\42" . esc_url(admin_url("\x61\144\155\x69\x6e\x2e\160\x68\160\77\160\x61\147\145\75" . $b6->_menuSlug)) . "\42\x3e" . mo_("\123\145\164\x74\x69\x6e\147\x73") . "\x3c\57\x61\76"), $Fi);
        bh:
        return $Fi;
    }
    function hourlySync()
    {
        $vx = GatewayFunctions::instance();
        $vx->hourlySync();
    }
    function custom_wp_mail_from_name($rS)
    {
        $vx = GatewayFunctions::instance();
        return $vx->custom_wp_mail_from_name($rS);
    }
}
