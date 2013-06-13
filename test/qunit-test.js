var images = [
	'http://events.jquery.org/2013/portland/img/logo@2x.png',
	'http://www.gravatar.com/avatar/46093583d8895095adb1b0071c505af2?s=75'
];

test( 'images are preloaded', function() {
	expect(6);
	
	// Set up
	var rotator = new window.ImageRotator( { images: images } );
	
	// Uninitialized
	equal( rotator.preloaded.length, 0 );
	
	// Act
	rotator.preloadImages();
	
	// Verify
	equal( rotator.preloaded.length, 2 );
	
	equal( typeof rotator.preloaded[0], 'object' );
	equal( typeof rotator.preloaded[1], 'object' );
	equal( rotator.preloaded[0].src, images[0] );
	equal( rotator.preloaded[1].src, images[1] );
} );

test( 'top image replaces bottom', function() {
	expect(1);
	
	// Set up
	var rotateDiv = document.getElementById( 'rotating-images' ),
		top = rotateDiv.querySelector( '.top-layer' ),
		bottom = rotateDiv.querySelector( '.bottom-layer' );
		
	top.style.backgroundImage = 'url(http://events.jquery.org/2013/portland/img/logo@2x.png)';
	bottom.style.backgroundImage = 'none';
	
	var rotator = new window.ImageRotator( { images: images } );
	
	// Act
	rotator.fadeImage();
	
	// Verify
	equal( bottom.style.backgroundImage, 'url(http://events.jquery.org/2013/portland/img/logo@2x.png)' );
} );

test( 'top image replaced by queue', function() {
	expect(1);
	
	var rotateDiv = document.getElementById( 'rotating-images' ),
		top = rotateDiv.querySelector( '.top-layer' ),
		bottom = rotateDiv.querySelector( '.bottom-layer' );
		
	top.style.backgroundImage = 'none';
	bottom.style.backgroundImage = 'none';
	
	var rotator = new window.ImageRotator( { images: images } );
	
	// Act
	rotator.fadeImage();
	
	// Verify
	equal( top.style.backgroundImage, 'url(' + images[1] + ')' );
} );

test( 'images cycle after queue', function() {
	expect(3);
	
	var rotateDiv = document.getElementById( 'rotating-images' ),
		top = rotateDiv.querySelector( '.top-layer' ),
		bottom = rotateDiv.querySelector( '.bottom-layer' );
		
	top.style.backgroundImage = 'none';
	bottom.style.backgroundImage = 'none';
	
	var rotator = new window.ImageRotator( { images: images } );
	
	rotator.fadeImage();
	equal( top.style.backgroundImage, 'url(' + images[1] + ')' );
	
	// Cycle back to beginning
	rotator.fadeImage();
	equal( top.style.backgroundImage, 'url(' + images[0] + ')' );
	
	rotator.fadeImage();
	equal( top.style.backgroundImage, 'url(' + images[1] + ')' );
} );

asyncTest( 'callback invoked after fade', function() {
	expect( 1 );
	
	// Set up
	var rotator = new window.ImageRotator( { fade: 0.1, images: images } );
	
	// Act
	rotator.fadeImage( function() {
		ok( true, 'callback was invoked' );
		start();
	} );
} );