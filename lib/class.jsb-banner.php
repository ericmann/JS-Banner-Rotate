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
	var $images = array();

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
	var $imgdisp = 8;

	/**
	 * Fade time between individual images.
	 *
	 * @since 1.4
	 * @access private
	 * @var int
	 */
	var $imgfade = 4;

	/**
	 * Option to display rotating slide numbers
	 *
	 * @since 1.4
	 * @access private
	 * @var bool
	 */
	var $numvis = true;

	/**
	 * Option to display a title for the rotating banners
	 *
	 * @since 1.4
	 * @access private
	 * @var bool
	 */
	var $titlevis = true;

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
	public function __construct( $images, $args ) {
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

		$this->images   = (array) $images;
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

	private function height_and_width( $move_to_top = false, $extras = array() ) {
		$styles = [];

		$styles[] = "height:{$this->height}px";
		$styles[] = "width:{$this->width}px";
		$styles[] = "overflow:hidden";


		if ( $move_to_top ) {
			$styles[] = "position:relative";
			$styles[] = "top:-{$this->height}px";
		}

		$styles = array_merge( $styles, $extras );

		$style_string = implode( ";", $styles );

		return "style=\"$style_string;\"";
	}

	public function output() {
		$outer_style = $this->height_and_width( false );
		$top_style = $this->height_and_width( false, array( 'background-image:url(' . $this->images[0] . ')' ) );
		$bottom_style = $this->height_and_width( true );

		$output = "";

		$output .= '<div id="banner-block" style="max-height: ' . $this->height . 'px;height:auto !important;height: ' . $this->height .'px;width:auto !important;width:' . $this->width . 'px;">';
		$output .= '<div class="banner-container" ' . $outer_style . '>';
		if($this->titlevis) {
			$output .= '<div class="banner-top-links">';
			$output .= '<div class="image-frame" style="background: transparent url(' . JSB_DIRECTORY . 'images/banner-top-links.png) no-repeat scroll 0 0;">';
			$output .= '<ul>';
			$output .= '<li class="images-link">' . $this->title . '</li>';
			$output .= '</ul>';
			$output .= '</div>';
			$output .= '</div>';
		}

		$output = "";
		$output .= '<div id="rotating-images" ' . $top_style . '>';
		$output .= '<div class="home-banner top-layer" ' . $top_style . '>';
		$output .= '</div>';
		$output .= '<div class="home-banner bottom-layer" ' . $bottom_style . '>';
		$output .= '</div><!-- /jsBanners -->';
		$output .= '</div>';

		$output .= "</div><!-- /banner-container -->";
		$output .= "</div><!-- /banner-block -->";

		echo $output;

		wp_localize_script( 'jsb-rotate', 'images', $this->images );
		wp_localize_script(
			'jsb-rotate',
			'jsb_options',
			array(
			     'display' => $this->imgdisp,
			     'fade'    => $this->imgfade
	             )
		);
	}
}
?>