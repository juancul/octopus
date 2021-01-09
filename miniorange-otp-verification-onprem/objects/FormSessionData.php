<?php


namespace OTP\Objects;

class FormSessionData
{
    private $isInitialized = false;
    private $emailSubmitted;
    private $phoneSubmitted;
    private $emailVerified;
    private $phoneVerified;
    private $emailVerificationStatus;
    private $phoneVerificationStatus;
    private $fieldOrFormId;
    private $userSubmitted;
    function __construct()
    {
    }
    function init()
    {
        $this->isInitialized = true;
        return $this;
    }
    public function getIsInitialized()
    {
        return $this->isInitialized;
    }
    public function getEmailSubmitted()
    {
        return $this->emailSubmitted;
    }
    public function setEmailSubmitted($we)
    {
        $this->emailSubmitted = $we;
    }
    public function getPhoneSubmitted()
    {
        return $this->phoneSubmitted;
    }
    public function setPhoneSubmitted($UG)
    {
        $this->phoneSubmitted = $UG;
    }
    public function getEmailVerified()
    {
        return $this->emailVerified;
    }
    public function setEmailVerified($fg)
    {
        $this->emailVerified = $fg;
    }
    public function getPhoneVerified()
    {
        return $this->phoneVerified;
    }
    public function setPhoneVerified($Tk)
    {
        $this->phoneVerified = $Tk;
    }
    public function getEmailVerificationStatus()
    {
        return $this->emailVerificationStatus;
    }
    public function setEmailVerificationStatus($XX)
    {
        $this->emailVerificationStatus = $XX;
    }
    public function getPhoneVerificationStatus()
    {
        return $this->phoneVerificationStatus;
    }
    public function setPhoneVerificationStatus($YC)
    {
        $this->phoneVerificationStatus = $YC;
    }
    public function getFieldOrFormId()
    {
        return $this->fieldOrFormId;
    }
    public function setFieldOrFormId($Zp)
    {
        $this->fieldOrFormId = $Zp;
    }
    public function getUserSubmitted()
    {
        return $this->userSubmitted;
    }
    public function setUserSubmitted($uD)
    {
        $this->userSubmitted = $uD;
    }
}
