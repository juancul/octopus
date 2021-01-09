<?php


namespace OTP\Helper;

use OTP\Objects\FormHandler;
use OTP\Traits\Instance;
if (defined("\101\x42\123\x50\x41\x54\110")) {
    goto sY;
}
die;
sY:
final class FormList
{
    use Instance;
    private $_forms;
    private $enabled_forms;
    private function __construct()
    {
        $this->_forms = array();
    }
    public function add($O5, $form)
    {
        $this->_forms[$O5] = $form;
        if (!$form->isFormEnabled()) {
            goto TP;
        }
        $this->enabled_forms[$O5] = $form;
        TP:
    }
    public function getList()
    {
        return $this->_forms;
    }
    public function getEnabledForms()
    {
        return $this->enabled_forms;
    }
}
