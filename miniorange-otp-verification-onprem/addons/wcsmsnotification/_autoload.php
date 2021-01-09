<?php


if (defined("\x41\x42\123\x50\101\124\x48")) {
    goto Lz;
}
die;
Lz:
define("\115\123\116\x5f\104\x49\x52", plugin_dir_path(__FILE__));
define("\x4d\x53\116\x5f\125\122\x4c", plugin_dir_url(__FILE__));
define("\x4d\x53\x4e\137\126\105\x52\x53\111\117\116", "\x31\56\x30\x2e\60");
define("\115\123\116\137\103\123\123\x5f\x55\x52\x4c", MSN_URL . "\x69\156\143\154\x75\x64\145\163\x2f\x63\x73\x73\x2f\x73\145\x74\x74\151\156\147\163\56\155\x69\x6e\56\x63\163\x73\77\166\145\162\x73\151\x6f\156\x3d" . MSN_VERSION);
define("\115\123\116\x5f\112\123\x5f\x55\122\x4c", MSN_URL . "\x69\156\x63\154\165\144\145\163\57\152\x73\57\163\x65\164\164\151\156\147\x73\x2e\x6d\x69\156\56\x6a\163\77\x76\145\x72\x73\151\157\x6e\x3d" . MSN_VERSION);
function get_wc_option($GM, $s6 = null)
{
    $GM = ($s6 === null ? "\x6d\x6f\x5f\x77\143\137\x73\x6d\163\137" : $s6) . $GM;
    return get_mo_option($GM, '');
}
function update_wc_option($Dc, $Xd, $s6 = null)
{
    $Dc = ($s6 === null ? "\155\157\137\167\x63\x5f\163\155\163\x5f" : $s6) . $Dc;
    update_mo_option($Dc, $Xd, '');
}
