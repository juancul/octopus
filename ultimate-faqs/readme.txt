=== Ultimate FAQ - WordPress FAQ Plugin ===
Contributors: Rustaurius, EtoileWebDesign
Tags: FAQ, WooCommerce faq, faqs, faq list, accordion faq, gutenberg faq, faq block, toggle faqs, filtered faqs, grouped faqs, faq order, faq sorting
Requires at least: 5.0
Tested up to: 5.6
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Easily create and add FAQs to your WordPress site with a Gutenberg block, shortcode or widget. Includes FAQ schema, search, accordion toggle and more.

== Description ==

With this plugin you can easily create FAQs and add them to your WordPress site using a Gutenberg block or shortcode. It makes use of a custom post type and integrates seamlessly into any site. 

* [Live Demo](https://www.etoilewebdesign.com/ultimate-faq-demo/)

### Key Features

* Create unlimited FAQs
* Create unlimited FAQ tags and FAQ categories
* Gutenberg FAQ block
* FAQ shortcode
* Responsive accordion layout that will fit any site and any device
* Ordering and sorting options for your FAQ page
* Group FAQ options
* Translation ready (all strings localized and .pot file included)
* Bulk import FAQs from a spreadsheet
* Insert custom CSS to style your FAQ layout

This plugin is very user friendly and comes with a walk-through. When you activate the plugin, it will run and help you create your first FAQs, create an FAQ page and also set some important options!

### Gutenberg Block, Shortcode and Widget

* Just add the <em>Display FAQs</em> Gutenberg block on any page to display your FAQs
* Or, if you're using a different visual composer or page builder, or the Classic Editor plugin, just add the [ultimate-faqs] shortcode anywhere on any page
* The plugin also comes with a widget to display your FAQs in any widgetized area in your theme.

### Video Introduction to the Ultimate FAQ Plugin

[youtube https://www.youtube.com/watch?v=xeGVZnVrZ6I]

### Additional Features

* Microdata / structured data / question schema (in the correct JSON-LD format) to help with SEO
* Choose what elements show for each FAQ (e.g. categories, tags, author, date, etc.)
* FAQ statistics and view count
* Allow people to comment on individual FAQs

### FAQs for WooCommerce (Requires Premium)

* Easily add an FAQ tab to each product page
* Responsive accordion layout that fits seamlessly into any product page
* Create an FAQ category that matches the name of a product or category in your WooCommerce and it will automatically show!
* For more info, please see the following video:

[youtube https://www.youtube.com/watch?v=cH3p0fW4c5o]

### Ultimate FAQ Premium

The premium version of this plugin comes with the following great extra features:

* FAQ search with autocomplete for question titles
* Additional FAQ display styles
* Choose from 15 toggle icon sets for your frequently asked questions
* WP Forms Integration
* Share FAQs on social media
* Select animation options
* Drag and drop precise re-ordering of FAQs
* Add an FAQ submit form to your site, so visitors can suggest their own FAQs and also (optionally) answers
* Admin notification for new FAQ submissions
* Add additional custom fields to your FAQs, such as a text area, file, link, date and more
* Export FAQs to spreadsheet
* Export all FAQs to a PDF to create a user manual
* SEO-Friendly FAQ, category and tag permalinks
* Advanced FAQ styling options
* Change the FAQ permalink slug base

You can find out more information about the premium version and accessing a <strong><em>free 7-day trial</em></strong> here: [https://www.etoilewebdesign.com/plugins/ultimate-faq/](https://www.etoilewebdesign.com/plugins/ultimate-faq/)

### Blocks

* <strong>Display FAQs</strong>: Display all FAQs, or only specific categories using the block attributes
* <strong>Popular FAQs</strong>: Displays a number of the most viewed FAQs (5 unless specified)
* <strong>Recent FAQs</strong>: Displays a number of the most recently added FAQs (5 unless specified)
* <strong>Search FAQs</strong>: Display a search form that allows users to find FAQs with a specific string in the title or body of the FAQ post (premium)
* <strong>Submit FAQ</strong>: Display a form that allows users to submit FAQs of their own and, if enabled, enter an answer to their submitted question as well (premium)

### Shortcodes

* [ultimate-faqs]: Display all FAQs, or only specific categories using include_category and exclude_category attributes (both take a comma-separated list of category slugs)
* [popular-faqs]: Displays a number of the most viewed FAQs (5 unless specified)
* [recent-faqs]: Displays a number of the most recently added FAQs (5 unless specified)
* [select-faq]: Display specific FAQ posts, using the attributes faq_name, faq_slug and faq_id which take comma-separated lists of FAQ post names, slugs and ids respectively
* [ultimate-faq-search]: Display a search form that allows users to find FAQs with a specific string in the title or body of the FAQ post (premium)
* [submit-question]: Display a form that allows users to submit FAQs of their own and, if enabled, enter an answer to their submitted question as well (premium)

### For help and support, please see:

* Our FAQ page, here: [https://wordpress.org/plugins/ultimate-faqs/faq/](https://wordpress.org/plugins/ultimate-faqs/faq/)
* Our installation guide, here: [https://wordpress.org/plugins/ultimate-faqs/installation/](https://wordpress.org/plugins/ultimate-faqs/installation/)
* Our documentation, here: [https://www.etoilewebdesign.com/support-center/?Plugin=UFAQ&Type=FAQs](https://www.etoilewebdesign.com/support-center/?Plugin=UFAQ&Type=FAQs)
* Our tutorial videos, here: [https://www.youtube.com/playlist?list=PLEndQUuhlvSrNdfu5FKa1uGHsaKZxgdWt
](https://www.youtube.com/playlist?list=PLEndQUuhlvSrNdfu5FKa1uGHsaKZxgdWt)
* The Ultimate FAQ support forum, here: [https://wordpress.org/support/plugin/ultimate-faqs](https://wordpress.org/support/plugin/ultimate-faqs)


== Installation ==

1. Upload the 'ultimate-faqs' folder to the '/wp-content/plugins/' directory
2. Activate the plugin through the 'Plugins' menu in WordPress

or

1. Go to the 'Plugins' menu in WordPress and click 'Add New'
2. Search for 'Ultimate FAQ' and select 'Install Now'
3. Activate the plugin when prompted

= Getting Started =

1. To create an FAQ:
    * Click on 'FAQs' in the WordPress admin sidebar menu
    * Click on 'Add New'
    * Enter the FAQ question in the title area and the FAQ answer in the main post content area
    * Set the author name using the 'Author Display Name' field under the main post content area
    * Select and/or create FAQ categories and FAQ tags in the right-side menu
    * Click the 'Publish' button

2. To display FAQs on your site:
    * Place the <em>Display FAQs</em> block or the [ultimate-faqs] shortcode on any page you've created and it will display your FAQs
    * You can display specific FAQs by making use of the [select-faq] shortcode
    * Display a select number of your most popular FAQs using the <em>Popular FAQs</em> block or the [popular-faqs] shortcode
    * Display a select number of your most recent FAQs using the <em>Recent FAQs</em> block or the [recent-faqs] shortcode

3. To include a submit question form:
    * Placing the <em>Submit FAQs</em> block or the [submit-question] shortcode on a page will generate a form that allows your visitors to submit FAQ questions and, if enabled, even suggest FAQ answers for their questions (premium)

4. To include an FAQ search form:
    * Use the <em>Search FAQs</em> block or the [ultimate-faq-search] shortcode to display an FAQ search form on a page. You can even set it so that all FAQs display on the search page and so that typing in the search box filters the results. (premium)

5. Customize your FAQ experience by making use of the many available settings and options, including toggle and accordion modes, FAQ comments, FAQ category grouping (premium) and many styling options (premium).

For a list of specific features, see the FAQ description page here: [https://wordpress.org/plugins/ultimate-faqs/](https://wordpress.org/plugins/ultimate-faqs/).

For help and support, please see:

* Our FAQ page, here: [https://wordpress.org/plugins/ultimate-faqs/faq/](https://wordpress.org/plugins/ultimate-faqs/faq/)
* Our documentation, here: [https://www.etoilewebdesign.com/support-center/?Plugin=UFAQ&Type=FAQs](https://www.etoilewebdesign.com/support-center/?Plugin=UFAQ&Type=FAQs)
* Our tutorial videos, here: [https://www.youtube.com/playlist?list=PLEndQUuhlvSrNdfu5FKa1uGHsaKZxgdWt
](https://www.youtube.com/playlist?list=PLEndQUuhlvSrNdfu5FKa1uGHsaKZxgdWt)
* The Ultimate FAQ support forum, here: [https://wordpress.org/support/plugin/ultimate-faqs](https://wordpress.org/support/plugin/ultimate-faqs)


== Frequently Asked Questions ==

= How do I get my FAQs to show up on my page? =

Try adding the shortcode [ultimate-faqs] to whatever page you'd like to display the FAQ on.

= What are the current FAQ shortcodes? =

* [ultimate-faqs]: display all FAQs, or only specific FAQ categories using include_category and exclude_category attributes (both take a comma-separated list of category slugs)
* [popular-faqs]: displays a number of the most viewed FAQs (5 unless specified).
* [recent-faqs]: displays a number of the most recently added FAQs (5 unless specified).
* [select-faq]: display specific FAQ posts, using the attributes faq_name, faq_slug and faq_id which take comma-separated lists of FAQ post names, FAQ slugs and FAQ ids respectively.
* [ultimate-faq-search]: display an FAQ search form that allows users to find FAQs with a specific string in the FAQ title or body of the FAQ post (premium).
* [submit-question]: display a form that allows users to submit FAQs of their own and, if enabled, enter an FAQ answer to their submitted FAQ question as well (premium).

= What attributes does the [ultimate-faqs] shortcode accept? =

The FAQ shortcode accepts two attributes, "include_category" and "exclude_category". Both take a comma-separated list of FAQ category slugs. For example, to include only FAQs about the Category "Cars" (which has a slug "cars"), you would use:

[ultimate-faqs include_category='cars']

You can now also use the 'include_category_ids' and 'exclude_category_ids' attributes, to let users include categories by ID instead of only by slug

= Can I hide my FAQ categories? =

Yes, you can choose to display or hide FAQ categories on the FAQ settings page.

= Is it possible to re-order my FAQs? =

Currently you can choose between ascending or descending ordering for your FAQ by either Title, Date Created, or Date Modified.

With the premium version, you can use the FAQ drag and drop ordering table to set exactly the order you want for your FAQs.

= How can I make my FAQs sharable over social media? =

On the FAQ settings page you can choose to link to twitter, facebook and more!

= How do I make my FAQs searchable? =

You can use the premium shortcode, [ultimate-faq-search], which displays an AJAX FAQ search form. You can use the "Auto-Complete Titles" option to have a list of all matching FAQ questions pop up when a user has typed 3 or more characters.

= Can I display all FAQs on pageload using the [ultimate-faq-search] shortcode? =

You can add the attribute "show_on_load" to the shortcode, and set it to "Yes" to display all FAQs when the page first loads.

= How do I add FAQs to a WooCommerce product page with the premium version? =

You can add FAQs for either a specific product or for a WooCommerce category.

For a specific product, create an FAQ category with the same name as the product, and then select that category for all of the FAQs you want included on your product page.

For a category of WooCommerce products, create an FAQ category with the same name as the WooCommerce category, and then select that category for all of the FAQs you want included on your product page.

= How do I limit the number of posts generated by a shortcode =

For the [ultimate-faqs], [popular-faqs] and [recent-faqs] shortcodes, you can use the post_count attribute to limit the number of posts shown. For example:

`[ultimate-faqs post_count='9']
`

= How do I customize my FAQs, for example, to change the font? =

You can customize the plugin by adding code to the Custom CSS box on the FAQ settings page, go to the "Custom CSS" box. For example to change the font you might want to add something like:

.ufaq-faq-title h4, .ufaq-faq-category-title h4  {font-family:"Palatino Linotype", "Book Antiqua", Palatino, serif;}

You can also use the "Styling" area of the "Options" tab if you're using the premium version, which has a bulit-in color picker for FAQ color fields and more!

For more questions and support you can post in the support forum:
<https://wordpress.org/support/plugin/ultimate-faqs>

= Videos =

Video 1 - Shortcodes and Attributes
[youtube https://www.youtube.com/watch?v=zf-tYLqHpRs]

Video 2 - Categories and Tags
[youtube https://www.youtube.com/watch?v=ZV4PM0M1l7M]

Video 3 - FAQs Ordering
[youtube https://www.youtube.com/watch?v=3gVBuCo7bHU]


== Screenshots ==

1. FAQ demo page - Default display style
2. Example of the "Color Block" FAQ display style
3. Example of the "Block" FAQ display style
4. The AJAX FAQ search shortcode in use
5. Simple user submitted FAQs form
6. All answers displayed in the 'list' FAQ mode
7. WooCommerce product page with "FAQs" tab
8. Example of FAQ page with custom FAQ font icons
9. FAQ with comments enabled
10. FAQ with ratings enabled
11. FAQ with post author and date displayed
12. FAQ social sharing
13. Mobile view of FAQs
14. Ultimate FAQs plugin dashboard
15. Admin area showing all FAQs with their number of views as well as their categories
16. View of custom fields on the FAQ post edit screen
17. FAQ tab in WooCommerce product edit
18. FAQ Categories
19. FAQ Tags
20. "Basic" area of the "Settings" tab
21. "Premium" area of the "Settings" tab
22. "Ordering" area of the "Settings" tab
23. "Fields" area of the "Settings" tab
24. "Labelling" area of the "Settings" tab
25. "Styling" area of the "Settings" tab
26. FAQ widgets


== Changelog ==

= 1.9.11 =
- Updated .pot file for translations.
- Update to plugin name and description to clarify purpose and use.

= 1.9.10 =
- Further update for the feedback notice due to user who seems to still not be able to dismiss it.

= 1.9.9 =
- Corrects recent issue causing the feedback notice to not dismiss correctly

= 1.9.8 =
- Updated plugin documentation to take into account features that have been modified and added recently, and to more accurately reflect the current version of the plugin.

= 1.9.7 =
- CSS updates for the admin
- Updating plugin and author links to the current correct URLs
- Small change in the name to make purpose of plugin more clear

= 1.9.6 =
- Adding labelling option

= 1.9.5 =
- Correcting/eliminating several PHP notices
- Updating the version of FPDF used to 1.82

= 1.9.4 =
- Update to correct a potential minor XSS vulnerability

= 1.9.3 =
- CSS update for the admin styling options page layout
- Clarifying the purpose of the plugin in the name

= 1.9.2 =
- Small CSS update for admin options page layout

= 1.9.1 =
- Added extra security to the import feature.

= 1.9.0 =
- Added a new feature to integrate with WP Forms. Now you can set a field in your WP Forms contact form to automatically suggest and display FAQs when someone starts typing their message.
- Corrected an issue where the FAQ search was sometimes not working when the auto complete option was disabled.
- Corrected an issue where sometimes the post count did not return correctly if the same post matched for multiple words. 

