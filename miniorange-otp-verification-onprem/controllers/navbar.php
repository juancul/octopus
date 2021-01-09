<?php


use OTP\Helper\MoConstants;
use OTP\Helper\MoMessages;
use OTP\Objects\Tabs;
$MU = remove_query_arg(array("\141\x64\x64\157\156", "\146\x6f\162\155"), $_SERVER["\x52\105\x51\x55\x45\x53\124\137\x55\x52\111"]);
$Ou = add_query_arg(array("\160\141\147\x65" => $l4->_tabDetails[Tabs::ACCOUNT]->_menuSlug), $MU);
$ja = MoConstants::FAQ_URL;
$sU = MoMessages::showMessage(MoMessages::REGISTER_WITH_US, array("\165\x72\x6c" => $Ou));
$Kt = MoMessages::showMessage(MoMessages::ACTIVATE_PLUGIN, array("\165\162\154" => $Ou));
$p3 = $_GET["\160\x61\147\145"];
$Y4 = add_query_arg(array("\x70\141\147\145" => $l4->_tabDetails[Tabs::PRICING]->_menuSlug), $MU);
include MOV_DIR . "\x76\151\x65\167\163\x2f\156\x61\x76\x62\x61\x72\x2e\x70\x68\x70";
