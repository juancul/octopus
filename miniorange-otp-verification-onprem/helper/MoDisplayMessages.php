<?php


namespace OTP\Helper;

if (defined("\x41\102\123\x50\101\124\x48")) {
    goto wB;
}
die;
wB:
class MoDisplayMessages
{
    private $_message;
    private $_type;
    function __construct($Tg, $qf)
    {
        $this->_message = $Tg;
        $this->_type = $qf;
        add_action("\141\x64\155\x69\x6e\137\x6e\157\x74\151\143\145\163", array($this, "\x72\145\x6e\144\x65\162"));
    }
    function render()
    {
        switch ($this->_type) {
            case "\x43\x55\123\124\117\x4d\x5f\115\105\123\123\x41\x47\105":
                echo mo_($this->_message);
                goto jH;
            case "\116\117\x54\111\x43\105":
                echo "\x3c\x64\x69\x76\40\163\164\171\x6c\x65\x3d\x22\x6d\x61\162\x67\151\x6e\55\164\x6f\160\x3a\61\45\x3b\42" . "\x63\x6c\141\x73\163\x3d\x22\x69\163\x2d\x64\x69\x73\155\x69\163\x73\151\x62\154\x65\40\x6e\157\164\x69\x63\145\40\156\x6f\x74\x69\x63\x65\x2d\167\x61\x72\156\x69\156\147\x20\x6d\157\x2d\x61\144\155\151\156\55\x6e\157\x74\151\x66\x22\x3e" . "\x3c\160\76" . mo_($this->_message) . "\x3c\x2f\160\x3e" . "\x3c\57\144\x69\x76\76";
                goto jH;
            case "\105\x52\x52\117\122":
                echo "\74\x64\151\166\40\x73\x74\171\154\145\x3d\42\155\x61\x72\x67\151\x6e\55\164\157\160\x3a\61\x25\73\42" . "\x63\154\x61\x73\163\x3d\42\156\x6f\164\x69\x63\145\40\156\x6f\x74\x69\143\145\x2d\x65\x72\162\x6f\162\x20\151\x73\x2d\144\151\163\155\x69\x73\x73\x69\142\154\145\x20\x6d\x6f\55\x61\x64\x6d\x69\x6e\x2d\156\x6f\164\151\146\x22\76" . "\74\x70\x3e" . mo_($this->_message) . "\x3c\x2f\160\x3e" . "\74\x2f\144\x69\166\76";
                goto jH;
            case "\123\x55\103\x43\x45\x53\123":
                echo "\74\x64\151\x76\x20\40\x73\x74\171\154\145\x3d\42\155\x61\x72\147\x69\156\55\x74\x6f\x70\72\61\45\x3b\42" . "\143\x6c\x61\x73\163\x3d\42\x6e\157\164\151\x63\145\x20\156\x6f\x74\x69\x63\x65\x2d\x73\x75\x63\x63\x65\x73\163\x20\151\x73\x2d\144\151\x73\x6d\151\163\163\x69\x62\x6c\145\40\155\157\55\141\144\155\x69\x6e\55\156\x6f\x74\151\x66\42\x3e" . "\x3c\160\x3e" . mo_($this->_message) . "\x3c\x2f\160\76" . "\x3c\x2f\144\151\x76\76";
                goto jH;
        }
        u7:
        jH:
    }
}
