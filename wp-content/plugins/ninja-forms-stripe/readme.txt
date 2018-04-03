=== Ninja Forms - Stripe Extension ===
Contributors: kstover, jameslaws, kbjohnson, klhall1987, Much2tall, ericwindham, wpnzach
Donate link: http://ninjaforms.com
Tags: form, forms
Requires at least: 4.7
Tested up to: 4.9
Stable tag: 3.0.14

License: GPLv2 or later

== Description ==
The Ninja Forms Stripe Extension allows users to accept payments through their forms using the Stripe Payments system.

== Installation ==

This section describes how to install the plugin and get it working.

1. Upload the `ninja-forms-stripe` directory to your `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Visit the 'Forms' menu item in your admin sidebar
4. When you create a form, you will have now have Stripe options on the form settings page.

== Use ==

For help and video tutorials, please visit our website: [NinjaForms.com](http://ninjaforms.com)

== Changelog ==

= 3.0.14 (26 February 2018) =

*Changes:*

* Failed payments should now be more obvious in submission records.
* Refined the look and feel of the new API key helper.

= 3.0.13 (12 February 2018) =

*Changes:*

* Metadata now attaches to the customer record for recurring payments.
* Added shipping address mapping for the Stripe action.
* Stripe Checkout button can now be customized.
* An email field on the form can now be used to autopopulate the email field in Stripe Checkout.
* Added an API key helper to the form builder for first time Stripe action setup.
* Credit card fields have been deprecated in favor of the Sripe Checkout payment method.
* Admin settings for Stripe Checkout should now better reflect their intention.

*Bugs:*

* All Stripe errors should now be caught on failed submissions.

= 3.0.12 (17 January 2018) =

*Bugs:*

* Resolved an issue that sometimes caused metadata settings to lose track of what fields were mapped to them.

= 3.0.11 (02 August 2017) =

*Bugs:*

* Stripe should now work properly with the Save Progress add-on.
* Stripe API keys should no longer be removed upon form import.
* Upgrading to version 3.0 should now populate the payment total of the Collect Payment action properly.

= 3.0.10 (12 July 2017) =

*Changes:*

* Added merge tags for Last 4, Card Brand, Customer ID, and Charge ID.
* Form errors should now prevent the Stripe Checkout Modal from appearing.

= 3.0.9 (31 May 2017) =

*Changes:*

* Added the option to send arbitrary metadata to Stripe in the Collect Payment action settings.

= 3.0.8 (02 May 2017) =

*Changes:*

* Transaction ID should now be appended to CSV exports and attachments.

*Bugs:*

* Fixed a bug that caused submission processing to fail when using Stripe.

= 3.0.7 (02 March 2017) =

*Bugs:*

* Fixed a bug that could cause Stripe to crash on old versions of PHP.

= 3.0.6 (01 March 2017) =

*Changes:*

* Added support for Stripe Checkout. If you do not add credit card fields to your form, Stripe Checkout will be used.
* Stripe can now be used with Conditional Logic.

= 3.0.5 (20 December 2016) =

*Bugs:*

* Fixed a bug that could cause Stripe Errors to be reported incorrectly to the user.

= 3.0.4 (01 November 2016) =

*Bugs:*

* Fixed a bug with card errors blocking re-submission.
* Fixed a bug with using the plugin default currency.

= 3.0.3 (04 October 2016) =

*Bugs:*

* Conditionally hiding credit card fields should prevent Stripe from processing.

= 3.0.2 (06 September 2016) =

* Updating to v3.0.2 for compatibility fix.

= 3.0.1 (06 September 2016) =

*Bugs:*

* Fixing a bug with currency settings for Ninja Forms Three.

= 3.0.0 (10 August 2016) =

* Updated with Ninja Forms v3.x compatibility
* Deprecated Ninja Forms v2.9.x compatible code

= 1.0.10 (09 September 2015) =

*Changes:*

* Customers should now be created in Stripe after their charge.

= 1.0.9 (08 September 2015) =

*Bugs:*

* Fixed a bug that could cause multiple Stripe enabled forms to fail if they were on the same page.

= 1.0.8 (12 May 2015) =

*Bugs:*

* Fixed a bug that could cause failed transactions to prevent future transactions from resolving properly.

*Changes:*

* Changed the position of the live and test keys to match the Stripe Dashboard.

= 1.0.7 (17 November 2014) =

*Bugs:*

* Removed the "is this a Stripe Item" option from non-processing fields like descriptions and submit buttons.
* Updated i18n support.
* Fixed a bug that prevented a Stripe form from working properly on a page with a non-Stripe form.

= 1.0.6 (22 September 2014) =

*Changes:*

* Added a .pot file for translation.

= 1.0.5 (12 August 2014) =

*Bugs:*

* Fixed a bug with thousand separators.
 
* Fixed a bug that prevented non-USD currency from being selected in some cases.

*Changes:*

* Added a shortcode for displaying/sending Stripe charge ids: [nf_stripe_charge_id].

= 1.0.4 (24 July 2014) =

*Changes:*

* Compatibility with Ninja Forms 2.7.

= 1.0.3 =

*Bugs:*

* Stripe should now work properly in all multi-part forms implementations.

= 1.0.2 =

*Changes:*

* More logic to help prevent conflicts with other Stripe plugins.

= 1.0.1 =

*Changes:*

* Added some logic to detect and attempt to prevent conflicts with other Stripe plugins.

= 1.0 =

* Initial release