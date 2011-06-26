<?php
class JS_Banner_Rotate {
	public static function enqueue_scripts() {
		wp_enqueue_script( 'jsb-rotate', JSB_ROTATE_INC_URL . '/jsbrotate.js', 'jquery', '1.4', true );
	}

	public static function print_styles() {
		wp_enqueue_style( 'jsb-rotate', JSB_ROTATE_INC_URL . '/jsbrotate.css', '', '1.3', 'screen' );
	}

	public static function shortcode_handler( $atts ) {
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
			JS_Banner_Rotate::canonical($atts);

		if( $atts['images'] != 'none' )
			JS_Banner_Rotate::unlimited($atts);
	}

	public static function canonical( $atts ) {
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

	public static function unlimited( $atts ) {
		$allbanners = explode("|", $atts['images']);
		JS_Banner_Rotate::localize_variables( 'images', $allbanners );
		$i = 0;
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

		<div id="jsBanners" class="home-banner" style="height:<?php echo $atts['height']; ?>px;width:<?php echo $atts['width']; ?>px;background:url('<?php echo $allbanners[0]; ?>') no-repeat;">
<?php foreach($allbanners as $banner) {
			$i++; ?>
			<span id="banner-<?php echo $i; ?>" style="height:<?php echo $atts['height']; ?>px;width:<?php echo $atts['width']; ?>px;" class="banner"><a href="<?php echo $atts['link']; ?>"><img src="<?php echo $banner; ?>" width="<?php echo $atts['width']; ?>" height="<?php echo $atts['height']; ?>" alt="JSB Rotate Image <?php echo $i; ?>" /></a></span>
<?php } ?>
		</div><!--/jsBanners-->
	</div><!--/banner-container-->
</div><!--/banner-block-->
<?php
	}

	public static function jsbrotate( $options ) {
		$atts = array();
		parse_str($options, $atts);
		$defaults = array(
			'height' => get_option('large_size_h'),
			'width'  => get_option('large_size_w'),
			'link'   => get_bloginfo('url'),
			'images' => 'none',
			'image1' => 'none',
			'image2' => 'none',
			'image3' => 'none',
			'image4' => 'none',
			'image5' => 'none',
			'numvis' => 'true',
			'imgdisp' => '8',
			'imgfade' => '4'
			);
	$atts = array_merge( $defaults, $atts );
	global $jsbrotate;
	$jsbrotate['imgdisp']=$atts['imgdisp'];
	$jsbrotate['imgfade']=$atts['imgfade'];

	if( $atts['image1'] != 'none' )
		JS_Banner_Rotate::canonical($atts);

	if( $atts['images'] != 'none' )
		JS_Banner_Rotate::unlimited($atts);
	}

	public static function localize_variables($name, $vars) {
		$data = "var $name = [";
		$arr = array();
		foreach($vars as $var) {
			$arr[count($arr)] = "'" . esc_js($var) . "'";
		}
		$data .= implode(", ", $arr);
		$data .= "]";

		echo "<script type='text/javascript'>\n";
		echo "/* <![CDATA[ */\n";
		echo $data;
		echo "\n/* ]]> */\n";
		echo "</script>\n";
	}
}
?>