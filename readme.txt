=== JS Banner Rotate ===
Contributors: ericmann
Donate link: http://www.jumping-duck.com/wordpress/
Tags: javascript, banner, header, image rotate, yui
Requires at least: 2.8
Tested up to: 3.1
Stable tag: 1.3.2

Create a JavaScript-driven rotating banner image on your WordPress site.

== Description ==

This plugin uses the Yahoo! User Interface (YUI) Javascript libraries to create a platform-agnostic rotating banner image for your website.  Unlike similar Flash implementations, this feature will work even on Flash-disabled web browsers.  

Note that you will need to upload your images separately using WordPress' built-in image gallery feature.  

== Installation ==

This section describes how to install the plugin and get it working.

e.g.

1. Upload the entire `js-banner-rotate` folder to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Place `[jsbrotate images=image1url|image2url... /]` on your pages/posts
1. Optionally, you can place the function `<?php jsbrotate(images=image1|image2...); ?>` in your templates to call the banner

= Accepted Arguments =

The shortcode/template tag accepts several parameters:

* As many image URLs as you want: [jsbrotate images=http://blog.url/image1.jpg|http://blog.url/image2.jpg /]
* Slideshow link: [jsbrotate link=http://whateveryouwant.com /]
* Image height and width: [jsbrotate height=200 width=900 /]
* Image display and fade time: [jsbrotate imgdisp=8 imgfade=4 /]

The default height and width is whatever is set for "large" images in the WordPress Media administration section (usually 1024x1024).  You must override these in the shortcode if you want to specify different values.

You can toggle the title display - the title defaults to "Home."

== Frequently Asked Questions ==

= How do I pass multiple parameters in the jsbrotate() function? =

To pass multiple parameters (height, fadetime, images, etc), separate them with & characters like this: `<?php jsbrotate('images=http://blog.url/image2.jpg|http://blog.url/image2.jpg&height=200&width=900'); ?>`

= How many images can I rotate? =

You can have as few as 1 image (which is a bit boring) and as many as you want in the rotation.

Previous versions of the plug-in have limited you to just 5 images ...

Just make sure your list of images is pipe-delimited (use the | key to separate the URLs).

= Can they be different sizes? =

Yes and no.  The slideshow itself will only render at one size (whatever you specify in the shortcode).  However, if your images are larger or wider than this setting, they will be resized using the CSS max-width and max-height properties.  Basically, they'll be "squished" in whatever direction was larger than the display box.  This can be problematic in older web browsers and can break certain complex images, so it's *highly* recommended that all of your rotating images be the same size.

In any case, the first image in your rotation MUST be the same size as the slideshow.  This image is used as a static background (in the event your site visitors don't have Javascript) and can't yet be dynamically resized.

= What other options does the shortcode/template tag allow? =

You can set several things via the shortcode:

* Image URLs (images=http://blog.url/image.jpg|http://blog.url/image2.jpg)
* Slideshow hyperlink (link=http://whateveryouwant.com)
* Image height and width (height=300 width=300)
* Image display and fade time (imgdisp=8, imgfade=4)
* Title visibility (titlevis=true)
* Title (title=Home)

= What are the shortcode/template tag parameter defaults? =

* link = Blog's URL
* height = WordPress large image default height
* width = WordPress large image default width
* imgdisp = 8 seconds
* imgfade = 4 seconds
* titlevis = false
* title = Home

= What happened to the image numbers? =

The majority of users we spoke with wanted to remove the numbers, so we've eliminated them altogether.

= The images rotate too slowly! =

You can now change the length of time each image remains on the screen and the amount of time it takes to fade between images.  We recommend that the fade time be no more than half the display time, otherwise the images don't stay on the screen for very long at all!

= I like the new template tag.  Can I put it wherever I want? =

No. You must use the template tag after `wp_head()` and before `wp_footer()` for it to work!

= My banners aren't rotating! / Something isn't working! =

Check to make sure you have the `wp_head()` template tag in your header and the wp_footer tag in your footer.  If you're missing either of these tags, the scripts won't work.  If you're using the template tag, make sure you've placed it after `wp_head()` and before `wp_footer()`.

*You can only have one rotating banner on any given page.  If you're using the banner in your posts, only the first post on the page will rotate!*

== Screenshots ==

1. Shortcode entered in the *HTML* view edit post screen.
2. The actual output of the banner on your blog.


== Changelog ==

= 1.3.2 =
* Removes insecure Elliot RPC integration

= 1.3.1 =
* Fixed calls to deprecated functions

= 1.3.0 =
* Overhauled system to integrate advanced error reporting
* Updated and improved documentation

= 1.2.2 =
* Fixed CSS typo for .banner-container definition
* Updated documentation for PHP function call

= 1.2.1 =
* Tested to WordPress version 2.9.1
* Modified GPL references to restrict to version 2 only

= 1.2.0 =
* Eliminates the use of the OJAY javascript library
* Allows the use of more than 5 images
* Removed image numbers

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

== Upgrade Notice ==

= 1.3.1 =
Fixes security vulnerability. Upgrade immediately.

= 1.3.0 =
This plug-in is no longer compatible with WordPress systems older than version 2.8.  Please do not try installing it on older systems.