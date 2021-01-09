<?php

function tot_notice_first_activation() {
    ?>
    <div class="updated notice tot-notice-first-activation is-dismissible tot-dismiss-notice" data-notice="first_activation">
        <h2><span class="tot-notice-icon"><img src="<?php echo tot_origin(); ?>/external_assets/wordpress/<?php echo tot_plugin_get_version(); ?>/activate/success.svg"/></span>Nice work!</h2>
        <p>You successfully installed the Identity Verification Plugin by Token of Trust.</p>
        <p><a href="https://app.tokenoftrust.com/new_account/?utm_source=wordpress&utm_medium=integration&utm_campaign=wordpress&utm_content=wordpress_plugin" target="_blank">Get your license key</a></p>
    </div>
    <?php
}