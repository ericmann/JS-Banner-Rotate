=== JS Banner Rotate ===
Contributors: ericmann
Donate link: http://www.jumping-duck.com/wordpress/
Tags: javascript, banner, header, image rotate
Requires at least: 2.7
Tested up to: 2.8.2
Stable tag: 1.0.3

Create a javascript-driven rotating banner image on your WordPress site.

== Description ==

This plugin uses Javascript to create a platform-agnostic rotating banner image for your website.  Unlike similar Flash implementations, this feature will work even on Flash-disabled web browsers.  It uses its own set of Javascript libraries, to it won't interfere with jQuery.

Note that you will need to upload your images separately using WordPress' built-in image gallery feature.  

== Installation ==

This section describes how to install the plugin and get it working.

e.g.

1. Upload the entire `js-banner-rotate` folder to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Place `[jsbrotate image1=... image2=... /]` on your pages/posts

= Accepted Arguments =

The shortcode accepts several parameters:

* Up to 5 numbered image URLs: [jsbrotate image1=http://blog.url/image1.jpg image2=http://blog.url/image2.jpg /]
* Section heading: [jsbrotate title=home /]
* Image height and width: [jsbrotate height=200 width=900 /]

The default height is 300px and the default width is 900px.  You must override these in the shortcode if you want to specify different values.

You cannot remove the title from the display - the title defaults to "Home."

== Frequently Asked Questions ==

= How many images can I rotate? =

You can have as few as 1 image (which is a bit boring) and as many as 5 images in the rotation.  Number them appropriately (i.e. image1, image2, image3, etc)

= Can they be different sizes? =

No.  All of your rotating images need to be the same size.

= What other options does the shortcode allow? =

You can set several things via the shortcode:

* Image URLs (image1=http://blog.url/image.jpg image2=http://blog.url/image2.jpg)
* Toggle the section heading (titlevis=true or titlevis=false)
* Section Heading (title=Home)
* Image Height and Width (height=200 width=900)

= What are the shortcode parameter defaults? =

* title=Home
* titlevis=true
* height=300
* width=900

= I want to get rid of the title on the banner, how do I do that? =

The banner is turned on by default.  To disable the banner, place "titlevis=false" in the shortcode.  It will cleanly remove the label.

= Can I change the colors and other styles of the display? =

Not yet.  That control will be coming in version 1.1.

== Screenshots ==

1. Shortcode entered in the *HTML* view edit post screen.
2. The actual output of the banner on your blog.


== Changelog ==

= 1.1.0 =
* Adds the ability to toggle the banner title on and off

= 1.0.2 =
* Cleans up CSS to prevent interference with other plug-ins
* Updates readme.txt to explain required/optional shortcode parameters and defaults
* Updates YUI javascript libraries to the most current release
* Tests compatability with WP 2.8.1

= 1.0.1 =
* First release