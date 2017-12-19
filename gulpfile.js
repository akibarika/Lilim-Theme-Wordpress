var gulp = require('gulp'),
        less = require('gulp-less'),
        minifyCss = require('gulp-minify-css'),
        uglify = require('gulp-uglify'),
        plumber = require('gulp-plumber'),
        rimraf = require('gulp-rimraf'),
        concat = require('gulp-concat'),
        path = require('path'),
        svgstore = require('gulp-svgstore'),
        svgmin = require('gulp-svgmin'),
        rename = require("gulp-rename"),
        notify = require('gulp-notify'),
        livereload = require('gulp-livereload'),
        autoprefixer = require('gulp-autoprefixer'),
        util = require('gulp-util'),
        merge = require('merge-stream')

// Base paths
var
        paths = {
            src: './wp-content/themes/Lilim-Theme-Wordpress/src/',
            dest: './wp-content/themes/Lilim-Theme-Wordpress/'
        };

var onError = function (err) {
    notify.onError(function (error) {
        return error.message;
    })(err);

    this.emit('end');
};

// CSS
gulp.task('css', function () {
    return gulp
            .src('less/styles.less', {cwd: paths.src})

            .pipe(plumber({
                errorHandler: onError
            }))

            .pipe(less())
            .pipe(autoprefixer())
            .pipe(minifyCss({keepSpecialComments: 0}))
            .pipe(gulp.dest(paths.dest + 'css'))
            .pipe(notify({message: 'Successfully compiled LESS'}));
});

gulp.task('js', function () {
    var mergedStream = merge();
    var targets = require(paths.src + 'js/akibarika.json');

    for (var filename in targets) {
        var stream = gulp
                .src(targets[filename])

                .pipe(plumber({
                    errorHandler: onError
                }))
                .pipe(concat(filename))
                .pipe(gulp.dest(paths.dest + 'js'))
                .pipe(notify({message: 'Successfully compiled js'}));

        mergedStream.add(stream);
    }

    return mergedStream;
});

// SVG tasks
gulp.task('svgstore', function () {
    return gulp
            .src(paths.src + 'images/svg/*.svg')
            .pipe(svgmin(function (file) {

                var prefix = path.basename(file.relative, path.extname(file.relative));
                return {
                    plugins: [{
                        cleanupIDs: {
                            prefix: prefix + '-',
                            minify: true
                        }
                    }]
                }
            }))
            .pipe(svgstore())
            .pipe(gulp.dest(paths.dest + 'images'))
            .pipe(notify('Successfully compiled SVG'));
});

// Rimraf
gulp.task('rimraf', function () {
    return gulp
            .src(['css', 'js'], {read: false})
            .pipe(rimraf());
});

// Default task
gulp.task('default', ['rimraf'], function () {
    gulp.start('css', 'js');
});

// Watch
gulp.task('watch', function () {

    // Watch .less files
    gulp.watch(paths.src + 'less/**/*.less', ['css']);

    // Watch .js files
    gulp.watch(paths.src + 'js/**/*.js', ['js']);

    // Create LiveReload server
    //var server = livereload();
    livereload.listen();
    // Watch any files in , reload on change
    gulp.watch([paths.dest + 'css/*.css', paths.dest + 'js/*.js']).on('change', livereload.changed);
});

