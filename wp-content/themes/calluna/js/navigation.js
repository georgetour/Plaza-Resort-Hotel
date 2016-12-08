/**
 * navigation.js
 */
 
/*!
 * jQuery Smooth Scroll - v1.5.7 - 2015-12-16
 * https://github.com/kswedberg/jquery-smooth-scroll
 * Copyright (c) 2015 Karl Swedberg
 * Licensed MIT (https://github.com/kswedberg/jquery-smooth-scroll/blob/master/LICENSE-MIT)
 */
(function(t){"function"==typeof define&&define.amd?define(["jquery"],t):"object"==typeof module&&module.exports?t(require("jquery")):t(jQuery)})(function(t){function e(t){return t.replace(/(:|\.|\/)/g,"\\$1")}var l="1.5.7",o={},n={exclude:[],excludeWithin:[],offset:0,direction:"top",scrollElement:null,scrollTarget:null,beforeScroll:function(){},afterScroll:function(){},easing:"swing",speed:400,autoCoefficient:2,preventDefault:!0},s=function(e){var l=[],o=!1,n=e.dir&&"left"===e.dir?"scrollLeft":"scrollTop";return this.each(function(){var e=t(this);if(this!==document&&this!==window)return!document.scrollingElement||this!==document.documentElement&&this!==document.body?(e[n]()>0?l.push(this):(e[n](1),o=e[n]()>0,o&&l.push(this),e[n](0)),void 0):(l.push(document.scrollingElement),!1)}),l.length||this.each(function(){"BODY"===this.nodeName&&(l=[this])}),"first"===e.el&&l.length>1&&(l=[l[0]]),l};t.fn.extend({scrollable:function(t){var e=s.call(this,{dir:t});return this.pushStack(e)},firstScrollable:function(t){var e=s.call(this,{el:"first",dir:t});return this.pushStack(e)},smoothScroll:function(l,o){if(l=l||{},"options"===l)return o?this.each(function(){var e=t(this),l=t.extend(e.data("ssOpts")||{},o);t(this).data("ssOpts",l)}):this.first().data("ssOpts");var n=t.extend({},t.fn.smoothScroll.defaults,l),s=t.smoothScroll.filterPath(location.pathname);return this.unbind("click.smoothscroll").bind("click.smoothscroll",function(l){var o=this,r=t(this),i=t.extend({},n,r.data("ssOpts")||{}),c=n.exclude,a=i.excludeWithin,f=0,u=0,h=!0,d={},m=location.hostname===o.hostname||!o.hostname,p=i.scrollTarget||t.smoothScroll.filterPath(o.pathname)===s,g=e(o.hash);if(i.scrollTarget||m&&p&&g){for(;h&&c.length>f;)r.is(e(c[f++]))&&(h=!1);for(;h&&a.length>u;)r.closest(a[u++]).length&&(h=!1)}else h=!1;h&&(i.preventDefault&&l.preventDefault(),t.extend(d,i,{scrollTarget:i.scrollTarget||g,link:o}),t.smoothScroll(d))}),this}}),t.smoothScroll=function(e,l){if("options"===e&&"object"==typeof l)return t.extend(o,l);var n,s,r,i,c,a=0,f="offset",u="scrollTop",h={},d={};"number"==typeof e?(n=t.extend({link:null},t.fn.smoothScroll.defaults,o),r=e):(n=t.extend({link:null},t.fn.smoothScroll.defaults,e||{},o),n.scrollElement&&(f="position","static"===n.scrollElement.css("position")&&n.scrollElement.css("position","relative"))),u="left"===n.direction?"scrollLeft":u,n.scrollElement?(s=n.scrollElement,/^(?:HTML|BODY)$/.test(s[0].nodeName)||(a=s[u]())):s=t("html, body").firstScrollable(n.direction),n.beforeScroll.call(s,n),r="number"==typeof e?e:l||t(n.scrollTarget)[f]()&&t(n.scrollTarget)[f]()[n.direction]||0,h[u]=r+a+n.offset,i=n.speed,"auto"===i&&(c=Math.abs(h[u]-s[u]()),i=c/n.autoCoefficient),d={duration:i,easing:n.easing,complete:function(){n.afterScroll.call(n.link,n)}},n.step&&(d.step=n.step),s.length?s.stop().animate(h,d):n.afterScroll.call(n.link,n)},t.smoothScroll.version=l,t.smoothScroll.filterPath=function(t){return t=t||"",t.replace(/^\//,"").replace(/(?:index|default).[a-zA-Z]{3,4}$/,"").replace(/\/$/,"")},t.fn.smoothScroll.defaults=n});

 /* ---------------------------------------------------------------- */
/* Smooth scroll to inner links
/* ---------------------------------------------------------------- */
jQuery('nav a[href^="#"]:not(a[href="#"]), a.btn[href^="#"], .ttbase-intro-header a[href^="#"]').smoothScroll({
    offset: -250,
    speed: 800
});
jQuery('.show-menu span').on("click",function(){
	"use strict";
		jQuery('.mobile-nav').addClass('show').animate({ right: '0'}, 250, 'easeInCubic');
		//jQuery('body').addClass('expanded').animate({ left: '-300'}, 250, 'easeInCubic');
	});

	jQuery('.close-mobile-nav').on("click",function(){
	"use strict";
		jQuery('.mobile-nav').removeClass('show').animate({ right: '-300'}, 200, 'easeOutCubic');
		//jQuery('body').removeClass('expanded').animate({ left: '0'}, 200, 'easeOutCubic');
	});
	
jQuery(document).ready(function($) {
	"use strict";
	// Dropdown Nav Menu
	$('.nav-menu ul li').on({
        mouseenter: function () {
            //stuff to do on mouse enter
            var sub = $(this).find('.second-lvl');
    		if(sub.length > 0 && $(window).width() > 979) {
    			sub.stop().fadeIn(300, 'easeOutCubic');
    		}
        },
        mouseleave: function () {
            //stuff to do on mouse leave
            var sub = $(this).find('.second-lvl');
    		if(sub.length > 0 && $(window).width() > 979) {
    			sub.stop().fadeOut(150, 'easeOutCubic');
    		}
        }
    });

	// Dropdown Nav Menu
	$(".responsive-menu .nav-menu").hide();
    $(".toggle-menu").on("click",function() {
        $(".responsive-menu .nav-menu").slideToggle(500);
    });
	// Mega Menu Background Image
	$('.mega-menu').each(function(){
		var menuBackground = ($(this).attr("data-background-image")) ? ($(this).attr("data-background-image")) : '',
			menuBackgroundPos = ($(this).attr("data-background-pos")) ? ($(this).attr("data-background-pos")) : '';
		$(this).find('.second-lvl').css({
			'background-image' : 'url('+menuBackground+')',
			'background-position' : menuBackgroundPos,
		});
	});
});