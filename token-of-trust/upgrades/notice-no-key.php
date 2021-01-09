<?php

function tot_notice_no_key() {
    ?>
    <div class="updated notice tot-notice-no-key is-dismissible tot-dismiss-notice" data-notice="no_key">
        <h2><span class="tot-notice-icon"><img src="<?php echo tot_origin(); ?>/external_assets/wordpress/<?php echo tot_plugin_get_version(); ?>/welcome/logo.svg"/></span>Identity Verification Key</h2>
        <p>A license key is required to activate the Identity Verification Plugin by Token of Trust.</p>
        <p><a href="https://app.tokenoftrust.com/new_account/?utm_source=wordpress&utm_medium=integration&utm_campaign=wordpress&utm_content=wordpress_plugin" target="_blank">Get your license key</a></p>
    </div>
    <?php
}