module.exports = function(grunt) {

  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    concat: {
      options: {
        separator: ';',
      },
      dist: {
        src: [
          //libraries
          "js/jquery.tinynav.js",
          "js/jquery.tinyscrollbar.js",
          "js/imagesloaded.pkgd.js",
          "js/jquery.transit.js",

          //scripts
          "js/globals.js",
          "js/alert.js",
          "js/weather.js",
          "js/thin-strip.js",
          "js/dropdowns.js",
          "js/dropdowns-accessibility.js",
          "js/sidebar-menu.js",
          "js/mobile-menu.js",
          "js/search-expanded.js",
          "js/gallery.js",

          //widgets
          "js/widgets/community-photos.js",
          "js/widgets/slideshow.js",
          "js/widgets/jquery.fullcalendar.js",
          "js/widgets/jquery.fullcalendar.gcal.js",
          "js/widgets/uw-calendar.js",
          "js/widgets/youtube-playlist.js"
        ],
        dest: 'js/site.dev.js'
      }
    },
    uglify: {
      options: {
        banner: '/*! <%= pkg.name %> <%= grunt.template.today("dd-mm-yyyy") %> */\n'
      },
      dist: {
        files: {
          'js/site.js': ['<%= concat.dist.dest %>']
        }
      }
    },
    jshint: {
      files: [ 'Gruntfile.js', '<%= concat.dist.src %>' ],
      options: {
        // options here to override JSHint defaults
        globals: {
          jQuery: true,
          console: true,
          module: true,
          document: true
        }
      }
    },
    watch: {
      files: ['<%= concat.dist.src %>'],
      tasks: ['default']
    }
  });

  grunt.loadNpmTasks('grunt-contrib-jshint');
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-watch');

  grunt.registerTask('default', ['concat', 'uglify']);

};
