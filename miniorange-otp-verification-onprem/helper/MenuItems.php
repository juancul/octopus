<?php


namespace OTP\Helper;

if (defined("\x41\102\x53\120\x41\124\110")) {
    goto BO;
}
die;
BO:
use OTP\MoOTP;
use OTP\Objects\PluginPageDetails;
use OTP\Objects\TabDetails;
use OTP\Traits\Instance;
final class MenuItems
{
    use Instance;
    private $_callback;
    private $_menuSlug;
    private $_menuLogo;
    private $_tabDetails;
    private function __construct()
    {
        $this->_callback = array(MoOTP::instance(), "\x6d\157\x5f\x63\x75\163\164\157\155\x65\x72\137\x76\141\x6c\x69\144\x61\x74\151\157\x6e\137\157\x70\x74\x69\x6f\x6e\163");
        $this->_menuLogo = MOV_ICON;
        $l4 = TabDetails::instance();
        $this->_tabDetails = $l4->_tabDetails;
        $this->_menuSlug = $l4->_parentSlug;
        $this->addMainMenu();
        $this->addSubMenus();
    }
    private function addMainMenu()
    {
        add_menu_page("\117\x54\120\40\126\x65\x72\x69\x66\151\x63\141\x74\x69\157\156", "\x4f\x54\x50\40\126\x65\x72\151\146\151\143\x61\x74\x69\157\156", "\155\141\156\141\147\145\137\157\x70\164\x69\157\156\163", $this->_menuSlug, $this->_callback, $this->_menuLogo);
    }
    private function addSubMenus()
    {
        foreach ($this->_tabDetails as $h2) {
            add_submenu_page($this->_menuSlug, $h2->_pageTitle, $h2->_menuTitle, "\155\x61\156\141\x67\x65\137\x6f\x70\x74\151\x6f\156\x73", $h2->_menuSlug, $this->_callback);
            My:
        }
        EE:
    }
}
