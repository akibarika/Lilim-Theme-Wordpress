var gulp = require('gulp');
var less = require('gulp-less');

gulp.task('less', function () {
  gulp.src('./css/styles.less') //path to your main less file
    .pipe(less())
    .pipe(gulp.dest('./css')); // your output folder
});