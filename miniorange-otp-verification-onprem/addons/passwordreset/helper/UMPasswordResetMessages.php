<?php


namespace OTP\Addons\PasswordReset\Helper;

use OTP\Helper\MoUtility;
use OTP\Objects\BaseMessages;
use OTP\Traits\Instance;
final class UMPasswordResetMessages extends BaseMessages
{
    use Instance;
    private function __construct()
    {
        define("\115\x4f\137\125\115\120\122\x5f\x41\x44\104\117\116\x5f\x4d\105\123\x53\101\107\105\123", serialize(array(self::USERNAME_MISMATCH => mo_("\x55\x73\x65\x72\x6e\141\x6d\145\x20\x74\150\141\164\x20\x74\150\145\x20\x4f\x54\120\x20\x77\x61\163\x20\163\x65\x6e\x74\40\x74\x6f\x20\141\x6e\x64\x20\164\150\145\x20\165\163\x65\162\156\x61\155\145\40\163\x75\142\x6d\x69\x74\x74\145\144\40\x64\x6f\x20\156\x6f\x74\40\x6d\x61\x74\143\x68"), self::USERNAME_NOT_EXIST => mo_("\127\145\x20\143\141\156\47\164\40\146\151\x6e\x64\40\x61\x6e\x20\x61\x63\143\x6f\x75\x6e\164\40\x72\x65\x67\x69\163\164\145\x72\x65\x64\40\x77\x69\164\150\x20\164\x68\x61\x74\40\x61\144\x64\x72\145\163\163\x20\x6f\162\40" . "\x75\163\x65\162\x6e\141\x6d\x65\x20\157\162\40\160\150\157\x6e\145\40\x6e\165\155\142\x65\162"), self::RESET_LABEL => mo_("\x54\x6f\x20\162\x65\x73\145\164\x20\x79\157\x75\x72\40\x70\x61\163\163\167\x6f\x72\x64\54\x20\160\154\145\141\163\x65\40\x65\156\164\x65\x72\x20\171\157\165\162\x20\145\x6d\x61\x69\154\x20\141\x64\x64\162\145\x73\163\x2c\x20\x75\163\x65\x72\156\141\155\x65\40\x6f\x72\40\x70\150\157\x6e\145\x20\x6e\165\x6d\x62\145\x72\x20\x62\145\x6c\x6f\167"), self::RESET_LABEL_OP => mo_("\x54\x6f\x20\162\x65\163\145\x74\40\171\157\165\162\x20\160\x61\163\x73\x77\157\x72\144\54\40\160\154\x65\141\163\x65\40\x65\156\164\145\x72\x20\171\157\165\162\x20\162\145\x67\151\163\x74\x65\x72\x65\144\40\160\150\157\156\145\40\x6e\165\155\142\145\162\x20\142\145\x6c\157\167"))));
    }
    public static function showMessage($bm, $tT = array())
    {
        $Ug = '';
        $bm = explode("\40", $bm);
        $d2 = unserialize(MO_UMPR_ADDON_MESSAGES);
        $I2 = unserialize(MO_MESSAGES);
        $d2 = array_merge($d2, $I2);
        foreach ($bm as $al) {
            if (!MoUtility::isBlank($al)) {
                goto iM;
            }
            return $Ug;
            iM:
            $oh = $d2[$al];
            foreach ($tT as $O5 => $Xd) {
                $oh = str_replace("\x7b\173" . $O5 . "\x7d\175", $Xd, $oh);
                oM:
            }
            np:
            $Ug .= $oh;
            VI:
        }
        Mx:
        return $Ug;
    }
}
