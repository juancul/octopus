<?php

/**
 * Adding a new field:
 *
 * 1. The section is registered with `register_setting`
 * 2. The section is rendered with `settings_fields` and `do_settings_sections` in `view-general-settings.php`
 * 3. The section is added with `add_settings_section`
 * 4. The field is added with `add_settings_field`
 * 5. The callback function is defined. These commonly use:
 *        `tot_checkbox_field`
 *        `tot_standard_text_field`
 *        `tot_dropdown_field`
 *        `tot_textarea_field`
 * 6. The field is saved in `tot_save_theme_settings`
 */

add_action('admin_init', 'tot_settings_init');

function tot_settings_init()
{
    register_setting('tot', 'tot_options');
    register_setting('tot_settings_email', 'tot_options');
    register_setting('tot_settings_tracking', 'tot_options');
    add_action("load-toplevel_page_totsettings", 'tot_load_settings_page');
    // Section: Keys
    add_settings_section(
        'tot_section_keys',
        __('License & API', 'token-of-trust'),
        'tot_no_op',
        'tot'
    );
    add_settings_section(
        'tot_section_email',
        __('Email Confirmation', 'token-of-trust'),
        'tot_no_op',
        'tot_settings_email'
    );
    add_settings_section(
        'tot_settings_verification_gates',
        __('Verification Gates', 'token-of-trust'),
        'tot_no_op',
        'tot_settings_verification_gates'
    );

    add_settings_section(
        'tot_settings_approval',
        __('User Approval', 'token-of-trust'),
        'tot_no_op',
        'tot_settings_approval'
    );
    add_settings_section(
        'tot_section_tracking',
        __('User Tracking', 'token-of-trust'),
        'tot_no_op',
        'tot_settings_tracking'
    );

    // Field: Production Domain
    add_settings_field(
        'tot_field_prod_domain', // as of WP 4.6 this value is used only internally
        // use $args' label_for to populate the id inside the callback
        __('Live Site Domain<sup class="tot-required">*</sup>', 'token-of-trust'),
        'tot_field_prod_domain_cb',
        'tot',
        'tot_section_keys',
        [
            'label_for' => 'tot_field_prod_domain'
        ]
    );

    // Field: License Key
    add_settings_field(
        'tot_field_license_key', // as of WP 4.6 this value is used only internally
        // use $args' label_for to populate the id inside the callback
        __('License Key<sup class="tot-required">*</sup>', 'token-of-trust'),
        'tot_field_license_key_cb',
        'tot',
        'tot_section_keys',
        [
            'label_for' => 'tot_field_license_key'
        ]
    );

    // Field: Confirm New User Emails
    add_settings_field(
        'tot_field_confirm_new_user_emails', // as of WP 4.6 this value is used only internally
        // use $args' label_for to populate the id inside the callback
        __('Confirm New User Emails', 'token-of-trust'),
        'tot_field_confirm_new_user_emails_cb',
        'tot_settings_email',
        'tot_section_email',
        [
            'label_for' => 'tot_field_confirm_new_user_emails'
        ]
    );

    // Field: Confirm Email Success Redirect
    add_settings_field(
        'tot_field_confirm_email_success_redirect', // as of WP 4.6 this value is used only internally
        // use $args' label_for to populate the id inside the callback
        __('Confirm Email Success Redirect', 'token-of-trust'),
        'tot_field_confirm_email_success_redirect_cb',
        'tot_settings_email',
        'tot_section_email',
        [
            'label_for' => 'tot_field_confirm_email_success_redirect'
        ]
    );

    // Field: Debug Mode
    add_settings_field(
        'tot_field_debug_mode', // as of WP 4.6 this value is used only internally
        // use $args' label_for to populate the id inside the callback
        __('Debug Mode', 'token-of-trust'),
        'tot_field_debug_mode_cb',
        'tot',
        'tot_section_keys',
        [
            'label_for' => 'tot_field_debug_mode'
        ]
    );


    // Field: Enable Approval of Users via Admin panels.
    add_settings_field(
        'tot_field_verification_gates_enabled', // as of WP 4.6 this value is used only internally
        // use $args' label_for to populate the id inside the callback
        __('Enable Verifications by Page.', 'token-of-trust'),
        'tot_field_verification_gates_enabled_cb',
        'tot_settings_verification_gates',
        'tot_settings_verification_gates',
        [
            'label_for' => 'tot_field_verification_gates_enabled'
        ]
    );


    // Field: Enable Approval of Users via Admin panels.
    add_settings_field(
        'tot_field_approval', // as of WP 4.6 this value is used only internally
        // use $args' label_for to populate the id inside the callback
        __('Allow admin\'s to manually approve users.', 'token-of-trust'),
        'tot_field_approval_cb',
        'tot_settings_approval',
        'tot_settings_approval',
        [
            'label_for' => 'tot_field_approval'
        ]
    );

    // Field: Approval Role
    add_settings_field(
        'tot_field_approved_role', // as of WP 4.6 this value is used only internally
        // use $args' label_for to populate the id inside the callback
        __('Role for approved users', 'token-of-trust'),
        'tot_field_approved_role_cb',
        'tot_settings_approval',
        'tot_settings_approval',
        [
            'label_for' => 'tot_field_approved_role'
        ]
    );

    // Field: Debug Mode
    add_settings_field(
        'tot_field_rejected_role', // as of WP 4.6 this value is used only internally
        // use $args' label_for to populate the id inside the callback
        __('Role for rejected users', 'token-of-trust'),
        'tot_field_rejected_role_cb',
        'tot_settings_approval',
        'tot_settings_approval',
        [
            'label_for' => 'tot_field_rejected_role'
        ]
    );

    // Field: Debug Mode
    add_settings_field(
        'tot_field_pending_role', // as of WP 4.6 this value is used only internally
        // use $args' label_for to populate the id inside the callback
        __('Role for pending users', 'token-of-trust'),
        'tot_field_pending_role_cb',
        'tot_settings_approval',
        'tot_settings_approval',
        [
            'label_for' => 'tot_field_pending_role'
        ]
    );

// TODO - Future support for not_verified here.
// Field: Debug Mode
//    add_settings_field(
//        'tot_field_not_verified_role', // as of WP 4.6 this value is used only internally
//        // use $args' label_for to populate the id inside the callback
//        __('Role for unverified users', 'token-of-trust'),
//        'tot_field_not_verified_role_cb',
//        'tot_settings_approval',
//        'tot_settings_approval',
//        [
//            'label_for' => 'tot_field_not_verified_role'
//        ]
//    );

    // Field: Debug Mode
    add_settings_field(
        'tot_field_auto_identify', // as of WP 4.6 this value is used only internally
        // use $args' label_for to populate the id inside the callback
        __('Identify user', 'token-of-trust'),
        'tot_field_auto_identify_cb',
        'tot_settings_tracking',
        'tot_section_tracking',
        [
            'label_for' => 'tot_field_auto_identify'
        ]
    );
}

//////////
// Section Callbacks

// Section: Keys
function tot_no_op($args)
{
    // no-op
}

//detects  calls to update settings
//Code for this method and tot_save_theme_settings is based on "https://www.smashingmagazine.com/2011/10/create-tabs-wordpress-settings-pages/"
function tot_load_settings_page()
{

    if (current_user_can('manage_options') && isset($_POST["tot_options"])) {
        tot_save_theme_settings();
        $goback = add_query_arg('settings-updated', 'true', wp_get_referer());
        tot_add_flash_notice('Settings updated', 'success', false);
        wp_redirect($goback);
        exit;
    }
}

//Method that handles post data from settings form submssion
function tot_save_theme_settings()
{
    global $pagenow;
    $settings = get_option('tot_options');

    if ($pagenow == 'admin.php' && strpos($_GET['page'], 'totsettings') !== false) {
        if (strpos(wp_get_referer(), 'totsettings_general') !== false) {

//            $settings['tot_field_confirm_new_user_emails'] = $_POST['tot_options']['tot_field_confirm_new_user_emails'];
//            $settings['tot_field_confirm_email_success_redirect'] = $_POST['tot_options']['tot_field_confirm_email_success_redirect'];
            $settings['tot_field_verification_gates_enabled'] = isset($_POST['tot_options']['tot_field_verification_gates_enabled']) ? '1' : '';
            $settings['tot_field_approval'] = isset($_POST['tot_options']['tot_field_approval']) ? '1' : '';
            $settings['tot_field_approved_role'] = $_POST['tot_options']['tot_field_approved_role'];
            $settings['tot_field_rejected_role'] = $_POST['tot_options']['tot_field_rejected_role'];
            $settings['tot_field_pending_role'] = $_POST['tot_options']['tot_field_pending_role'];
            $settings['tot_field_auto_identify'] = isset($_POST['tot_options']['tot_field_auto_identify']) ? '1' : '';

        } elseif (strpos(wp_get_referer(), 'totsettings_license') !== false) {
            $settings['tot_field_prod_domain'] = $_POST['tot_options']['tot_field_prod_domain'];
            $settings['tot_field_license_key'] = $_POST['tot_options']['tot_field_license_key'];
            $settings['tot_field_debug_mode'] = isset($_POST['tot_options']['tot_field_debug_mode']) ? '1' : '';
        }
    }
    $updated = update_option('tot_options', $settings);
}

/////////
// Field Callbacks

function tot_standard_text_field($args, $description = null, $additional_text = null)
{
    $options = get_option('tot_options');

    if (isset($additional_text)) {
        foreach ($additional_text as $paragraph) {
            ?>
            <p>
                <?php echo $paragraph; ?>
            </p>
            <?php
        }
    }

    ?>

    <input class="tot_field_standard"
           value="<?php echo isset($options[$args['label_for']]) ? $options[$args['label_for']] : ""; ?>"
           id="<?php echo esc_attr($args['label_for']); ?>"
           name="tot_options[<?php echo esc_attr($args['label_for']); ?>]"/>
    <?php

    if (isset($description)) {
        foreach ($description as $paragraph) {
            ?>
            <p class="description">
                <?php echo $paragraph; ?>
            </p>
            <?php
        }
    }
}

function tot_textarea_field($args, $description = null, $additional_text = null)
{
    $options = get_option('tot_options');

    if (isset($additional_text)) {
        foreach ($additional_text as $paragraph) {
            ?>
            <p>
                <?php echo $paragraph; ?>
            </p>
            <?php
        }
    }

    ?>
    <textarea rows="5" class="tot_field_standard" id="<?php echo esc_attr($args['label_for']); ?>"
              name="tot_options[<?php echo esc_attr($args['label_for']); ?>]"><?php echo isset($options[$args['label_for']]) ? $options[$args['label_for']] : "" ?></textarea>
    <?php

    if (isset($description)) {
        foreach ($description as $paragraph) {
            ?>
            <p class="description">
                <?php echo $paragraph; ?>
            </p>
            <?php
        }
    }
}


function tot_dropdown_field($args, $options_array, $description = null, $additional_text = null)
{
    $options = get_option('tot_options');

    if (isset($additional_text)) {
        foreach ($additional_text as $paragraph) {
            ?>
            <p>
                <?php echo $paragraph; ?>
            </p>
            <?php
        }
    }

    ?>
    <select class="tot_field_standard"
            id="<?php echo esc_attr($args['label_for']); ?>"
            name="tot_options[<?php echo esc_attr($args['label_for']); ?>]">
        <?php
        foreach ($options_array as $opt) {
            $selected = '';
            if (isset($options) && isset($options[$args['label_for']])) {
                $selected = selected($options[$args['label_for']], $opt['value'], false);
            }
            echo '<option value="' . $opt['value'] . '" ' . $selected . '>' . $opt['label'] . '</option>';
        } ?>
    </select>
    <?php

    if (isset($description)) {
        foreach ($description as $paragraph) {
            ?>
            <p class="description">
                <?php echo $paragraph; ?>
            </p>
            <?php
        }
    }
}

function tot_checkbox_field($args, $description = null, $additional_text = null)
{
    $options = get_option('tot_options');

    if (isset($additional_text)) {
        foreach ($additional_text as $paragraph) {
            ?>
            <p>
                <?php echo $paragraph; ?>
            </p>
            <?php
        }
    }

    ?>
    <input type="checkbox" class="tot_field_standard" id="<?php echo esc_attr($args['label_for']); ?>"
           name="tot_options[<?php echo esc_attr($args['label_for']); ?>]"
           value="1" <?php checked(isset($options[$args['label_for']]) ? $options[$args['label_for']] : "", "1", true); ?> />
    <?php

    if (isset($description)) {
        foreach ($description as $paragraph) {
            ?>
            <p class="description">
                <?php echo $paragraph; ?>
            </p>
            <?php
        }
    }
}

// Field: Production Domain
function tot_field_prod_domain_cb($args)
{
    tot_standard_text_field($args, array(
        'Example: ' . $_SERVER['HTTP_HOST'],
        'This site will run in live mode, test and development sites will automatically run in "Test Mode."'
    ));
}

// Field: License Key
function tot_field_license_key_cb($args)
{
    $options = get_option('tot_options');
    $additional_text = null;
    $hint = null;
    $license_field_value = tot_get_setting_license_key();
    if (!tot_option_has_a_value($license_field_value)) {
        $additional_text = array('<a href="' . tot_production_origin() . '/new_account/?utm_source=wordpress&utm_medium=integration&utm_campaign=wordpress&utm_content=wordpress_plugin" class="button" target="_blank">Get a license key</a>');
    } else if (!is_wp_error(tot_get_keys())) {
        $hint = array(
            '<a href="' . tot_production_origin() . '/signup/dashboard/?utm_source=wordpress&utm_medium=integration&utm_campaign=wordpress&utm_content=wordpress_plugin" target="_blank">View license details</a>'
        );
    }

    tot_textarea_field($args, $hint, $additional_text);
}

// Field: Confirm New User Emails
function tot_field_debug_mode_cb($args)
{
    tot_checkbox_field($args, array(
        'Displays messages inline within pages. This should not be enabled on the live site unless absolutely necessary as site visitors users will see error details.'
    ));
}

// Field: Confirm Email Success Redirect
function tot_field_confirm_email_success_redirect_cb($args) {
    $options_array = [];
    $wp_pages = get_pages($arg = array('post_type' => 'page'));

    array_push($options_array, array(
        'label' => '/',
        'value' => '/'
    ));

    foreach ($wp_pages as $wp_page) {
        $path = str_replace(get_site_url(), '', get_page_link($wp_page->ID));
        array_push($options_array, array(
            'label' => $path,
            'value' => $path
        ));
    }

    tot_dropdown_field($args, $options_array, array(
        'Example: /email-thank-you',
        'Once the user confirms their email address, they will be redirected to this page on your site. Your website domain will be added to the begining of this url'
    ));
}

// Field: Debug Mode
function tot_field_confirm_new_user_emails_cb($args)
{
    tot_checkbox_field($args, array(
        'Send new users an email to confirm they own the email address provided.'
    ));
}

function tot_field_approval_cb($args)
{
    tot_checkbox_field($args, array(
        'Approve users within WordPress admin pages.'
    ));
}

function tot_shared_role_dropdown_field($args, $hint)
{
    global $wp_roles;

    $options_array = array();
    $roles = $wp_roles->roles;

    array_push($options_array, array(
            'label' => 'Do not change role',
            'value' => '')
    );

    foreach (array_keys($roles) as $key) {
        array_push($options_array, array('label' => $roles[$key]['name'], 'value' => $key));
    }

    tot_dropdown_field($args, $options_array, array($hint));
}

function tot_field_approved_role_cb($args)
{
    tot_shared_role_dropdown_field($args, 'The role to assign approved users, all other roles will be removed from the user. Administrator\'s role(s) will not be changed.');
}

function tot_field_rejected_role_cb($args)
{
    tot_shared_role_dropdown_field($args, 'The role to assign rejected users, all other roles will be removed from the user. Administrator\'s  role(s) will not be changed.');
}

function tot_field_pending_role_cb($args)
{
    tot_shared_role_dropdown_field($args, 'The role to assign pending users, all other roles will be removed from the user. Administrator\'s  role(s) will not be changed.');
}

function tot_field_auto_identify_cb($args)
{
    tot_checkbox_field($args, array(
        "Enable this feature to pass user data to Token of Trust about your WordPress users prior to accepting Token of Trust's End-User Terms of Service and Privacy Policy. This feature requires an active Service Agreement with Token of Trust and an opt-in statement in your user registration form. <a href=\"mailto:privacy@tokenoftrust.com?Subject=DPA Request\">Request a Data Processing Addendum</a>"
    ));
}
function tot_field_verification_gates_enabled_cb($args) {
    tot_checkbox_field($args, array(
        "Allows you to use Token of Trust to protect any page. Specify which ones via add_filter on 'tot_get_verification_requirement' in functions.php. Specify whether the condition is met via add_filter on 'tot_verification_gates_is_met' in functions.php."
    ));
}