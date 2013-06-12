module.exports = function(grunt) {
	grunt.initConfig( {
		pkg: grunt.file.readJSON('package.json'),
		jshint : {
			src: 'includes/**/*.js',
			gruntfile : 'Gruntfile.js'
		},
		qunit : {
			all_tests : 'test/qunit-test.html'
		}
	} );
	grunt.loadNpmTasks( 'grunt-contrib-jshint' );
	grunt.loadNpmTasks( 'grunt-contrib-qunit' );
	
	grunt.registerTask( 'default', [ 'jshint', 'qunit' ] );
};