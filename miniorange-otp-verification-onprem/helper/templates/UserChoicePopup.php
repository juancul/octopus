<?php


namespace OTP\Helper\Templates;

if (defined("\101\x42\123\120\101\124\x48")) {
    goto Ls;
}
die;
Ls:
use OTP\Objects\MoITemplate;
use OTP\Objects\Template;
use OTP\Traits\Instance;
class UserChoicePopup extends Template implements MoITemplate
{
    use Instance;
    protected function __construct()
    {
        $this->key = "\125\x53\x45\x52\103\x48\117\111\x43\105";
        $this->templateEditorID = "\x63\x75\x73\164\157\155\x45\155\141\151\x6c\x4d\163\x67\105\x64\151\x74\157\162\x32";
        parent::__construct();
    }
    public function getDefaults($JA)
    {
        if (is_array($JA)) {
            goto Bc;
        }
        $JA = array();
        Bc:
        $JA[$this->getTemplateKey()] = file_get_contents(MOV_DIR . "\x69\x6e\x63\154\x75\144\145\x73\x2f\150\164\155\154\57\x75\x73\145\x72\x63\x68\x6f\151\143\145\x2e\x6d\151\156\56\x68\164\x6d\x6c");
        return $JA;
    }
    public function parse($wD, $Tg, $Rn, $P8)
    {
        $Do = $this->getRequiredFormsSkeleton($Rn, $P8);
        $bi = $this->preview ? '' : extra_post_data();
        $Te = "\173\x7b\105\130\124\x52\x41\137\120\117\123\x54\x5f\104\101\124\x41\x7d\x7d\x3c\151\156\160\x75\x74\40\164\171\x70\145\75\x22\150\151\x64\144\145\156\x22\x20\156\141\155\145\x3d\x22\157\x70\x74\151\x6f\156\42\40\x76\x61\x6c\165\145\x3d\42\155\x69\156\x69\x6f\162\141\x6e\x67\x65\55\166\141\154\151\x64\141\164\x65\55\x6f\x74\x70\x2d\143\150\157\x69\143\x65\x2d\x66\157\x72\155\42\40\x2f\76";
        $wD = str_replace("\173\x7b\112\121\x55\105\122\x59\x7d\x7d", $this->jqueryUrl, $wD);
        $wD = str_replace("\x7b\173\106\117\x52\x4d\x5f\111\x44\175\x7d", "\155\157\137\x76\141\x6c\151\144\x61\x74\145\x5f\146\157\x72\155", $wD);
        $wD = str_replace("\x7b\x7b\107\x4f\137\102\101\x43\x4b\x5f\x41\x43\124\111\x4f\x4e\x5f\x43\x41\114\x4c\175\x7d", "\x6d\157\137\x76\x61\154\151\144\141\164\x69\157\156\137\x67\157\142\141\143\153\50\51\73", $wD);
        $wD = str_replace("\173\x7b\115\x4f\137\x43\123\123\x5f\x55\x52\x4c\x7d\175", MOV_CSS_URL, $wD);
        $wD = str_replace("\173\x7b\122\105\121\x55\x49\x52\x45\x44\137\106\117\122\x4d\x53\137\x53\103\x52\111\120\124\123\175\x7d", $Do, $wD);
        $wD = str_replace("\x7b\173\110\105\x41\104\x45\x52\175\175", mo_("\x56\141\154\151\144\x61\x74\145\40\117\124\x50\40\x28\117\156\x65\40\x54\x69\155\x65\40\120\x61\x73\163\x63\157\x64\x65\51"), $wD);
        $wD = str_replace("\x7b\x7b\x47\117\137\x42\101\x43\x4b\x7d\175", mo_("\46\154\x61\x72\x72\x3b\40\107\x6f\x20\x42\141\x63\153"), $wD);
        $wD = str_replace("\173\173\x4d\x45\x53\123\101\x47\105\175\x7d", mo_($Tg), $wD);
        $wD = str_replace("\173\x7b\102\x55\x54\124\x4f\116\137\x54\x45\130\124\x7d\175", mo_("\x56\x61\x6c\151\x64\x61\x74\145\x20\x4f\124\120"), $wD);
        $wD = str_replace("\x7b\x7b\x52\105\121\125\111\x52\105\x44\137\x46\111\105\114\x44\123\x7d\x7d", $Te, $wD);
        $wD = str_replace("\173\x7b\105\x58\124\x52\101\137\120\117\x53\x54\x5f\x44\x41\124\x41\x7d\x7d", $bi, $wD);
        return $wD;
    }
    private function getRequiredFormsSkeleton($Rn, $P8)
    {
        $wo = "\74\146\x6f\162\155\x20\x6e\x61\155\145\x3d\x22\146\42\x20\155\145\x74\150\157\x64\x3d\42\x70\x6f\x73\x74\42\x20\x61\143\164\151\157\156\75\x22\x22\40\x69\x64\x3d\42\x76\141\x6c\x69\x64\x61\164\x69\x6f\156\x5f\x67\157\102\141\143\x6b\137\146\157\162\x6d\42\x3e\15\12\x9\x9\x9\11\x3c\x69\156\x70\165\x74\40\151\144\75\42\x76\x61\x6c\x69\x64\x61\164\151\157\x6e\137\147\x6f\102\x61\143\153\42\40\x6e\x61\x6d\145\75\x22\157\x70\x74\151\x6f\x6e\42\x20\x76\x61\x6c\165\x65\75\x22\166\x61\154\x69\144\x61\164\151\157\156\x5f\147\157\x42\141\143\153\42\x20\164\171\160\145\x3d\42\150\x69\x64\x64\x65\x6e\42\x2f\x3e\xd\xa\x9\x9\x9\74\57\146\x6f\162\x6d\x3e\x7b\173\x53\103\x52\111\x50\124\123\x7d\x7d";
        $wo = str_replace("\173\x7b\x53\103\x52\111\120\x54\x53\x7d\x7d", $this->getRequiredScripts(), $wo);
        return $wo;
    }
    private function getRequiredScripts()
    {
        $S9 = "\x3c\163\x74\x79\154\x65\76\x2e\155\157\137\x63\165\163\164\x6f\155\145\162\137\166\x61\154\151\x64\x61\x74\x69\157\156\55\x6d\157\144\x61\154\173\x64\151\x73\x70\x6c\x61\x79\72\142\x6c\x6f\x63\153\41\151\x6d\x70\x6f\162\164\x61\156\x74\x7d\x3c\x2f\x73\x74\x79\x6c\145\x3e";
        if (!$this->preview) {
            goto O9;
        }
        $S9 .= "\74\163\143\x72\151\160\164\x3e\x24\155\157\75\x6a\121\x75\145\x72\x79\x3b\44\x6d\157\x28\42\x23\x6d\x6f\x5f\166\x61\154\151\144\x61\x74\x65\137\x66\x6f\162\155\42\51\x2e\163\x75\x62\155\x69\164\x28\x66\165\x6e\143\164\151\x6f\156\x28\x65\51\x7b\x65\56\160\x72\x65\x76\145\x6e\164\104\145\x66\141\x75\154\x74\50\51\73\x7d\51\x3b\x3c\57\163\x63\162\151\x70\x74\x3e";
        goto J9;
        O9:
        $S9 .= "\x3c\x73\143\162\151\160\164\76\x66\x75\x6e\x63\164\x69\157\156\x20\155\157\137\166\141\154\151\x64\x61\164\151\x6f\x6e\137\147\157\x62\x61\143\x6b\50\51\173\144\x6f\143\165\155\x65\x6e\164\56\147\145\164\x45\154\x65\x6d\x65\156\164\102\x79\111\x64\x28\x22\x76\x61\154\151\x64\x61\x74\x69\157\156\x5f\147\x6f\x42\x61\143\x6b\137\x66\157\162\155\x22\x29\x2e\163\165\x62\155\151\x74\50\51\x3b\175\x3c\x2f\163\x63\162\151\160\x74\x3e";
        J9:
        return $S9;
    }
}
