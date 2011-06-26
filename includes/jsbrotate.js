window.currentImage = window.currentImage || 0;
window.fadeDuration = 2;
window.fadeInterval = 10;

if(document.images) {
	for(var i=0;i<images.length;i++){
		var preload_image_obj = new Image();
		preload_image_obj.src = images[i];
	}
}

jQuery(document).ready(function() {
	setTimeout('fadeImage()', fadeInterval * 1000);
})

function fadeImage() {
	var $ = jQuery,
		top = $('#rotating-images .top-layer'),
		bottom = $('#rotating-images .bottom-layer');

	window.currentImage++;
	if(window.currentImage >= images.length) window.currentImage = 0;

	bottom.css('backgroundImage', top.css('backgroundImage'));
	top.stop().hide();
	top.css('backgroundImage', 'url(' + images[window.currentImage] + ')');
	top.fadeIn(fadeDuration * 1000, function() {
		setTimeout('fadeImage()', fadeInterval * 1000);
	}).delay(fadeInterval * 1000);
}