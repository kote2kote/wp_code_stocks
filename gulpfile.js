/**
 *   Gulp with TailwindCSS - An CSS Utility framework
 *   Author : Manjunath G
 *   URL : manjumjn.com | lazymozek.com
 *   Twitter : twitter.com/manju_mjn
 **/

/*
  Usage:
  1. npm install //To install all dev dependencies of package
  2. npm run dev //To start development and server for live preview
  3. npm run prod //To generate minifed files for live server
*/

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

//Note : Webp still not supported in major browsers including forefox
//const webp = require('gulp-webp'); //For converting images to WebP format
//const replace = require('gulp-replace'); //For Replacing img formats to webp in html
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

// function livePreview(done) {
//   phpServer.server(
//     {
//       base: options.paths.root,
//       port: options.config.port || 5000,
//       open: false,
//       bin: '/Applications/MAMP/bin/php/php7.2.8/bin/php',
//       ini: '/Applications/MAMP/bin/php/php7.2.8/conf/php.ini',
//     }

//     // function () {
//     //   browserSync.init({
//     //     // server: {
//     //     //   baseDir: options.paths.root,
//     //     // },
//     //     // port: options.config.port || 5000,
//     //     baseDir: 'http://localhost:10028/',
//     //     proxy: '127.0.0.1:5010',
//     //   });
//     // }
//   );
//   browserSync.reload();
//   done();
// }

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

// function prodStyles() {
//   const tailwindcss = require('tailwindcss');
//   return src(`${options.paths.src.css}/**/*.scss`)
//     .pipe(sass().on('error', sass.logError))
//     .pipe(postcss([tailwindcss(options.config.tailwindjs), require('autoprefixer')]))
//     .pipe(
//       // purgecss({
//       //   content: ['./**/*.{html,php}'],
//       //   defaultExtractor: (content) => {
//       //     const broadMatches = content.match(/[^<>"'`\s]*[^<>"'`\s:]/g) || [];
//       //     const innerMatches = content.match(/[^<>"'`\s.()]*[^<>"'`\s.():]/g) || [];
//       //     return broadMatches.concat(innerMatches);
//       //   },
//       // })
//       purgecss({
//         content: ['./**/*.php'],
//         defaultExtractor: (content) => content.match(/[\w-/:]+(?<!:)/g) || [],
//       })
//     )
//     .pipe(cleanCSS({ compatibility: 'ie8' }))
//     .pipe(dest(options.paths.build.css));
// }

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
