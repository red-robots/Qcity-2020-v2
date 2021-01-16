//This is for GULP 4

// Initialize modules
// Importing specific gulp API functions lets us write them below as series() instead of gulp.series()

// Importing all the Gulp-related packages we want to use
// const sourcemaps = require('gulp-sourcemaps');
// const sass = require('gulp-sass');
// const concat = require('gulp-concat');
// const uglify = require('gulp-uglify');
// const postcss = require('gulp-postcss');
// const autoprefixer = require('autoprefixer');
// const cssnano = require('cssnano');

// CSS related plugins.
var gulp         = require('gulp'); // Gulp of-course
var sass         = require('gulp-sass'); // Gulp pluign for Sass compilation
var minifycss    = require('gulp-uglifycss'); // Minifies CSS files
var autoprefixer = require('gulp-autoprefixer'); // Autoprefixing magic
var postcss      = require('gulp-postcss');

// JS related plugins.
var concat       = require('gulp-concat'); // Concatenates JS files
var uglify       = require('gulp-uglify'); // Minifies JS files

// Image realted plugins.
var imagemin     = require('gulp-imagemin'); // Minify PNG, JPEG, GIF and SVG images with imagemin.

// Utility related plugins.
var rename       = require('gulp-rename'); // Renames files E.g. style.css -> style.min.css
var sourcemaps   = require('gulp-sourcemaps'); // Maps code in a compressed file (E.g. style.css) back to it’s original position in a source file (E.g. structure.scss, which was later combined with other css files to generate style.css)
var notify       = require('gulp-notify'); // Sends message notification to you
var browserSync  = require('browser-sync').create(); // Reloads browser and injects CSS. Time-saving synchronised browser testing.
var reload       = browserSync.reload; // For manual browser reload.
//const AUTOPREFIXER_BROWSERS = require('autoprefixer');
const { src, dest, watch, series, parallel } = gulp;

const AUTOPREFIXER_BROWSERS = [
    'last 2 version',
    '> 1%',
    'ie >= 9',
    'ie_mob >= 10',
    'ff >= 30',
    'chrome >= 34',
    'safari >= 7',
    'opera >= 23',
    'ios >= 7',
    'android >= 4',
    'bb >= 10'
  ];

var replace = require('gulp-replace');


var styleSRC            = './assets/sass/style.scss'; // Path to main .scss file.
var styleDestination    = './'; // Path to place the compiled CSS file.
                                // Defualt set to root folder.

var jsVendorSRC         = './assets/js/vendors/*.js'; // Path to JS vendors folder.
var jsVendorDestination = './assets/js/'; // Path to place the compiled JS vendors file.
var jsVendorFile        = 'vendors'; // Compiled JS vendors file name.
                                    // Default set to vendors i.e. vendors.js.

var jsCustomSRC         = './assets/js/custom/*.js'; // Path to JS custom scripts folder.
var jsCustomDestination = './assets/js/'; // Path to place the compiled JS custom scripts file.
var jsCustomFile        = 'custom'; // Compiled JS custom file name.
                                    // Default set to custom i.e. custom.js.

var imagesSRC           = './assets/img/raw/**/*.{png,jpg,gif,svg}'; // Source folder of images which should be optimized.
var imagesDestination   = './assets/img/'; // Destination folder of optimized images. Must be different from the imagesSRC folder.

// Watch files paths.
var styleWatchFiles     = './assets/sass/**/*.scss'; // Path to all *.scss files inside css folder and inside them.
var vendorJSWatchFiles  = './assets/js/vendors/*.js'; // Path to all vendors JS files.
var customJSWatchFiles  = './assets/js/custom/*.js'; // Path to all custom JS files.

// File paths
const files = { 
    scssPath: styleWatchFiles,
    jsPath: customJSWatchFiles,
    vendorPath: vendorJSWatchFiles
}


// Sass task: compiles the style.scss file into style.css
// function scssTask(){    
//     return src(files.scssPath)
//         .pipe(sourcemaps.init()) // initialize sourcemaps first
//         .pipe(sass()) // compile SCSS to CSS
//         .pipe(postcss([ autoprefixer(), cssnano() ])) // PostCSS plugins
//         .pipe(sourcemaps.write('.')) // write sourcemaps file in current directory
//         .pipe(dest('dist')
//     ); // put final CSS in dist folder
// }

function scssTask(){  
    return src( styleSRC )
        .pipe( sourcemaps.init() )
        .pipe(sass().on('error', sass.logError))
        .pipe( sourcemaps.write( { includeContent: false } ) )
        .pipe( sourcemaps.init( { loadMaps: true } ) )
        .pipe( autoprefixer( AUTOPREFIXER_BROWSERS ) )

        .pipe( sourcemaps.write ( styleDestination ) )
        .pipe( gulp.dest( styleDestination ) )


        .pipe( rename( { suffix: '.min' } ) )
        .pipe( minifycss( {
            maxLineLen: 10
        }))
        .pipe( gulp.dest( styleDestination ) )
        .pipe( browserSync.stream() )
        .pipe( notify( { message: 'TASK: "styles" Completed!', onLast: true } ) );
}

// JS task: concatenates and uglifies JS files to script.js
// function jsTask(){
//     return src([
//         files.jsPath
//         //,'!' + 'includes/js/jquery.min.js', // to exclude any specific files
//         ])
//         .pipe(concat('all.js'))
//         .pipe(uglify())
//         .pipe(dest('dist')
//     );
// }

function jsTask(){
    return src( jsCustomSRC )
        .pipe( concat( jsCustomFile + '.js' ) )
        .pipe( gulp.dest( jsCustomDestination ) )
        .pipe( rename( {
            basename: jsCustomFile,
            suffix: '.min'
        }))
        .pipe( uglify() )
        .pipe( gulp.dest( jsCustomDestination ) )
        .pipe( notify( { message: 'TASK: "customJs" Completed!', onLast: true } ) );
}

function jsVendorTask(){
    return src([
        './assets/js/vendors/flexslider.js',
        './assets/js/vendors/blocks.js',
        './assets/js/vendors/colorbox.js',
        './assets/js/vendors/isotope.js',
        './assets/js/vendors/images-loaded.js',
        './assets/js/vendors/navigation.js',
        './assets/js/vendors/wow.js',
        './assets/js/vendors/jquery.sticky-sidebar.min.js'
        ])
        .pipe( concat( jsVendorFile + '.js' ) )
        .pipe( gulp.dest( jsVendorDestination ) )
        .pipe( rename( {
            basename: jsVendorFile,
            suffix: '.min'
        }))
        .pipe( uglify() )
        .pipe( gulp.dest( jsVendorDestination ) )
        .pipe( notify( { message: 'TASK: "vendorsJs" Completed!', onLast: true } ) );
}

// Cachebust
// function cacheBustTask(){
//     var cbString = new Date().getTime();
//     return src(['index.html'])
//         .pipe(replace(/cb=\d+/g, 'cb=' + cbString))
//         .pipe(dest('.'));
// }

// Watch task: watch SCSS and JS files for changes
// If any change, run scss and js tasks simultaneously
function watchTask(){
    watch([files.scssPath, files.jsPath, files.vendorPath],
        {interval: 1000, usePolling: true}, //Makes docker work
        series(
            parallel(scssTask, jsTask, jsVendorTask),
        )
    );    
}

// Export the default Gulp task so it can be run
// Runs the scss and js tasks simultaneously
// then runs cacheBust, then watch task
exports.default = series(
    parallel(scssTask, jsTask, jsVendorTask), 
    watchTask
);