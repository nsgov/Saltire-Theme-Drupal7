/*
Author: Able Sense Media
Web: ablesense.com
Date of creation: 01/04/2013
*/

var APP = (function () {
	var me = {},
		browser = {}

	/////////////////////////////////////////////////////////////////
	////////////////////// PRIVATE FUNCTIONS ////////////////////////
	/////////////////////////////////////////////////////////////////
		//private vars
		;

	function getSVGsupport() {
		return document.implementation.hasFeature("http://www.w3.org/TR/SVG11/feature#BasicStructure", "1.1");
	}

	function getMQsupport() {
		return (typeof window.matchMedia == 'function');
	}

	function getNthChildSupport() {
		// selectorSupported lovingly lifted from the mad italian genius, Diego Perini
		// http://javascript.nwbox.com/CSSSupport/

		var support,
			sheet,
			doc = document,
			root = doc.documentElement,
			head = root.getElementsByTagName('head')[0],
			impl = doc.implementation || {
				hasFeature: function() {
					return false;
				}
			},
			selector = ':nth-child(2n+1)',
			link = doc.createElement("style");

		link.type = 'text/css';

		(head || root).insertBefore(link, (head || root).firstChild);

		sheet = link.sheet || link.styleSheet;

		if (!(sheet && selector)) return false;

		support = impl.hasFeature('CSS2', '') ?

		function(selector) {
			try {
				sheet.insertRule(selector + '{ }', 0);
				sheet.deleteRule(sheet.cssRules.length - 1);
			} catch (e) {
				return false;
			}
			return true;
		} : function(selector) {
			sheet.cssText = selector + ' { }';
			return sheet.cssText.length !== 0 && !(/unknown/i).test(sheet.cssText) && sheet.cssText.indexOf(selector) === 0;
		};

		return support(selector);
	}

	function getViewportSize() {
		//adds a class to the body according to the device and returns an integer when called.
		var devices = ['mobile', 'tablet', 'desktop', 'luxury'],
		s = document.body.clientWidth,
		c = document.body.className,
		d = 3;

		if(s < 480){
			d = 0;
		}else if(s < 768){
			d = 1;
		}else if(s <= 960){
			d = 2;
		}

		if (c.indexOf(devices[d]) !== -1) { document.body.className += ' ' + devices[d]; }
		return d;
	}

	/////////////////////////////////////////////////////////////////
	////////////////////// PUBLIC FUNCTIONS /////////////////////////
	/////////////////////////////////////////////////////////////////





	browser.supportsSVG = getSVGsupport();
	browser.supportsMQ = getMQsupport();
	browser.supportsNthChild = getNthChildSupport();
	browser.viewportSize = getViewportSize();
	$(window).resize(function() {
		browser.viewportSize = getViewportSize();
	});
	me.browser = browser;

	return me;
}());

var NAV = (function () {
	var me = {},
		globalNav = $('header nav#global-navigation'),
		globalNavAnchor = $('<a href="#global-navigation" class="trigger">Global site menu</a>'),
		navTitle = $('.breadcrumbs > li:first > a').text(),
		mainNav = $('header nav#main-navigation'),
		mainNavAnchor = $('<a href="#main-navigation" class="mobileTrigger">Navigation</a>'),
		subNav = false,
		activeUL = null,
		depth = 0,
		depthOfCurrentPage = 0,
		mobileNavWasMade = false,
		navIsMobile = false;

	/////////////////////////////////////////////////////////////////
	//////////////////////////// PRIVATE ////////////////////////////
	/////////////////////////////////////////////////////////////////

	function back(){
		mainNav.removeClass('depth' + depth);
		depth--;
		mainNav.addClass('depth' + depth);

		activeUL = activeUL.addClass('offcanvas').parent().parent();
		mainNav.children('div').css('height', activeUL.height());

		if(depth === 0){
			mainNavAnchor.off().on('click', function(e){
				e.preventDefault();
				e.stopPropagation();

				mainNav.toggleClass('collapsed');
			});
		}
	}

	function forth(source){
		mainNav.removeClass('depth' + depth);
		depth++;
		mainNav.addClass('depth' + depth);

		activeUL = source.next().removeClass('offcanvas');
		mainNav.children('div').css('height', activeUL.height());

		if(depth === 1){
			mainNavAnchor.off().on('click', function(e){
				e.preventDefault();
				e.stopPropagation();

				back();
			});
		}
	}


	/////////////////////////////////////////////////////////////////
	//////////////////////////// PUBLIC /////////////////////////////
	/////////////////////////////////////////////////////////////////

	me.buildMainNav = function(){
		var d = APP.browser.viewportSize;

		if(d < 3){
			if(!mobileNavWasMade && !navIsMobile){
				var mainNavul = mainNav.find('ul');

				mainNavul.find('li > ul').each(function(){
					$(this).addClass('offcanvas').parent().addClass('hassubnav').children('a').each(function(){
						var a = $(this),
							clone = a.clone(),
							li = $('<li></li>');

						li.append(clone.removeClass('active active-trail'));
						a.next().prepend(li);
						a.on('click', function(e){
							e.preventDefault();
							e.stopPropagation();

							forth(a);
						});
					});
				});

				depthOfCurrentPage = mainNavul.find('.active').parents('ul').length;

				if(navTitle !== ''){ mainNavAnchor.text(navTitle); }

				mainNav.prepend(mainNavAnchor.on('click', function(e){
					e.preventDefault();
					e.stopPropagation();

					//Make the current UL visible
					var current = mainNavul.find('.active');
					activeUL = current.parent().parent();
					current.parents('ul').removeClass('offcanvas');
					depth = depthOfCurrentPage-1;
					mainNav.addClass('depth' + depth).children('div').css('height', activeUL.height());

					if(depth >= 1){
						mainNavAnchor.off().on('click', function(e){
							e.preventDefault();
							e.stopPropagation();

							back();
						});
					}

					//close the nav when clicking outside
					$(document).one('click', function(){
						mainNav.removeClass('depth' + depth);
						depth = 0;
						mainNav.addClass('depth' + 0);

						mainNavAnchor.off().on('click', function(e){
							e.preventDefault();
							e.stopPropagation();

							mainNav.toggleClass('collapsed');
						});

						mainNav.toggleClass('collapsed');
					});

					mainNav.toggleClass('collapsed');
				}));

				mobileNavWasMade = true;
			}

			navIsMobile = true;
			mainNav.addClass('mobile collapsed');
			if(subNav){ subNav.addClass('hidden'); }

		}else if(d >= 3){
			if(navIsMobile){ mainNav.children('div').css('height', 'auto'); }
			navIsMobile = false;
			mainNav.removeClass('mobile collapsed');
			if(subNav){ subNav.removeClass('hidden'); }

			if(!subNav){
				subNav = $('<nav></nav>').addClass('subnav');
				var activeSub = mainNav.find('div > ul > li > a.active-trail, div > ul > li > a.active').next().clone(true);
				activeSub.find('a:not(.active-trail, .active)').next('ul').addClass('collapsed');

				if(activeSub.length !== 0){
					subNav.append(activeSub);
				}

				// $('header + div:not(.home)').prepend(subNav);
				$('.main-sidebar').append(subNav);
			}
		}
	};

	me.buildGlobalNav = function(){
		globalNav.addClass('collapsed');
		globalNavAnchor.on('click', function(e){
			e.preventDefault();
			globalNav.toggleClass('collapsed');
		});
		globalNav.children('div').append(globalNavAnchor);
	};

	return me;
}());

$(function(){
	$('html').removeClass('no-js');

	if (!APP.browser.supportsSVG) {
		$('html').addClass('no-svg');

		// $('img').each(function(){
		// 	$(this).attr('src', $(this).attr('src').replace('.svg', '.png'));
		// });
	}

	if (!APP.browser.supportsMQ) {
		var respond = document.createElement('script');
		respond.src = '/sites/all/themes/bridgewater/js/respond.js';
		document.body.appendChild(respond);
	}


	//family navigation collapsable
	NAV.buildGlobalNav();


	//disable transitions for iOS5 users
	if (navigator.userAgent.match(/OS 5(_\d)+ like Mac OS X/i)){
		$('header nav#main-navigation, header nav#main-navigation > div').css('transition', 'none');
	}


	//main navigation mobile if needed
	NAV.buildMainNav();
	$(window).resize(function(){ //on screen orientation change or window resize
		NAV.buildMainNav();
	});


	//clone the actions subnav into the sidebar for success stories
	function successStoriesSubnav() {
		var main = $('main'),
			subnav = $('nav.subnav');

		if (APP.browser.viewportSize == 3 && main.hasClass('success-stories') && subnav.children().length === 0) {
			var actionsSub = $('header #main-navigation a:contains(Actions)').next().clone(true);
			console.log(actionsSub);

			if(actionsSub.length !== 0){
				subnav.append(actionsSub);
			}
		}
	}

	successStoriesSubnav();
	$(window).resize(function(){ //on screen orientation change or window resize
		successStoriesSubnav();
	});


	//ns logo toggles the global nav panel
	$('header .nslogo').on('click', function(e) {
		e.preventDefault();
		$('header nav#global-navigation').toggleClass('collapsed');
	});

	//responsive images technique for the infographic
	if (APP.browser.viewportSize >= 2) {
		$('img[data-big]').each(function() {
			var el = $(this);
			el.attr('src', el.attr('data-big'));

			if (!APP.browser.supportsSVG) {
				el.attr('src', el.attr('src').replace('.svg', '.png'));
			}
		});
	}
});