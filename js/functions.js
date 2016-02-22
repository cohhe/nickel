/**
 * Theme functions file
 *
 * Contains handlers for navigation, accessibility, header sizing
 * footer widgets and Featured Content slider
 *
 */

var nickel = {};

jQuery(window).load(function() {

});

jQuery(document).ready(function($) {
	if ( jQuery('.menu-item-type-taxonomy').length ) {
		jQuery('.menu-item-type-taxonomy').first().addClass('visible');
		jQuery('.menu-item-type-taxonomy').first().parent().addClass('category-menu');

		jQuery(document).on('hover', '#primary-navigation .menu-item-has-children', function() {
			if ( jQuery(this).find('ul').first().hasClass('category-menu') ) {
				var submenu_offset = jQuery(this).offset().left;
				var menu_offset = jQuery('#primary-navigation').offset().left;
				jQuery(this).find('ul').first().width( jQuery('.header-wrapper').width()-60 );
				jQuery('.sub-menu.category-menu').each(function() {
					jQuery(this).height( jQuery(this).find('.menu-category-container').height()-15 );
				});
				jQuery(this).find('ul').first().css({"left": "-"+parseInt(submenu_offset-menu_offset)+"px"});
			};
		});

		jQuery(document).on('hover', '.menu-item-type-taxonomy > a', function() {
			jQuery('.menu-item-type-taxonomy').removeClass('visible');
			jQuery(this).parent().addClass('visible');
		});
	};

	jQuery(document).on('click', '.nickel-categories-select a', function() {
		jQuery('.nickel-categories-select a').removeClass('active');
		jQuery(this).addClass('active');

		jQuery('.nickel-categories-inner').hide();
		jQuery('.nickel-categories-inner.'+jQuery(this).html().toLowerCase()).show();
	});

	jQuery(document).on('click', '.nickel-news-select a', function() {
		jQuery('.nickel-news-select a').removeClass('active');
		jQuery(this).addClass('active');

		var post_class = jQuery(this).html();
		if ( post_class == 'latest' ) {
			post_class = 'latest-posts';
		} else if ( post_class == 'random' ) {
			post_class = 'random-posts';
		} else if ( post_class == 'popular' ) {
			post_class = 'popular-posts';
		}

		jQuery('.nickel-news-inner').hide();
		jQuery('.nickel-news-inner.'+post_class.toLowerCase()).show();
	});

	jQuery(document).on('click', '.mobile-menu-button', function() {
		jQuery('#mobile-navigation').toggleClass('active');
	});

	jQuery(document).on('click', '.header-search', function() {
		jQuery(this).parent().find('.search-submit').click();
	});

	// jQuery('.menu-item.menu-item-has-children').on({
	// 	mouseenter: function () {
	// 		jQuery(this).find('.sub-menu').first().stop().animate({
	// 			opacity: 1,
	// 		}, 200, function() {
	// 			// Animation complete.
	// 		});
	// 	},
	// 	mouseleave: function () {
	// 		jQuery(this).find('.sub-menu').first().stop().animate({
	// 			opacity: 0,
	// 		}, 200, function() {
	// 			// Animation complete.
	// 		});
	// 	}
	// });
});

function clearInput (input, inputValue) {
	"use strict";

	if (input.value === inputValue) {
		input.value = '';
	}
}

( function( $ ) {
	var body    = $( 'body' ),
		_window = $( window );

	$('.scroll-to-top').click(function () {
		$('body,html').animate({
			scrollTop: 0
		}, 800);
		return false;
	});

	jQuery(document).scroll(function() {
		if ( jQuery(document).scrollTop() >= 200 ) {
			jQuery('.site-header').addClass('scrolled');
		} else {
			jQuery('.site-header').removeClass('scrolled');
		}
	});

	// Enable menu toggle for small screens.
	( function() {
		var nav = $( '#primary-navigation' ), button, menu;
		if ( ! nav ) {
			return;
		}

		button = nav.find( '.menu-toggle' );
		if ( ! button ) {
			return;
		}

		// Hide button if menu is missing or empty.
		menu = nav.find( '.nav-menu' );
		if ( ! menu || ! menu.children().length ) {
			button.hide();
			return;
		}

		$( '.menu-toggle' ).on( 'click.nickel', function() {
			nav.toggleClass( 'toggled-on' );
		} );
	} )();

	/*
	 * Makes "skip to content" link work correctly in IE9 and Chrome for better
	 * accessibility.
	 *
	 * @link http://www.nczonline.net/blog/2013/01/15/fixing-skip-to-content-links/
	 */
	_window.on( 'hashchange.nickel', function() {
		var element = document.getElementById( location.hash.substring( 1 ) );

		if ( element ) {
			if ( ! /^(?:a|select|input|button|textarea)$/i.test( element.tagName ) ) {
				element.tabIndex = -1;
			}

			element.focus();

			// Repositions the window on jump-to-anchor to account for header height.
			window.scrollBy( 0, -80 );
		}
	} );

	$( function() {

		/*
		 * Fixed header for large screen.
		 * If the header becomes more than 48px tall, unfix the header.
		 *
		 * The callback on the scroll event is only added if there is a header
		 * image and we are not on mobile.
		 */
		if ( _window.width() > 781 ) {
			var mastheadHeight = $( '#masthead' ).height(),
				toolbarOffset, mastheadOffset;

			if ( mastheadHeight > 48 ) {
				body.removeClass( 'masthead-fixed' );
			}

			if ( body.is( '.header-image' ) ) {
				toolbarOffset  = body.is( '.admin-bar' ) ? $( '#wpadminbar' ).height() : 0;
				mastheadOffset = $( '#masthead' ).offset().top - toolbarOffset;

				_window.on( 'scroll.nickel', function() {
					if ( ( window.scrollY > mastheadOffset ) && ( mastheadHeight < 49 ) ) {
						body.addClass( 'masthead-fixed' );
					} else {
						body.removeClass( 'masthead-fixed' );
					}
				} );
			}
		}

		// Focus styles for menus.
		$( '.primary-navigation, .secondary-navigation' ).find( 'a' ).on( 'focus.nickel blur.nickel', function() {
			$( this ).parents().toggleClass( 'focus' );
		} );
	} );
} )( jQuery );

/*------------------------------------------------------------
 * FUNCTION: Scroll Page Back to Top
 * Used for ajax navigation scroll position reset
 *------------------------------------------------------------*/

function scrollPageToTop(){
	// Height hack for mobile/tablet
	jQuery('body').css('height', 'auto');
	jQuery("html, body").animate({ scrollTop: 0 }, "slow");

	// if( nickel.device != 'desktop' ){
		// jQuery('body').scrollTop(0);
	// }else{
	//  jQuery('.content-wrapper').scrollTop(0);
	// }

	jQuery('body').css('height', '');
}

(function() {

	// detect if IE : from http://stackoverflow.com/a/16657946      
	var ie = (function(){
		var undef,rv = -1; // Return value assumes failure.
		var ua = window.navigator.userAgent;
		var msie = ua.indexOf('MSIE ');
		var trident = ua.indexOf('Trident/');

		if (msie > 0) {
			// IE 10 or older => return version number
			rv = parseInt(ua.substring(msie + 5, ua.indexOf('.', msie)), 10);
		} else if (trident > 0) {
			// IE 11 (or newer) => return version number
			var rvNum = ua.indexOf('rv:');
			rv = parseInt(ua.substring(rvNum + 3, ua.indexOf('.', rvNum)), 10);
		}

		return ((rv > -1) ? rv : undef);
	}());


	// disable/enable scroll (mousewheel and keys) from http://stackoverflow.com/a/4770179                  
	// left: 37, up: 38, right: 39, down: 40,
	// spacebar: 32, pageup: 33, pagedown: 34, end: 35, home: 36
	var keys = [37, 38, 39, 40], wheelIter = 0;

	function preventDefault(e) {
		e = e || window.event;
		if (e.preventDefault)
		e.preventDefault();
		e.returnValue = false;  
	}

	function keydown(e) {
		for (var i = keys.length; i--;) {
			if (e.keyCode === keys[i]) {
				preventDefault(e);
				return;
			}
		}
	}

	function touchmove(e) {
		preventDefault(e);
	}

	function wheel(e) {
		// for IE 
		//if( ie ) {
			//preventDefault(e);
		//}
	}

	function disable_scroll() {
		window.onmousewheel = document.onmousewheel = wheel;
		document.onkeydown = keydown;
		document.body.ontouchmove = touchmove;
	}

	function enable_scroll() {
		window.onmousewheel = document.onmousewheel = document.onkeydown = document.body.ontouchmove = null;  
	}

	var docElem = window.document.documentElement,
		scrollVal,
		isRevealed, 
		noscroll, 
		isAnimating;

	function scrollY() {
		return window.pageYOffset || docElem.scrollTop;
	}

	function scrollPage() {
		scrollVal = scrollY();
		
		if( noscroll && !ie ) {
			if( scrollVal < 0 ) return false;
			// keep it that way
			window.scrollTo( 0, 0 );
		}

		if( jQuery('body').hasClass( 'notrans' ) ) {
			jQuery('body').removeClass( 'notrans' );
			return false;
		}

		if( isAnimating ) {
			return false;
		}
		
		if( scrollVal <= 0 && isRevealed ) {
			toggle(0);
		}
		else if( scrollVal > 0 && !isRevealed ){
			toggle(1);
		}
	}

	function toggle( reveal ) {
		isAnimating = true;
		
		if( reveal ) {
			jQuery('body').addClass( 'modify' );
		}
		else {
			noscroll = true;
			disable_scroll();
			jQuery('body').removeClass( 'modify' );
		}

		// simulating the end of the transition:
		setTimeout( function() {
			isRevealed = !isRevealed;
			isAnimating = false;
			if( reveal ) {
				noscroll = false;
				enable_scroll();
			}
		}, 600 );
	}

	if( !/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {

		// refreshing the page...
		var pageScroll = scrollY();
		noscroll = pageScroll === 0;

		disable_scroll();

		if( pageScroll ) {
			isRevealed = true;
			jQuery('body').addClass( 'notrans' );
			jQuery('body').addClass( 'modify' );
		}

		
	} else if ( jQuery('body').hasClass('single-post') && /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
		jQuery('body').addClass( 'notrans' );
		jQuery('body').addClass( 'modify' );
	}
	
})();