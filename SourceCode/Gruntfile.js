module.exports = function(grunt)
{
	grunt.initConfig(
	{
		pkg: grunt.file.readJSON('package.json'),
		cssmin:
		{
			options:
			{
			},
			target:
			{
				files:
				{
				}
			}
		},
		sass:
		{
			dev:
			{
				files:
				{
				}
			}
		},
		uglify:
		{
			options:
			{
				banner: '/*! <%= pkg.name %> <%= grunt.template.today("yyyy-mm-dd") %> */\n'
			},
			build:
			{
				src: 'src/<%= pkg.name %>.js',
				dest: 'build/<%= pkg.name %>.min.js'
			},
			my_target:
			{
				files:
				{
				}
			}
		},
		watch:
		{
			targets:
			{
				files: ['js/**/*.js', 'assets/css/**/*.scss'],
				tasks: ['sass', 'cssmin', 'uglify'],
			}
		}
	});

	grunt.loadNpmTasks('grunt-contrib-cssmin');
	grunt.loadNpmTasks('grunt-contrib-sass');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-watch');

	grunt.registerTask('default', ["cssmin", "sass", "uglify", "watch"]);
};
