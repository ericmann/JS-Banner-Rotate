<?php
/*
Plugin Name: JS Banner Rotate
Plugin URI: http://www.jumping-duck.com/wordpress/
Description: Create a JavaScript-driven rotating banner image on your WordPress site.
Version: 1.3.3
Author: Eric Mann
Author URI: http://www.eamann.com
 */

/* Copyright 2009-10  Eric Mann  (email : eric@eamann.com)

 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; version 2.

 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.

 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

/*
 * This plugin uses Javascript libraries originally developed by Yahoo.
 * Please refer to http://developer.yahoo.com/yui/ for more information on the YUI.
 */

/* Define plugin variables */
if( ! defined( 'JSB_VER' ))
	define( 'JSB_VER', '1.3.1' );
if( ! defined( 'JSB_BASE' ))
	define( 'JSB_BASE' , dirname(__FILE__) );
if( ! defined( 'JSB_DIRECTORY' ))
	define( 'JSB_DIRECTORY' , get_option('siteurl') . '/wp-content/plugins/js-banner-rotate' );
if( ! defined( 'JSB_INC' ))
	define( 'JSB_INC' , JSB_DIRECTORY . '/includes' );
if( ! defined( 'JSB_BASE_INC' ))
	define( 'JSB_BASE_INC', JSB_BASE . '/includes' );

/* Check to see if this is a new installation or an upgrade */
$current_ver = get_option('jsb_version');
update_option('jsb_version', JSB_VER);

/*
 * Sets admin warnings regarding required PHP and WordPress versions.
 */
function _jsb_wp_warning() {
	$data = get_plugin_data(__FILE__);
	
	echo '<div class="error"><p><strong>' . __('Warning:') . '</strong> '
		. sprintf(__('The active plugin %s is not compatible with your WordPress version.') .'</p><p>',
			'&laquo;' . $data['Name'] . ' ' . $data['Version'] . '&raquo;')
		. sprintf(__('%s is required for this plugin.'), 'WordPress 2.8 ');
	echo '</p></div>';
}

// START PROCEDURE

// Check required WordPress version.
if ( version_compare(get_bloginfo('version'), '2.8', '<')) {
	add_action('admin_notices', '_jsb_wp_warning');
} else {
	include_once ( JSB_BASE_INC . '/core.php' );
}
?>