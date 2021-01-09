<?php


if (defined("\101\x42\x53\x50\101\124\110")) {
    goto MF;
}
die;
MF:
define("\x55\x4d\x50\x52\x5f\104\x49\x52", plugin_dir_path(__FILE__));
define("\x55\x4d\120\x52\137\x55\x52\114", plugin_dir_url(__FILE__));
define("\x55\x4d\x50\x52\137\126\105\122\123\x49\x4f\x4e", "\61\56\x30\x2e\x30");
define("\x55\x4d\120\x52\137\103\x53\123\x5f\125\122\114", UMPR_URL . "\151\x6e\143\154\x75\x64\145\163\57\x63\163\x73\57\x73\x65\164\164\151\156\147\x73\x2e\155\151\x6e\x2e\143\x73\163\x3f\x76\145\162\x73\151\x6f\x6e\75" . UMPR_VERSION);
function get_umpr_option($GM, $s6 = null)
{
    $GM = ($s6 == null ? "\x6d\157\137\165\x6d\137\160\162\137" : $s6) . $GM;
    return get_mo_option($GM, '');
}
function update_umpr_option($Dc, $Xd, $s6 = null)
{
    $Dc = ($s6 === null ? "\x6d\157\137\165\155\137\x70\x72\137" : $s6) . $Dc;
    update_mo_option($Dc, $Xd, '');
}
