<?php
/**
 * Primary plugin functionality, wrapped in a class definition to provide namespace-like abstraction.
 *
 * @author Eric Mann
 *
 * @since 1.4
 */
class JS_Banner_Rotate {
	/**
	 * Enqueue the necessary scripts and styles needed to create the rotating image banner.
	 *
	 * @since 1.4
	 */
	public static function enqueue_scripts() {
		wp_enqueue_script( 'jsb-rotate', JSB_DIRECTORY . '/includes/jsbrotate.js', array( 'jquery' ), '2.0', true );

		wp_enqueue_style( 'jsb-rotate', JSB_DIRECTORY . '/includes/jsbrotate.css', '', '2.0', 'screen' );
	}

	/**
	 * Handle the user-entered in-page shortcode.
	 *
	 * Expected attributes (space-delimited string):
	 * - height:   Height of banner in pixels.
	 * - width:    Width of banner in pixels.
	 * - title:    Title of banner.
	 * - link:     Url that will be used when the banner is clicked.
	 * - titlevis: Flag whether or not the banner title is visible.
	 * - images:   Pipe-delimited string of image Urls. For example, `images=http://site.com/image1.jpg|http://site.com/image2.jpg
	 * - image1:   deprecated
	 * - image2:   deprecated
	 * - image3:   deprecated
	 * - image4:   deprecated
	 * - image5:   deprecated
	 * - imgdisp:  Number of seconds to display each image.
	 * - imgfade:  Number of seconds to fade each image
	 * - color:    deprecated
	 *
	 * @since 1.4
	 *
	 * @param array $atts Attributes passed in to the shortcode as a string within the WordPress editor.
	 *
	 * @return string HTML markup for the shortcode.
	 */
	public static function shortcode_handler( $atts ) {
		$atts = shortcode_atts(
			array(
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
				),
			$atts);

		return self::generate_banner( $atts );
	}

	/**
	 * Handle the template tag.
	 *
	 * Expected attributes (space-delimited string):
	 * - height:   Height of banner in pixels.
	 * - width:    Width of banner in pixels.
	 * - link:     Url that will be used when the banner is clicked.
	 * - images:   Pipe-delimited string of image Urls. For example, `images=http://site.com/image1.jpg|http://site.com/image2.jpg
	 * - image1:   deprecated
	 * - image2:   deprecated
	 * - image3:   deprecated
	 * - image4:   deprecated
	 * - image5:   deprecated
	 * - imgdisp:  Number of seconds to display each image.
	 * - imgfade:  Number of seconds to fade each image
	 *
	 * @since 1.4
	 *
	 * @param array $atts Attributes passed in to the shortcode as a string within the WordPress editor.
	 *
	 * @return string HTML markup for the shortcode.
	 */
	public static function jsbrotate( $options ) {
		$atts = array();

		parse_str( $options, $atts );

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

		echo self::generate_banner( $atts );
	}

	/**
	 * Create a JSB_Banner object from user-entered arguments that were filtered earlier in the class.
	 *
	 * All arguments in the $options array are required and assumed to be pre-populated. This function should only ever
	 * be called from within the JS_Banner_Rotate class.  The required array elements are:
	 * - images:   Pipe-delimited list of image uris to rotate through.
	 * - height:   Height of the banner in pixels.
	 * - width:    Width of the banner in pixels.
	 * - link:     Url to use as a clickable link for the entire presentation.
	 * - imgdisp:  Number of seconds to display each image.
	 * - imgfade:  Number of seconds to fade each image.
	 * - titlevis: Flag whether or not the banner title is visible.
	 * - title:    Title for the banner.
	 *
	 * @since 2.0
	 *
	 * @see shortcode_handler()
	 * @see jsbrotate()
	 *
	 * @param array $options Array of arguments used to generate the banner.
	 *
	 * @return string HTML markup for the banner.
	 */
	private static function generate_banner( $options ) {
		// Backwards compatability, convert the old image# strings into an images array
		if ( $options['images'] == 'none' ) {
			_deprecated_argument( __FUNCTION__, '2.0', 'Please upgrade your use of individual image# parameters to the pipe-delimited images list!' );

			$options['images'] = array();

			if ( $options['image1'] != 'none' )
				$options['images'][] = $options['image1'];

			if ( $options['image2'] != 'none' )
				$options['images'][] = $options['image2'];

			if ( $options['image3'] != 'none' )
				$options['images'][] = $options['image3'];

			if ( $options['image4'] != 'none' )
				$options['images'][] = $options['image4'];

			if ( $options['image5'] != 'none' )
				$options['images'][] = $options['image5'];
		} else {
			$options['images'] = explode( "|", $options['images'] );
		}

		$banner = new JSB_Banner(
			$options['images'],
			array(
			     'height'   => $options['height'],
			     'width'    => $options['width'],
			     'link'     => $options['link'],
			     'imgdisp'  => $options['imgdisp'],
			     'imgfade'  => $options['imgfade'],
			     'numvis'   => false,
			     'titlevis' => $options['titlevis'],
			     'title'    => $options['title']
			) );

		return $banner->output();
	}
}
?>