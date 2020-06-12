jQuery(document).ready(function() {
    
    var gettingStartedContainer = jQuery( document.getElementById( 'getting-started' ) );
    
    gettingStartedContainer.find( '.responsive-video' ).fitVids();
    
    // Page tabs.
    jQuery(function() {
        gettingStartedContainer.find( '.page-tabs' ).on( 'click', 'a', function(e) {
            e.preventDefault();
            
            var currentItem = jQuery(this);
            
            gettingStartedContainer.find( 'li' ).removeClass( 'active' );
            currentItem.parent().addClass( 'active' );

            gettingStartedContainer.find( '.single-panel' ).removeClass( 'active' );
            gettingStartedContainer.find( currentItem.attr( 'href' ) ).addClass( 'active' );
        });  
    });

});