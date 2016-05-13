module.exports = function(grunt) {

    // Project configuration.
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        browserify: {
            dist: {
                files: {
                    'public/js/app/build/companiesReact.js' : 'public/js/app/companiesReact.js',
                    'public/js/app/build/vacanciesReact.js' : 'public/js/app/vacanciesReact.js'
                }
            }
        },
        uglify: {
            build: {
                files: [{
                    expand: true,
                    src : '*.js',
                    dest : 'public/js/app/build/min/',
                    cwd: 'public/js/app/build',
                    flatten: true,
                    rename: function(destBase, destPath) {
                        return destBase+destPath.replace('.js', '.min.js');
                    }
                }]

            }
        }
    });

    // Load the plugin that provides the "uglify" task.
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-browserify');

    // Default task(s).
    grunt.registerTask('default', ['browserify','uglify']);

};