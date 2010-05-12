<?php
function jsb_enqueue_scripts() {	
	// YUI Scripts
	wp_enqueue_script('yahoo-dom-event', JSB_INC . '/yahoo-dom-event.js', '', '2.7.0');
	wp_enqueue_script('animation-min', JSB_INC . '/animation-min.js', 'yahoo-dom-event', '2.7.0');
	wp_enqueue_script('selector', JSB_INC . '/selector-min.js', 'yahoo-dom-event', '2.7.0');
	
	// JSB Scripts
	wp_enqueue_script('jsb-rotate', JSB_INC . '/jsbrotate.js', 'yahoo-dom-event', '1.3');

	//Stylesheet	
	wp_enqueue_style('jsb-rotate', JSB_INC . '/jsbrotate.css', '', '1.3', 'screen');
}

function jsb_add_vars() {
	global $jsbrotate;
	echo "<script type=\"text/javascript\"> \n";
	echo "var imgdisp=" . $jsbrotate['imgdisp'] * 1000 . ",imgfade=" . $jsbrotate['imgfade'] . "; \n";
	echo "</script> \n";
}

function jsb_shortcode($atts) {
	$atts = shortcode_atts(array(
				'height' => get_option('large_size_h'),
				'width' => get_option('large_size_w'),
				'title' => 'Home',
				'link' => get_bloginfo('url'),
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
}

function jsbrotate($options) {
	$atts = array();
	parse_str($options, $atts);
	global $jsbrotate;
	if($atts['height'] == '')
		$atts['height'] = get_option('large_size_h');
	if($atts['width'] == '')
		$atts['width'] = get_option('large_size_w');
	if($atts['link'] == '')
		$atts['link'] = get_bloginfo('url');
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

add_action('init', 'jsb_enqueue_scripts');
add_action('wp_footer', 'jsb_add_vars');
add_shortcode('jsbrotate', 'jsb_shortcode');
?>