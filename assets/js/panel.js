(function( $ ) {

    $( document ).on( 'click', '.facetwp_map-tab-trigger', function( e ){
        e.preventDefault();
        var clicked  = $( this ),
            target   = $( clicked.attr('href') ),
            wrapper  = clicked.closest('.facetwp_map-panel-inside'),
            tabs     = wrapper.find('> .facetwp_map-panel-tabs').children(),
            sections = wrapper.find('> .facetwp_map-sections').children();

        tabs.attr('aria-selected', false );
        clicked.parent().attr('aria-selected', true );

        sections.attr('aria-hidden', true );
        target.attr('aria-hidden', false );

    });

})( jQuery );