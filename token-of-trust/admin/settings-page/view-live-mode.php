<?php

$tot_license_detail_request = tot_refresh_keys();
$tot_admin_connection_test = tot_get_admin_access_token(true);
$keys = tot_get_keys();
$app_domain = tot_get_setting_prod_domain();
$app_title = !is_wp_error($keys) && $keys['app_title'] ? $keys['app_title'] : 'Our app';
$tot_get_live_keys_mailto = 'mailto:support@tokenoftrust.com?subject='
    . 'Live Mode for ' . $app_domain
    . '&body='
    . $app_title . ' is ready to go live and we\'re ready for you to review the site for approval. You can view the site at ' . $_SERVER['HTTP_HOST'] . '. Please contact us if you have any questions.';

?>

<div class="wrap tot-settings-page tot-settings-page-live-mode">

    <div class="tot-left-col">

        <h1>Live Mode</h1>

        <?php

        if(tot_live_mode_available()) {

        ?>

            <h2>Congratulations!</h2>
            <p>Live mode is Enabled.</p>
            <a href="?page=totsettings_license" class="button button-primary">Back to API settings</a>

        <?php

        }else {

        ?>

            <h2>Switch from sandbox to live mode</h2>
            <p>Your website is currently setup to connect with the Token of Trust sandbox, a virtual testing environment that mimics the live Token of Trust production environment. Token of Trust sandbox supports the same components and API features as the live environment.</p>
            <p><strong>Submit Website for Approval.</strong></p>
            <p>All Token of Trust integrations require approval before live-mode may be enabled.</p>
            <p><a href="<?php echo $tot_get_live_keys_mailto; ?>" class="button button-primary">Start a Submission</a></p>

            <br><hr><br>

            <h2>Already done?</h2>
            <p>Once live mode is enabled on your Token of Trust account, update our API keys here.</p>
            <p>
                <a href="" class="button button-primary">Refresh your API keys</a>

            </p>

            <br><hr><br>

            <?php tot_display_error_console(array($tot_license_detail_request, $tot_admin_connection_test, $keys), tot_keys_work('test'), tot_keys_work('live')); ?>

        <?php

        }

        ?>

    </div>

</div>
