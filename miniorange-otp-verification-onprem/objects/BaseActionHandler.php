<?php


namespace OTP\Objects;

use OTP\Helper\MoConstants;
use OTP\Helper\MoMessages;
use OTP\Helper\MoUtility;
class BaseActionHandler
{
    protected $_nonce;
    protected function __construct()
    {
    }
    protected function isValidRequest()
    {
        if (!(!current_user_can("\x6d\x61\156\x61\147\145\x5f\x6f\x70\x74\x69\x6f\156\163") || !check_admin_referer($this->_nonce))) {
            goto th;
        }
        wp_die(MoMessages::showMessage(MoMessages::INVALID_OP));
        th:
        return true;
    }
    protected function isValidAjaxRequest($O5)
    {
        if (check_ajax_referer($this->_nonce, $O5)) {
            goto Vf;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(BaseMessages::INVALID_OP), MoConstants::ERROR_JSON_TYPE));
        Vf:
    }
    public function getNonceValue()
    {
        return $this->_nonce;
    }
}
