<?php


use OTP\Helper\MoConstants;
use OTP\Helper\MoUtility;
use OTP\Objects\PluginPageDetails;
use OTP\Objects\Tabs;
$Vx = admin_url() . "\145\144\151\x74\56\x70\x68\x70\77\160\x6f\163\x74\137\x74\x79\x70\x65\x3d\160\x61\x67\145";
$Q6 = MoUtility::micv() ? "\x77\x70\x5f\157\164\x70\137\166\145\x72\x69\x66\151\x63\141\164\x69\157\x6e\137\x75\x70\x67\x72\x61\x64\145\x5f\x70\154\x61\x6e" : "\x77\160\137\x6f\164\160\x5f\166\x65\x72\151\146\151\x63\141\x74\x69\x6f\x6e\x5f\x62\x61\163\x69\143\x5f\x70\154\x61\156";
$jG = $yJ->getNonceValue();
$Gd = add_query_arg(array("\160\x61\147\145" => $l4->_tabDetails[Tabs::FORMS]->_menuSlug, "\x66\157\x72\155" => "\143\157\x6e\146\151\147\165\x72\145\x64\137\146\x6f\162\x6d\163\x23\143\157\x6e\x66\x69\x67\x75\x72\145\x64\137\146\x6f\162\x6d\x73"));
$ob = add_query_arg("\x70\141\x67\145", $l4->_tabDetails[Tabs::FORMS]->_menuSlug . "\43\x66\157\162\155\137\x73\x65\141\162\143\150", remove_query_arg(array("\x66\157\x72\x6d")));
$x0 = isset($_GET["\146\157\162\x6d"]) ? $_GET["\146\x6f\x72\x6d"] : false;
$yG = $x0 == "\143\x6f\x6e\x66\x69\147\x75\162\x65\x64\137\x66\x6f\x72\155\x73";
$RC = $l4->_tabDetails[Tabs::OTP_SETTINGS];
$Ol = $RC->_url;
$Ck = $l4->_tabDetails[Tabs::SMS_EMAIL_CONFIG];
$Ie = $Ck->_url;
$M4 = $l4->_tabDetails[Tabs::DESIGN];
$OO = $M4->_url;
$wq = $l4->_tabDetails[Tabs::ADD_ONS];
$sX = $wq->_url;
$lO = $l4->_tabDetails[Tabs::CONTACT_US];
$SO = $lO->_url;
$Im = MoConstants::FEEDBACK_EMAIL;
include MOV_DIR . "\166\x69\145\x77\x73\x2f\163\145\x74\164\151\156\147\163\x2e\x70\x68\x70";
include MOV_DIR . "\166\151\x65\x77\x73\x2f\x69\156\x73\x74\x72\x75\x63\164\151\x6f\156\163\56\x70\150\160";
