<?php
/**
 * Default template for displaying the output of the [jsbrotate /] shortcode.
 *
 * To customize the display of the shortcode, simply copy this file into your active theme and make changes to the copied
 * version.  The plugin will automatically detect the new version in your theme and will defer to it instead.
 */

global $jsbrotate_container;

/**
 * Certain variables are required for properly generating the output of the shortcode.  The following variables must be
 * retrieved from the container variable housed in the global scop.e
 *
 * @var string $title    Title of the rotating banner.
 * @var bool   $titlevis Flag whether or not to display the banner title.
 * @var number $width    Width of the element in pixels.
 * @var number $height   Height of the element in pixels.
 * @var string $image    URL of the first image in the rotation.
 */
extract( $jsbrotate_container );
?>
<div id="banner-block" style="max-height:<?php echo $height; ?>px;height:auto !important;height:<?php echo $height; ?>px;width:auto !important;width:<?php echo $width; ?>px">
	<div class="banner-container" style="height:<?php echo $height; ?>px;width:<?php echo $width; ?>px;overflow:hidden;">
		<?php if ( $titlevis ) { ?>
	    <div class="banner-top-links">
		    <div class="image-frame" style="background: transparent url('<?php echo JSB_DIRECTORY; ?>images/banner-top-links.png') no-repeat scroll 0 0;">
			    <ul>
				    <li class="images-link"><?php echo $title; ?></li>
			    </ul>
		    </div>
	    </div>
		<?php } ?>
		<div id="rotating-images" style="height:<?php echo $height; ?>px;width:<?php echo $width; ?>px;overflow:hidden;">
			<div class="home-banner top-layer" style="height:<?php echo $height; ?>px;width:<?php echo $width; ?>px;overflow:hidden;background-image:url(<?php echo $image; ?>);"></div>
			<div class="home-banner bottom-layer" style="height:<?php echo $height; ?>px;width:<?php echo $width; ?>px;overflow:hidden;position:relative;top:-<?php echo $height; ?>px;"></div>
		</div>
	</div>
</div>