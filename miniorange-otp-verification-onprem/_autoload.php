<?php


use OTP\Helper\FormList;
use OTP\Helper\FormSessionData;
use OTP\Helper\MoUtility;
use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\SplClassLoader;
if (defined("\x41\x42\123\120\x41\124\x48")) {
    goto sf;
}
die;
sf:
define("\x4d\x4f\126\137\104\x49\x52", plugin_dir_path(__FILE__));
define("\115\x4f\x56\137\x55\x52\x4c", plugin_dir_url(__FILE__));
$PG = wp_remote_retrieve_body(wp_remote_get(MOV_URL . "\x70\141\x63\153\141\147\145\x2e\152\x73\157\x6e", array("\x73\x73\x6c\x76\x65\x72\151\x66\171" => false)));
$AM = empty($PG) || strpos($PG, "\x6e\157\164\x20\146\157\165\x6e\x64") !== false ? initializePackageJson() : $PG;
$AM = json_decode($AM);
define("\x4d\117\x56\x5f\x56\105\x52\123\x49\x4f\x4e", $AM->version);
define("\x4d\117\x56\x5f\124\131\x50\105", $AM->type);
define("\x4d\x4f\x56\137\x48\117\x53\124", $AM->hostname);
define("\x4d\117\x56\x5f\104\105\106\x41\125\114\124\137\x43\125\x53\124\117\115\x45\122\113\x45\131", $AM->dCustomerKey);
define("\115\117\x56\x5f\104\x45\x46\x41\125\114\x54\x5f\x41\120\x49\113\x45\x59", $AM->dApiKey);
define("\115\117\126\137\x53\123\114\137\x56\105\122\x49\x46\x59", $AM->sslVerify);
define("\115\117\126\137\103\x53\123\137\125\x52\x4c", MOV_URL . "\x69\156\143\154\165\144\x65\163\x2f\x63\x73\163\57\155\157\137\x63\165\x73\x74\157\155\145\x72\137\166\x61\154\151\x64\x61\164\151\x6f\156\x5f\x73\x74\x79\x6c\145\x2e\x6d\151\x6e\x2e\x63\163\163\x3f\x76\145\x72\x73\x69\x6f\156\x3d" . MOV_VERSION);
define("\115\x4f\x5f\x49\x4e\x54\x54\x45\114\x49\116\x50\x55\124\137\103\123\x53", MOV_URL . "\151\156\143\154\165\x64\145\163\x2f\x63\163\163\x2f\x69\x6e\164\x6c\124\145\x6c\111\x6e\x70\x75\164\56\x6d\x69\x6e\x2e\x63\163\x73\77\166\x65\x72\x73\x69\x6f\x6e\x3d" . MOV_VERSION);
define("\115\x4f\126\137\112\x53\137\x55\x52\114", MOV_URL . "\x69\156\143\154\x75\x64\145\x73\57\152\163\x2f\x73\145\x74\164\x69\156\147\163\x2e\x6d\151\x6e\x2e\152\163\77\x76\145\x72\163\151\x6f\156\75" . MOV_VERSION);
define("\x56\101\114\111\x44\x41\124\111\117\116\x5f\x4a\x53\137\x55\122\114", MOV_URL . "\x69\x6e\143\x6c\x75\x64\145\x73\x2f\152\x73\57\x66\x6f\x72\155\x56\141\x6c\151\144\x61\x74\151\157\156\56\155\x69\x6e\56\152\x73\77\166\x65\162\x73\151\157\156\75" . MOV_VERSION);
define("\x4d\117\x5f\111\x4e\124\x54\x45\114\x49\116\x50\x55\124\x5f\112\x53", MOV_URL . "\x69\156\x63\154\x75\x64\145\163\x2f\x6a\x73\57\x69\x6e\164\x6c\x54\x65\x6c\x49\x6e\160\x75\x74\56\x6d\x69\156\56\152\x73\77\x76\x65\x72\x73\x69\157\x6e\75" . MOV_VERSION);
define("\115\117\137\x44\x52\x4f\x50\104\117\127\116\x5f\x4a\123", MOV_URL . "\151\x6e\143\x6c\x75\x64\145\163\57\152\x73\x2f\x64\162\157\160\x64\157\x77\x6e\x2e\155\x69\156\56\x6a\163\x3f\166\145\x72\163\x69\x6f\156\75" . MOV_VERSION);
define("\115\117\x56\137\x4c\x4f\101\104\x45\122\x5f\125\x52\x4c", MOV_URL . "\x69\156\143\154\165\x64\x65\163\x2f\151\155\141\147\145\163\x2f\x6c\157\x61\x64\145\162\56\147\151\146");
define("\x4d\x4f\126\x5f\x44\117\x4e\101\x54\x45", MOV_URL . "\x69\156\x63\154\x75\x64\145\163\57\x69\155\x61\147\x65\x73\57\144\x6f\156\x61\164\x65\x2e\x70\x6e\147");
define("\x4d\x4f\126\137\120\101\x59\120\101\x4c", MOV_URL . "\x69\x6e\x63\x6c\165\144\x65\163\x2f\151\155\x61\x67\x65\x73\x2f\x70\x61\x79\x70\x61\x6c\x2e\x70\156\x67");
define("\115\x4f\x56\x5f\116\105\124\x42\x41\116\x4b", MOV_URL . "\151\x6e\143\154\165\x64\x65\163\x2f\x69\x6d\141\x67\x65\163\57\x6e\145\164\x62\x61\x6e\x6b\x69\x6e\x67\x2e\x70\x6e\x67");
define("\x4d\117\126\x5f\x43\101\122\104", MOV_URL . "\x69\x6e\x63\x6c\165\144\x65\163\57\151\x6d\141\147\x65\x73\x2f\x63\x61\x72\144\56\160\156\147");
define("\x4d\x4f\x56\137\114\117\107\117\137\x55\122\x4c", MOV_URL . "\151\x6e\143\x6c\165\x64\x65\163\57\151\x6d\141\147\145\x73\x2f\154\x6f\x67\x6f\56\x70\x6e\x67");
define("\x4d\117\x56\x5f\x49\x43\x4f\x4e", MOV_URL . "\151\x6e\x63\154\x75\x64\145\x73\x2f\x69\x6d\141\147\x65\x73\x2f\x6d\x69\156\151\x6f\x72\x61\156\147\145\137\x69\143\157\x6e\x2e\x70\x6e\147");
define("\x4d\117\126\137\x41\x44\104\x4f\x4e\137\x44\111\x52", MOV_DIR . "\x61\x64\144\x6f\156\163\x2f");
define("\x4d\x4f\x56\x5f\125\123\105\137\120\117\114\131\x4c\101\x4e\x47", TRUE);
define("\x4d\117\x5f\124\105\123\x54\137\x4d\117\x44\x45", $AM->testMode);
define("\115\x4f\x5f\106\101\111\114\137\115\x4f\x44\x45", $AM->failMode);
define("\115\117\x56\x5f\123\105\123\123\111\x4f\x4e\137\x54\x59\120\105", $AM->session);
define("\x4d\117\126\137\x4d\x41\111\x4c\137\x4c\x4f\x47\x4f", MOV_URL . "\151\156\143\154\x75\x64\145\163\x2f\x69\x6d\x61\147\x65\x73\57\x6d\x6f\137\x73\x75\x70\160\x6f\162\164\x5f\x69\x63\x6f\x6e\x2e\x70\156\147");
include "\x53\160\154\103\154\141\x73\x73\114\157\141\144\145\x72\56\160\150\x70";
$xV = new SplClassLoader("\117\124\x50", realpath(__DIR__ . DIRECTORY_SEPARATOR . "\x2e\56"));
$xV->register();
require_once "\166\151\145\167\163\x2f\143\157\155\155\x6f\156\55\x65\x6c\145\155\x65\156\164\x73\56\x70\x68\x70";
initializeForms();
function initializeForms()
{
    $R4 = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(MOV_DIR . "\150\141\x6e\144\154\x65\x72\x2f\146\157\x72\x6d\163", RecursiveDirectoryIterator::SKIP_DOTS), RecursiveIteratorIterator::LEAVES_ONLY);
    foreach ($R4 as $dV) {
        $bY = $dV->getFilename();
        $z_ = "\117\124\x50\x5c\x48\x61\156\144\154\145\x72\x5c\106\x6f\162\155\163\x5c" . str_replace("\x2e\160\x68\x70", '', $bY);
        $QR = FormList::instance();
        $sP = $z_::instance();
        $QR->add($sP->getFormKey(), $sP);
        eS:
    }
    BG:
}
function admin_post_url()
{
    return admin_url("\141\x64\x6d\x69\x6e\55\x70\157\163\164\x2e\x70\150\160");
}
function wp_ajax_url()
{
    return admin_url("\141\x64\155\x69\156\55\x61\x6a\x61\x78\x2e\160\150\x70");
}
function mo_($GM)
{
    $fD = "\x6d\x69\156\x69\x6f\162\x61\156\x67\x65\x2d\x6f\164\160\x2d\166\x65\162\151\146\x69\143\141\x74\151\157\156";
    $GM = preg_replace("\x2f\x5c\x73\53\57\123", "\40", $GM);
    return is_scalar($GM) ? MoUtility::_is_polylang_installed() && MOV_USE_POLYLANG ? pll__($GM) : __($GM, $fD) : $GM;
}
function get_mo_option($GM, $s6 = null)
{
    $GM = ($s6 === null ? "\155\x6f\137\x63\165\x73\x74\157\x6d\x65\162\137\x76\x61\x6c\151\x64\141\164\x69\157\156\137" : $s6) . $GM;
    return apply_filters("\147\145\164\x5f\x6d\x6f\137\157\x70\164\151\157\x6e", get_site_option($GM));
}
function update_mo_option($GM, $Xd, $s6 = null)
{
    $GM = ($s6 === null ? "\155\x6f\x5f\143\x75\163\x74\157\155\145\162\x5f\166\141\154\x69\144\x61\164\151\157\x6e\x5f" : $s6) . $GM;
    update_site_option($GM, apply_filters("\165\160\x64\x61\164\145\x5f\155\157\x5f\x6f\160\x74\x69\x6f\156", $Xd, $GM));
}
function delete_mo_option($GM, $s6 = null)
{
    $GM = ($s6 === null ? "\155\157\x5f\x63\x75\x73\x74\157\x6d\x65\x72\137\166\141\154\x69\x64\141\x74\151\x6f\156\137" : $s6) . $GM;
    delete_site_option($GM);
}
function get_mo_class($kz)
{
    $VW = get_class($kz);
    return substr($VW, strrpos($VW, "\134") + 1);
}


function initializePackageJson()
{
    $cE = json_encode(array("\156\x61\x6d\x65" => "\155\x69\x6e\x69\157\162\141\156\147\x65\x2d\x6f\164\160\x2d\x76\x65\x72\151\x66\151\143\x61\164\151\157\x6e\55\x6f\x6e\160\x72\x65\x6d", "\x76\x65\x72\163\x69\157\156" => "\61\x32\x2e\x33\x2e\64", "\x74\x79\160\145" => "\x43\165\163\x74\157\155\107\141\x74\x65\x77\x61\171\127\x69\x74\150\x41\144\x64\x6f\156\x73", "\x74\x65\163\164\115\157\144\x65" => false, "\x66\x61\151\x6c\115\x6f\144\145" => false, "\150\x6f\163\164\156\x61\x6d\145" => "\150\x74\164\x70\163\72\57\x2f\x6c\157\x67\151\x6e\x2e\170\145\x63\x75\x72\151\x66\x79\x2e\143\157\155", "\x64\x43\165\x73\164\157\155\145\x72\113\x65\x79" => "\61\x36\65\65\x35", "\144\101\x70\151\113\x65\171" => "\146\x46\x64\62\x58\x63\166\124\107\x44\145\155\x5a\166\x62\x77\x31\x62\143\x55\x65\x73\x4e\x4a\127\105\161\x4b\142\142\125\x71", "\163\x73\154\x56\x65\x72\151\146\x79" => false, "\x73\x65\163\x73\x69\157\x6e" => "\124\x52\101\x4e\x53\x49\105\116\x54"));
    return $cE;
}
