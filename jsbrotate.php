<?php
/*
Plugin Name: JS Banner Rotate
Plugin URI: http://www.jumping-duck.com/wordpress/
Description: Create a javascript-driven rotating banner image on your WordPress site.
Version: 1.2.2
Author: Eric Mann
Author URI: http://www.eamann.com
*/

/*  Copyright 2009  Eric Mann  (email : eric@eamann.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; version 2.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/*
	This plugin uses Javascript libraries originally developed by Yahoo.
	Please refer to http://developer.yahoo.com/yui/ for more information on the YUI.
*/

/* Define plugin variables */
if( ! defined( 'JSB_DIRECTORY' ))
	define( 'JSB_DIRECTORY' , get_option('siteurl') . '/wp-content/plugins/js-banner-rotate' );
if( ! defined( 'JSB_SCRIPTS' ))
	define( 'JSB_SCRIPTS' , JSB_DIRECTORY . '/scripts' );
if( ! defined( 'JSB_WIDTH' ))
	define( 'JSB_WIDTH' , get_option('large_size_w') );
if( ! defined( 'JSB_HEIGHT' ))
	define( 'JSB_HEIGHT', get_option('large_size_h') );
if( ! defined( 'JSB_TITLE' ))
	define( 'JSB_TITLE', 'Home' );
if( ! defined( 'JSB_LINK' ))
	define( 'JSB_LINK', get_bloginfo("url") );

/* Check the installation */
jsb_install();

/* Set up options and install the plug-in */
function jsb_install() {
	add_option('jsb_version', '1.0');
}

function jsb_add_head() {
	// YUI Scripts
	wp_enqueue_script('yahoo-dom-event', JSB_SCRIPTS . '/yahoo-dom-event.js', '', '2.7.0');
	wp_enqueue_script('animation-min', JSB_SCRIPTS . '/animation-min.js', 'yahoo-dom-event', '2.7.0');
	wp_enqueue_script('selector', JSB_SCRIPTS . '/selector-min.js', 'yahoo-dom-event', '2.7.0');

	//Stylesheet	
	wp_enqueue_style('jsb-rotate', JSB_DIRECTORY . '/jsbrotate.css', '', '1.1', 'screen');
}


function jsb_add_foot() {
global $jsbrotate;
	/* The following code block will call all of our javascript libraries and set things up for the banner rotation */
	?> 

<script type="text/javascript">
window.onload = jsbinit;

function jsbinit() {
	var allBanners = document.getElementById("jsBanners").getElementsByTagName("span");
	var totalBanners = allBanners.length;
	var lastBanner = totalBanners - 1;
	show = new Array();
	hide = new Array();
	for(var i = 0; i < allBanners.length; i++) {
		show[i] = new YAHOO.util.Anim(allBanners[i], {opacity:{to:1}},<?php echo $jsbrotate['imgfade']; ?>);
		hide[i] = new YAHOO.util.Anim(allBanners[i], {opacity:{to:0}},<?php echo $jsbrotate['imgfade']; ?>);
	}
	var k = 0;
	for(var j=0; j < allBanners.length - 1; j++) {
		createListener(j);							
	}
	show[lastBanner].onComplete.subscribe(function() {createNext(lastBanner, true);});
	
	show[0].animate();
}
function createNext(id, last) {
	if(last==false) {
		setTimeout(function() {
			hide[id].animate();
			show[(id+1)].animate();
			}, <?php echo ($jsbrotate['imgdisp'] * 1000); ?>);
	} else {
		setTimeout(function() {
			hide[id].animate();
			show[0].animate();
			}, <?php echo ($jsbrotate['imgdisp'] * 1000); ?>);
	}
}

function createListener(id) {
	show[id].onComplete.subscribe(function() {createNext(id, false);});
}
</script> 
	<?php
}

function jsb_shortcode($atts) {
	$atts = shortcode_atts(array(
				'height' => JSB_HEIGHT,
				'width' => JSB_WIDTH,
				'title' => JSB_TITLE,
				'link' => JSB_LINK,
				'titlevis' => 'false',
				'images' => 'none',
				'image1' => 'none',
				'image2' => 'none',
				'image3' => 'none',
				'image4' => 'none',
				'image5' => 'none',
				'imgdisp' => '8',
				'imgfade' => '4',
				'color' => '#ab106c'				
				), $atts);

	global $jsbrotate;
	$jsbrotate['imgdisp']=$atts['imgdisp'];
	$jsbrotate['imgfade']=$atts['imgfade'];
	$jsbrotate['url']=$atts['link'];
	
	if( $atts['image1'] != 'none' )
		jsb_canonical($atts);
		
	if( $atts['images'] != 'none' )
		jsb_unlimited($atts);

	add_action('wp_footer', 'jsb_add_foot');
}

function jsbrotate($options) {
	$atts = array();
	parse_str($options, $atts);
	global $jsbrotate;
	if($atts['height'] == '')
		$atts['height'] = JSB_HEIGHT;
	if($atts['width'] == '')
		$atts['width'] = JSB_WIDTH;
	if($atts['link'] == '')
		$atts['link'] = JSB_LINK;
	if($atts['images'] == '')
		$atts['images'] = 'none';
	if($atts['image1'] == '')
		$atts['image1'] = 'none';
	if($atts['image2'] == '')
		$atts['image2'] = 'none';
	if($atts['image3'] == '')
		$atts['image3'] = 'none';				
	if($atts['image4'] == '')
		$atts['image4'] = 'none';
	if($atts['image5'] == '')
		$atts['image5'] = 'none';
	if($atts['numvis'] == '')
		$atts['numvis'] = 'true';
	if($atts['imgdisp'] == '')
		$atts['imgdisp'] = '8';
	if($atts['imgfade'] == '')
		$atts['imgfade'] = '4';
	$jsbrotate['imgdisp']=$atts['imgdisp'];
	$jsbrotate['imgfade']=$atts['imgfade'];

	if( $atts['image1'] != 'none' )
		jsb_canonical($atts);

	if( $atts['images'] != 'none' )
		jsb_unlimited($atts);

	add_action('wp_footer', 'jsb_add_foot');
}

function jsb_canonical($atts) {
?>

<div id="banner-block" style="max-height:<?php echo $atts['height']; ?>px;height:auto !important; height:<?php echo $atts['height']; ?>px;max-width:<?php echo $atts['width']; ?>px;width:auto !important;width:<?php echo $atts['width']; ?>px;">
	<div class="banner-container">
	<?php if ($atts['titlevis'] == "true") { ?>
		<div class="banner-top-links">
			<div class="image-frame" style="background:transparent url(<?php echo JSB_DIRECTORY; ?>/images/banner-top-links.png) no-repeat scroll 0 0;"> 
				<ul>			
					<li class="images-link"><?php echo $atts['title']; ?></li> 
				</ul> 
			</div><!--/image-frame-->
		</div><!--/banner-top-links-->
	<?php } ?>

		<div id="jsBanners" class="home-banner" style="height:<?php echo $atts['height']; ?>px;width:<?php echo $atts['width']; ?>px;background:url('<?php echo $atts['image1']; ?>') no-repeat;">	
			<span style="height:<?php echo $atts['height']; ?>px;width:<?php echo $atts['width']; ?>px;" class="banner"><img src="<?php echo $atts['image1']; ?>" width="<?php echo $atts['width']; ?>" height="<?php echo $atts['height']; ?>" alt="JSB Rotate Image 1" /></span>
			<?php if( $atts['image2'] != 'none' ) { ?>
			<span style="height:<?php echo $atts['height']; ?>px;width:<?php echo $atts['width']; ?>px;" class="banner"><img src="<?php echo $atts['image2']; ?>" width="<?php echo $atts['width']; ?>" height="<?php echo $atts['height']; ?>" alt="JSB Rotate Image 2" /></span>
			<?php if( $atts['image3'] != 'none' ) { ?>
			<span style="height:<?php echo $atts['height']; ?>px;width:<?php echo $atts['width']; ?>px;" class="banner"><img src="<?php echo $atts['image3']; ?>" width="<?php echo $atts['width']; ?>" height="<?php echo $atts['height']; ?>" alt="JSB Rotate Image 3" /></span>
			<?php if( $atts['image4'] != 'none' ) { ?>
			<span style="height:<?php echo $atts['height']; ?>px;width:<?php echo $atts['width']; ?>px;" class="banner"><img src="<?php echo $atts['image4']; ?>" width="<?php echo $atts['width']; ?>" height="<?php echo $atts['height']; ?>" alt="JSB Rotate Image 4" /></span>
			<?php if( $atts['image5'] != 'none' ) { ?>
			<span style="height:<?php echo $atts['height']; ?>px;width:<?php echo $atts['width']; ?>px;" class="banner"><img src="<?php echo $atts['image5']; ?>" width="<?php echo $atts['width']; ?>" height="<?php echo $atts['height']; ?>" alt="JSB Rotate Image 5" /></span>
			<?php
			} // Close image5 conditional
			} // Close image4 conditional
			} // Close image3 conditional
			} // Close image2 conditional
			?>
		</div><!--/jsBanners-->
	</div><!--/banner-container-->
</div><!--/banner-block-->
<?php
}

function jsb_unlimited($atts) {
	$allbanners = explode("|", $atts['images']);
	$i = 0;
?>
<a href="<?php echo $atts['link']; ?>">
<div id="banner-block" style="max-height:<?php echo $atts['height']; ?>px;height:auto !important; height:<?php echo $atts['height']; ?>px;max-width:<?php echo $atts['width']; ?>px;width:auto !important;width:<?php echo $atts['width']; ?>px;">
	<div class="banner-container">
	<?php if ($atts['titlevis'] == "true") { ?>
		<div class="banner-top-links">
			<div class="image-frame" style="background:transparent url(<?php echo JSB_DIRECTORY; ?>/images/banner-top-links.png) no-repeat scroll 0 0;"> 
				<ul>			
					<li class="images-link"><?php echo $atts['title']; ?></li> 
				</ul> 
			</div><!--/image-frame-->
		</div><!--/banner-top-links-->
	<?php } ?>

		<div id="jsBanners" class="home-banner" style="height:<?php echo $atts['height']; ?>px;width:<?php echo $atts['width']; ?>px;background:url('<?php echo $allbanners[0]; ?>') no-repeat;">	
<?php foreach($allbanners as $banner) { 
			$i++; ?>		
			<span id="banner-<?php echo $i; ?>" style="height:<?php echo $atts['height']; ?>px;width:<?php echo $atts['width']; ?>px;" class="banner"><img src="<?php echo $banner; ?>" width="<?php echo $atts['width']; ?>" height="<?php echo $atts['height']; ?>" alt="JSB Rotate Image <?php echo $i; ?>" /></span>
<?php } ?>			
		</div><!--/jsBanners-->
	</div><!--/banner-container-->
</div><!--/banner-block-->
</a>
<?php
}

add_action('init', 'jsb_add_head');
add_shortcode('jsbrotate', 'jsb_shortcode');
?>