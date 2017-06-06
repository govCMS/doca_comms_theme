'use strict';

var theme = __dirname + '/';
var gulp = require('gulp');
var plugins = require('gulp-load-plugins')();
var rubySass = require('gulp-ruby-sass');
var runSequence = require('run-sequence');
var del = require('del');
var path = require('path');
var merge = require('merge-stream');
var compass = require('compass-options').dirs({'config': theme + 'config.rb'});
var mainBowerFiles = require('main-bower-files');

// Lint JavaScript.
gulp.task('lint:js', function () {
  return gulp.src(theme + 'src/js/*.js')
      .pipe(plugins.jshint())
      .pipe(plugins.jshint.reporter('jshint-stylish'));
});

// Lint Sass.
gulp.task('lint:sass', function () {
  return gulp.src(theme + compass.sass + '/**/*.scss')
      .pipe(plugins.scssLint({'bundleExec': true, 'maxBuffer': Infinity}));
});

// Lint Sass and JavaScript.
gulp.task('lint', function (cb) {
  runSequence(['lint:js', 'lint:sass'], cb);
});

// Concat and minify JavaScript.
gulp.task('scripts', function () {
  var site = gulp.src([theme + 'src/js/*.js'])
      .pipe(plugins.concat('site.min.js'))
      .pipe(plugins.uglify())
      .pipe(gulp.dest(theme + 'dist/js'));

  var components = gulp.src([theme + '/src/sass/components/**/*.js'])
      .pipe(plugins.concat('components.min.js'))
      .pipe(plugins.uglify())
      .pipe(gulp.dest(theme + 'dist/js'));

  return merge(site, components);
});

gulp.task('bower-scripts', function () {
  return gulp.src(mainBowerFiles({
    includeDev: true,
    paths: {
      bowerDirectory: __dirname + '/vendor',
      bowerJson: __dirname + '/bower.json'
    },
    filter: '**/*.js'
  }))
      .pipe(plugins.concat('vendors.min.js'))
      .pipe(plugins.uglify())
      .pipe(gulp.dest(theme + 'dist/js'));
});

gulp.task('bower-css', function () {
  return gulp.src(mainBowerFiles({
    includeDev: true,
    paths: {
      bowerDirectory: __dirname + '/vendor',
      bowerJson: __dirname + '/bower.json'
    },
    filter: '**/*.css'
  }))
      .pipe(plugins.concat('vendors.css'))
      .pipe(gulp.dest(theme + 'dist/css'));
});

// Bower components.
gulp.task('bower', ['bower-scripts', 'bower-css']);

// Use this if the current theme is not using docs_common as base theme.
gulp.task('modernizr', function () {
  gulp.src(theme + './src/sass/components/**/*.{js,scss}')
      .pipe(plugins.modernizr("modernizr.min.js", {
        "options": [
          "setClasses"
        ]
      }))
      .pipe(plugins.uglify())
      .pipe(gulp.dest(theme + "dist/js/"))
});

process.chdir(theme);

gulp.task('sass:development', function () {
  return rubySass(theme + 'src/sass/site.scss', {
    compass: true,
    bundleExec: true,
    sourcemap: true,
    style: 'expanded'
  })
      .on('error', function (err) {
        console.error('Error!', err.message);
      })
      .pipe(plugins.pixrem())
      .pipe(plugins.sourcemaps.write())
      .pipe(gulp.dest('dist/css'));
});

gulp.task('sass:production', function () {
  return rubySass(theme + 'src/sass/site.scss', {
    compass: true,
    bundleExec: true,
    style: 'compressed'
  })
      .on('error', function (err) {
        console.error('Error!', err.message);
      })
      .pipe(plugins.pixrem())
      .pipe(gulp.dest('dist/css'));
});

// Styles
gulp.task('watch', ['modernizr', 'sass:development', 'lint'], function () {
  gulp.watch(theme + 'src/sass/**/*.scss', ['modernizr', 'sass:development', 'lint']);
  gulp.watch(theme + 'src/sass/**/*.js', ['scripts']);
  gulp.watch(theme + 'src/js/*.js', ['scripts']);
});

// Clean CSS directory.
gulp.task('clean:css', del.bind(null, [theme + '/.sass-cache', theme + compass.css + '/**/*.map'], {force: true}));

// Clean all directories.
gulp.task('clean', ['clean:css']);

// Production build of front-end.
gulp.task('build', ['clean', 'sass:production', 'scripts', 'modernizr'],
    function (cb) {
      // Run linting last, otherwise its output gets lost.
      runSequence(['lint'], cb);
    });

// The default task.
gulp.task('default', ['build']);
