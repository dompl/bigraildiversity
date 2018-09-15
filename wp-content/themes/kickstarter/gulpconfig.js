// ==== CONFIGURATION ==== //
// Project paths
var theme = 'bigraildiversity', // The directory name for your theme; change this at the very least!
    server = 'bigraildiversity.loc', // We need to use a proxy instead of the built-in server because WordPress has to do some server-side rendering for the theme to work
    src = 'src/', // The raw material of your theme: custom scripts, SCSS source files, PHP files, images, etc.; do not delete this folder!
    build = 'build/', // A temporary directory containing a development version of your theme; delete it anytime
    dist = '../' + theme + '/', // The distribution package that you'll be uploading to your server; delete it anytime
    assets = 'assets/', // A staging area for assets that require processing before landing in the source folder (example: icons before being added to a sprite sheet)
    bower = 'bower_components/', // Bower packages
    modules = 'node_modules/', // npm packages
    composer = 'vendor/', // Composer packages
    icons = 'icons/', // Fonts folder
    useModernizr = false; // Use or not modernzr in your projectr
// Project settings
module.exports = {
    browsersync: {
        files: [build + '/**', '!' + build + '/**.map'], // Exclude map files
        notify: false, // In-line notifications (the blocks of text saying whether you are connected to the BrowserSync server or not)
        open: false, // Set to false if you don't like the browser window opening automatically
        port: 3000, // Port number for the live version of the site; default: 3000
        proxy: server,
        host: server,
        ghost: true,
        // ghchangeOrigin: true,
        // reloadDebounce: 200
    },
    icons: {
        icon: {
            name: theme,
            template: src + 'scss/templates/_icons.scss',
            formats: ['ttf', 'eot', 'woff', 'woff2', 'svg'],
            normalize: true,
            height: 1001,
            unicode: true,
        },
        build: {
            iconsCss: icons,
            src: build + icons,
            scssDest: '../../' + src + 'scss/_icons.scss',
        },
        svg: {
            src: src + 'img/icons/**/*.svg',
        },
    },
    images: {
        build: { // Copies images from `src` to `build`; does not optimize
            src: [src + '**/*(*.png|*.jpg|*.jpeg|*.gif|*.svg|*.ico)', '!' + src + 'img/icons/**/*.svg'],
            dest: build
        },
        dist: {
            src: [dist + '**/*(*.png|*.jpg|*.jpeg|*.gif)', '!' + dist + 'screenshot.png'], // The source is actually `dist` since we are minifying images in place
            imagemin: {
                optimizationLevel: 7,
                progressive: true,
                interlaced: true
            },
            dest: dist
        },
    },
    livereload: {
        port: 35729 // This is a standard port number that should be recognized by your LiveReload helper; there's probably no need to change it
    },
    scripts: {
        bundles: { // Bundles are defined by a name and an array of chunks (below) to concatenate; warning: this method offers no dependency management!
            jquery: ['jquery'],
            footer: ['footer'],
        },
        chunks: {
            jquery: [
                modules + 'jquery/dist/jquery.js', // https://www.npmjs.com/package/jquery @1.12.4
                modules + 'jquery-migrate/dist/jquery-migrate.js', // https://www.npmjs.com/package/jquery-migrate @1.4.1
            ],
            footer: [
                modules + 'jquery-pjax/jquery.pjax.js',
                modules + 'blazy/blazy.js', // https://github.com/dinbror/blazy
                // modules + 'slick-carousel/slick/slick.js', // https://github.com/kenwheeler/slick/
                // modules + 'wowjs/dist/wow.js', // https://github.com/matthieua/WOW
                // modules + 'modaal/dist/js/modaal.js', // https://github.com/humaan/Modaal
                modules + 'jquery-match-height/dist/jquery.matchHeight.js', // https://github.com/liabru/jquery-match-height
                // src + 'js/lib/cookie-bar.js',
                src + 'js/lib/navigation.js',
                src + 'js/footer.js',
            ],
        },
        dest: build + 'js/', // Where the scripts end up in your theme
        lint: {
            src: [src + 'js/**/*.js', '!' + src + 'js/lib/*.js']
        },
        modernizr: {
            use: useModernizr,
            src: [src + 'js/**/*.js', '!' + src + 'js/lib/modernizr.js'],
            wait: 300, // Set time to wait for next script to avoid looping for modernizr
            options: { // https://github.com/Modernizr/customizr#config-file
                dest: src + 'js/lib/modernizr.js',
                uglify: true,
                useBuffers: false,
                options: ['setClasses', 'addTest', 'html5printshiv', 'testProp', 'fnBind'],
                excludeTests: ['inputsearchevent', 'target'],
                tests: ['svg'],
            },
            dest: src + 'js/lib/'
        },
        minify: {
            src: build + 'js/**/*.js',
            uglify: {}, // Default options
            dest: build + 'js/'
        },
        namespace: 'x-'
    },
    styles: {
        build: {
            src: src + 'scss/**/*.scss',
            dest: build
        },
        compiler: 'libsass', // Choose a Sass compiler: 'libsass' or 'rubysass'
        cssnano: {
            autoprefixer: {
                add: true,
                browsers: ['> 3%', 'last 2 versions', 'ie 9', 'ios 6', 'android 4'] // This tool is magic and you should use it in all your projects :)
            }
        },
        rubySass: { // Requires the Ruby implementation of Sass; run `gem install sass` if you use this; Compass is *not* included by default
            loadPath: [ // Adds Bower and npm directories to the load path so you can @import directly
                './src/scss', './src/scss/icons/*.scss',
                modules + 'normalize.css',
                modules + 'scut/dist',
                modules + 'slick-carousel/slick',
                modules + 'animate-sass', //https://github.com/tgdev/animate-sass
                modules + 'susy/sass', // Import Susy
                modules + 'animate-sass', //https://github.com/tgdev/animate-sass
                modules + 'breakpoint-sass/stylesheets', // Import Breakpoint
                modules + 'breakpoint-slicer/stylesheets', // Import Breakpoint Slicer
                modules + 'unslider/src/scss', // Unslider // https://github.com/idiot/unslider/tree/master/src/scss
                modules + 'accoutrement-color/sass', // https://github.com/oddbird/accoutrement-color
                modules,
                bower
            ],
            precision: 6,
            sourcemap: true
        },
        libsass: { // Requires the libsass implementation of Sass (included in this package)
            includePaths: [ // Adds Bower and npm directories to the load path so you can @import directly
                './src/scss', './src/scss/icons/*.scss',
                modules + 'normalize.css',
                modules + 'scut/dist',
                modules + 'slick-carousel/slick',
                modules + 'animate-sass', //https://github.com/tgdev/animate-sass
                modules + 'susy/sass', // Import Susy
                modules + 'breakpoint-sass/stylesheets', // Import Breakpoint
                modules + 'breakpoint-slicer/stylesheets', // Import Breakpoint Slicer
                modules + 'unslider/src/scss', // Unslider // https://github.com/idiot/unslider/tree/master/src/scss
                modules + 'accoutrement-color/sass', // https://github.com/oddbird/accoutrement-color
                modules,
                bower,
            ],
            precision: 6,
            onError: function(err) {
                return console.log(err);
            }
        }
    },
    fonts: {
        files: {
            src: [src + 'fonts/**/*', '!' + src + 'fonts/google/**/*'], // Copy all font files apart from the google fonts. Skip google fonts folder
            dest: build + 'fonts/'
        }
    },
    theme: {
        lang: {
            src: src + 'languages/**/*', // Glob pattern matching any language files you'd like to copy over; we've broken this out in case you want to automate language-related functions
            dest: build + 'languages/'
        },
        php: {
            src: [src + '**/*.php'], // This simply copies PHP and Json files over; both this and the previous task could be combined if you like
            dest: build
        },
        json: {
            src: src + 'json/**/*.json',
            dest: build + 'json/'
        }
    },
    utils: {
        clean: [build + '**/.DS_Store'], // A glob pattern matching junk files to clean out of `build`; feel free to add to this array
        wipe: [dist], // Clean this out before creating a new distribution copy
        dist: {
            src: [build + '**/*', '!' + build + '**/*.map'],
            dest: dist,
        },
        json: [build + 'json/**/*.json'] // Wipe json Files
    },
    gfonts: { // A gulp plugin to download Google webfonts and generate a stylesheet for them. USAGE : Grab your google font code from google fonts (ie Lato:300,400,700i&;subset=latin-ex) and past it in src/fonts/fonts.list One per line. Once done uncmment google font in your main stylesheeet.
        font: {
            dir: 'fonts/google/', // Google font directory
            cssDir: '../' + src + 'scss/', // Google font scss file directory ( main per default )
            cssFile: '_google-fonts.scss' // Google font scss file name
        },
        build: {
            src: src + 'fonts/google/fonts.list', // List file with your fonts. Recommended not to change it.
            clean: build + '/fonts/google/*.*',
            dest: build
        }
    },
    watch: { // What to watch before triggering each specified task; if files matching the patterns below change it will trigger BrowserSync or Livereload
        src: {
            styles: src + 'scss/**/*.scss',
            icons: src + 'img/icons/**/*.svg',
            gfonts: src + 'fonts/google/*.list',
            scripts: src + 'js/**/*.js', // You might also want to watch certain dependency trees but that's up to you
            images: src + '**/*(*.png|*.jpg|*.jpeg|*.gif|*.svg|*.ico)',
            theme: src + '**/*.php',
            json: src + 'json/**/*.json',
            livereload: build + '**/*'
        },
        watcher: 'browsersync' // Modify this value to easily switch between BrowserSync ('browsersync') and Livereload ('livereload')
    }
}
