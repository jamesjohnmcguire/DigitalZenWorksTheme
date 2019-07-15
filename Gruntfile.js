module.exports = function(grunt)
{
	grunt.initConfig(
	{
		cssmin:
		{
			options:
			{
			},
			target:
			{
				files:
				{
					'css/index.min.css': ['css.normalize.css', 'css/boilerplate.css']
				}
			}
		}
	});

	grunt.loadNpmTasks('grunt-contrib-cssmin');
	grunt.registerTask('default', ["cssmin"]);
};
