var gulp = require('gulp'),
        less = require('gulp-less'),
        minifycss = require('gulp-minify-css'),
        uglify = require('gulp-uglify'),
        plumber = require('gulp-plumber'),
        rimraf = require('gulp-rimraf'),
        concat = require('gulp-concat'),
        notify = require('gulp-notify'),
        sourcemaps = require('gulp-sourcemaps'),
        livereload = require('gulp-livereload'),
        autoprefixer = require('gulp-autoprefixer');


var config = {

    // Should CSS & JS be compressed?
    minifyCss: false,
    uglifyJS: true
}

// CSS

gulp.task('css', function () {
    var stream = gulp
            .src('src/less/styles.less')
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

gulp.task('js',['appjs','vendorjs','commentjs','postjs']);

gulp.task('appjs', function () {
    var stream = gulp.src([
        'src/js/all.js',
        'src/js/fx.js',
        'src/js/post.js'

    ]).pipe(sourcemaps.init())
            .pipe(concat('app.js'));

    if (config.uglifyJS === true) {
        stream.pipe(uglify());
    }

    return stream
            .pipe(sourcemaps.write('.'))
            .pipe(gulp.dest('js'))
            .pipe(notify({message: 'Successfully compiled app js'}));
});

gulp.task('vendorjs', function () {
    var scripts = [
        'src/js/jquery.min.js',
        'src/js/imagesloaded.pkgd.min.js'
    ];

    var stream = gulp
            .src(scripts)
            .pipe(sourcemaps.init())
            .pipe(concat('vendor.js'));

    if (config.uglifyJS === true) {
        stream.pipe(uglify());
    }

    return stream
            .pipe(sourcemaps.write('.'))
            .pipe(gulp.dest('js'))
            .pipe(notify({message: 'Successfully compiled vendor js'}));
});

gulp.task('postjs', function () {
    var scripts = [
        'src/js/TweenMax.min.js',
        'src/js/share.js'
    ];

    var stream = gulp
            .src(scripts)
            .pipe(sourcemaps.init())
            .pipe(concat('post.js'));

    if (config.uglifyJS === true) {
        stream.pipe(uglify());
    }

    return stream
            .pipe(sourcemaps.write('.'))
            .pipe(gulp.dest('js'))
            .pipe(notify({message: 'Successfully compiled vendor js'}));
});

gulp.task('commentjs', function () {
    var scripts = [
        'src/js/comments-ajax.js'
    ];

    var stream = gulp
            .src(scripts)
            .pipe(sourcemaps.init())
            .pipe(concat('comment.js'));

    if (config.uglifyJS === true) {
        stream.pipe(uglify());
    }

    return stream
            .pipe(sourcemaps.write('.'))
            .pipe(gulp.dest('js'))
            .pipe(notify({message: 'Successfully compiled vendor js'}));
});

// Rimraf
gulp.task('rimraf', function () {
    return gulp
            .src(['css', 'js'], {read: false})
            .pipe(rimraf());
});

// Default task
gulp.task('default', ['rimraf'], function () {
    gulp.start('css', 'vendorjs', 'appjs', 'postjs');
});

// Watch
gulp.task('watch', function () {

    // Watch .less files
    gulp.watch('src/less/**/*.less', ['css']);

    // Watch .js files
    gulp.watch('src/js/**/*.js', ['appjs','vendorjs','commentjs','postjs']);

    // Create LiveReload server
    //var server = livereload();
    livereload.listen();
    // Watch any files in , reload on change
    gulp.watch(['css/*.css', 'js/*.js']).on('change', livereload.changed);
});

