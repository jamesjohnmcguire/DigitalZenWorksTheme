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
					'style.min.css': ['style.css']
				}
			}
		}
	});

	grunt.loadNpmTasks('grunt-contrib-cssmin');
	grunt.registerTask('default', ["cssmin"]);	
};
