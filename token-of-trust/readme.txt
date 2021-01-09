=== Token of Trust Identity Verification  ===
Contributors: tokenoftrust
Tags: identity verification, id verification, member verification, user verification, age verification, social media
verification, government id verification
Requires at least: 3.0.1
Tested up to: 5.4.1
Requires PHP: 7.2.0
Stable tag: 1.4.46
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
 
Add Token of Trust's identity verification process and verification status components to WordPress websites.

== Screenshots ==

1. The 'account connector' is an embeddable component that invokes the Token of Trust verification workflow. The 'reputation summary' is an embeddable component that represent the current state of verification for a given user.
2. The Token of Trust Identity Verification Plugin for WordPress works with WordPress core and also has deeper integrations with select WordPress Member Management Plugins.
3. The Token of Trust settings page is where website admins can enter their License Key and check the integration status with the Token of Trust Platform.

== Description ==

Verify people creating new accounts and transacting on your website without hassle. Whether you need to prevent fraud, verify age, or meet KYC and AML compliance guidelines, you can quickly and easily add identity verification by Token of Trust to ensure your website is accepting orders from verified customers and restricting membership sites to participation from verified users. For full details see [Token of Trust’s WordPress Integration Options and Scenarios](https://tokenoftrust.com/docs/integrations/wordpress/?utm_source=wordpress&utm_medium=integration&utm_campaign=wordpress&utm_content=wordpress.org_plugin-page).

This plugin connects your WordPress site with Token of Trust’s robust identity verification platform. To use this plugin with live users, you will need an active subscription with Token of Trust but you can [get started today](https://app.tokenoftrust.com/accounts/new/?utm_source=wordpress&utm_medium=integration&utm_campaign=wordpress&utm_content=wordpress.org_plugin-page) in test-mode by getting a license key from Token of Trust. When you’re ready to go live, a Token of Trust verification expert will help you find the best configuration to fit your needs.
 
= TOP FEATURES =

* Fast-track for repeat customers - makes it faster and easier for them and you save money on repeat verifications!
* Stand-alone web portal - launch now and run ad-hoc verifications to protect your riskiest orders today.
* Supports specialized integrations - for WooCommerce, Ultimate Member and BuddyPress.
* Supports a wide range of verifications - age verification, SMS/phone Verification, KYC, AML, Email Verification, Proof of Address, Electronic ID verification, Government Issued ID Capture and Verification, Selfie Capture and verification and Online Activity Verification (Facebook, LinkedIn, Paypal).
* Supporting for whitelisting - if you're switching from another platform and want to make sure you don't have to re-verify 1000s of people again.
* Mobile responsive design - means it works flawlessly on smartphones, tablets, and desktops.
* Integrated workflows - are by users quickly and easily without leaving your site.
* Support for GDPR and CCPA - helps to ensure you don't have to touch personal data to makes compliance easy for your team.
* Supports multilingual and internationalization - to ensure you can maximize your websites reach.


= ADDITIONAL FEATURES =

* Access to the Top Rated Token of Trust Identity Verification, Age Verification and Fraud Prevention platform. It is constantly evolving so you’re up to date with the latest identity verification technologies.
* Customizable workflows to fit your evolving verification and compliance needs - new verification no longer require additional development work.
* Online Activity Verification - across Facebook, LinkedIn and, PayPal, can be used as a quick check to fight fraud.
* Support auditing by viewing recent verification activity.
* Verification summary for sharing on user profiles to give users confidence that they're dealing with other reputable members.
* Reputation Reports to give your team actionable details about what users have been able to prove and what to be careful about.
* Manually approve users when you need to with our Approve Users feature.
* Automation for Order Approvals - when your backend team is confident that they know which orders to pass and which orders to inspect you can level up your team's efficiency.


= HOW DOES THIS PLUGIN WORK? =

1. The plugin guides users through your verification process without leaving your web-page. (Please note that social verifications do require departure from your site if enabled).
1. We verify the user and take care of the sensitive personal information - it never hits your site.
1. Depending upon your configuration, plan and the verification results users can be automatically or manually approved.
1. When the verification process is complete, the Token of Trust platform creates a reputation report that displays a verification summary that can be used by administrators or shared on member profiles to support decision-making. The reputation report can be accessed visually or via Token of Trust’s API to support automation.

USING TOKEN OF TRUST WITH WOOCOMMERCE

WooCommerce support is currently in private beta. Contact [support@tokenoftrust.com](mailto:support@tokenoftrust.com) if you'd like to participate.

Token of Trust can be configured with WooCommerce to verify customers in the checkout process in any of 3 ways:

1. for all products
1. for products within certain categories or with certain tags
1. for carts over a configurable dollar amount

This allows you to apply age verification, anti-fraud and compliance measures only where you really need them.

= USING TOKEN OF TRUST WITH MEMBER MANAGEMENT PLUGINS =

The Token of Trust plugin for WordPress works best alongside member management plugins that establish user profiles and account settings pages within WordPress. The member management plugins we currently support without advanced configurations are:

*   BuddyPress
*   Ultimate Member
*   For those who are more ambitious, shortcodes are available for advanced WordPress integrations.

= OTHER INTEGRATIONS =

See [Token of Trust's Wordpress Integration options and scenarios](https://tokenoftrust.com/docs/integrations/wordpress/?utm_source=wordpress&utm_medium=integration&utm_campaign=wordpress&utm_content=wordpress.org_plugin-page) or [Contact Us](https://tokenoftrust.com/contact/general_form/?utm_source=wordpress&utm_medium=integration&utm_campaign=wordpress&utm_content=wordpress.org_plugin-page) for details on all the ways you can use Token of Trust with Wordpress or contact [support@tokenoftrust.com](mailto:support@tokenoftrust.com) with questions.

= LANGUAGES =

Token of Trust has been translated into the following languages:

*   English (US)
*   Spanish
*   French
 
= WE LOVE FEEDBACK =

We're on a mission to help people make safe and smart decisions online. If you have an idea for how we can improve our plugin or platform, [Send us a Message](https://tokenoftrust.com/contact/general_form/?utm_source=wordpress&utm_medium=integration&utm_campaign=wordpress&utm_content=wordpress.org_plugin-page)


== Changelog =


## 1.4.46 ##

- Added support for a filter (tot_verification_gates_is_met) to allow customization of the conditions under which the verification gates return 'is_met'.
- Removed some type specifications to improve PHP backward compatibility.
- Make the 'verification-required' url more resilient by sending it through site_url().

= 1.4.45 =

- Support for guest checkout verification when there is no user signed in.
- Fix for case when tot reviewer approved webhook was being ignored.

= 1.4.44 =

- Explicitly add ctp_order_key to list of query param variables.

= 1.4.43 =

- Search for ctp_order_key in addition to woocommerce 'key' to support Custom Thank You Page for Woo Commerce plugin.

= 1.4.42 =

- Fix an issue where new versions of tot-get-verified.js were not getting loaded.

= 1.4.41 =

- Very minor fix - to eliminate a warning message when dealing with restricted categories.

= 1.4.40 =

- Fix for an issue where modal dialog sometimes popped up blank or with error.

= 1.4.39 =

- Improved error handling and visibility for calls to verify person.

= 1.4.38 =

- Fixes for tot-reputation-status shortcode - error when not within order context.
- Changed default to not auto-launch. Now specify auto-launch-when-not-verified="true" if we should automatically launch.

= 1.4.37 =

- Allow tot-reputation-status shortcode to be used for orders as well as users. Allows support for custom thank you pages.

= 1.4.36 =

- Fix for slow network connections causing modals not to load.
- Formatting for the sample verification required page.


= Earlier Versions =

For the earlier versions, please see the separate changelog.txt file.


== Installation ==

= From your WordPress dashboard =

1. Visit Plugins > Add New
2. Search for Token of Trust
3. Activate the Token of Trust plugin from your Plugins page.
4. Navigate to the new Token of Trust settings page in the WordPress admin menu
5. Complete the fields for production domain and your API keys.
 
= From WordPress.org or GitHub =

1. Upload the Token of Trust plugin folder to:
   `/wp-content/plugins/`
2. Activate the Token of Trust plugin from your Plugins page.
4. Navigate to the new Token of Trust settings page in the WordPress admin menu
5. Complete the fields for production domain and your API keys.

Once complete, the WordPress dashboard will contain an Account Connector widget. Any BuddyPress or Ultimate Member profiles will contain a Verifications tab and new shortcodes will be available.

For additional help and documentation for integrating Token of Trust components on WordPress sites, please visit the [WordPress Plugin Docs on our website](https://tokenoftrust.com/docs/integrations/wordpress/?utm_source=wordpress&utm_medium=integration&utm_campaign=wordpress&utm_content=wordpress.org_plugin-page).

= Widget Shortcodes =

You can use the shortcodes below to render tot widgets where you want them. Short codes will default to the currently logged-in user.

= Account Connector =

Allows the logged in user to connect their account to token of trust. After connecting this shows their reputation (much like the Reputation Summary below) and allows navigation to Token of Trust to improve their reputation and configure their user.

Please Note: For security reasons this widget should only be shown on password protected pages for the intended user!

`
[tot-wp-embed tot-widget="accountConnector"][/tot-wp-embed]
`

To show the account connector using to the person API.

`
[tot-wp-embed tot-widget="accountConnector" verification-model="person"][/tot-wp-embed]
`

= Reputation Summary =

Displays a summary view of the user's reputation.

`
[tot-wp-embed tot-widget="reputationSummary"][/tot-wp-embed]
`

= Profile Photo =

Displays a given user's selected token of trust photo.

`
[tot-wp-embed tot-widget="profilePhoto"][/tot-wp-embed]
`

= Verified Indicator =

Displays a small indication of how far the user has gone through token of trust verification process.

`
[tot-wp-embed tot-widget="verifiedIndicator"][/tot-wp-embed]
`

To show this indication when members are not verified, use with this additional attribute.

`
[tot-wp-embed tot-widget="verifiedIndicator" tot-show-when-not-verified="true"][/tot-wp-embed]
`

= Additional Settings =

You can override any short code user by passing additional attributes as follows:

`
[tot-wp-embed wp-userid="EXAMPLE" tot-widget="reputationSummary"][/tot-wp-embed]
`

= Render in templates/PHP =

The easiest way to render widgets from templates is to use shortcodes just like in the WordPress admin interface

`
<?php

echo do_shortcode('[tot-wp-embed tot-widget="reputationSummary"][/tot-wp-embed]');
`

== Frequently Asked Questions ==

= Is Token of Trust compliant with the EU’s General Data Protection Regulation (GDPR)? =

Yes, Token of Trust maintains compliance with GDPR as a “Data Processor”. You may request Token of Trust’s Data Processing Addendum (DPA) by emailing [support@tokenoftrust.com](mailto:support@tokenoftrust.com).

= Do I have to create a Token of Trust account before using this plugin? =

Yes. This is plugin connects your Token of Trust account to your WordPress site using a license key and requires that you [create a Token of Trust account](https://app.tokenoftrust.com/accounts/new/?utm_source=wordpress&utm_medium=integration&utm_campaign=wordpress&utm_content=wordpress.org_plugin-page) to get started. A credit card is not required to try it out. All Token of Trust accounts start in test-mode, allowing free testing without affecting your live data. You can switch from test-mode to live-mode whenever you’re ready for launch.

= Does Token of Trust support age verification? =

Yes. Token of Trust is capable of confirming a person's identity, determining their age, and checking if they’re above a minimum age. Token of Trust can support websites with minimum age requirements. This may apply to e-commerce merchants selling age-restricted products, such as alcohol, tobacco and firearms. Visit Token of Trust’s [Age Verification page](https://tokenoftrust.com/product/age-verification/?utm_source=wordpress&utm_medium=integration&utm_campaign=wordpress&utm_content=wordpress.org_plugin-page) to learn more.

= Does Token of Trust verify government-issued photo IDs like a Passport? =

Yes. Official government IDs like a Passport or National ID Card can be captured and analyzed within Token of Trust’s verification workflow. Not all types of identity documents are accepted everywhere. For example, Student IDs are not an accepted document type in any country, but government-issued Drivers Licenses are accepted in select countries. Check our website [for more information about our Real World Verification](https://tokenoftrust.com/product/real_world_verification/). If you have questions about a specific document type, please email [support@tokenoftrust.com](mailto:support@tokenoftrust.com).

= Does Token of Trust verify my users' social identity? =

Yes. Once your Token of Trust account is setup and connected to your WordPress plugin, your site can verify customer social identities and display the level of verification on their profile.

= Can I choose where verification displays for an advanced or custom application? =

Yes. We do support advanced shortcodes, javascript embeds and manual PHP rendering tools. See our website for more details on [Token of Trust's Wordpress Integration options and scenarios](https://tokenoftrust.com/docs/integrations/wordpress/?utm_source=wordpress&utm_medium=integration&utm_campaign=wordpress&utm_content=wordpress.org_plugin-page) or [contact Token of Trust](https://tokenoftrust.com/contact/?utm_source=wordpress&utm_medium=integration&utm_campaign=wordpress&utm_content=wordpress.org_plugin-page) to ask specific questions about advanced integration details.

= What integrations do you support for building communities, marketplaces and other types of member management? =

*   BuddyPress
*   Ultimate Member

= What factors contribute to a member's identity verification? =

Token of Trust verification looks at a variety of attributes across multiple social networks and real world IDs like driver's licenses. Some attributes include:

*   Account age
*   Activity location, geo tags and meta other meta data
*   Age verification
*   Name verification
*   Social fraud network scans
*   Government fraud lists
*   ID property consistency and security features
*   Electronic ID Verification (eIDV)

= Can I run Token of Trust from localhost? =

Yes we currently support running from any of the following localhost ports with our test keys: 80, 443, 3000, 3001, 3443, 7888, 8000, 8080, 8888, 32080, 32443, or 33080.

The Token of Trust plugin automatically detects when you're running on localhost so no configuration change is required - your Live Site always remains your production site.
