/**
 * create by chuchur
 * date 2016年12月5日12:57:40
 */
var gulp = require('gulp'),
    path = require('path'),
    concat = require('gulp-concat'),
    connect = require('gulp-connect'),
    uglify = require('gulp-uglify'),
    imagemin = require('gulp-imagemin');
    less = require('gulp-less'),
    cleancss = require('gulp-clean-css'),
    fileinclude  = require('gulp-file-include');


// less 压缩和发布
gulp.task('less', () => {
  return gulp.src('./less/*.less') 
    .pipe(less())
    .pipe(cleancss({
      advanced: true, 
      keepSpecialComments: '*',
      keepBreaks: false,
    }))
   .pipe(concat('styles.min.css'))
   .pipe(gulp.dest('./css/'))
});


gulp.task('reload', () => {
  return gulp.src('./*')
    .pipe(connect.reload());
});

//输出日志
var watchEvent =  (event) => {
  console.log('文件 ' + path.basename(event.path) + ' 发生 ' + event.type + ', 重启任务...');
};

//监听文件改变
gulp.task('watch', () => {
  gulp.watch('./less/*.less', ['less', 'reload']).on("change", watchEvent);
});

var devTasks = [ 'less','reload', 'watch'];
gulp.task('default', devTasks);