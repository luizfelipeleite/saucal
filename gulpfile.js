const gulp = require('gulp');
const babel = require('gulp-babel');
const sass = require('gulp-sass')(require('sass'))
const autoprefixer = require('gulp-autoprefixer');
const cleanCSS = require('gulp-clean-css');
const rename = require('gulp-rename');

gulp.task('js', () => {
  return gulp.src('assets/js/*.js') // Modified source path
    .pipe(babel({
      presets: ['@babel/env', '@babel/preset-react']
    }))
    .pipe(gulp.dest('dist/js'));
});

gulp.task('scss', () => {
  return gulp.src('assets/scss/*.scss') // Modified source path
    .pipe(sass().on('error', sass.logError))
    .pipe(autoprefixer({
      cascade: false
    }))
    .pipe(gulp.dest('dist/css'))
    .pipe(cleanCSS())
    .pipe(rename({
      suffix: '.min'
    }))
    .pipe(gulp.dest('dist/css'));
});

gulp.task('watch', () => {
  gulp.watch('assets/js/*.js', gulp.series('js')); // Modified watch path
  gulp.watch('assets/scss/*.scss', gulp.series('scss')); // Modified watch path
});

gulp.task('default', gulp.series('js', 'scss', 'watch'));
