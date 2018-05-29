/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
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
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
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
/******/ 	__webpack_require__.p = "/";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 176);
/******/ })
/************************************************************************/
/******/ ({

/***/ 176:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(177);


/***/ }),

/***/ 177:
/***/ (function(module, exports) {



jQuery(function () {
    jQuery('[data-toggle="tooltip"]').tooltip();
});

jQuery('#close-menu').click(function () {
    jQuery('#wrapper').toggleClass('toggled');
});

jQuery(document).ready(function () {
    jQuery("#menu-toggle").click(function (e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });

    jQuery.each(jQuery('.nav-item.dropdown a.nav-link.dropdown-parent'), function (key, value) {
        if (jQuery(this).parent().find('.show').length > 0) jQuery(this).attr('aria-expanded', 'true');
    });

    jQuery('li a[role=button]').click(function () {
        if (jQuery(this).attr('aria-expanded') == 'false') {
            jQuery(this).attr('aria-expanded', 'true');
            jQuery(this).parent().find('div[aria-labelledby=navbarDropdown]').toggleClass('show');
        } else {
            jQuery(this).attr('aria-expanded', 'false');
            jQuery(this).parent().find('div[aria-labelledby=navbarDropdown]').toggleClass('show');
        }
    });

    jQuery('select#banks').on('change', function (e) {
        var bank_id = e.target.value;
        var selector = jQuery(this).parent();
        selector.find('small').remove();
        jQuery.get('/api/banks/' + bank_id, function (data) {
            if (data) selector.append('<small><strong>Balance: ' + data.balance + '</strong></small>');
        });
    }).trigger('change');
    jQuery('button.close').click(function () {
        jQuery(this).parent().fadeOut();
    });

    // Handles Print
    printModule();
});

// Handles Print
function printModule() {
    jQuery('.btn-print-modal').click(function () {
        var type = jQuery(this).attr('expense-type');
        var id = jQuery(this).attr('expense-id');

        jQuery.get('/' + type + '/print/' + id, function (data) {
            if (data) {
                jQuery('#printer .modal-body').html(data);
                jQuery('#printer').modal('toggle');

                jQuery('#printer .btn-print-cancel').click(function () {
                    jQuery('#printer .btn-print').unbind();
                    jQuery('#printer').modal('toggle');
                });

                jQuery('#printer .btn-print').click(function () {
                    jQuery('#print-element').printThis({
                        importStyle: true
                    });
                    // window.JWSI.printDiv('print-element');
                });
            }
        });
    });
}

/***/ })

/******/ });