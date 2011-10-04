<?php
/*
Plugin Name: JS Banner Rotate
Plugin URI: http://www.jumping-duck.com/wordpress/
Description: Create a JavaScript-driven rotating banner image on your WordPress site.
Version: 1.4
Author: Eric Mann
Author URI: http://www.eamann.com
License: GPLv3+
 */

/* Copyright 2009-11  Eric Mann, Jumping Duck Media
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 3 or, at
 * your discretion, any later version, as published by the Free
 * Software Foundation.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program; if not, write to the Free Software
 *  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

/* Define plugin variables */
if ( ! defined('JSB_ROTATE_INC_URL') )
	define( 'JSB_ROTATE_INC_URL', WP_PLUGIN_URL . '/js-banner-rotate/includes' );
if ( ! defined('JSB_ROTATE_IMG_URL') )
	define( 'JSB_ROTATE_IMG_URL', WP_PLUGIN_URL . '/js-banner-rotate/images' );
if ( ! defined('JSB_ROTATE_LIB_URL') )
	define( 'JSB_ROTATE_LIB_URL', WP_PLUGIN_URL . '/js-banner-rotate/lib' );

/* Check to see if this is a new installation or an upgrade */
delete_option( 'jsb_version' );
update_option( 'js-banner-rotate-core', 1, '', 'no' );

/*
 * Sets admin warnings regarding required PHP and WordPress versions.
 */
function _jsb_php_warning() {
	echo '<div id="message" class="error">';
	echo '  <p>JS Banner Rotate requires at least PHP 5.  Your system is running version ' . PHP_VERSION . ', which is not compatible!</p>';
	echo '</div>';
}

if ( version_compare( PHP_VERSION, '5.0', '<' ) ) {
	add_action('admin_notices', '_jsb_php_warning');
} else {
	require_once( 'lib/class.js-banner-rotate.php' );
	require_once( 'lib/class.jsb-banner.php' );
}

function jsbrotate( $options ){
	JS_Banner_Rotate::jsbrotate($options);
}

add_action( 'wp_enqueue_scripts',   array( 'JS_Banner_Rotate', 'enqueue_scripts' ) );
add_action( 'wp_print_styles',      array( 'JS_Banner_Rotate', 'print_styles' ) );

add_shortcode( 'jsbrotate',         array( 'JS_Banner_Rotate', 'shortcode_handler' ) );
?>