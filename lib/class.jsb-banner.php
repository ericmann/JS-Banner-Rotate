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

	/**
	 * Retrieve the shortcode template either from the theme or from the default template included with the plugin.
	 *
	 * To override the default template, merely place a file called `template.jsbrotate_shortcode.php` in the active theme. You
	 * can use the existing template file in the plugin as an example and can reposition elements or add/remove markup
	 * where needed.
	 *
	 * @uses apply_filters() Calls `jsbrotate_shortcode` to retrieve the shortcode template filename.
	 * @uses apply_filters() Calls `jsbrotate_shortcode_container` to filter arguments passed to the shortcode template.
	 *
	 * @return string HTML markup of the parsed shortcode.
	 */
	public function output() {
		// Get the shortcode template
		$template_name = apply_filters( 'jsbrotate_shortcode', 'template.jsbrotate_shortcode.php' );
		$path = locate_template( $template_name );
		if ( empty( $path ) ) {
			$path = JSB_INC_DIRECTORY . 'lib/' . $template_name;
		}

		// Populate a global container variable
		global $jsbrotate_container;
		$jsbrotate_container = array(
			'title'    => $this->title,
			'titlevis' => $this->titlevis,
			'height'   => $this->height,
			'width'    => $this->width,
			'image'    => $this->images[0]
		);
		$jsbrotate_container = apply_filters( 'jsbrotate_shortcode_container', $jsbrotate_container );

		// Start a buffer to capture the HTML output of the shortcode
		ob_start();

		include( $path );

		$output = ob_get_contents();

		ob_end_clean();

		// Because globals are evil, kill it.
		unset( $jsbrotate_container );

		wp_localize_script( 'jsb-rotate', 'images', $this->images );
		wp_localize_script(
			'jsb-rotate',
			'jsb_options',
			array(
			     'display' => $this->imgdisp,
			     'fade'    => $this->imgfade
	             )
		);

		return $output;
	}
}
?>