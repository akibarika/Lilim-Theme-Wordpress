var gulp = require('gulp'),
        less = require('gulp-less'),
        minifycss = require('gulp-minify-css'),
        uglify = require('gulp-uglify'),
        plumber = require('gulp-plumber'),
        notify = require('gulp-notify'),
        sourcemaps = require('gulp-sourcemaps'),
        livereload = require('gulp-livereload');


var config = {
    minifyCss: true
}

// CSS
gulp.task('css', function () {
    var stream = gulp
            .src('css/styles.less')
            .pipe(plumber({
                errorHandler: notify.onError(function (error) {
                    return 'Error compiling LESS: ' + error.message;
                })
            }))
            //.pipe(sourcemaps.init())
            //.pipe(less({sourceMap: true}))
            .pipe(less())
            //.pipe(sourcemaps.write('maps', {sourceRoot: 'css'}));

    if (config.minifyCss === true) {
        stream.pipe(minifycss());
    }

    return stream
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
    gulp.watch(['css/style.css']).on('change', livereload.changed);
});

// Default task
gulp.task('default', function () {
    gulp.start('css');
});