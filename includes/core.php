<?php
function jsb_enqueue_scripts() {	
	// YUI Scripts
	wp_enqueue_script('yahoo-dom-event', JSB_INC . '/yahoo-dom-event.js', '', '2.7.0');
	wp_enqueue_script('animation-min', JSB_INC . '/animation-min.js', 'yahoo-dom-event', '2.7.0');
	wp_enqueue_script('selector', JSB_INC . '/selector-min.js', 'yahoo-dom-event', '2.7.0');
	
	// JSB Scripts
	wp_enqueue_script('jsb-rotate', JSB_INC . '/jsbrotate.js', 'yahoo-dom-event', '1.3');

	//Stylesheet	
	wp_enqueue_style('jsb-rotate', JSB_INC . '/jsbrotate.css', '', '1.3', 'screen');
}

function jsb_add_vars() {
	global $jsbrotate;
	echo "<script type=\"text/javascript\"> \n";
	echo "var imgdisp=" . $jsbrotate['imgdisp'] * 1000 . ",imgfade=" . $jsbrotate['imgfade'] . "; \n";
	echo "</script> \n";
}

?>