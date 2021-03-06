module.exports = function(grunt)
{
	grunt.initConfig(
	{
		sass:
		{
			dev:
			{
				files:
				{
					'assets/css/common.css': 'assets/css/common.scss'
				}
			}
		},
		cssmin:
		{
			options:
			{
			},
			target:
			{
				files:
				{
					'assets/css/index.min.css': ['assets/css/source/normalize.css', 'assets/css/source/boilerplate.css']
				}
			}
		},
		uglify:
		{
			my_target:
			{
				files:
				{
					'js/index.min.js': ['js/vendor/modernizr-3.7.1.min.js', 'js/plugins.js']
				}
			}
		},
		watch:
		{
			targets:
			{
				files: ['js/**/*.js', 'css/**/*.scss'],
				tasks: ['sass', 'cssmin', 'uglify'],
			}
		}
	});

	grunt.loadNpmTasks('grunt-contrib-cssmin');
	grunt.loadNpmTasks('grunt-contrib-sass');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.registerTask('default', ["cssmin","sass", "uglify", "watch"]);
};
