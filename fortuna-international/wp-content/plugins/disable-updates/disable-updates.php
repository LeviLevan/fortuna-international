<?php
/*
Plugin Name:  Disable Updates
Description:  Prevents users from updating the WordPress core, plugins and themes
Plugin URI:   https://vanderwijk.com/
Donate link:  https://www.paypal.me/vanderwijk
Version:      1.2.7
Author:       Johan van der Wijk
Author URI:   https://vanderwijk.com/
Text Domain:  disable-updates
Domain Path:  /languages
License: GPL2

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

*/

// Hides all upgrade notices
function hide_admin_notices() {
	remove_action( 'admin_notices', 'update_nag', 3 );
}
add_action( 'admin_menu','hide_admin_notices' );

// Remove the 'Updates' menu item from the admin interface
function remove_menus() {
	global $submenu;
	remove_submenu_page ( 'index.php', 'update-core.php' );
}
add_action( 'admin_menu', 'remove_menus', 102 );

// Disable all automatic updates
add_filter( 'automatic_updater_disabled', '__return_true' );

// Disable core updates
remove_action( 'load-update-core.php', 'wp_update_core' );
add_filter( 'pre_site_transient_update_core', function ( $a ) {
    return null;
} );

// Disable theme updates
remove_action( 'load-update-core.php', 'wp_update_themes' );
add_filter( 'pre_site_transient_update_themes', function ( $a ) {
    return null;
} );

// Disable plugin updates
remove_action( 'load-update-core.php', 'wp_update_plugins' );
add_filter( 'pre_site_transient_update_plugins', function ( $a ) {
    return null;
} );
