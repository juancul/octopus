<?php


namespace OTP\Helper\Templates;

if (defined("\101\x42\123\x50\x41\x54\x48")) {
    goto Aa;
}
die;
Aa:
use OTP\Objects\MoITemplate;
use OTP\Objects\Template;
use OTP\Traits\Instance;
class ErrorPopup extends Template implements MoITemplate
{
    use Instance;
    protected function __construct()
    {
        $this->key = "\105\x52\x52\117\122";
        $this->templateEditorID = "\143\x75\x73\x74\x6f\155\x45\155\141\x69\x6c\x4d\163\147\x45\x64\x69\x74\157\x72\64";
        $this->requiredTags = array_diff($this->requiredTags, array("\x7b\x7b\106\x4f\x52\115\137\x49\104\175\x7d", "\x7b\x7b\122\105\121\x55\x49\122\x45\104\137\106\x49\105\114\104\123\175\175"));
        parent::__construct();
    }
    public function getDefaults($JA)
    {
        if (is_array($JA)) {
            goto hv;
        }
        $JA = array();
        hv:
        $JA[$this->getTemplateKey()] = file_get_contents(MOV_DIR . "\151\x6e\x63\154\x75\144\x65\x73\x2f\150\164\x6d\x6c\x2f\145\162\x72\157\162\56\155\151\156\56\150\x74\x6d\154");
        return $JA;
    }
    public function parse($wD, $Tg, $Rn, $P8)
    {
        $P8 = $P8 ? "\164\x72\x75\x65" : "\146\141\x6c\163\x65";
        $Do = $this->getRequiredFormsSkeleton($Rn, $P8);
        $wD = str_replace("\173\173\x4a\121\125\105\x52\131\175\x7d", $this->jqueryUrl, $wD);
        $wD = str_replace("\173\x7b\107\117\x5f\x42\101\x43\x4b\137\101\103\x54\x49\x4f\116\x5f\103\101\x4c\x4c\175\x7d", "\155\x6f\x5f\x76\x61\154\151\x64\x61\164\x69\157\156\x5f\147\x6f\x62\x61\x63\x6b\x28\x29\73", $wD);
        $wD = str_replace("\173\173\x4d\117\x5f\103\123\x53\x5f\125\122\114\x7d\x7d", MOV_CSS_URL, $wD);
        $wD = str_replace("\x7b\x7b\x52\x45\121\125\x49\x52\x45\x44\x5f\106\x4f\122\x4d\123\x5f\x53\x43\x52\111\120\x54\x53\175\x7d", $Do, $wD);
        $wD = str_replace("\x7b\173\110\x45\x41\104\105\122\x7d\x7d", mo_("\126\141\154\151\144\141\x74\x65\x20\117\x54\x50\x20\x28\117\156\x65\40\x54\x69\x6d\x65\40\120\141\163\163\x63\157\144\145\51"), $wD);
        $wD = str_replace("\x7b\x7b\107\x4f\x5f\x42\101\103\113\x7d\x7d", mo_("\x26\154\x61\162\162\73\40\107\157\x20\x42\141\143\x6b"), $wD);
        $wD = str_replace("\x7b\173\x4d\105\x53\123\101\x47\x45\x7d\x7d", mo_($Tg), $wD);
        return $wD;
    }
    private function getRequiredFormsSkeleton($Rn, $P8)
    {
        $wo = "\x3c\146\157\x72\x6d\40\156\x61\155\145\x3d\x22\x66\42\x20\x6d\x65\164\150\157\x64\x3d\42\160\157\163\x74\42\x20\x61\x63\x74\151\157\x6e\75\42\42\x20\151\144\75\x22\x76\x61\154\151\144\x61\164\x69\x6f\x6e\x5f\147\157\102\x61\x63\153\137\x66\157\162\x6d\42\76\xd\12\11\11\11\74\x69\156\x70\x75\164\40\x69\x64\x3d\x22\166\141\154\151\x64\x61\164\x69\157\x6e\x5f\x67\157\x42\x61\x63\x6b\42\40\x6e\x61\x6d\x65\75\42\x6f\x70\164\x69\157\x6e\x22\40\x76\x61\154\165\145\75\42\166\x61\x6c\x69\x64\141\164\x69\x6f\x6e\x5f\147\157\102\x61\x63\153\x22\x20\164\x79\160\x65\x3d\x22\x68\x69\144\x64\145\156\x22\57\76\15\xa\x9\x9\74\57\146\x6f\x72\155\76\x7b\173\x53\x43\122\x49\120\x54\x53\x7d\x7d";
        $wo = str_replace("\x7b\173\x53\103\x52\111\x50\x54\x53\x7d\x7d", $this->getRequiredScripts(), $wo);
        return $wo;
    }
    private function getRequiredScripts()
    {
        $S9 = "\x3c\x73\x74\171\154\145\76\56\x6d\x6f\137\x63\x75\163\164\x6f\155\x65\x72\137\x76\141\x6c\x69\x64\x61\x74\x69\x6f\156\55\x6d\x6f\144\141\154\x7b\x64\151\x73\160\x6c\x61\x79\72\x62\x6c\x6f\x63\153\41\x69\x6d\x70\157\x72\164\141\x6e\164\175\x3c\57\163\164\171\x6c\x65\76";
        $S9 .= "\x3c\163\143\x72\x69\160\x74\76\146\x75\156\143\164\151\x6f\x6e\x20\x6d\157\x5f\x76\x61\154\151\144\141\x74\x69\x6f\x6e\137\x67\x6f\142\141\143\153\50\x29\x7b\x64\157\143\165\x6d\145\x6e\x74\x2e\x67\x65\164\x45\x6c\145\x6d\x65\x6e\x74\102\x79\111\144\50\x22\x76\141\x6c\151\x64\141\164\x69\157\156\137\x67\157\x42\x61\x63\x6b\x5f\146\157\x72\x6d\x22\51\x2e\x73\165\x62\155\151\x74\x28\x29\175\x3c\57\x73\143\162\151\160\x74\76";
        return $S9;
    }
}
