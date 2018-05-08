=== Plugin Name ===
International SEO by Transifex
Contributors: txmatthew, ThemeBoy, brooksx
Tags: transifex, localize, localization, multilingual, international, SEO
Requires at least: 3.5.2
Tested up to: 4.5.2
Stable tag: 1.3.13
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Translate your WordPress powered website using Transifex.

== Description ==

This plugin is designed to be used with Transifex localization platform. There’s no need to create one language per post, insert language tags, or have multiple WordPress instances. Your site’s content is automatically detected and ready to be saved to the Transifex localization platform, where you can translate with the help of your existing translators, or order professional translations from Transifex partners.

In order to use Transifex, you will need to [sign up here for an account](https://www.transifex.com/signup/?utm_source=wp-directory&utm_campaign=int-wp). This plugin also requires a Transifex Live API key. More information about how to obtain a key can be found in the [plugin documentation](http://docs.transifex.com/integrations/wordpress/#getting-your-transifex-live-api-key/?utm_source=wp-directory&utm_campaign=int-wp).

Features:

* Integrates Transifex into WordPress
* Adds support for localized language URLs either by subdomain or subdirectory.
* Adds support rewriting all URLs on the page
* Automatically adds hreflang tags to your pages.
* Adds supports for using an external prerendered server for SEO purposes
* Works with WordPress multisite

Learn more about the [Transifex Live Translation Plugin](https://www.transifex.com/integrations/wordpress-multilingual-plugin/?utm_source=wp-directory&utm_campaign=int-wp).

Get Involved:

Developers can contribute via the plugin's [GitHub Repository](https://github.com/transifex/transifex-live-wordpress).

Translators can contribute new languages to this plugin or our other WordPress plugins through [Transifex](https://www.transifex.com/wp-translations/transifex-live/?utm_source=wp-directory&utm_campaign=int-wp).

Minimum Requirements:

* WordPress 3.5.2 or greater
* PHP version 5.4.0 or greater
* MySQL version 5.0 or greater

== Installation ==

Automatic

Automatic installation is the easiest option as WordPress handles the file transfers itself and you don’t need to leave your web browser. To do an automatic install of Transifex Live, log in to your WordPress admin panel, navigate to the Plugins menu and click Add New.

In the search field type "Transifex Live" and click Search Plugins. Once you’ve found the plugin you can view details about it such as the point release, rating and description. Most importantly of course, you can install it by simply clicking Install Now. After clicking that link you will be asked if you’re sure you want to install the plugin. Click yes and WordPress will automatically complete the installation.
After installation a new menu setting option will appear called 'Transifex Live'.  You will need to complete the admin form before the plugin will become active.

Manual

The manual installation method involves downloading the plugin and uploading it to your webserver via your favorite FTP application.

1. Download the plugin file to your computer and unzip it
2. Using an FTP program, or your hosting control panel, upload the unzipped plugin folder to your WordPress installation’s wp-content/plugins/ directory.
3. Activate the plugin from the Plugins menu within the WordPress admin.
After installation a new menu setting option will appear called 'Transifex Live'.  You will need to complete the admin form before the plugin will become active.

Upgrading

Automatic updates should work like a charm; as always though, ensure you backup your site just in case.

== Screenshots ==

1. screenshot-1.jpg
2. screenshot-2.jpg
3. screenshot-3.jpg

== Changelog ==

= 1.3.13 =
Support X-Transifex-Lang header to set correct language for prerender request
Minor fixes in the way prerender url is handled

= 1.3.12 =
Minor fixes

= 1.3.11 =
Support Live's manifest.jsonp file

= 1.3.10 =
Update keywords

= 1.3.9 =
Cosmetic changes to plugin copy and WordPress.org assets

= 1.3.8 =
Added staging checkbox to admin page

= 1.3.7 =
Fix to allow custom hreflang code and enhanced subdomain language detection

= 1.3.6 =
Patch release for rewrite fix when locale is in url

= 1.3.5 =
Patch release for improved static front page support

= 1.3.4 =
Minor patch release, cleared up some minor warning issues

= 1.3.3 =
A few minor fixes.  Revised admin UI

= 1.3.2 =
Added additional Prerender options for caching

= 1.3.1 =
Patch for Prerender logic

= 1.3.0 =
Fixed support for PHP 5.4
Fixed hreflang tag output for subdirectories
Improved admin UI
Added picker support that respects locale
Additional admin API key validation
Added Prerendering capability
Fixed some timing issues with the WP loop

= 1.2.0 =
Added support for subdomains
Added reverse lookups for many link types

= 1.1.0 =
Cleaned up readme and notes
Fixed brittle js ordering and namespace
Removed settings that can now be controlled in Transifex Live dashboard
Initial implementation of SEO and lang urls
SEO and lang urls feature switch set to off
Removing staging option (use Transifex dashboard to control it)
SEO and lang urls and HREFLANG enabled
Custom language picker color options removed

= 1.0.0 =
Full release.  Restructured plugin to follow boilerplate.  Added unit tests.

