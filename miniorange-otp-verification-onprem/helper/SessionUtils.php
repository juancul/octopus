<?php


namespace OTP\Helper;

if (defined("\101\x42\x53\120\x41\124\x48")) {
    goto UL;
}
die;
UL:
use OTP\Objects\FormSessionData;
use OTP\Objects\TransactionSessionData;
use OTP\Objects\VerificationType;
final class SessionUtils
{
    static function isOTPInitialized($O5)
    {
        $p8 = MoPHPSessions::getSessionVar($O5);
        if (!$p8 instanceof FormSessionData) {
            goto ok;
        }
        return $p8->getIsInitialized();
        ok:
        return FALSE;
    }
    static function addEmailOrPhoneVerified($O5, $k8, $au)
    {
        switch ($au) {
            case VerificationType::PHONE:
                self::addPhoneVerified($O5, $k8);
                goto ot;
            case VerificationType::EMAIL:
                self::addEmailVerified($O5, $k8);
                goto ot;
        }
        U2:
        ot:
    }
    static function addEmailSubmitted($O5, $k8)
    {
        $p8 = MoPHPSessions::getSessionVar($O5);
        if (!$p8 instanceof FormSessionData) {
            goto OH;
        }
        $p8->setEmailSubmitted($k8);
        MoPHPSessions::addSessionVar($O5, $p8);
        OH:
    }
    static function addPhoneSubmitted($O5, $k8)
    {
        $p8 = MoPHPSessions::getSessionVar($O5);
        if (!$p8 instanceof FormSessionData) {
            goto qu;
        }
        $p8->setPhoneSubmitted($k8);
        MoPHPSessions::addSessionVar($O5, $p8);
        qu:
    }
    static function addEmailVerified($O5, $k8)
    {
        $p8 = MoPHPSessions::getSessionVar($O5);
        if (!$p8 instanceof FormSessionData) {
            goto lK;
        }
        $p8->setEmailVerified($k8);
        MoPHPSessions::addSessionVar($O5, $p8);
        lK:
    }
    static function addPhoneVerified($O5, $k8)
    {
        $p8 = MoPHPSessions::getSessionVar($O5);
        if (!$p8 instanceof FormSessionData) {
            goto bg;
        }
        $p8->setPhoneVerified($k8);
        MoPHPSessions::addSessionVar($O5, $p8);
        bg:
    }
    static function addStatus($O5, $k8, $qf)
    {
        $p8 = MoPHPSessions::getSessionVar($O5);
        if (!$p8 instanceof FormSessionData) {
            goto aw;
        }
        if ($p8->getIsInitialized()) {
            goto av;
        }
        return;
        av:
        if (!($qf === VerificationType::EMAIL)) {
            goto XQ;
        }
        $p8->setEmailVerificationStatus($k8);
        XQ:
        if (!($qf === VerificationType::PHONE)) {
            goto CC;
        }
        $p8->setPhoneVerificationStatus($k8);
        CC:
        MoPHPSessions::addSessionVar($O5, $p8);
        aw:
    }
    static function isStatusMatch($O5, $dq, $qf)
    {
        $p8 = MoPHPSessions::getSessionVar($O5);
        if (!$p8 instanceof FormSessionData) {
            goto m8;
        }
        switch ($qf) {
            case VerificationType::EMAIL:
                return $dq === $p8->getEmailVerificationStatus();
            case VerificationType::PHONE:
                return $dq === $p8->getPhoneVerificationStatus();
            case VerificationType::BOTH:
                return $dq === $p8->getEmailVerificationStatus() || $dq === $p8->getPhoneVerificationStatus();
        }
        vf:
        Pf:
        m8:
        return FALSE;
    }
    static function isEmailVerifiedMatch($O5, $GM)
    {
        $p8 = MoPHPSessions::getSessionVar($O5);
        if (!$p8 instanceof FormSessionData) {
            goto zS;
        }
        return $GM === $p8->getEmailVerified();
        zS:
        return FALSE;
    }
    static function isPhoneVerifiedMatch($O5, $GM)
    {
        $p8 = MoPHPSessions::getSessionVar($O5);
        if (!$p8 instanceof FormSessionData) {
            goto ji;
        }
        return $GM === $p8->getPhoneVerified();
        ji:
        return FALSE;
    }
    static function setEmailTransactionID($Cz)
    {
        $kb = MoPHPSessions::getSessionVar(FormSessionVars::TX_SESSION_ID);
        if ($kb instanceof TransactionSessionData) {
            goto Pq;
        }
        $kb = new TransactionSessionData();
        Pq:
        $kb->setEmailTransactionId($Cz);
        MoPHPSessions::addSessionVar(FormSessionVars::TX_SESSION_ID, $kb);
    }
    static function setPhoneTransactionID($Cz)
    {
        $kb = MoPHPSessions::getSessionVar(FormSessionVars::TX_SESSION_ID);
        if ($kb instanceof TransactionSessionData) {
            goto Fj;
        }
        $kb = new TransactionSessionData();
        Fj:
        $kb->setPhoneTransactionId($Cz);
        MoPHPSessions::addSessionVar(FormSessionVars::TX_SESSION_ID, $kb);
    }
    static function getTransactionId($au)
    {
        $kb = MoPHPSessions::getSessionVar(FormSessionVars::TX_SESSION_ID);
        if (!$kb instanceof TransactionSessionData) {
            goto iG;
        }
        switch ($au) {
            case VerificationType::EMAIL:
                return $kb->getEmailTransactionId();
            case VerificationType::PHONE:
                return $kb->getPhoneTransactionId();
            case VerificationType::BOTH:
                return MoUtility::isBlank($kb->getPhoneTransactionId()) ? $kb->getEmailTransactionId() : $kb->getPhoneTransactionId();
        }
        oC:
        Qa:
        iG:
        return '';
    }
    static function unsetSession($MY)
    {
        foreach ($MY as $O5) {
            MoPHPSessions::unsetSession($O5);
            Hd:
        }
        OA:
    }
    static function isPhoneSubmittedAndVerifiedMatch($O5)
    {
        $p8 = MoPHPSessions::getSessionVar($O5);
        if (!$p8 instanceof FormSessionData) {
            goto Hu;
        }
        return $p8->getPhoneVerified() === $p8->getPhoneSubmitted();
        Hu:
        return FALSE;
    }
    static function isEmailSubmittedAndVerifiedMatch($O5)
    {
        $p8 = MoPHPSessions::getSessionVar($O5);
        if (!$p8 instanceof FormSessionData) {
            goto Xd;
        }
        return $p8->getEmailVerified() === $p8->getEmailSubmitted();
        Xd:
        return FALSE;
    }
    static function setFormOrFieldId($O5, $k8)
    {
        $p8 = MoPHPSessions::getSessionVar($O5);
        if (!$p8 instanceof FormSessionData) {
            goto cu;
        }
        $p8->setFieldOrFormId($k8);
        MoPHPSessions::addSessionVar($O5, $p8);
        cu:
    }
    static function getFormOrFieldId($O5)
    {
        $p8 = MoPHPSessions::getSessionVar($O5);
        if (!$p8 instanceof FormSessionData) {
            goto Ho;
        }
        return $p8->getFieldOrFormId();
        Ho:
        return '';
    }
    static function initializeForm($form)
    {
        $p8 = new FormSessionData();
        MoPHPSessions::addSessionVar($form, $p8->init());
    }
    static function addUserInSession($O5, $k8)
    {
        $p8 = MoPHPSessions::getSessionVar($O5);
        if (!$p8 instanceof FormSessionData) {
            goto Y8;
        }
        $p8->setUserSubmitted($k8);
        MoPHPSessions::addSessionVar($O5, $p8);
        Y8:
    }
    static function getUserSubmitted($O5)
    {
        $p8 = MoPHPSessions::getSessionVar($O5);
        if (!$p8 instanceof FormSessionData) {
            goto Cx;
        }
        return $p8->getUserSubmitted();
        Cx:
        return '';
    }
}
