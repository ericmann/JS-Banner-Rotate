/*global jQuery */
( function( window, $, undefined ) {
	var document = window.document,
		OPTIONS = window.jsb_options || {};
	
	/**
	 * Object that controls the image rotation.
	 *
	 * @param options Array of options, including the fade duration, interval timeout, and images to rotate through.
	 * @constructor
	 */
	var ImageRotator = window.ImageRotator = function (options) {
		var currentImage = 0,
			fadeDuration = options.fade || 4,
			fadeInterval = options.display || 8,
			images = options.images || [],
			SELF = this;

		SELF.preloaded = [];
			
		/**
		 * Attempt to preload images into the browser so large images won't cause a delay when rotated through.
		 */
		SELF.preloadImages = function () {
			for ( var i = 0, l = images.length; i < l; i += 1 ) {
				var preload_image_obj = new Image();
				preload_image_obj.src = images[ i ];
				
				SELF.preloaded.push( preload_image_obj );
			}
		};

		/**
		 * Fade the images.
		 *
		 * - Copy the image in the foreground to the background
		 * - Hide the foreground image
		 * - Replace the hidden foreground image with the next in the rotation
		 * - Fade the foreground image back in.
		 */
		SELF.fadeImage = function () {
			var imageEl = jQuery( document.getElementById( 'rotating-images' ) ),
				top = imageEl.find( '.top-layer' ),
				bottom = imageEl.find( '.bottom-layer' );

			currentImage += 1;

			if (currentImage >= images.length) {
				currentImage = 0;
			}

			bottom.css( 'backgroundImage', top.css( 'backgroundImage' ) );
			top.stop().hide();
			top.css( 'backgroundImage', 'url(' + images[currentImage] + ')' );
			top.fadeIn( fadeDuration * 1000, function () {
				setTimeout( SELF.fadeImage, fadeInterval * 1000 );
			} );
		};
	};
} )( this, jQuery );