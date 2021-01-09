<?php


namespace OTP\Helper;

if (defined("\x41\102\123\120\x41\124\x48")) {
    goto g6;
}
die;
g6:
use OTP\Objects\BaseAddOnHandler;
use OTP\Traits\Instance;
final class AddOnList
{
    use Instance;
    private $_addOns;
    private function __construct()
    {
        $this->_addOns = array();
    }
    public function add($O5, $form)
    {
        $this->_addOns[$O5] = $form;
    }
    public function getList()
    {
        return $this->_addOns;
    }
}
