<?php
class JS_Banner_Rotate {
	public static function enqueue_scripts() {
		wp_enqueue_script( 'jsb-rotate', JSB_ROTATE_INC_URL . '/jsbrotate.js', 'jquery', '2.0', true );

		wp_enqueue_style( 'jsb-rotate', JSB_ROTATE_INC_URL . '/jsbrotate.css', '', '2.0', 'screen' );
	}

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

		self::jsbrotate( null, $atts );
	}

	public static function jsbrotate( $options = null, $atts = array() ) {
		if ( null !== $options ) {
			parse_str( $options, $atts );
		}
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

		// Backwards compatability, convert the old image# strings into an images array
		if ( $atts['images'] == 'none' ) {
			__deprecated_argument( __FUNCTION__, '2.0', 'Please upgrade your use of individual image# parameters to the pipe-delimited images list!' );

			$atts['images'] = array();

			if ( $atts['image1'] != 'none' )
				$atts['images'][] = $atts['image1'];

			if ( $atts['image2'] != 'none' )
				$atts['images'][] = $atts['image2'];

			if ( $atts['image3'] != 'none' )
				$atts['images'][] = $atts['image3'];

			if ( $atts['image4'] != 'none' )
				$atts['images'][] = $atts['image4'];

			if ( $atts['image5'] != 'none' )
				$atts['images'][] = $atts['image5'];
		} else {
			$atts['images'] = explode( "|", $atts['images'] );
		}

		$banner = new JSB_Banner(
			$atts['images'],
			array(
			     'height'   => $atts['height'],
			     'width'    => $atts['width'],
			     'link'     => $atts['link'],
			     'imgdisp'  => $atts['imgdisp'],
			     'imgfade'  => $atts['imgfade'],
			     'numvis'   => false,
			     'titlevis' => $atts['titlevis'],
			     'title'    => $atts['title']
			) );

		$banner->output();
	}
}
?>