(()=>{"use strict";var e={};function t(e){return t="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e},t(e)}function r(e,r){for(var o=0;o<r.length;o++){var n=r[o];n.enumerable=n.enumerable||!1,n.configurable=!0,"value"in n&&(n.writable=!0),Object.defineProperty(e,(a=n.key,i=void 0,i=function(e,r){if("object"!==t(e)||null===e)return e;var o=e[Symbol.toPrimitive];if(void 0!==o){var n=o.call(e,r||"default");if("object"!==t(n))return n;throw new TypeError("@@toPrimitive must return a primitive value.")}return("string"===r?String:Number)(e)}(a,"string"),"symbol"===t(i)?i:String(i)),n)}var a,i}e.d=(t,r)=>{for(var o in r)e.o(r,o)&&!e.o(t,o)&&Object.defineProperty(t,o,{enumerable:!0,get:r[o]})},e.o=(e,t)=>Object.prototype.hasOwnProperty.call(e,t);var o=$(".search-input"),n=$(".super-search"),a=$(".close-search"),i=$(".search-result"),c=null,l=function(){function e(){!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,e)}var t,l,s;return t=e,(l=[{key:"searchFunction",value:function(e){clearTimeout(c),c=setTimeout((function(){n.removeClass("search-finished"),i.fadeOut(),$.ajax({type:"GET",cache:!1,url:n.data("search-url"),data:{q:e},success:function(e){e.error?i.html(e.message):(i.html(e.data.items),n.addClass("search-finished")),i.fadeIn(500)},error:function(e){i.html(e.responseText),i.fadeIn(500)}})}),500)}},{key:"bindActionToElement",value:function(){var e=this;a.on("click",(function(t){t.preventDefault(),a.hasClass("active")?(n.removeClass("active"),i.hide(),a.removeClass("active"),$("body").removeClass("overflow"),$(".quick-search > .form-control").focus()):(n.addClass("active"),""!==o.val()&&e.searchFunction(o.val()),$("body").addClass("overflow"),a.addClass("active"))})),o.keyup((function(t){o.val(t.target.value),e.searchFunction(t.target.value)}))}}])&&r(t.prototype,l),s&&r(t,s),Object.defineProperty(t,"prototype",{writable:!1}),e}();$(document).ready((function(){(new l).bindActionToElement()}))})();