<?php


namespace OTP\Objects;

class PluginPageDetails
{
    function __construct($Fa, $RL, $H5, $Tl, $MU, $AQ, $Of, $u8 = '', $iZ = true)
    {
        $this->_pageTitle = $Fa;
        $this->_menuSlug = $RL;
        $this->_menuTitle = $H5;
        $this->_tabName = $Tl;
        $this->_url = add_query_arg(array("\160\x61\x67\145" => $this->_menuSlug), $MU);
        $this->_url = remove_query_arg(array("\x61\144\144\157\156", "\x66\x6f\x72\155", "\x73\155\163"), $this->_url);
        $this->_view = $AQ;
        $this->_id = $Of;
        $this->_showInNav = $iZ;
        $this->_css = $u8;
    }
    public $_pageTitle;
    public $_menuSlug;
    public $_menuTitle;
    public $_tabName;
    public $_url;
    public $_view;
    public $_id;
    public $_showInNav;
    public $_css;
}
