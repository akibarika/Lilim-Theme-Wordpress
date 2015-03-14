var gulp = require('gulp'),
        less = require('gulp-less'),
        minifycss = require('gulp-minify-css'),
        uglify = require('gulp-uglify'),
        plumber = require('gulp-plumber'),
        notify = require('gulp-notify'),
        sourcemaps = require('gulp-sourcemaps'),
        livereload = require('gulp-livereload'),
        autoprefixer = require('gulp-autoprefixer');


var config = {
    minifyCss: true
}

// CSS

gulp.task('css', function () {
    var stream = gulp
            .src('css/styles.less')
            .pipe(sourcemaps.init())
            .pipe(less().on('error', notify.onError(function (error) {
                return 'Error compiling LESS: ' + error.message;
            })))
            .pipe(autoprefixer());

    if (config.minifyCss === true) {
        stream.pipe(minifycss());
    }

    return stream
            .pipe(sourcemaps.write('.'))
            .pipe(gulp.dest('css'))
            .pipe(notify({message: 'Successfully compiled LESS'}));
});
// Watch
gulp.task('watch', function () {

    // Watch .less files
    gulp.watch('css/*.less', ['css']);


    // Create LiveReload server
    //var server = livereload();
    livereload.listen();
    // Watch any files in , reload on change
    gulp.watch(['css/styles.css']).on('change', livereload.changed);
});

// Default task
gulp.task('default', function () {
    gulp.start('css');
});