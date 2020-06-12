/**
 * Additional functionality for the theme's options.
 */
wp.customize.AppetiteThemeOptions = ( function( api ) {
    'use strict';

    var component, featuredPageControls;

    // IDs of the Featured Page controls.
    featuredPageControls = [
        {
            pageControlID: 'appetite_featured_page_one_id',
            alignmentControlID: 'appetite_featured_page_one_align',
            layoutControlID: 'appetite_featured_page_one_layout',
        },
        {
            pageControlID: 'appetite_featured_page_two_id',
            alignmentControlID: 'appetite_featured_page_two_align',
            layoutControlID: 'appetite_featured_page_two_layout',
        },
        {
            pageControlID: 'appetite_featured_page_three_id',
            alignmentControlID: 'appetite_featured_page_three_align',
            layoutControlID: 'appetite_featured_page_three_layout',
        }
    ]

    component = {};

    /**
     * Add layout toggle functionality to all registed Featured Pages.
     */
    _.each( featuredPageControls, function( featuredPageControl ) {
        var getFeaturedPageControls = api.control( featuredPageControl.pageControlID, featuredPageControl.alignmentControlID, featuredPageControl.layoutControlID);

        getFeaturedPageControls.done( function( pageControl, alignmentControl, layoutControl ) {
            component.toggleFeaturedPageLayoutControl( pageControl.container, alignmentControl.container, layoutControl.container );
            
            pageControl.container.on( 'change', 'select', function () {
                component.toggleFeaturedPageLayoutControl( pageControl.container, alignmentControl.container, layoutControl.container );
            } );
        });
    } );

    /**
     * Toggle Featured Page layout control based on a selected page.
     */
    component.toggleFeaturedPageLayoutControl = function ( selectContainer, alignmentContainer, layoutContainer ) {
        selectContainer = selectContainer.find( 'select' );
        if ( selectContainer.val() === '0' ) {
            layoutContainer.hide();
            alignmentContainer.hide();
        } else {
            var selectedItem = selectContainer.find( 'option:selected' );
            var nextOptionLevel = selectedItem.next().attr( 'class' );
            var currentOptionLevel = selectedItem.attr( 'class' );
            var hasChild = false;

            if ( nextOptionLevel && currentOptionLevel ) {
                nextOptionLevel = parseInt( nextOptionLevel.replace( 'level-', '' ) );
                currentOptionLevel = parseInt( currentOptionLevel.replace( 'level-', '' ) );

                if ( nextOptionLevel > currentOptionLevel ) {
                    hasChild = true;
                }
            }

            if ( hasChild ) {
                layoutContainer.show();
                alignmentContainer.hide();
            } else {
                layoutContainer.hide();
                alignmentContainer.show();
            }
        }
    }
} )( wp.customize );
