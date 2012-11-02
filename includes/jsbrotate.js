/**
 * Object that controls the image rotation.
 *
 * @param options Array of options, including the fade duration, interval timeout, and images to rotate through.
 * @constructor
 */
var ImageRotator = function (options) {
	var currentImage = 0,
		fadeDuration = 4,
		fadeInterval = 8,
		images = [],
		self = this;

	/**
	 * Attempt to preload images into the browser so large images won't cause a delay when rotated through.
	 */
	this.preloadImages = function () {
		var i,
			preload_image_obj;

		if (document.images) {
			for (i = 0; i < images.length; i += 1) {
				preload_image_obj = new Image();
				preload_image_obj.src = images[i];
			}
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
	this.fadeImage = function () {
		var imageEl = jQuery('#rotating-images'),
			top = imageEl.find('.top-layer'),
			bottom = imageEl.find('.bottom-layer');

		currentImage += 1;

		if (currentImage >= images.length) {
			currentImage = 0;
		}

		bottom.css('backgroundImage', top.css('backgroundImage'));
		top.stop().hide();
		top.css('backgroundImage', 'url(' + images[currentImage] + ')');
		top.fadeIn(fadeDuration * 1000, function () {
			setTimeout(self.fadeImage, fadeInterval * 1000);
		});
	};

	if ('undefined' !== typeof options.images) {
		images = options.images;
	}

	if ('undefined' !== typeof options.display) {
		self.fadeInterval = options.display;
	}

	if ('undefined' !== typeof options.fade) {
		fadeDuration = options.fade;
	}
};


jQuery(document).ready(function () {
	var options = {
		images: window.images,
		display: window.jsb_options.display,
		fade: window.jsb_options.fade
	},
		rotator = new ImageRotator(options);

	// The first image in the rotation will always be loaded. Attempt to load the others so the queue moves quickly.
	rotator.preloadImages();

	setTimeout(rotator.fadeImage, window.jsb_options.display * 1000);
});