const { series, parallel, watch } = require("gulp");
var gulp = require("gulp"),
  imagemin = require("gulp-imagemin"),
  clean = require("gulp-clean"),
  concat = require("gulp-concat"),
  uglify = require("gulp-uglify"),
  sass = require("gulp-sass"),
  cleanCSS = require("gulp-clean-css"),
  rename = require("gulp-rename"),
  sourcemaps = require("gulp-sourcemaps");

sass.compiler = require("node-sass");

function createDist() {
  return gulp.src("resources/images/**/*").pipe(gulp.dest("public_html/dist/images/"));
}

function cleanDist() {
  return gulp.src("public_html/dist").pipe(clean());
}

function minifyImg() {
  return gulp
    .src("public_html/dist/images/**/*")
    .pipe(imagemin())
    .pipe(gulp.dest("public_html/dist/images"));
}

function buildJs() {
  return gulp
    .src([
      "node_modules/jquery/dist/jquery.js",
      "node_modules/bootstrap/dist/js/bootstrap.js",
      "resources/js/app.js",
    ])
    .pipe(concat("all.min.js"))
    .pipe(uglify())
    .pipe(gulp.dest("public_html/dist/js"));
}

function buildCss() {
  return gulp
    .src("resources/scss/style.scss")
    .pipe(sourcemaps.init())
    .pipe(sass().on("error", sass.logError))
    .pipe(cleanCSS())
    .pipe(rename("bundle.min.css"))
    .pipe(sourcemaps.write("./"))
    .pipe(gulp.dest("public_html/dist/css"));
}

exports.createDist = createDist;

exports.image = series(
  cleanDist,
  createDist,
  parallel(minifyImg)
);

exports.scss = buildCss;

exports.compila = function () {
  watch("resources/scss/**/*.scss", buildCss);
  watch("resources/js/**/*.js", buildJs);
};

exports.default = series(
  cleanDist,
  createDist,
  parallel(minifyImg, buildJs, buildCss)
);
