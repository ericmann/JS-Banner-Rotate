<?php
/**
 * The Rotating Banner class
 *
 * @since 1.4
 */
class JSB_Banner {
	/**
	 * Array of images to rotate.
	 *
	 * @since 1.4
	 * @access private
	 * @var array
	 */
	var $images;

	/**
	 * Height of the banner block.
	 *
	 * @since 1.4
	 * @access private
	 * @var int
	 */
	var $height;

	/**
	 * Width of the banner block.
	 *
	 * @since 1.4
	 * @access private
	 * @var int
	 */
	var $width;

	/**
	 * Display time for individual images in seconds.
	 *
	 * @since 1.4
	 * @access private
	 * @var int
	 */
	var $imgdisp;

	/**
	 * Fade time between individual images.
	 *
	 * @since 1.4
	 * @access private
	 * @var int
	 */
	var $imgfade;

	/**
	 * Option to display rotating slide numbers
	 *
	 * @since 1.4
	 * @access private
	 * @var bool
	 */
	var $numvis;

	/**
	 * Option to display a title for the rotating banners
	 *
	 * @since 1.4
	 * @access private
	 * @var bool
	 */
	var $titlevis;

	/**
	 * Banner title
	 *
	 * @since 1.4
	 * @access private
	 * @var string
	 */
	var $title;

	/**
	 * Constructor
	 * 
	 * @param array $images   Images to rotate
	 * @param array $args     Arguments to control the banner
	 * @return JSB_Banner
	 */
	public function JSB_Banner( $images, $args ) {
		$defaults = array(
			'height'    => get_option( 'large_size_h' ),
			'width'     => get_option( 'large_size_w' ),
			'link'      => get_bloginfo( 'url' ),
			'imagedisp' => 8,
			'imgfade'   => 4,
			'numvis'    => false,
			'titlevis'  => false
		);

		$args = array_merge( $defaults, $args );

		$this->images   = (array) $args['images'];
		$this->height   = (int) $args['height'];
		$this->width    = (int) $args['width'];
		$this->imgdisp  = (int) $args['imgdisp'];
		$this->imgfade  = (int) $args['imgfade'];
		$this->numvis   = (boolean) $args['numvis'];

		if ( isset( $atts['title'] ) ) {
			$this->title    = (string) $args['title'];
			$this->titlevis = (boolean) $args['titlevis'];
		} else {
			$this->titlevis = false;
		}
	}

	/**
	 * Create the banner block header.
	 *
	 * @since 1.4
	 * @access private
	 * @return string
	 */
	function header() {
		$header = "";

		$header .= '<div id="banner-block" style="max-height: ' . $this->height . 'px;height:auto !important;height: ' . $this->height .';width:auto !important;width:' . $this->width . 'px;">';
		$header .= '<div class="banner-container">';
		if($this->titlevis) {
			$header .= '<div class="banner-top-links">';
			$header .= '<div class="image-frame" style="background: transparent url(' . JSB_DIRECTORY . 'images/banner-top-links.png) no-repeat scroll 0 0;">';
			$header .= '<ul>';
			$header .= '<li class="images-link">' . $this->title . '</li>';
			$header .= '</ul>';
			$header .= '</div>';
			$header .= '</div>';
		}

		return $header;
	}

	/**
	 * Loop through images and create a banner block
	 *
	 * @since 1.4
	 * @access private
	 * @return string
	 */
	function body() {

	}

	/**
	 * Close the banner block elements
	 *
	 * @since 1.4
	 * @access private
	 * @return string
	 */
	function footer(){
		$footer = "";

		$footer .= "</div><!-- /banner-container -->";
		$footer .- "</div><!-- /banner-block -->";

		return $footer;
	}

	public function output() {
		JS_Banner_Rotate::localize_variables( 'images', $this->images );

		echo $this->header();

		echo $this->footer();
	}
}
?>