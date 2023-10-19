=== Disable Updates ===
Contributors: vanderwijk
Author link: https://vanderwijk.com
Tags: disable, updates, core update, plugin update, theme update
Requires at least: 3.0
Tested up to: 6.2
Stable tag: 1.2.7

Disables the WordPress update checking and notification system.

== Description ==

This plugin disables all WordPress updates (core, plugins and themes). This can be useful if you have multiple environments such as a live and staging server and you don't want your users to use the update functionality.

This plugin not only disables the update mechanism for the core, plugins and themes, but it also removes the update menu item from the left navigation menu in the admin.

== Screenshots ==

1. WordPress admin before activating the plugin.
2. After activating the plugin all update notices are disabled.

== Installation ==

1. Unzip the zip file and upload the folder to the `wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.

== Frequently Asked Questions ==

= I am not sure what this plugin does, should I be using it? =

No, keeping WordPress up-to-date is very important for security reasons. You should only install this plugin if you keep your system up to date using another mechanism such as a staging server or svn.

== Upgrade Notice ==

First version

== Changelog ==

= 1.2.5 =
WordPress 5.8 compatibility tested

= 1.2 =
PHP 7.2 compatibility update

= 1.1 =
Added `automatic_updater_disabled` filter

= 1.0 =
* Initial release

