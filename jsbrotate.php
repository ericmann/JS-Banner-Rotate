<?php
/**
 * Plugin Name: JS Banner Rotate
 * Plugin URI: http://jumping-duck.com/wordpress/plugins/js-banner-rotate/
 * Description: Create a JavaScript-driven rotating banner image on your WordPress site.
 * Version: 2.0
 * Author: Eric Mann
 * Author URI: http://eamann.com
 * License: GPLv2+
 */

/**
 * Copyright 2009-12  Eric Mann, Jumping Duck Media
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2 or, at
 * your discretion, any later version, as published by the Free
 * Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

/* Define plugin variables */
if ( ! defined('JSB_ROTATE_INC_URL') )
	define( 'JSB_ROTATE_INC_URL', WP_PLUGIN_URL . '/js-banner-rotate/includes' );
if ( ! defined('JSB_ROTATE_IMG_URL') )
	define( 'JSB_ROTATE_IMG_URL', WP_PLUGIN_URL . '/js-banner-rotate/images' );
if ( ! defined('JSB_ROTATE_LIB_URL') )
	define( 'JSB_ROTATE_LIB_URL', WP_PLUGIN_URL . '/js-banner-rotate/lib' );

define( 'JSB_DIRECTORY',     plugin_dir_url( __FILE__ ) );
define( 'JSB_INC_DIRECTORY', dirname( __FILE__) . '/' );

/* Check to see if this is a new installation or an upgrade */
delete_option( 'jsb_version' );
update_option( 'js-banner-rotate-core', 2, '', 'no' );

require_once( 'lib/class.js-banner-rotate.php' );
require_once( 'lib/class.jsb-banner.php' );

/**
 * Shortcut function to manually invoke the rotating banner from PHP rather than through a shortcode.
 *
 * The options array:
 * <code>
 * $options = array(
 *     'height'  => ...
 *     'width'   => ...
 *     'link'    => ...
 *     'images'  => ...
 *     'numvis'  => true/false
 *     'imgdisp' => ...
 *     'imgfade' => ...
 * );
 * </code>
 *
 * @param array $options
 */
function jsbrotate( $options ) {
	JS_Banner_Rotate::jsbrotate( $options );
}

add_action( 'wp_enqueue_scripts',   array( 'JS_Banner_Rotate', 'enqueue_scripts' ) );

add_shortcode( 'jsbrotate',         array( 'JS_Banner_Rotate', 'shortcode_handler' ) );
?>