<?php

function tot_add_educational_div($tot_connection_test, $is_test_mode, $is_live_mode, $tot_is_production) {
    ?>
    <div class="">
        <div class="tot-edu-row">
            <div class="tot-edu-column">
                <h1 id="tot-edu-header">Getting started with Token of Trust.</h1>
            </div>
        </div>
        <div id = "tot-edu-main-content">
            <p>Welcome to the Token of Trust Identity Verification plugin for WordPress.</p>
            <div class="tot-edu-row">
                <div class="tot-edu-column">
                    <h3>Features on paid plans include:</h3>
                    <ul id = "tot_features_list">
                        <li>Age verification</li>
                        <li>Government issued ID verification</li>
                        <li>Configurable/custom verification workflows</li>
                        <li>Page level protection using verification results</li>
                        <li>Viewable user verification summaries</li>
                    </ul>
                </div>
                <div class="tot-edu-column"></div>
            </div>

            <a href="?page=totsettings_license" class = "button button-primary button-large" id = "tot_configure_button">Start Configuring</a>
            <span>Questions? Try our <a href = <?php echo tot_mailto_support($tot_connection_test, $is_test_mode, $is_live_mode, $tot_is_production);?>>email support</a></span>

            <div class="tot-edu-row tot-callout-row">
                <div class="tot-edu-column">
                    <a href="https://tokenoftrust.com/p/id_verification_wordpress/#workflows" class="tot-edu-img"><img src="<?php echo tot_origin(); ?>/external_assets/wordpress/<?php echo tot_plugin_get_version(); ?>/showVerificationWorkflowDetails/img_wp_verificationWorkflow.jpg"/></a>
                    <div class="tot-edu-content">
                        <h1>Verification Workflows</h1>
                        <p>Verification workflow sequences can be configured to suit the needs of your website.</p>
                        <p><a href="https://tokenoftrust.com/p/id_verification_wordpress/#workflows">View example workflows</a></p>
                    </div>
                </div>
                <div class="tot-edu-column">
                    <a href="https://tokenoftrust.com/docs/integrations/wordpress/#embeds" class="tot-edu-img"><img src="<?php echo tot_origin(); ?>/external_assets/wordpress/<?php echo tot_plugin_get_version(); ?>/showEmbeddableComponentsDetails/img_wp_embeddableComponents.jpg"/></a>
                    <div class="tot-edu-content">
                        <h1>Embeddable Components</h1>
                        <p>A variety of components can be embedded using shortcodes into user profiles, index pages, and admin panels.</p>
                        <p><a href="https://tokenoftrust.com/docs/integrations/wordpress/#embeds">See all embeddable components</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}
function tot_mailto_support($tot_connection_test, $is_test_mode, $is_live_mode, $tot_is_production){
    global $wpdb;
    $subject = "[". tot_get_setting_prod_domain(). "] Support Request";

    $body = "Environment Information:\nPlugin Version: " . tot_plugin_get_version(). "\nPHP Version:" . phpversion() .
        "\nMySQL Version: " .  $wpdb->db_version() . "\nWordPress Version: " . get_bloginfo('version').
        "\nSSL enable: " . (isset($_SERVER['HTTPS']) && strtoupper($_SERVER['HTTPS']) == 'ON' ? "true" : "false") .
        "\nAPI Connection: " . (!is_wp_error($tot_connection_test) ? "true" : "false") .
        "\nTest Mode: " . ($is_test_mode ? "true" : "false") . "\nLive Mode: " . ($is_live_mode  ? "true" : "false") .
        "\nConnection Type: " . (is_wp_error($tot_is_production) ? "Error" : ($tot_is_production ?  'Live Mode':'Test Mode')) ;

    $a = "mailto:support@tokenoftrust.com?subject=". rawurlencode($subject)."&amp;body=". rawurlencode($body);

    return $a;
}