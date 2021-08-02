=== Plugin Name ===
Contributors: neuropassenger
Donate link: https://neuropassenger.ru
Tags: cf7, spam, form
Requires at least: 5.7.2
Tested up to: 5.7.2
Stable tag: 1.2.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin protects Contact Form 7 from spam.

== Installation ==

1. Unzip `bs-spam-protector.zip` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

== Changelog ==

= 1.2.1 =
* Fixes conflicts with cache.

= 1.2.0 =
* Added detailed log system for the validation process.

= 1.1.3 =
* Implemented earlier JavaScript loading for more reliable initialization of the validation process.

= 1.1.2 =
* Added the ability to use protection on several forms on a single page.

= 1.1.1 =
* Security fixes.

= 1.1 =
* Added a settings page for changing the secret key.
* The secret key is automatically generated upon plugin activation and deleted upon deactivation.

= 1.0 =
* First stable version.

== Upgrade Notice ==

= 1.2.1 =
* If you are experiencing problems with the validation code and are using caching, this update is highly recommended.

= 1.1.3 =
* It is recommended that you update if some submitted forms are incorrectly validated.

= 1.1.2 =
* If you are using more than one form on a single page, you need this update.

= 1.1.1 =
This version fixes security related issues.  Upgrade immediately.

= 1.1 =
More robust validation key generation.