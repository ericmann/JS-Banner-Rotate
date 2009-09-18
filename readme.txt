=== JS Banner Rotate ===
Contributors: ericmann
Donate link: http://www.jumping-duck.com/wordpress/
Tags: javascript, banner, header, image rotate
Requires at least: 2.7
Tested up to: 2.8.4
Stable tag: 1.1.1

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
1. Optionally, you can place the function `<?php jsbrotate(image1=...&image2=...); ?>` in your templates to call the banner

= Accepted Arguments =

The shortcode/template tag accepts several parameters:

* Up to 5 numbered image URLs: [jsbrotate image1=http://blog.url/image1.jpg image2=http://blog.url/image2.jpg /]
* Section heading: [jsbrotate title=home /]
* Section heading visibility: [jsbrotate titlevis=false /]
* Image height and width: [jsbrotate height=200 width=900 /]
* Image number visibility: [jsbrotate numvis=false /]
* Image number color: [jsbrotate color=#ffffff /]
* Image display and fade time: [jsbrotate imgdisp=8 imgfade=4 /]

The default height and width is whatever is set for "large" images in the WordPress Media administration section (usually 1024x1024).  You must override these in the shortcode if you want to specify different values.

You can toggle the title display - the title defaults to "Home."

== Frequently Asked Questions ==

= How many images can I rotate? =

You can have as few as 1 image (which is a bit boring) and as many as 5 images in the rotation.  Number them appropriately (i.e. image1, image2, image3, etc)

= Can they be different sizes? =

No.  All of your rotating images need to be the same size.

= What other options does the shortcode/template tag allow? =

You can set several things via the shortcode:

* Image URLs (image1=http://blog.url/image.jpg image2=http://blog.url/image2.jpg)
* Toggle the section heading (titlevis=true or titlevis=false)
* Section Heading (title=Home)
* Image number visibility (numvis=true)
* Image number color (color=#ffffff)
* Image Height and Width (height=300 width=300)
* Image display and fade time (imgdisp=8, imgfade=4)

= What are the shortcode/template tag parameter defaults? =

* title = Home
* titlevis = true
* height = WordPress large image default height
* width = WordPress large image default width
* numvis = true
* color = #ab106c
* imgdisp = 8 seconds
* imgfade = 4 seconds

= I want to get rid of the title on the banner, how do I do that? =

The banner is turned on by default.  To disable the banner, place "titlevis=false" in the shortcode.  It will cleanly remove the label.

= Can I change the colors and other styles of the display? =

You can change the color of the numbered image links in the lower right-hand corner.  You can also toggle their display on and off.

= The images rotate too slowly! =

You can now change the length of time each image remains on the screen and the amount of time it takes to fade between images.  We recommend that the fade time be no more than half the display time, otherwise the images don't stay on the screen for very long at all!

= I like the new template tag.  Can I put it wherever I want? =

No. You must use the template tag after wp_head() and before wp_footer() for it to work!

= My banners aren't rotating! / Something isn't working!

Check to make sure you have the wp_head() template tag in your header and the wp_footer tag in your footer.  If you're missing either of these tags, the scripts won't work.  If you're using the template tag, make sure you've placed it after wp_head() and before wp_footer().

== Screenshots ==

1. Shortcode entered in the *HTML* view edit post screen.
2. The actual output of the banner on your blog.


== Changelog ==

= 1.1.1 =
* Fixes IE CSS display problem

= 1.1 =
* Further clean-ups to Javascript implementation
* Adds the ability to change the color of the image numbers
* Adds the ability to toggle the image numbers on and off
* Adds the ability to change the timing of the image display and fade
* Adds template tag
* Changes default image sizing to match WordPress defaults

= 1.0.3 =
* Adds the ability to toggle the banner title on and off

= 1.0.2 =
* Cleans up CSS to prevent interference with other plug-ins
* Updates readme.txt to explain required/optional shortcode parameters and defaults
* Updates YUI javascript libraries to the most current release
* Tests compatability with WP 2.8.1

= 1.0.1 =
* First release