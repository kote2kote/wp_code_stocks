const { src, dest, task, watch, series, parallel } = require('gulp');
const del = require('del'); //For Cleaning build/dist for fresh export
const options = require('./config'); //paths and other options from config.js
const browserSync = require('browser-sync').create();
const phpServer = require('gulp-connect-php');
const sass = require('gulp-sass'); //For Compiling SASS files
const postcss = require('gulp-postcss'); //For Compiling tailwind utilities with tailwind config
const concat = require('gulp-concat'); //For Concatinating js,css files
const uglify = require('gulp-terser'); //To Minify JS files
const imagemin = require('gulp-imagemin'); //To Optimize Images
const cleanCSS = require('gulp-clean-css'); //To Minify CSS files
const purgecss = require('gulp-purgecss'); // Remove Unused CSS from Styles
const imageResize = require('gulp-image-resize');
const rename = require('gulp-rename');
const logSymbols = require('log-symbols'); //For Symbolic Console logs :) :P

//Load Previews on Browser on dev
function livePreview(done) {
  browserSync.init({
    server: {
      baseDir: options.paths.root,
    },
    port: options.config.port || 5000,
    open: false,
  });
  done();
}

function icon(done) {
  for (let icon of options.icons) {
    let width = icon[0];
    let height = icon[1];
    src('favicon.png')
      .pipe(
        imageResize({
          width,
          height,
          crop: true,
          upscale: false,
        })
      )
      .pipe(rename(`favicon-${width}x${height}.png`))
      .pipe(dest(options.paths.dist.icons))
      .pipe(dest(options.paths.build.icons));
  }
  done();
}

// Triggers Browser reload
function previewReload(done) {
  console.log('\n\t' + logSymbols.info, 'Reloading Browser Preview.\n');
  // browserSync.reload();
  done();
}

//Development Tasks
function devHTML() {
  return src(`${options.paths.src.base}/**/*.html`)
    .pipe(dest(options.paths.dist.base))
    .pipe(dest(options.paths.build.base));
}

function devStyles() {
  const tailwindcss = require('tailwindcss');
  return src(`${options.paths.src.css}/**/*.scss`)
    .pipe(sass().on('error', sass.logError))
    .pipe(dest(options.paths.src.css))
    .pipe(postcss([tailwindcss(options.config.tailwindjs), require('autoprefixer')]))
    .pipe(concat({ path: 'style.css' }))
    .pipe(dest(options.paths.dist.css))
    .pipe(dest(options.paths.build.css));
}

function devScripts() {
  return src([
    `${options.paths.src.js}/libs/**/*.js`,
    `${options.paths.src.js}/**/*.js`,
    `!${options.paths.src.js}/**/external/*`,
  ])
    .pipe(concat({ path: 'scripts.js' }))
    .pipe(dest(options.paths.dist.js))
    .pipe(dest(options.paths.build.js));
}

function devImages() {
  return src(`${options.paths.src.img}/**/*`)
    .pipe(dest(options.paths.dist.img))
    .pipe(dest(options.paths.build.img));
}

function watchFiles() {
  watch(`${options.paths.src.base}/**/*.html`, series(devHTML, devStyles, previewReload));
  watch(`./**/*.php`, series(devStyles, previewReload));
  watch(
    [options.config.tailwindjs, `${options.paths.src.css}/**/*.scss`],
    series(devStyles, previewReload)
  );
  watch(`${options.paths.src.js}/**/*.js`, series(devScripts, previewReload));
  watch(`${options.paths.src.img}/**/*`, series(devImages, previewReload));
  console.log('\n\t' + logSymbols.info, 'Watching for Changes..\n');
}

function devClean() {
  console.log('\n\t' + logSymbols.info, 'Cleaning dist folder for fresh start.\n');
  return del([options.paths.dist.base]);
}

//Production Tasks (Optimized Build for Live/Production Sites)
function prodHTML() {
  return src(`${options.paths.src.base}/**/*.html`).pipe(dest(options.paths.build.base));
}
function prodDevSVG() {
  return src(`${options.paths.src.base}/svg/**/*.svg`)
    .pipe(dest(`${options.paths.dist.base}/svg/**/*.svg`))
    .pipe(dest(`${options.paths.build.base}/svg/**/*.svg`));
}

function prodStyles() {
  const tailwindcss = require('tailwindcss');
  return src(`${options.paths.src.css}/**/*.scss`)
    .pipe(sass().on('error', sass.logError))
    .pipe(dest(options.paths.src.css))
    .pipe(postcss([tailwindcss(options.config.tailwindjs), require('autoprefixer')]))
    .pipe(concat({ path: 'style.css' }))
    .pipe(cleanCSS({ compatibility: 'ie8' }))
    .pipe(dest(options.paths.build.css));
}

function prodScripts() {
  return src([`${options.paths.src.js}/libs/**/*.js`, `${options.paths.src.js}/**/*.js`])
    .pipe(concat({ path: 'scripts.js' }))
    .pipe(uglify())
    .pipe(dest(options.paths.build.js));
}

function prodImages() {
  return src(options.paths.src.img + '/**/*')
    .pipe(imagemin())
    .pipe(dest(options.paths.build.img));
}

function prodClean() {
  console.log('\n\t' + logSymbols.info, 'Cleaning build folder for fresh start.\n');
  return del([options.paths.build.base]);
}

function buildFinish(done) {
  console.log(
    '\n\t' + logSymbols.info,
    `Production build is complete. Files are located at ${options.paths.build.base}\n`
  );
  done();
}

exports.default = series(
  devClean, // Clean Dist Folder
  parallel(devStyles, devScripts, devImages, icon, devHTML, prodDevSVG), //Run All tasks in parallel
  livePreview, // Live Preview Build
  watchFiles // Watch for Live Changes
);

exports.prod = series(
  prodClean, // Clean Build Folder
  parallel(prodStyles, prodScripts, prodImages, icon, prodHTML, prodDevSVG), //Run All tasks in parallel
  buildFinish
);
