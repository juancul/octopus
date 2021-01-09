<?php


namespace OTP\Objects;

class TransactionSessionData
{
    private $emailTransactionId;
    private $phoneTransactionId;
    public function getEmailTransactionId()
    {
        return $this->emailTransactionId;
    }
    public function setEmailTransactionId($LM)
    {
        $this->emailTransactionId = $LM;
    }
    public function getPhoneTransactionId()
    {
        return $this->phoneTransactionId;
    }
    public function setPhoneTransactionId($Mj)
    {
        $this->phoneTransactionId = $Mj;
    }
}
