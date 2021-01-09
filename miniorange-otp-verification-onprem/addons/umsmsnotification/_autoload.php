<?php


if (defined("\x41\x42\123\120\x41\124\110")) {
    goto EU;
}
die;
EU:
define("\125\115\123\116\137\x44\111\x52", plugin_dir_path(__FILE__));
define("\x55\x4d\123\116\137\125\x52\x4c", plugin_dir_url(__FILE__));
define("\x55\115\x53\x4e\x5f\126\105\x52\x53\x49\x4f\116", "\61\x2e\x30\56\x30");
define("\125\115\x53\116\137\103\123\123\x5f\x55\122\114", UMSN_URL . "\151\x6e\143\154\165\144\145\x73\x2f\x63\163\163\57\163\x65\x74\164\151\156\x67\x73\56\x6d\x69\x6e\x2e\x63\x73\x73\77\x76\145\162\x73\151\x6f\156\x3d" . UMSN_VERSION);
function get_umsn_option($GM, $s6 = null)
{
    $GM = ($s6 == null ? "\155\157\x5f\x75\155\137\163\x6d\x73\x5f" : $s6) . $GM;
    return get_mo_option($GM, '');
}
function update_umsn_option($Dc, $Xd, $s6 = null)
{
    $Dc = ($s6 === null ? "\x6d\157\x5f\165\x6d\137\163\155\163\x5f" : $s6) . $Dc;
    update_mo_option($Dc, $Xd, '');
}
