# Change Log

## 1.4.46 ##

- Added support for a filter (tot_verification_gates_is_met) to allow customization of the conditions under which the verification gates return 'is_met'.
- Removed some type specifications to improve PHP backward compatibility.
- Make the 'verification-required' url more resilient by sending it through site_url().

## 1.4.45 ##

- Support for guest checkout verification when there is no user signed in.   
- Fix for case when tot reviewer approved webhook was being ignored. 

## 1.4.44 ##

- Explicitly add ctp_order_key to list of query param variables.   

## 1.4.43 ##

- Search for ctp_order_key in addition to woocommerce 'key' to support Custom Thank You Page for Woo Commerce plugin.   

## 1.4.42 ##

- Fix an issue where new versions of tot-get-verified.js were not getting loaded.   

## 1.4.41 ##

- Very minor fix - to eliminate a warning message when dealing with restricted categories. 

## 1.4.40 ##

- Fix for an issue where modal dialog sometimes popped up blank or with error. 

## 1.4.39 ##

- Improved error handling and visibility for calls to verify person. 

## 1.4.38 ##

- Fixes for tot-reputation-status shortcode - error when not within order context. 
- Changed default to not auto-launch. Now specify auto-launch-when-not-verified="true" if we should automatically launch.

## 1.4.37 ##

- Allow tot-reputation-status shortcode to be used for orders as well as users. Allows support for custom thank you pages.

## 1.4.36

- Fix for slow network connections causing modals not to load.
- Formatting for the sample verification required page.  

## 1.4.35

- Added support for product variations - detection of categories and tags for child products. 

## 1.4.34

- Fix to ensure that when minimum is cleared out that we do not verify.

## 1.4.33

- Added translations for ultimate member account and profile pages.

## 1.4.32

- Fix to remove ultimate member submit button.

## 1.4.31

- Added filter for tot_verification_gates_rejected_block.
- Updated version of php supported (hints require version 7.2+).

## 1.4.30

- Some translation updates.

## 1.4.29

- Added spanish and french translations to plugin.

## 1.4.28

- Fixed an issue where white-listed users were being challenged to get verified.
- Fixed an issue where repeat customers moved into ready for review rather than processing.
- Fixed an issue where age verified orders requiring fallback and configured for admin review didn't move into ready for review. 

## 1.4.27

- Added 'Ready for Review' status to allow admins to distinguish orders waiting for customers to those that are ready for them. 
- Approved orders are automatically moved into Processing. 
- Added 'authorization' as query parameter for webhook to improve chances for our webhooks to make it through proxies. 

## 1.4.26

- Tested on Wordpress 5.4.1.
- Fixed an error on initial install and an extra log in the debug.log that shouldn't be on unless our debug setting is on.   

## 1.4.25

- White listed orders should not be moved into Awaiting Verification.   

## 1.4.24

- Added ability to require verifications for only certain payment_methods.  

## 1.4.23

- Fixes for webhooks.
- Moved post-payment processing to pending instead. Fixes an issue with Square post processing payments.   

## 1.4.22

- Temp fix for an SSL Cert issue.   

## 1.4.21

- Non-functional - remove debug statement.  

## 1.4.20

- Fixed situation where Verification required was showing up on receipts and in orders even when disabled. 

## 1.4.19

- Added Verification Gates allowing integrators to use TOT to guard whatever pages they want. Guarded pages are redirected to a 'Verification Required' page which can be customized as desired. 
- Added the ability to turn on verification for live site testing within single session.

## 1.4.18

- Introduced new algorithm for calc of appUserid so that movement from portal to WP integration is seamless. 
  
## 1.4.17

- Fixed a problem with WooCommerce 4.x where the verification modal fails to popup.
- Fix an issue where keys can get messed up when live mode is not turned on. 
- Improve logging when tot_test_mode is turned on. 
  
## 1.4.16

- Full support for whitelisting - allows bypass of Token of Trust for pre-verified users.
- Much better detection of api connectivity problems and determination of live vs test modes.
  
## 1.4.15

- Added filter (tot_is_verification_consent_required_for_order) to allow shutoff of user-consent on checkout to support when customers add TOT to Terms of Use, when it is not required by law or to allow for alternative checks with users. Note that we recommend ALWAYS asking the user before invoking verification.  
- Fixed an issue where webhooks do not cause order to be marked verified when payment is not yet complete.  
- Added logic to allow vendor approval to mean that an item is age verified - allowing orders to be moved into processing when marked approved. 

## 1.4.14

- Re-enabled user columns in woo commerce to support account based users. 

## 1.4.13

- Update links and clarify getting started workflow.

## 1.4.12

- Updated copy to reflect new features.


## 1.4.11

- Added support to View Documents from Reputation Summary for those doing Vendor Review.

## 1.4.10

- API updates
- WooCommerce order detail summary
- WooCommerce order document review

## 1.4.9

- Additional webhooks

## 1.4.8

- Enhancement to admin order management
- Enhancement for guest checkout orders
- Bug fix for API responses

## 1.4.7

- Enhancement to verification data

## 1.4.6

- Hook and settings enhancements
- Automated workflow for verification results
- Verification summary on WooCommerce order detail page

## 1.4.5

- Hook and settings enhancements

## 1.4.4

- Woocommerce receipt page notifications
- Adding filters for verification data

## 1.4.3

- Webhook enhancements

## 1.4.2

- Woocommerce order automation for age verification
- Webhook support
- Enhanced settings

## 1.4.1

- Bug fixes
- WordPress 5.2.1 support

## 1.4.0

- Add support for WooCommerce
- Add age verification features

## 1.3.5

- Copy updates.

## 1.3.4

- WordPress 5.0.1 support

## 1.3.3

- Override Token of Trust verification status with WordPress administrator's approval decision
- Better live mode detection
- Simplify live mode process and settings screens

## 1.3.2

- Add action hook for sending additional `appData` to Token of Trust set connection end point
- Miscellaneous bug fixes
- Updated user connection and additional information with API

Release date: 2018-09-18

## 1.3.1

- Automatically assign roles when user approval status changes
- Better handling of live/testing domains
- Miscellaneous bug fixes

Release date: 2018-07-15

## 1.3.0

- Adding user approval (whitelist)
- Updating email confirmation display

Release date: 2018-06-21

## 1.2.4

- Enhanced control over test mode.

## 1.2.3

- Compatibility with php < 5.5

## 1.2.2

- Updated account management links and references.

## 1.2.1

- Adding support for Ultimate Member 2.
- Testing against recent WordPress and BuddyPress versions.

## 1.2.0

- Adding ability to report abuse to WordPress administrators.
- Added setting to automatically add this to UltimateMember and BuddyPress.
- Added ability for administrators to submit a report from the WordPress admin user screens.

## 1.1.10

- Added UltimateMember and BuddyPress settings.
- Added verified indicator and account connector to UltimateMember accounts page
- Updated debugging

## 1.1.9

- Clarified description.
- Tested against 4.9.1.

## 1.1.8

- Added email verification feature.
- Added 'Getting Started'.
- Show when not verified on Users Admin tab.

## 1.1.7

- Adding not verified state to verifiedIndicator widget short code

## 1.1.6

- Automatic SSL configuration
- Minor fixes including live mode domains

## 1.1.5

- Documentation enhancements
- Better SSL checks

## 1.1.4

- Notice enhancements

## 1.1.3

- Fallback notice layout

## 1.1.2

- Added settings link to plugins page.
- Added activation and license notices to admin UI.

## 1.1.1

- Enhancement to BuddyPress debugging.
- Connect Token of Trust Widgets to a customized user GUID.
- Migration scripts added.

## 1.0.5

- Fix to ensure that account connector is shown in ultimate member on profile page.
- Correcte API Connection check to use the client host as it should.
- Add port checking for localhost and a more explicit warning to use only supported ports.
- Added documentation for shortcodes.

## 1.0.4

- Enhancement to Ultimate Member debugging.

## 1.0.3

- Add Token of Trust widgets to WordPress User administration screens.
- Minor api connection enhancements.

## 1.0.2

- Allow the use of the production domain as test (before live keys have been issued).
- Minor changes to link/copy.

## 1.0.0

- Publish to WordPress plugin marketplace

## 0.0.7

- Live mode API key endpoint

## 0.0.6

- Environment endpoint targets
- Debug timeout
- UI improvements

## 0.0.5

- Updated set connection endpoint to match API spec
- Additional error reporting for set connection

## 0.0.4

- Migrate to license keys.
- Add capability checks.
- Add debug mode
- Error detail pages error handling.

## 0.0.3

- Added a Token of Trust widget background to default styles.
- [UltimateMember](http://ultimatemember.com/) tab logo sizing.

## 0.0.2

- [UltimateMember](http://ultimatemember.com/) integration.

## 0.0.1

- Initial support
- Settings Page.
- WordPress admin dashboard integration.
- [BuddyPress](https://buddypress.org/) integration.
