// Include Our Plugins
//https://github.com/scniro/gulp-clean-css

var gulp = require('gulp');
var jshint = require('gulp-jshint');
var sass = require('gulp-sass');
var cleanCSS = require('gulp-clean-css');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var rename = require('gulp-rename');


// Concatenate & Minify JS
gulp.task('fontawesome-fonts', function() {
        return gulp.src([
            './bower_components/font-awesome/fonts/*'
        ])
        .pipe(gulp.dest('resources/assets/fonts'));
});
gulp.task('fontawesome-css', function() {
    return gulp.src([
        './bower_components/font-awesome/css/font-awesome.css'
        ])
        .pipe(concat('all.css'))
        .pipe(gulp.dest('resources/assets/css'))
        .pipe(rename('all.min.css'))
        .pipe(cleanCSS())
        .pipe(gulp.dest('resources/assets/css'));
});
gulp.task('fontawesome', ['fontawesome-css', 'fontawesome-fonts']);



// gulp.task('js', function() {
//     return gulp.src([
//         './bower_components/file3.js',
//         './bower_components/file1.js',
//         './bower_components/file2.js'
//         ])
//         .pipe(concat('all.js'))
//         .pipe(gulp.dest('./resources/js'))
//         .pipe(rename('all.min.js'))
//         .pipe(uglify())
//         .pipe(gulp.dest('resources/js'));
// });
//
// gulp.task('fontawesome-css', function() {
//     return gulp.src([
//         './bower_components/font-awesome/css/font-awesome.css'
//     ])
//         .pipe(concat('fontawesome.css'))
//         .pipe(gulp.dest('resources/assets/css'))
//         .pipe(rename('all.min.css'))
//         .pipe(cleanCSS())
//         .pipe(gulp.dest('resources/assets/css'));
// });
// gulp.task('fontawesome', ['fontawesome-css', 'fontawesome-fonts']);

// Gather Assets
// gulp.task('assets', function() {
//         return gulp.src([
//             './bower_components/*.jpg',
//             './bower_components/*.jpeg',
//             './bower_components/*.gif',
//             './bower_components/*.png'
//         ])
//         .pipe(gulp.dest('resources/assets/img'));
// });

// Lint Task
// gulp.task('lint', function() {
//     return gulp.src('js/*.js')
//         .pipe(jshint())
//         .pipe(jshint.reporter('default'));
// });

// Sass Task
// gulp.task('sass', function() {
//     return gulp.src('scss/*.scss')
//         .pipe(sass())
//         .pipe(gulp.dest('dist/css'));
// });

// Watch Files For Changes
// gulp.task('watch', function() {
//     gulp.watch('js/*.js', ['css', 'scripts']);
//     gulp.watch('scss/*.scss', ['sass']);
// });



// Default Task
gulp.task('default', [
    //'js',
    //'assets'
    'fontawesome'
]);
