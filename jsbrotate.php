<?php
/*
Plugin Name: JS Banner Rotate
Plugin URI: http://www.jumping-duck.com/wordpress/
Description: Create a javascript-driven rotating banner image on your WordPress site.
Version: 1.1.1
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
	This plugin uses Javascript libraries originally developed by Yahoo and The Other Media.
	Please refer to http://developer.yahoo.com/yui/ for more information on the YUI.
	Please refer to http://ojay.othermedia.org/ for more information on Ojay.
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

	//Ojay Scripts
	wp_enqueue_script('js-class-min', JSB_SCRIPTS . '/js-class-min.js', '', '0.4.1');
	wp_enqueue_script('core-min', JSB_SCRIPTS . '/core-min.js', array('yahoo-dom-event', 'animation-min', 'selector', 'js-class-min'), '0.4.1');

	//Stylesheet	
	wp_enqueue_style('jsb-rotate', JSB_DIRECTORY . '/jsbrotate.css', '', '1.1', 'screen');
}


function jsb_add_foot() {
global $jsbrotate;
	/* The following code block will call all of our javascript libraries and set things up for the banner rotation */
	?> 

<script type="text/javascript">
// <![CDATA[

	(function() {
		var banner  = Ojay('#jsBanners'),
			banners = banner.descendants('.banner').setStyle({opacity: 0}).hide(),
			current = banners.at(0).setStyle({opacity: 1}).show(),
			bannerHolder = Ojay('#jsBanners')
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
				<?php if($jsbrotate['numvis']=="true") { ?>
					banner.insert(numbers, 'after');
				<?php } ?>
				
                var index = 0, update = function(idx) {
                    current.animate({opacity: {to: 0}, zIndex: {to: 0}}, <?php echo $jsbrotate['imgfade']; ?>).hide();
                    current = banners.at(idx);
					index = idx;
                    current.show().animate({opacity: {to: 1}, zIndex: {to: 4}}, <?php echo $jsbrotate['imgfade']; ?>);
                    numbers.children().wait(2)
                                      .removeClass('current')
					                  .at(index).addClass('current');
                };
				numbers.children().at(index).addClass('current');
                
                var time = Number(new Date), TIMEOUT = <?php echo 1000 * $jsbrotate['imgdisp']; ?>, timeout = TIMEOUT;
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
	<?php
}

function jsb_add_css() {
?>
<style type="text/css">
#banner-block, #jsBanners .home-banner {
	height: <?php echo JSB_HEIGHT; ?>px;
	width: <?php echo JSB_WIDTH; ?>px;
}
#banner-block .banner-top-links .image-frame {
	background:transparent url(<?php echo JSB_DIRECTORY; ?>/images/banner-top-links.png) no-repeat scroll 0 0;
	height:100%;
	width:100%;
}
#banner-block .banner-container ul.banner-links {
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
				'titlevis' => 'true',
				'image1' => 'none',
				'image2' => 'none',
				'image3' => 'none',
				'image4' => 'none',
				'image5' => 'none',
				'numvis' => 'true',
				'imgdisp' => '8',
				'imgfade' => '4',
				'color' => '#ab106c'
				), $atts);

	global $jsbrotate;
	$jsbrotate['numvis']=$atts['numvis'];
	$jsbrotate['imgdisp']=$atts['imgdisp'];
	$jsbrotate['imgfade']=$atts['imgfade'];

	if( $atts['image1'] != 'none' ) {
	if( $atts['color'] != '#ab106c') {
?>
	<style type="text/css">
	.banner-container ul.banner-links li{
		color: <?php echo $atts['color']; ?>;
	}
	.banner-container ul.banner-links li.current {
		background:<?php echo $atts['color']; ?> none repeat scroll 0 0;
	}
	</style>
<?php } ?>
<div id="banner-block" style="height:<?php echo $atts['height']; ?>px;width:<?php echo $atts['width']; ?>px;">
	<div class="banner-container">
	<?php if ($atts['titlevis'] == "true") { ?>
		<div class="banner-top-links">
			<div class="image-frame"> 
				<ul>			
					<li class="images-link"><a href="<?php echo $atts['link']; ?>"><?php echo $atts['title']; ?></a></li> 
				</ul> 
			</div><!--/image-frame-->
		</div><!--/banner-top-links-->
	<?php } ?>
		<div id="jsBanners" class="home-banner" style="height:<?php echo $atts['height']; ?>px;width:<?php echo $atts['width']; ?>px;background:url('<?php echo $atts['image1']; ?>') no-repeat;">	
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
	if($atts['title'] == '')
		$atts['title'] = JSB_TITLE;
	if($atts['link'] == '')
		$atts['link'] = JSB_LINK;
	if($atts['titlevis'] == '')
		$atts['titlevis'] = 'true';
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
	if($atts['color'] == '')
		$atts['color'] = '#ab106c';
	$jsbrotate['numvis']=$atts['numvis'];
	$jsbrotate['imgdisp']=$atts['imgdisp'];
	$jsbrotate['imgfade']=$atts['imgfade'];

	if( $atts['image1'] != 'none' ) {
	if( $atts['color'] != '#ab106c') {
?>
	<style type="text/css">
	.banner-container ul.banner-links li{
		color: <?php echo $atts['color']; ?>;
	}
	.banner-container ul.banner-links li.current {
		background:<?php echo $atts['color']; ?> none repeat scroll 0 0;
	}
	</style>
<?php } ?>
<div id="banner-block" style="height:<?php echo $atts['height']; ?>px;width:<?php echo $atts['width']; ?>px;">
	<div class="banner-container">
	<?php if ($atts['titlevis'] == "true") { ?>
		<div class="banner-top-links">
			<div class="image-frame"> 
				<ul>			
					<li class="images-link"><a href="<?php echo $atts['link']; ?>"><?php echo $atts['title']; ?></a></li> 
				</ul> 
			</div><!--/image-frame-->
		</div><!--/banner-top-links-->
	<?php } ?>
		<div id="jsBanners" class="home-banner" style="height:<?php echo $atts['height']; ?>px;width:<?php echo $atts['width']; ?>px;background:url('<?php echo $atts['image1']; ?>') no-repeat;">	
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
	add_action('wp_footer', 'jsb_add_foot');
}

add_action('wp_head', 'jsb_add_css');
add_action('init', 'jsb_add_head');
add_shortcode('jsbrotate', 'jsb_shortcode');
?>