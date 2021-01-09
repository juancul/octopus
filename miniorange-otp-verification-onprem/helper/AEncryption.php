<?php


namespace OTP\Helper;

if (defined("\x41\102\x53\120\101\x54\110")) {
    goto l8;
}
die;
l8:
class AEncryption
{
    public static function encrypt_data($GM, $a_)
    {
        $Qh = '';
        $IV = 0;
        oo:
        if (!($IV < strlen($GM))) {
            goto Tm;
        }
        $qk = substr($GM, $IV, 1);
        $DX = substr($a_, $IV % strlen($a_) - 1, 1);
        $qk = chr(ord($qk) + ord($DX));
        $Qh .= $qk;
        ld:
        $IV++;
        goto oo;
        Tm:
        return base64_encode($Qh);
    }
    public static function decrypt_data($GM, $a_)
    {
        $Qh = '';
        $GM = base64_decode($GM);
        $IV = 0;
        no:
        if (!($IV < strlen($GM))) {
            goto Ge;
        }
        $qk = substr($GM, $IV, 1);
        $DX = substr($a_, $IV % strlen($a_) - 1, 1);
        $qk = chr(ord($qk) - ord($DX));
        $Qh .= $qk;
        WJ:
        $IV++;
        goto no;
        Ge:
        return $Qh;
    }
}
