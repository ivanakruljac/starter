var gulp = require('gulp'),
    sass = require('gulp-sass'),
    postcss = require('gulp-postcss'),
    uglify = require('gulp-uglify'),
    concat = require('gulp-concat'),
    sassLint = require('gulp-sass-lint'),
    autoprefixer = require('autoprefixer'),
    discardComments = require('postcss-discard-comments'),
    whitespace = require('postcss-normalize-whitespace'),
    cssnano = require('cssnano'),
    sourcemaps = require('gulp-sourcemaps'),
    browserSync = require('browser-sync')

function style() {
    return (
        // check if formatting is alright
        gulp.src('./assets/scss/**/*.s+(a|c)ss')
            .pipe(sassLint())
            .pipe(sassLint.format())
            .pipe(sassLint.failOnError())
            // Initialize sourcemaps before compilation starts
            .pipe(sourcemaps.init())
            .pipe(sass())
            .on('error', sass.logError)
            // Use postcss with autoprefixer and compress the compiled file using cssnano
            .pipe(
                postcss([
                    autoprefixer(),
                    discardComments(),
                    whitespace(),
                    cssnano(),
                ])
            )
            // Now add/write the sourcemaps
            .pipe(sourcemaps.write('./'))
            .pipe(gulp.dest('./'))
            .pipe(browserSync.stream())
    )
}


function uglifyjs() {
    return gulp
        .src('./assets/lib/**/*.js')
        .pipe(concat('starter.min.js'))
        .pipe(
            uglify().on('error', function (e) {
                console.log(e)
            })
        )
        .pipe(gulp.dest('./assets/js'))
        .pipe(browserSync.stream())
}


let busy = false
function scripts(done) {
    if (busy) {
        return
    } else {
        browserSync.reload()
    }
    busy = false
    done()
}

function watch() {
    gulp.watch('./assets/scss/**/*.scss', style)
    gulp.watch('./assets/lib/*.js', uglifyjs)
    gulp.watch('./**/*.(php|html)', scripts)
}

function sync(cb) {
    browserSync.init({
        proxy: 'http://localhost/starter/',
        port: 2001,
    })
    cb()
}

exports.tasks = gulp.series(
    gulp.parallel(style, uglifyjs, scripts),
    sync,
    watch
)
