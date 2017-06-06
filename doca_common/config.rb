# Require any additional compass plugins installed on your system.
require 'breakpoint'
require 'sass-globbing'
require 'singularitygs'
require 'compass/import-once/activate'

# Location of the theme's resources.
css_dir         = "dist/css"
sass_dir        = "src/sass"
fonts_dir       = "fonts"
images_dir      = "images"
javascripts_dir = "js"

# You can select your preferred output style here (can be overridden via the command line):
# output_style = :expanded or :nested or :compact or :compressed
output_style = :expanded

# To enable relative paths to assets via compass helper functions. Since Drupal
# themes can be installed in multiple locations, we don't need to worry about
# the absolute path to the theme from the server root.
relative_assets = true

# To disable debugging comments that display the original location of your selectors. Uncomment:
line_comments = false

# CSS sourcemaps
sourcemap = false

# Pass options to sass.
# sass_options = {}
