=== JS Banner Rotate ===
Contributors: ericmann
Donate link: http://www.jumping-duck.com/wordpress/
Tags: javascript, banner, header, image rotate
Requires at least: 2.7
Tested up to: 2.8
Stable tag: 1.0.1

Create a javascript-driven rotating banner image on your WordPress site.

== Description ==

This plugin uses Javascript to create a platform-agnostic rotating banner image for your website.  Unlike similar Flash implementations, this feature will work even on Flash-disabled web browsers.  It uses its own set of Javascript libraries, to it won't interfere with jQuery.

Note that you will need to upload your images separately using WordPress' built-in image gallery feature.  

== Installation ==

This section describes how to install the plugin and get it working.

e.g.

1. Upload the entire `js-banner-rotate` folder to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Place `[jsbrotate image1=... image2=... /]` in your templates/pages/posts (See the FAQs for additional options)

== Frequently Asked Questions ==

= How many images can I rotate? =

You can have as few as 1 image (which is a bit boring) and as many as 5 images in the rotation.  Number them appropriately (i.e. image1, image2, image3, etc)

= Can they be different sizes? =

No.  All of your rotating images need to be the same size.

= What other options does the shortcode allow? =

You can set several things via the shortcode:

* Image URLs (image1=http://blog.url/image.jpg image2=http://blog.url/image2.jpg)
* Section Heading (title=Home)
* Image Height and Width (height=200 width=900)

== Changelog ==

= 1.0.1 =
* First release