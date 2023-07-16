/******/ (function(modules) { // webpackBootstrap
/******/ 	// install a JSONP callback for chunk loading
/******/ 	function webpackJsonpCallback(data) {
/******/ 		var chunkIds = data[0];
/******/ 		var moreModules = data[1];
/******/ 		var executeModules = data[2];
/******/
/******/ 		// add "moreModules" to the modules object,
/******/ 		// then flag all "chunkIds" as loaded and fire callback
/******/ 		var moduleId, chunkId, i = 0, resolves = [];
/******/ 		for(;i < chunkIds.length; i++) {
/******/ 			chunkId = chunkIds[i];
/******/ 			if(installedChunks[chunkId]) {
/******/ 				resolves.push(installedChunks[chunkId][0]);
/******/ 			}
/******/ 			installedChunks[chunkId] = 0;
/******/ 		}
/******/ 		for(moduleId in moreModules) {
/******/ 			if(Object.prototype.hasOwnProperty.call(moreModules, moduleId)) {
/******/ 				modules[moduleId] = moreModules[moduleId];
/******/ 			}
/******/ 		}
/******/ 		if(parentJsonpFunction) parentJsonpFunction(data);
/******/
/******/ 		while(resolves.length) {
/******/ 			resolves.shift()();
/******/ 		}
/******/
/******/ 		// add entry modules from loaded chunk to deferred list
/******/ 		deferredModules.push.apply(deferredModules, executeModules || []);
/******/
/******/ 		// run deferred modules when all chunks ready
/******/ 		return checkDeferredModules();
/******/ 	};
/******/ 	function checkDeferredModules() {
/******/ 		var result;
/******/ 		for(var i = 0; i < deferredModules.length; i++) {
/******/ 			var deferredModule = deferredModules[i];
/******/ 			var fulfilled = true;
/******/ 			for(var j = 1; j < deferredModule.length; j++) {
/******/ 				var depId = deferredModule[j];
/******/ 				if(installedChunks[depId] !== 0) fulfilled = false;
/******/ 			}
/******/ 			if(fulfilled) {
/******/ 				deferredModules.splice(i--, 1);
/******/ 				result = __webpack_require__(__webpack_require__.s = deferredModule[0]);
/******/ 			}
/******/ 		}
/******/ 		return result;
/******/ 	}
/******/
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// object to store loaded and loading chunks
/******/ 	// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 	// Promise = chunk loading, 0 = chunk loaded
/******/ 	var installedChunks = {
/******/ 		"main": 0
/******/ 	};
/******/
/******/ 	var deferredModules = [];
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	var jsonpArray = window["webpackJsonp"] = window["webpackJsonp"] || [];
/******/ 	var oldJsonpFunction = jsonpArray.push.bind(jsonpArray);
/******/ 	jsonpArray.push = webpackJsonpCallback;
/******/ 	jsonpArray = jsonpArray.slice();
/******/ 	for(var i = 0; i < jsonpArray.length; i++) webpackJsonpCallback(jsonpArray[i]);
/******/ 	var parentJsonpFunction = oldJsonpFunction;
/******/
/******/
/******/ 	// add entry module to deferred list
/******/ 	deferredModules.push(["./src/js/main.js","vendor"]);
/******/ 	// run deferred modules when ready
/******/ 	return checkDeferredModules();
/******/ })
/************************************************************************/
/******/ ({

/***/ "./src/js/main.js":
/*!************************!*\
  !*** ./src/js/main.js ***!
  \************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _vendor__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./vendor */ "./src/js/vendor.js");
/* harmony import */ var handlebars__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! handlebars */ "./node_modules/handlebars/dist/cjs/handlebars.js");
/* harmony import */ var handlebars__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(handlebars__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _node_modules_swiper_js_swiper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../node_modules/swiper/js/swiper.js */ "./node_modules/swiper/js/swiper.js");
/* harmony import */ var _node_modules_swiper_js_swiper_js__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_node_modules_swiper_js_swiper_js__WEBPACK_IMPORTED_MODULE_2__);



var text = [];
var music = [];
var video = [];
var photo = [];
var $document = $(document);
var $body = $('body');
var $container = $('.container');
var app = {
  path: {
    text: './ajax/text.json.php',
    textContent: './ajax/text-content.json.php',
    music: './ajax/music.json.php',
    video: './ajax/video.json.php',
    photo: './ajax/photo.json.php'
  },
  text: [],
  textContent: [],
  music: [],
  video: [],
  photo: [],
  $player: $('.player'),
  $video: $('.player__frame__video'),
  videoPlay: false,
  $music: $('.player__frame__audio'),
  musicPlay: false,
  $playerName: $('.player__title__bg'),
  $playerLink: $('.player__frame__link'),
  $playerPrev: $('.player__frame__prev'),
  $playerNext: $('.player__frame__next'),
  textScrollSpeed: 8,
  showVideo: function showVideo() {
    app.$music[0].pause();
    app.$music.hide();
    app.$music.data('index', 0);
    app.$video.show();
    app.$playerLink.show();

    if (app.video.list.length > 1) {
      app.$playerPrev.show();
      app.$playerNext.show();
    } else {
      app.$playerPrev.hide();
      app.$playerNext.hide();
    }

    app.$player.data('type', 'video');
    app.musicPlay = false;
    app.videoPlay = true;
  },
  showMusic: function showMusic() {
    app.$video[0].pause();
    app.$video.hide();
    app.$video.data('index', 0);
    app.$music.show();
    app.$playerLink.hide();

    if (app.music.list.length > 1) {
      app.$playerPrev.show();
      app.$playerNext.show();
    } else {
      app.$playerPrev.hide();
      app.$playerNext.hide();
    }

    app.$player.data('type', 'music');
    app.videoPlay = false;
    app.musicPlay = true;
  },
  init: function init() {
    // document.addEventListener('contextmenu', (e) => {
    // 	e.preventDefault();
    // }, false);
    // document.onkeydown = (e) => {
    // 	if (e.ctrlKey &&
    // 		(e.keyCode === 67 ||
    // 			e.keyCode === 86 ||
    // 			e.keyCode === 85 ||
    // 			e.keyCode === 83 ||
    // 			e.keyCode === 117)) {
    // 		return false;
    // 	}
    // };
    // if (location.hostname !== atob('bG9sYS50bXdlYi5ydQ==')) {
    // 	$body.html(atob('ZmFpbGVkIQ=='));
    // 	return false;
    // }
    app.initFirst();
    app.handlers();
  },
  initFirst: function initFirst() {
    var $activeBtn = $('.item button.is-active');
    var options = $activeBtn.data();

    if (!$activeBtn.length) {
      return false;
    }

    switch (options.type) {
      case 'text':
        app.openText(options.id);
        break;

      case 'music':
        app.openMusic(options.id, false);
        break;

      case 'video':
        app.openVideo(options.id, false);
        break;

      case 'photo':
        app.openPhoto(options.id);
        break;
    }

    $activeBtn.addClass('is-active');
    $activeBtn.closest('.item').addClass('is-active');
  },
  handlers: function handlers() {
    var clicked = false;

    var findActive = function findActive(type) {
      $('.item').removeClass('is-active');

      // switch (type) {
      //   case 'text':
      //     $('button[data-type="text"], button[data-type="photo"]').removeClass('is-active');
      //     $('button.is-active[data-type="video"], button.is-active[data-type="music"]').closest('.item').addClass('is-active');
      //     break;
      //
      //   case 'music':
      //     $('button[data-type="video"], button[data-type="music"]').removeClass('is-active');
      //     $('button.is-active[data-type="text"], button.is-active[data-type="photo"]').closest('.item').addClass('is-active');
      //     break;
      //
      //   case 'video':
      //     $('button[data-type="video"], button[data-type="music"]').removeClass('is-active');
      //     $('button.is-active[data-type="text"], button.is-active[data-type="photo"]').closest('.item').addClass('is-active');
      //     break;
      //
      //   case 'photo':
      //     $('button[data-type="text"], button[data-type="photo"]').removeClass('is-active');
      //     $('button.is-active[data-type="video"], button.is-active[data-type="music"]').closest('.item').addClass('is-active');
      //     break;
      // }

      switch (type) {
        case 'text':
          $('button[data-type="text"], button[data-type="photo"], button[data-type="video"], button[data-type="music"]').removeClass('is-active');
          $('button.is-active[data-type="video"], button.is-active[data-type="music"]').closest('.item').addClass('is-active');
          break;

        case 'music':
          $('button[data-type="text"], button[data-type="photo"], button[data-type="video"], button[data-type="music"]').removeClass('is-active');
          $('button.is-active[data-type="text"], button.is-active[data-type="photo"]').closest('.item').addClass('is-active');
          break;

        case 'video':
          $('button[data-type="text"], button[data-type="photo"], button[data-type="video"], button[data-type="music"]').removeClass('is-active');
          $('button.is-active[data-type="text"], button.is-active[data-type="photo"]').closest('.item').addClass('is-active');
          break;

        case 'photo':
          $('button[data-type="text"], button[data-type="photo"], button[data-type="video"], button[data-type="music"]').removeClass('is-active');
          $('button.is-active[data-type="video"], button.is-active[data-type="music"]').closest('.item').addClass('is-active');
          break;
      }
    };

    $('.item ul button').on('click', function (e) {
      var $this = $(e.currentTarget);
      var options = $this.data();
      e.preventDefault();

      switch (options.type) {
        case 'text':
          app.openText(options.id);
          break;

        case 'music':
          app.openMusic(options.id);
          break;

        case 'video':
          app.openVideo(options.id);
          break;

        case 'photo':
          app.openPhoto(options.id);
          break;
      }

      findActive(options.type);
      $this.addClass('is-active');
      $this.closest('.item').addClass('is-active');
    });
    $document.on('click', function () {
      if (!clicked) {
        app.$video[0].muted = false;
        clicked = true;
      }
    });
    
    $(document).on('mouseenter', '.scroll-text', function(e) {
      var $this = $(e.currentTarget);
      var $span = $this.find('>span');
      var diff = $span.outerWidth();

      var speed = diff * app.textScrollSpeed;

      if (speed < 1000) {
        speed = 1000;
      }

      var repeatToLeft = function() {
        speed = ( $this.outerWidth() + diff) * app.textScrollSpeed;

        $span.css({
          left: $this.outerWidth(),
        });
        animateToLeft();
      }

      var animateToLeft = function() {
        $span.animate({
          left: 0 - diff,
        }, speed, 'linear', repeatToLeft);
      };

      var animateToRight = function() {
        $span.animate({
          left: 0,
        }, speed, animateToLeft);
      };

      if (diff > $this.outerWidth()) {
        animateToLeft();
      }
    });
    
    $(document).on('mouseleave', '.scroll-text', function(e) {
      var $this = $(e.currentTarget);
      var $span = $this.find('>span');
      var diff = $this.offset().left - $span.offset().left;

      $span.stop();
      $span.animate({
        left: 0,
      }, Math.abs(diff * (app.textScrollSpeed / 2)));
    });
    app.$video[0].addEventListener('ended', function () {
      var nextIndex = app.$video.data('index') + 1;

      if (!app.video.list[nextIndex]) {
        nextIndex = 0;
      }

      app.$video.attr('src', app.video.list[nextIndex].src).data('index', nextIndex);
      app.$video[0].play();
      app.$playerName.html("\u0412\u0438\u0434\u0435\u043E <div class=\"scroll-text\"><span>".concat(app.video.title, "</span></div><div class=\"scroll-text\"><span>").concat(app.video.list[nextIndex].name).concat("</span></div>"));

      if ($('.window__video__item').length) {
        $('.window__video__item').removeClass('is-active');
        $(".window__video__item[data-id=".concat(nextIndex, "]")).addClass('is-active');
      }
    });
    app.$music[0].addEventListener('ended', function () {
      var nextIndex = app.$music.data('index') + 1;

      if (!app.music.list[nextIndex]) {
        nextIndex = 0;
      }

      app.$music.attr('src', app.music.list[nextIndex].src).data('index', nextIndex);
      app.$music[0].play();
      app.$playerName.html("\u041C\u0443\u0437\u044B\u043A\u0430 <div class=\"scroll-text\"><span>".concat(app.music.title, "</span></div><div class=\"scroll-text\"><span>").concat(app.music.list[nextIndex].name).concat("</span></div>"));

      if ($('.window__music__item').length) {
        $('.window__music__item').removeClass('is-active');
        $(".window__music__item[data-id=".concat(nextIndex, "]")).addClass('is-active');
      }
    });
    app.$playerNext.on('click', function (e) {
      var nextIndex;
      e.preventDefault();

      switch (app.$player.data('type')) {
        case 'video':
          nextIndex = app.$video.data('index') + 1;

          if (!app.video.list[nextIndex]) {
            nextIndex = 0;
          }

          app.$video.attr('src', app.video.list[nextIndex].src).data('index', nextIndex);
          app.$video[0].play();
          app.$playerName.html("\u0412\u0438\u0434\u0435\u043E <div class=\"scroll-text\"><span>".concat(app.video.title, "</span></div><div class=\"scroll-text\"><span>").concat(app.video.list[nextIndex].name).concat("</span></div>"));

          if ($('.window__video__item').length) {
            $('.window__video__item').removeClass('is-active');
            $(".window__video__item[data-id=".concat(nextIndex, "]")).addClass('is-active');
          }

          break;

        case 'music':
          nextIndex = app.$music.data('index') + 1;

          if (!app.music.list[nextIndex]) {
            nextIndex = 0;
          }

          app.$music.attr('src', app.music.list[nextIndex].src).data('index', nextIndex);
          app.$music[0].play();
          app.$playerName.html("\u041C\u0443\u0437\u044B\u043A\u0430 <div class=\"scroll-text\"><span>".concat(app.music.title, "</span></div><div class=\"scroll-text\"><span>").concat(app.music.list[nextIndex].name).concat("</span></div>"));

          if ($('.window__music__item').length) {
            $('.window__music__item').removeClass('is-active');
            $(".window__music__item[data-id=".concat(nextIndex, "]")).addClass('is-active');
          }

          break;
      }
    });
    app.$playerPrev.on('click', function (e) {
      var nextIndex;
      e.preventDefault();

      switch (app.$player.data('type')) {
        case 'video':
          nextIndex = app.$video.data('index') - 1;

          if (!app.video.list[nextIndex]) {
            nextIndex = app.video.list.length - 1;
          }

          app.$video.attr('src', app.video.list[nextIndex].src).data('index', nextIndex);
          app.$video[0].play();
          app.$playerName.html("\u0412\u0438\u0434\u0435\u043E <div class=\"scroll-text\"><span>".concat(app.video.title, "</span></div><div class=\"scroll-text\"><span>").concat(app.video.list[nextIndex].name).concat("</span></div>"));

          if ($('.window__video__item').length) {
            $('.window__video__item').removeClass('is-active');
            $(".window__video__item[data-id=".concat(nextIndex, "]")).addClass('is-active');
          }

          break;

        case 'music':
          nextIndex = app.$music.data('index') - 1;

          if (!app.music.list[nextIndex]) {
            nextIndex = app.music.list.length - 1;
          }

          app.$music.attr('src', app.music.list[nextIndex].src).data('index', nextIndex);
          app.$music[0].play();
          app.$playerName.html("\u041C\u0443\u0437\u044B\u043A\u0430 <div class=\"scroll-text\"><span>".concat(app.music.title, "</span></div><div class=\"scroll-text\"><span>").concat(app.music.list[nextIndex].name).concat("</span></div>"));

          if ($('.window__music__item').length) {
            $('.window__music__item').removeClass('is-active');
            $(".window__music__item[data-id=".concat(nextIndex, "]")).addClass('is-active');
          }

          break;
      }
    });
    app.$playerLink.on('click', function (e) {
      var $this = $(e.currentTarget);
      e.preventDefault();
      $this.toggleClass('is-active');

      if ($this.hasClass('is-active')) {
        app.$player.addClass('is-show-big');
      } else {
        app.$player.removeClass('is-show-big');
      }
    });
  },
  openText: function openText(id) {
    var showWindow = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : true;

    var openWindow = function openWindow() {
      if (showWindow) {
        app.window.create('text', app.text);
      }
    };

    if (app.text.id === id) {
      if (!$('.window').length) {
        openWindow();
      } else if ($('.window').data('type') !== 'text') {
        app.window.destroy();
        openWindow();
      }
    } else {
      if ($('.window').length) {
        app.window.destroy();
      }

      app.loadData('text', id).done(function (response) {
        app.text = response;
        openWindow();
      });
    }
  },
  openMusic: function openMusic(id) {
    var showWindow = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : true;

    var openWindow = function openWindow() {
      if (showWindow) {
        app.window.create('music', app.music);
      }
    };

    var setMusic = function setMusic() {
      app.showMusic();
      app.$music.attr('src', app.music.list[0].src).data('index', 0);
      app.$music[0].play();
      app.$playerName.html("\u041C\u0443\u0437\u044B\u043A\u0430 <div class=\"scroll-text\"><span>".concat(app.music.title, "</span></div><div class=\"scroll-text\"><span>").concat(app.music.list[0].name).concat("</span></div>"));
    };

    if (app.music.id === id) {
      if (!$('.window').length) {
        if (!app.musicPlay) {
          setMusic();
        }

        openWindow();
      } else if ($('.window').data('type') !== 'music') {
        app.window.destroy();
        openWindow();

        if (!app.musicPlay) {
          setMusic();
        }
      }
    } else {
      if ($('.window').length) {
        app.window.destroy();
      }

      app.loadData('music', id).done(function (response) {
        app.music = response;
        setMusic();
        openWindow();
      });
    }
  },
  openVideo: function openVideo(id) {
    var showWindow = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : true;

    var openWindow = function openWindow() {
      if (showWindow) {
        app.window.create('video', app.video);
      }
    };

    var setVideo = function setVideo() {
      app.$video.attr('src', app.video.list[0].src).data('index', 0);
      app.$video[0].play();
      app.$playerName.html("\u0412\u0438\u0434\u0435\u043E <div class=\"scroll-text\"><span>".concat(app.video.title, "</span></div><div class=\"scroll-text\"><span>").concat(app.video.list[0].name).concat("</span></div>"));
      app.showVideo();
    };

    if (app.video.id === id) {
      if (!$('.window').length) {
        if (!app.videoPlay) {
          setVideo();
        }

        openWindow();
      } else if ($('.window').data('type') !== 'video') {
        app.window.destroy();
        openWindow();

        if (!app.videoPlay) {
          setVideo();
        }
      }
    } else {
      if ($('.window').length) {
        app.window.destroy();
      }

      app.loadData('video', id).done(function (response) {
        app.video = response;
        setVideo();
        openWindow();
      });
    }
  },
  openPhoto: function openPhoto(id) {
    var showWindow = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : true;

    var openWindow = function openWindow() {
      if (showWindow) {
        app.window.create('photo', app.photo);
      }
    };

    if (app.photo.id === id) {
      if (!$('.window').length) {
        openWindow();
      } else if ($('.window').data('type') !== 'photo') {
        app.window.destroy();
        openWindow();
      }
    } else {
      if ($('.window').length) {
        app.window.destroy();
      }

      app.loadData('photo', id).done(function (response) {
        app.photo = response;
        openWindow();
      });
    }
  },
  loadData: function loadData(type, id) {
    return $.ajax({
      type: 'get',
      url: app.path[type],
      data: {
        id: id
      },
      dataType: 'json'
    });
  },
  window: {
    create: function create(type, data) {
      var source = $("#".concat(type, "-template")).html();
      var template = handlebars__WEBPACK_IMPORTED_MODULE_1___default.a.compile(source);
      $container.append(template(data));

      switch (type) {
        case 'text':
          app.window.text();
          break;

        case 'textContent':
          app.window.textContent();
          break;

        case 'music':
          app.window.music();
          break;

        case 'video':
          app.window.video();
          break;

        case 'photo':
          app.window.photo();
          break;
      }

      $('.window__close').on('click', function (e) {
        app.window.destroy();
      });
    },
    destroy: function destroy() {
      $('.window').remove();
    },
    text: function text() {
      var $window = $('.window');
      var $swiperContainer = $window.find('.swiper-container');

      var calcCount = function calcCount() {
        return parseInt($swiperContainer.outerHeight() / $('.window__text__item').outerHeight(), 10);
      };

      var slider;
      var $preview = $('.js-text-preview');
      var $previewTitle = $('.js-text-preview-title');
      var $previewText = $('.js-text-preview-text');

      var initPreview = function initPreview() {
        $preview.data('id', app.text.current);
        $previewTitle.text(app.text.list[app.text.current].name);
        $previewText.html(app.text.list[app.text.current].preview);
        $('.window__text__item').removeClass('is-active');
        $(".window__text__item[data-index=".concat(app.text.current, "]")).addClass('is-active');
      };

      if (app.text.current === undefined) {
        app.text.current = 0;
      }

      $window.data('type', 'text');
      setTimeout(function () {
        slider = new _node_modules_swiper_js_swiper_js__WEBPACK_IMPORTED_MODULE_2___default.a($swiperContainer, {
          direction: 'vertical',
          slidesPerView: calcCount(),
          simulateTouch: false,
          initialSlide: app.text.current,
        });
      }, 100);
      initPreview();
      $('.window__text__item').on('click', function (e) {
        var $this = $(e.currentTarget);
        e.preventDefault();
        if ($this.hasClass('is-active')) {
          app.loadData('textContent', $(".window__text__item[data-index=".concat(app.text.current, "]")).data('id')).done(function (response) {
            app.window.destroy();
            app.textContent = response;
            app.window.create('textContent', app.textContent);
          });
        } else {
          app.text.current = $this.data('index');
          initPreview();
        }
      });
      $('.window__zoom').on('click', function (e) {
        var $this = $(e.currentTarget);
        e.preventDefault();
        $this.toggleClass('is-active');

        if ($this.hasClass('is-active')) {
          $window.addClass('is-show-big');
          slider.params.slidesPerView = calcCount();
        } else {
          $window.removeClass('is-show-big');
          slider.params.slidesPerView = calcCount();
        }

        slider.update();
      });
      $('.window__expand').on('click', function (e) {
        var $this = $(e.currentTarget);
        e.preventDefault();
        $this.toggleClass('is-active');

        if ($this.hasClass('is-active')) {
          $window.addClass('is-show-expand');
        } else {
          $window.removeClass('is-show-expand');
        }

        slider.update();
      });
      $('.window__controls__start').on('click', function (e) {
        e.preventDefault();
        slider.slideTo(slider.activeIndex - calcCount());
      });
      $('.window__controls__prev').on('click', function (e) {
        e.preventDefault();
        slider.slideTo(slider.activeIndex - 1);
      });
      $('.window__controls__next').on('click', function (e) {
        e.preventDefault();
        slider.slideTo(slider.activeIndex + 1);
      });
      $('.window__controls__end').on('click', function (e) {
        e.preventDefault();
        slider.slideTo(slider.activeIndex + calcCount());
      });
      $('.window__close').on('click', function (e) {
        var $activeBtn = $('button.is-active[data-type="text"]');
        var $activeBtnItem = $activeBtn.closest('.item');
        app.text.current = undefined;
        e.preventDefault();
        $activeBtn.removeClass('is-active');

        if (!$activeBtnItem.find('button.is-active').length) {
          $activeBtnItem.removeClass('is-active');
        }
      });
      $previewText.on('click', function (e) {
        e.preventDefault();
        app.loadData('textContent', $(".window__text__item[data-index=".concat(app.text.current, "]")).data('id')).done(function (response) {
          app.window.destroy();
          app.textContent = response;
          app.window.create('textContent', app.textContent);
        });
      });
    },
    textContent: function textContent() {
      var $window = $('.window');
      var $container = $('.window__text-content__container');
      var $text = $('.window__text-content__text');
      $window.data('type', 'text-content');
      $('.window__expand').on('click', function (e) {
        var $this = $(e.currentTarget);
        e.preventDefault();
        $this.toggleClass('is-active');

        if ($this.hasClass('is-active')) {
          $window.addClass('is-show-expand');
        } else {
          $window.removeClass('is-show-expand');
        }

        var scroll = $text.offset().top - $container.offset().top;
        var maxScroll = $container.outerHeight() - $text.outerHeight();

        if (maxScroll > 0) {
          maxScroll = 0;
        }

        if (scroll < maxScroll) {
          scroll = maxScroll;
        }

        $text.css({
          transform: "translateY(".concat(scroll, "px)")
        });
      });
      $('.window__controls__start').on('click', function (e) {
        var scroll = $text.offset().top - $container.offset().top + ($container.outerHeight() - 100);
        e.preventDefault();

        if (scroll > 0) {
          scroll = 0;
        }

        $text.css({
          transform: "translateY(".concat(scroll, "px)")
        });
      });
      $('.window__controls__prev').on('click', function (e) {
        var scroll = $text.offset().top - $container.offset().top + 100;
        e.preventDefault();

        if (scroll > 0) {
          scroll = 0;
        }

        $text.css({
          transform: "translateY(".concat(scroll, "px)")
        });
      });
      $('.window__controls__next').on('click', function (e) {
        var scroll = $text.offset().top - $container.offset().top - 100;
        var maxScroll = $container.outerHeight() - $text.outerHeight();
        e.preventDefault();

        if (maxScroll > 0) {
          maxScroll = 0;
        }

        if (scroll < maxScroll) {
          scroll = maxScroll;
        }

        $text.css({
          transform: "translateY(".concat(scroll, "px)")
        });
      });
      $('.window__controls__end').on('click', function (e) {
        var scroll = $text.offset().top - $container.offset().top - ($container.outerHeight() - 15);
        var maxScroll = $container.outerHeight() - $text.outerHeight();
        e.preventDefault();

        if (maxScroll > 0) {
          maxScroll = 0;
        }

        if (scroll < maxScroll) {
          scroll = maxScroll;
        }

        $text.css({
          transform: "translateY(".concat(scroll, "px)")
        });
      });
      $('.window__close').on('click', function (e) {
        setTimeout(function () {
          app.openText(app.text.id);
        }, 100);
      });
    },
    video: function video() {
      var $window = $('.window');
      var $swiperContainer = $window.find('.swiper-container');

      var calcCount = function calcCount() {
        return parseInt($swiperContainer.outerHeight() / $('.window__video__item').outerHeight(), 10);
      };

      var slider;
      $window.data('type', 'video');

      if (app.$video.data('index') !== undefined) {
        $(".window__video__item[data-id=\"".concat(app.$video.data('index'), "\"]")).addClass('is-active');
      }

      setTimeout(function () {
        slider = new _node_modules_swiper_js_swiper_js__WEBPACK_IMPORTED_MODULE_2___default.a($swiperContainer, {
          direction: 'vertical',
          slidesPerView: calcCount(),
          simulateTouch: false
        });
      }, 100);
      $('.window__video__item').on('click', function (e) {
        var $this = $(e.currentTarget);
        e.preventDefault();
        app.$video.attr('src', app.video.list[$this.data('id')].src).data('index', $this.data('id'));
        app.$video[0].play();
        app.$playerName.html("\u0412\u0438\u0434\u0435\u043E <div class=\"scroll-text\"><span>".concat(app.video.title, "</span></div><div class=\"scroll-text\"><span>").concat(app.video.list[$this.data('id')].name).concat("</span></div>"));
        $('.window__video__item').removeClass('is-active');
        $this.addClass('is-active');
      });
      $('.window__zoom').on('click', function (e) {
        var $this = $(e.currentTarget);
        e.preventDefault();
        $this.toggleClass('is-active');

        if ($this.hasClass('is-active')) {
          $window.addClass('is-show-big');
          slider.params.slidesPerView = calcCount();
        } else {
          $window.removeClass('is-show-big');
          slider.params.slidesPerView = calcCount();
        }

        slider.update();
      });
      $('.window__controls__start').on('click', function (e) {
        e.preventDefault();
        slider.slideTo(slider.activeIndex - calcCount());
      });
      $('.window__controls__prev').on('click', function (e) {
        e.preventDefault();
        slider.slideTo(slider.activeIndex - 1);
      });
      $('.window__controls__next').on('click', function (e) {
        e.preventDefault();
        slider.slideTo(slider.activeIndex + 1);
      });
      $('.window__controls__end').on('click', function (e) {
        e.preventDefault();
        slider.slideTo(slider.activeIndex + calcCount());
      });
    },
    music: function music() {
      var $window = $('.window');
      var $swiperContainer = $window.find('.swiper-container');

      var calcCount = function calcCount() {
        return parseInt($swiperContainer.outerHeight() / $('.window__music__item').outerHeight(), 10);
      };

      var slider;
      $window.data('type', 'music');

      if (app.$music.data('index') !== undefined) {
        $(".window__music__item[data-id=\"".concat(app.$music.data('index'), "\"]")).addClass('is-active');
      }

      setTimeout(function () {
        slider = new _node_modules_swiper_js_swiper_js__WEBPACK_IMPORTED_MODULE_2___default.a($swiperContainer, {
          direction: 'vertical',
          slidesPerView: calcCount(),
          simulateTouch: false
        });
      }, 100);
      $('.window__music__item').on('click', function (e) {
        var $this = $(e.currentTarget);
        e.preventDefault();
        app.$music.attr('src', app.music.list[$this.data('id')].src).data('index', $this.data('id'));
        app.$music[0].play();
        app.$playerName.html("\u041C\u0443\u0437\u044B\u043A\u0430 <div class=\"scroll-text\"><span>".concat(app.music.title, "</span></div><div class=\"scroll-text\"><span>").concat(app.music.list[$this.data('id')].name).concat("</span></div>"));
        $('.window__music__item').removeClass('is-active');
        $this.addClass('is-active');
      });
      $('.window__zoom').on('click', function (e) {
        var $this = $(e.currentTarget);
        e.preventDefault();
        $this.toggleClass('is-active');

        if ($this.hasClass('is-active')) {
          $window.addClass('is-show-big');
          slider.params.slidesPerView = calcCount();
        } else {
          $window.removeClass('is-show-big');
          slider.params.slidesPerView = calcCount();
        }

        slider.update();
      });
      $('.window__controls__start').on('click', function (e) {
        e.preventDefault();
        slider.slideTo(slider.activeIndex - calcCount());
      });
      $('.window__controls__prev').on('click', function (e) {
        e.preventDefault();
        slider.slideTo(slider.activeIndex - 1);
      });
      $('.window__controls__next').on('click', function (e) {
        e.preventDefault();
        slider.slideTo(slider.activeIndex + 1);
      });
      $('.window__controls__end').on('click', function (e) {
        e.preventDefault();
        slider.slideTo(slider.activeIndex + calcCount());
      });
    },
    photo: function photo() {
      var $window = $('.window');
      var $swiperContainer = $window.find('.swiper-container');

      var calcCount = function calcCount() {
        return parseInt($swiperContainer.outerHeight() / $('.window__photo__item').outerHeight(), 10);
      };

      var slider;
      var $photoName = $('.js-window-photo-name');
      $window.data('type', 'photo');
      $photoName.hide();
      setTimeout(function () {
        slider = new _node_modules_swiper_js_swiper_js__WEBPACK_IMPORTED_MODULE_2___default.a($swiperContainer, {
          direction: 'vertical',
          slidesPerView: 2,
          slidesPerColumn: 3,
          simulateTouch: false
        });
        slider.on('slideChange slideChangeTransitionEnd', function () {
          $photoName.text(". ".concat($('.swiper-slide-active').find('.window__photo__item__name').text()));
        });
      }, 100);
      $('.window__photo__item').on('click', function (e) {
        var $this = $(e.currentTarget);
        e.preventDefault();
        $this.toggleClass('is-active');

        if (!$window.hasClass('is-show-big')) {
          $window.addClass('is-show-big');
          $photoName.text(". ".concat($this.find('.window__photo__item__name').text()));
          $photoName.show();
          $('.window__zoom').addClass('is-active');
          slider.params.slidesPerView = 1;
          slider.params.slidesPerColumn = 1;
          slider.changeDirection('horizontal');
          slider.update();
          slider.slideTo($this.closest('.swiper-slide').index(), 0);
        }
      });
      $('.window__zoom').on('click', function (e) {
        var $this = $(e.currentTarget);
        e.preventDefault();
        $this.toggleClass('is-active');

        if ($this.hasClass('is-active')) {
          $window.addClass('is-show-big');
          slider.params.slidesPerView = 1;
          slider.params.slidesPerColumn = 1;
          $photoName.text(". ".concat($('.swiper-slide-active').find('.window__photo__item__name').text()));
          $photoName.show();
          slider.changeDirection('horizontal');
        } else {
          $window.removeClass('is-show-big');
          slider.params.slidesPerView = 2;
          slider.params.slidesPerColumn = 3;
          $photoName.hide();
          slider.changeDirection('vertical');
        }

        slider.update();
      });
      $('.window__expand').on('click', function (e) {
        var $this = $(e.currentTarget);
        e.preventDefault();
        $this.toggleClass('is-active');

        if ($this.hasClass('is-active')) {
          $window.addClass('is-show-expand');
        } else {
          $window.removeClass('is-show-expand');
        }

        slider.update();
      });
      $('.window__controls__start').on('click', function (e) {
        e.preventDefault();
        slider.slideTo(slider.activeIndex - calcCount());
      });
      $('.window__controls__prev').on('click', function (e) {
        e.preventDefault();
        slider.slideTo(slider.activeIndex - 1);
      });
      $('.window__controls__next').on('click', function (e) {
        e.preventDefault();
        slider.slideTo(slider.activeIndex + 1);
      });
      $('.window__controls__end').on('click', function (e) {
        e.preventDefault();
        slider.slideTo(slider.activeIndex + calcCount());
      });
      $('.window__close').on('click', function (e) {
        var $activeBtn = $('button.is-active[data-type="photo"]');
        var $activeBtnItem = $activeBtn.closest('.item');
        e.preventDefault();
        $activeBtn.removeClass('is-active');

        if (!$activeBtnItem.find('button.is-active').length) {
          $activeBtnItem.removeClass('is-active');
        }
      });
    }
  },
  getScrollbarWidth: function getScrollbarWidth() {
    var outer = document.createElement('div');
    outer.style.visibility = 'hidden';
    outer.style.overflow = 'scroll';
    outer.style.msOverflowStyle = 'scrollbar';
    document.body.appendChild(outer);
    var inner = document.createElement('div');
    outer.appendChild(inner);
    var scrollbarWidth = outer.offsetWidth - inner.offsetWidth;
    outer.parentNode.removeChild(outer);
    return scrollbarWidth;
  }
};
app.init();

/***/ }),

/***/ "./src/js/vendor.js":
/*!**************************!*\
  !*** ./src/js/vendor.js ***!
  \**************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_polyfill__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/polyfill */ "./node_modules/@babel/polyfill/lib/index.js");
/* harmony import */ var _babel_polyfill__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_polyfill__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var svg4everybody__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! svg4everybody */ "./node_modules/svg4everybody/dist/svg4everybody.js");
/* harmony import */ var svg4everybody__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(svg4everybody__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js");
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(jquery__WEBPACK_IMPORTED_MODULE_2__);



svg4everybody__WEBPACK_IMPORTED_MODULE_1___default()();
window.$ = jquery__WEBPACK_IMPORTED_MODULE_2___default.a;
window.jQuery = jquery__WEBPACK_IMPORTED_MODULE_2___default.a;

__webpack_require__(/*! ninelines-ua-parser */ "./node_modules/ninelines-ua-parser/dist/ninelines-ua-parser.js");

/***/ })

/******/ });
//# sourceMappingURL=main.js.map