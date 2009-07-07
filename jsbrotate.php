<?php
/*
Plugin Name: JS Banner Rotate
Plugin URI: http://www.jumping-duck.com/wordpress/
Description: Create a javascript-driven rotating banner image on your WordPress site.
Version: 1.0.1
Author: Eric Mann
Author URI: http://www.eamann.com
*/

/*  Copyright 2009  Eric Mann  (email : eric@eamann.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/*
	This plugin uses Javascript libraries originally developed by Yahoo, James Coglan, and
	The OTHER Media, LTD.  Please refer to the javascript libaries located in 'js-banner-rotate/scripts'
	for copyright information pertaining to these scripts..
*/

/* Define plugin variables */
if( ! defined( 'JSB_DIRECTORY' ))
	define( 'JSB_DIRECTORY' , get_option('siteurl') . '/wp-content/plugins/js-banner-rotate' );
if( ! defined( 'JSB_SCRIPTS' ))
	define( 'JSB_SCRIPTS' , JSB_DIRECTORY . '/scripts' );
if( ! defined( 'JSB_WIDTH' ))
	define( 'JSB_WIDTH' , '900' );
if( ! defined( 'JSB_HEIGHT' ))
	define( 'JSB_HEIGHT', '300' );
if( ! defined( 'JSB_TITLE' ))
	define( 'JSB_TITLE', 'Home' );
if( ! defined( 'JSB_LINK' ))
	define( 'JSB_LINK', get_option('siteurl') );

/* Check the installation */
jsb_install();

/* Set up options and install the plug-in */
function jsb_install() {
	add_option('jsb_version', '1.0');
}

function jsb_add_javascript() {
	/* The following code block will call all of our javascript libraries and set things up for the banner rotation */
?> 
<script type="text/javascript" src="<?php echo JSB_SCRIPTS; ?>/yahoo-dom-event.js"></script>
<script type="text/javascript" src="<?php echo JSB_SCRIPTS; ?>/selector-beta-min.js"></script>
<script type="text/javascript" src="<?php echo JSB_SCRIPTS; ?>/animation-min.js"></script>
<script type="text/javascript" src="<?php echo JSB_SCRIPTS; ?>/js-class-min.js"></script> 
<script type="text/javascript" src="<?php echo JSB_SCRIPTS; ?>/core-min.js"></script>

<script type="text/javascript">
// <![CDATA[

	(function() {
		var banner  = Ojay('#homeBanners'),
			banners = banner.descendants('.banner').setStyle({opacity: 0}).hide(),
			current = banners.at(0).setStyle({opacity: 1}).show(),
			bannerHolder = Ojay('#homeBanners')
						.setStyle({background: '#000000'});
                
		var numbers = Ojay(Ojay.HTML.ul({className: 'banner-links'}, function(h) {
			banners.length.times(function(i) {
                        var link = Ojay(h.li(String(i+1)));
                        link.on('click', function() {
                            time = Number(new Date);
                            timeout = 2 * TIMEOUT;
                            numbers.children()
                                      .removeClass('current')
                                      .at(i).addClass('current');
                            update(i);
                        });
                    });
                }));
                banner.insert(numbers, 'after');
				
                var index = 0, update = function(idx) {
                    current.animate({opacity: {to: 0}, zIndex: {to: 0}}, 4).hide();
                    current = banners.at(idx);
					index = idx;
                    current.show().animate({opacity: {to: 1}, zIndex: {to: 4}}, 4);
                    numbers.children().wait(2)
                                      .removeClass('current')
					                  .at(index).addClass('current');
                };
				numbers.children().at(index).addClass('current');
                
                var time = Number(new Date), TIMEOUT = 8000, timeout = TIMEOUT;
                setInterval(function() {
                    if (Number(new Date) - time < timeout) return;
                    time = Number(new Date);
                    timeout = TIMEOUT;
                    if (++index == banners.length) index = 0;
                    update(index);
                }, timeout / 2);
        	})();
    	
// ]]>
</script> 
<script type="text/javascript"> 
// <![CDATA[
 
Ojay('#banner-block').on('click', Ojay.delegateEvent({
    '.banner-top-links a': function(link, evnt) {
        evnt.stopDefault();
        Ojay.HTTP.GET(link.node.href)
        .insertInto('#banner-block')
        .evalScripts();
    }
}));
 
// ]]>
</script> 
<?php
}

function jsb_add_css() {
?>
<!--style>
.banner-container {
	margin-botton:20px;
	position:relative;
	clear:both;
}

.banner-top-links {
	height: 33px;
	left:50%;
	margin-left:-50px;
	margin-top:-1px;
	position:absolute;
	top:0px;
	width:100px;
	z-index:1000;
}

.banner-top-links ul {
	margin: 0 10px;
}

.banner-top-links ul li.images-link {
	float:left;
	height:23px;
	list-style-type:none;
	margin-bottom:0;
}

.banner-top-links ul li a {
	display: block;
	height: 23px;
	position: relative;
	text-indent:-9999px;
	z-index:100px;
}

.home-banner {
	height: <?php echo JSB_HEIGHT; ?> px;
	width: <?php echo JSB_WIDTH; ?> px;
	overflow: hidden;
	position:relative;
}

.banner {
	opacity: 0;
	position:absolute;
}

img {
	display:block;
}
</style-->
<link media="screen" type="text/css" href="<?php echo JSB_DIRECTORY; ?>/jsbrotate.css" media="screen" rel="stylesheet" />
<style>
#banner-block, .home-banner {
	height: <?php echo JSB_HEIGHT; ?>px;
	width: <?php echo JSB_WIDTH; ?>px;
}
.banner-top-links .image-frame {
	background:transparent url(<?php echo JSB_DIRECTORY; ?>/images/banner-top-links.png) no-repeat scroll 0 0;
	height:100%;
	width:100%;
}
.banner-container ul.banner-links {
	background:transparent url(<?php echo JSB_DIRECTORY; ?>/images/banner-links.png) repeat-x scroll right top;
}
</style>
<?php
}

function jsb_shortcode($atts) {
	$atts = shortcode_atts(array(
				'height' => JSB_HEIGHT,
				'width' => JSB_WIDTH,
				'title' => JSB_TITLE,
				'link' => JSB_LINK,
				'image1' => 'none',
				'image2' => 'none',
				'image3' => 'none',
				'image4' => 'none',
				'image5' => 'none'
				), $atts);

	if( $atts['image1'] != 'none' ) {
?>
<div id="banner-block" style="height:<?php echo $atts['height']; ?>px;width:<?php echo $atts['width']; ?>px;">
	<div class="banner-container"> 
		<div class="banner-top-links">
			<div class="image-frame"> 
				<ul>			
					<li class="images-link"><a href="<?php echo $atts['link']; ?>"><?php echo $atts['title']; ?></a></li> 
				</ul> 
			</div><!--/image-frame-->
		</div><!--/banner-top-links-->
		<div id="homeBanners" class="home-banner" style="height:<?php echo $atts['height']; ?>px;width:<?php echo $atts['width']; ?>px;background:url('<?php echo $atts['image1']; ?>') no-repeat;">	
			<span class="banner"><img src="<?php echo $atts['image1']; ?>" width="<?php echo $atts['width']; ?>" height="<?php echo $atts['height']; ?>" alt="JSB Rotate Image 1" /></span>
			<?php if( $atts['image2'] != 'none' ) { ?>
			<span class="banner"><img src="<?php echo $atts['image2']; ?>" width="<?php echo $atts['width']; ?>" height="<?php echo $atts['height']; ?>" alt="JSB Rotate Image 2" /></span>
			<?php if( $atts['image3'] != 'none' ) { ?>
			<span class="banner"><img src="<?php echo $atts['image3']; ?>" width="<?php echo $atts['width']; ?>" height="<?php echo $atts['height']; ?>" alt="JSB Rotate Image 3" /></span>
			<?php if( $atts['image4'] != 'none' ) { ?>
			<span class="banner"><img src="<?php echo $atts['image4']; ?>" width="<?php echo $atts['width']; ?>" height="<?php echo $atts['height']; ?>" alt="JSB Rotate Image 4" /></span>
			<?php if( $atts['image5'] != 'none' ) { ?>
			<span class="banner"><img src="<?php echo $atts['image5']; ?>" width="<?php echo $atts['width']; ?>" height="<?php echo $atts['height']; ?>" alt="JSB Rotate Image 5" /></span>
			<?php
			} // Close image5 conditional
			} // Close image4 conditional
			} // Close image3 conditional
			} // Close image2 conditional
			?>
		</div><!--/homeBanners-->
	</div><!--/banner-container-->
</div><!--/banner-block-->
<?php
	} // Close image1 conditional
}

add_action('wp_head', 'jsb_add_css');
add_action('wp_footer', 'jsb_add_javascript');
add_shortcode('jsbrotate', 'jsb_shortcode');
?>