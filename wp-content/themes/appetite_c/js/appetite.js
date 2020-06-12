"use strict";

/*
 Handles additional functionalities of the theme.
*/
(function(){

	var browserWindow = jQuery( window );
	var documentBody = jQuery( document.body );
	var pageContainer = jQuery( document.getElementById( 'page' ) );
	var headerContainer = pageContainer.find( document.getElementById( 'masthead' ) );
	var contentContainer = pageContainer.find( document.getElementById( 'content' ) );
	var primaryHeader = contentContainer.find( document.getElementById( 'primary-header' ) );

	var appetiteTheme = {
		// Run on ready.
		onReady: function() {
			this.createResponsiveTables();
			this.createHeaderSearchBox();
			this.setToggleSidebar();
			this.createStickyHeader();
			this.setPageHeader();
			this.skipLinkFocusFix();

			if ( documentBody.hasClass( 'page-template-front-page' ) ) {
				this.setFeaturedContent();
				this.setFrontPageTestimonials();
			}
		},

		// Run on load.
		onLoaded: function() {
			// On load, make the site header section visible.
			headerContainer.addClass( 'header-loaded' );

			// On load, set top paddings and make the page header section visible.
			if ( primaryHeader.length ) {
				if ( documentBody.width() > 768 ) {
					primaryHeader.css( 'padding-top', headerContainer.outerHeight() );
				}

				primaryHeader.addClass( 'visible' );
			}
		},

		// Add custom class to table element and make it responsive.
		createResponsiveTables: function() {
			jQuery( 'table' ).addClass( 'table' ).wrap( '<div class="table-responsive" />' );

			var infiniteCount, infiniteItems;
			infiniteCount = 0;

			documentBody.on( 'post-load', function() {
				infiniteCount = infiniteCount + 1;
				infiniteItems = jQuery( '.infinite-wrap.infinite-view-' + infiniteCount );
				infiniteItems.find( 'table' ).addClass( 'table' ).wrap( '<div class="table-responsive" />' );
			});
		},

		// Set up the Featured Content.
		setFeaturedContent: function() {
			var featuredSlideshow = contentContainer.find( '.featured-content' );
			if ( featuredSlideshow.length && typeof jQuery.fn.bxSlider !== 'undefined' ) {
				var featuredImageContainer = contentContainer.find( '.featured-image' );
				var transitionSpeed = featuredSlideshow.data( 'transition-speed' );

				featuredSlideshow.bxSlider({
					adaptiveHeight: true,
					mode: 'fade',
					controls: false,
					auto: featuredSlideshow.data( 'autoplay' ),
	                autoHover: true,
					speed: transitionSpeed,
					pause: 5500,
					onSliderLoad:function() {
						featuredImageContainer.fadeOut( transitionSpeed, function () {
							featuredImageContainer.css( 'background-image', 'url('+featuredSlideshow.find( '.featured-slide' ).first().data( 'slide-img' ) +')' );
							featuredImageContainer.fadeIn( transitionSpeed );
						});

	                    featuredSlideshow.css( 'visibility', 'visible' );
					},
					onSlideBefore: function( currentSlide ) {
						featuredImageContainer.fadeOut( transitionSpeed, function () {
	                        var image = new Image();
	                        image.src = currentSlide.data( 'slide-img' );

	                        image.onload = function () {
	                            featuredImageContainer.css( 'background-image', 'url('+currentSlide.data( 'slide-img') +')' );
					            featuredImageContainer.fadeIn( transitionSpeed );
	                        }
						});
	    			}
				});
			}
		},

		// Set up Front Page testimonials.
		setFrontPageTestimonials: function() {
			var testimonialsContent = contentContainer.find( document.getElementById( 'testimonial-container' ) );
			if ( testimonialsContent.length && typeof jQuery.fn.bxSlider !== 'undefined' ) {
				testimonialsContent.bxSlider({
					  mode: 'fade',
					  pager: true,
					  adaptiveHeight: true,
					  pause: 7000,
					  controls: false,
					  pagerCustom: '#testimonials-pager'
				});

				jQuery( document.getElementById( 'testimonials-pager' ) ).on( 'click', 'a', appetiteTheme.preventDefaultTestimonialPager );
			}
		},

		// Prevent click event on testimonial pager on the Front Page template.
		preventDefaultTestimonialPager: function(e) {
			e.preventDefault();
		},

		// Create header search box section.
		createHeaderSearchBox: function() {
			jQuery( document.getElementById( 'sidebar-button' ) ).on( 'click', function(e) {
				e.preventDefault();

				if ( documentBody.hasClass( 'active-toggle-sidebar' ) && ! documentBody.hasClass( 'mobile-view' ) ) {
					jQuery( document.getElementById( 'toggle-sidebar' ) ).find( '.search-field' ).focus();
				}
			});
		},

		// Set up toggle sidebar section.
		setToggleSidebar: function() {
			if ( document.getElementsByTagName( 'html' )[0].getAttribute( 'dir' ) === 'rtl' ) {
				var searchSide = 'left';
			} else {
				var searchSide = 'right';
			}

			var toggleSidebar = jQuery( document.getElementById( 'sidebar-button' ) ).bigSlide({
				menu: ('#toggle-sidebar'),
				side: searchSide
			});

			jQuery( document.getElementById( 'close-toggle-sidebar' ) ).on( 'click', function(e) {
				e.preventDefault();
				toggleSidebar.close();
			});
		},

		// Create sticky header.
		createStickyHeader: function() {
			var adminBar = jQuery( document.getElementById( 'wpadminbar' ) );

			if ( adminBar.is( ':visible' ) ) {
				headerContainer.css( 'top', adminBar.height() );
			} else {
				headerContainer.css( 'top', '0' );
			}

			this.setStickyHeaderClass();

			browserWindow.on( 'scroll', function() {
				appetiteTheme.setStickyHeaderClass();
			});
		},

		// Set sticky header class based on the header location.
		setStickyHeaderClass: function() {
			if ( browserWindow.scrollTop() > 0 ) {
				headerContainer.addClass( 'scroll-header' );
			} else {
				headerContainer.removeClass( 'scroll-header' );
			}
		},

		// Set up page header section.
		setPageHeader: function() {
			if ( primaryHeader.length ) {
				// Set timers.
				var resizeTimer, scrollTimer;

				// Add or remove top paddings depending on the screen rezolution.
				function setPrimaryHeaderTopPaddings() {
					if ( documentBody.width() > 768 ) {
						primaryHeader.css( 'padding-top', headerContainer.outerHeight() );
					} else {
						primaryHeader.css( 'padding-top', '0' );
					}
				};

				// On resize, run the paddings function and reset the timeout.
				browserWindow.on( 'resize', function() {
					clearTimeout( resizeTimer );
					resizeTimer = setTimeout( setPrimaryHeaderTopPaddings, 150 );
				});

				// On scroll, change top paddings depending on an initial height of the hadader.
				browserWindow.on( 'scroll', function() {
					clearTimeout( scrollTimer );
				 	scrollTimer = setTimeout( function() {
						if ( browserWindow.scrollTop() == 0 ) {
							setPrimaryHeaderTopPaddings();
						}
					}, 100 );
				});
			}
		},

		// Helps with accessibility for keyboard only users.
		skipLinkFocusFix: function() {
			var isIe = /(trident|msie)/i.test( navigator.userAgent );

			if ( isIe && document.getElementById && window.addEventListener ) {
				window.addEventListener( 'hashchange', function() {
					var id = location.hash.substring( 1 ),
						element;

					if ( ! ( /^[A-z0-9_-]+$/.test( id ) ) ) {
						return;
					}

					element = document.getElementById( id );

					if ( element ) {
						if ( ! ( /^(?:a|select|input|button|textarea)$/i.test( element.tagName ) ) ) {
							element.tabIndex = -1;
						}

						element.focus();
					}
				}, false );
			}
		}
	};

	// Things that need to happen when the document is ready.
	jQuery( function() {
		appetiteTheme.onReady();
	});

	// Things that need to happen after a full load.
	browserWindow.on( 'load', function() {
		appetiteTheme.onLoaded();
	});
})();
