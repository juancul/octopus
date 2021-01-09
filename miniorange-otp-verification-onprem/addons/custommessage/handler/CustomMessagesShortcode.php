<?php


namespace OTP\Addons\CustomMessage\Handler;

use OTP\Traits\Instance;
class CustomMessagesShortcode
{
    use Instance;
    private $_adminActions;
    private $_nonce;
    public function __construct()
    {
        $X8 = CustomMessages::instance();
        $this->_nonce = $X8->getNonceValue();
        $this->_adminActions = $X8->_adminActions;
        add_shortcode("\155\157\137\143\x75\x73\x74\x6f\155\137\163\x6d\x73", array($this, "\137\143\x75\163\x74\157\155\x5f\x73\155\163\x5f\163\x68\157\x72\x74\x63\157\x64\145"));
        add_shortcode("\155\157\137\x63\x75\163\x74\x6f\x6d\137\x65\155\x61\x69\x6c", array($this, "\x5f\143\x75\x73\x74\157\x6d\137\x65\155\141\x69\x6c\x5f\x73\x68\x6f\162\164\x63\157\144\x65"));
    }
    function _custom_sms_shortcode()
    {
        if (is_user_logged_in()) {
            goto Tj;
        }
        // header("location:".get_mo_option('custom_messages_redirect_url')."");exit();
        $URL=get_mo_option('custom_messages_redirect_url');
        echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
        echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
        return;
        Tj:
        $mq = array_keys($this->_adminActions);
        // include MCM_DIR . "\x76\x69\x65\167\x73\57\143\x75\163\164\157\155\x53\x4d\123\102\157\x78\x2e\x70\150\x70";
        wp_register_script("\143\x75\163\x74\x6f\x6d\x5f\x73\x6d\163\x5f\x6d\163\x67\137\163\x63\162\x69\x70\x74", MCM_SHORTCODE_SMS_JS, array("\152\161\165\x65\162\171"), MOV_VERSION);
        wp_localize_script("\143\x75\163\164\x6f\155\x5f\x73\x6d\163\137\x6d\x73\x67\137\163\x63\x72\x69\x70\x74", "\x6d\x6f\166\x63\x75\163\x74\157\x6d\163\155\163", array("\141\x6c\164" => mo_("\x53\145\x6e\x64\x69\156\147\x2e\x2e\x2e"), "\151\x6d\147" => MOV_LOADER_URL, "\x6e\x6f\156\x63\x65" => wp_create_nonce($this->_nonce), "\165\162\154" => wp_ajax_url(), "\141\143\164\151\x6f\x6e" => $mq[0], "\142\x75\164\x74\x6f\x6e\x54\145\170\164" => mo_("\123\x65\156\144\x20\x53\x4d\123")));
        wp_enqueue_script("\143\x75\163\164\157\x6d\x5f\x73\155\163\x5f\155\x73\147\x5f\163\x63\x72\x69\x70\x74");
    }
    function _custom_email_shortcode()
    {
        if (is_user_logged_in()) {
            goto HN;
        }
        return;
        HN:
        $mq = array_keys($this->_adminActions);
        include MCM_DIR . "\166\x69\x65\167\x73\57\143\165\x73\164\157\x6d\105\155\141\x69\x6c\102\x6f\170\56\160\150\160";
        wp_register_script("\143\x75\x73\x74\157\155\137\x65\155\141\151\154\137\155\x73\147\137\x73\143\x72\x69\160\x74", MCM_SHORTCODE_EMAIL_JS, array("\152\x71\165\145\x72\x79"), MOV_VERSION);
        wp_localize_script("\143\165\x73\164\157\155\137\145\x6d\x61\x69\154\x5f\155\x73\147\x5f\x73\143\x72\151\160\164", "\x6d\x6f\166\143\x75\x73\164\x6f\155\145\155\141\x69\x6c", array("\141\x6c\x74" => mo_("\123\145\x6e\144\151\156\147\56\x2e\56"), "\151\x6d\147" => MOV_LOADER_URL, "\156\157\x6e\143\145" => wp_create_nonce($this->_nonce), "\165\162\154" => wp_ajax_url(), "\141\143\x74\151\x6f\x6e" => $mq[1], "\142\x75\164\164\157\156\x54\x65\170\x74" => mo_("\x53\x65\x6e\x64\x20\x45\x6d\x61\x69\154")));
        wp_enqueue_script("\x63\x75\163\x74\x6f\x6d\137\x65\x6d\x61\151\154\137\x6d\x73\x67\137\x73\143\x72\x69\160\164");
    }
}
