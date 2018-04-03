/**
 * Gulp file for lefuturiste developement
 *
 * Le_Futuriste <contact@lefuturiste.fr>
 * http://lefuturiste.fr
 *
 * Usage:
 * Compile sass => gulp sass (with bourdon)
 * Compile js => gulp concat-scripts
 * Minify js => gulp minify-scripts
 */

/**
 * CONFIG VAR:
 */
/**
 * Source directory of sass
 */
var sass_src_dir = "assets/sass"

/**
 * Output directory of sass
 */
var sass_dest_dir = "public/dist/css"

/**
 * Output style of sass
 * Type: String Default: nested Values: nested, expanded, compact, compressed
 * https://github.com/sass/node-sass#outputstyle
 */
var sass_output_style = "compressed"

/**
 * Source directory of js scripts
 */
var scripts_src_dir = "assets/js/*.js"

/**
 * Output directory of scripts
 */
var scripts_dest_dir = "public/dist/js"

/**
 * Require dependencies
 */
var gulp = require('gulp'),
    sass = require('gulp-sass'),
    bulkSass = require('gulp-sass-glob-import'),
    concat = require('gulp-concat'),
    rename = require('gulp-rename'),
    minify = require('gulp-minify'),
    livereload = require('gulp-livereload');

/**
 * gulp sass
 */
gulp.task('sass', function () {
    return gulp.src(sass_src_dir + '/**.scss')
        .pipe(bulkSass())
        .pipe(sass({
            includePaths: require('node-bourbon').includePaths,
            outputStyle: sass_output_style
        }).on('error', sass.logError))
        .pipe(gulp.dest(sass_dest_dir))
        .pipe(livereload());
});

/**
 * gulp sass:watch
 */
gulp.task('sass:watch', function () {
    livereload.listen();
    gulp.watch('assets/sass/**/*.scss', ['sass']);
});

/**
 * gulp concat-scripts
 */
gulp.task('concat-scripts', function () {
    return gulp.src([
        scripts_src_dir
    ])
        .pipe(concat('app.js'))
        .pipe(gulp.dest(scripts_dest_dir))
        .pipe(gulp.dest(scripts_dest_dir));
});

/**
 * gulp minify-scripts
 */
gulp.task('minify-scripts', function () {
    gulp.src(scripts_dest_dir + '/App.js')
        .pipe(minify({
            ext: {
                src: '.js',
                min: '.min.js'
            }
        }))
        .pipe(gulp.dest(scripts_dest_dir))
});

/**
 * [deprecated] gulp scripts
 */
gulp.task('scripts', ['concat-scripts', 'minify-scripts']);