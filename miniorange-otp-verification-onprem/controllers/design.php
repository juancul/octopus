<?php


use OTP\Helper\Templates\DefaultPopup;
use OTP\Helper\Templates\ErrorPopup;
use OTP\Helper\Templates\ExternalPopup;
use OTP\Helper\Templates\UserChoicePopup;
use OTP\Objects\Template;
$a9 = DefaultPopup::instance();
$Fk = UserChoicePopup::instance();
$E2 = ExternalPopup::instance();
$eY = ErrorPopup::instance();
$jG = $a9->getNonceValue();
$Br = $a9->getTemplateKey();
$UQ = $Fk->getTemplateKey();
$YK = $E2->getTemplateKey();
$wK = $eY->getTemplateKey();
$Ha = maybe_unserialize(get_mo_option("\x63\x75\163\x74\157\155\137\160\x6f\x70\x75\x70\x73"));
$L1 = $Ha[$a9->getTemplateKey()];
$Sd = $Ha[$E2->getTemplateKey()];
$RD = $Ha[$Fk->getTemplateKey()];
$kJ = $Ha[$eY->getTemplateKey()];
$nV = Template::$templateEditor;
$wz = $a9->getTemplateEditorId();
$IT = array_merge($nV, array("\x74\x65\170\x74\x61\162\145\x61\x5f\156\x61\155\x65" => $wz, "\145\x64\151\x74\157\162\137\x68\x65\151\147\150\x74" => 400));
$kF = $Fk->getTemplateEditorId();
$rD = array_merge($nV, array("\164\145\170\x74\141\162\145\141\137\x6e\141\x6d\145" => $kF, "\145\144\x69\x74\157\x72\137\150\x65\x69\147\x68\x74" => 400));
$yI = $E2->getTemplateEditorId();
$HP = array_merge($nV, array("\x74\x65\170\x74\x61\162\x65\141\x5f\156\x61\155\x65" => $yI, "\145\x64\x69\x74\157\162\137\x68\145\x69\x67\150\x74" => 400));
$ff = $eY->getTemplateEditorId();
$hc = array_merge($nV, array("\164\x65\x78\x74\x61\162\145\x61\x5f\x6e\x61\x6d\145" => $ff, "\145\x64\151\x74\157\x72\137\x68\x65\151\x67\150\x74" => 400));
$wp = str_replace("\x7b\x7b\103\x4f\116\x54\105\116\124\175\x7d", "\74\x69\x6d\147\40\x73\x72\x63\75\47" . MOV_LOADER_URL . "\x27\x3e", $a9->paneContent);
$hb = "\x3c\163\160\x61\x6e\x20\x73\x74\x79\154\x65\x3d\47\146\x6f\156\x74\55\163\x69\172\145\72\x20\61\x2e\x33\145\x6d\73\47\x3e" . "\x50\x52\105\x56\111\105\x57\x20\x50\101\x4e\105\74\x62\162\57\x3e\74\142\x72\x2f\76" . "\74\57\x73\160\x61\156\x3e" . "\74\x73\x70\x61\156\x3e" . "\x43\x6c\151\143\x6b\40\x6f\156\x20\x74\150\145\40\x50\x72\145\166\151\145\x77\x20\x62\x75\164\164\x6f\x6e\x20\x61\x62\157\x76\145\x20\x74\x6f\40\x63\150\145\143\153\40\x68\157\x77\x20\x79\x6f\165\162\x20\x70\x6f\x70\165\x70\x20\x77\157\165\x6c\x64\40\x6c\157\x6f\153\x20\x6c\x69\x6b\x65\x2e" . "\x3c\x2f\163\160\x61\x6e\x3e";
$hb = str_replace("\173\173\x4d\x45\123\123\101\x47\x45\175\x7d", $hb, $a9->messageDiv);
$Tg = str_replace("\x7b\x7b\103\117\116\x54\105\116\x54\x7d\x7d", $hb, $a9->paneContent);
include MOV_DIR . "\x76\x69\145\167\163\x2f\x64\145\x73\151\147\x6e\56\x70\150\160";
