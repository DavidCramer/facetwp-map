(function( $ ) {

    $( document ).on( 'click', '.facetwp-tab-trigger', function( e ){
        e.preventDefault();
        var clicked  = $( this ),
            target   = $( clicked.attr('href') ),
            wrapper  = clicked.closest('.facetwp-panel-inside'),
            tabs     = wrapper.find('> .facetwp-panel-tabs').children(),
            sections = wrapper.find('> .facetwp-sections').children();

        tabs.attr('aria-selected', false );
        clicked.parent().attr('aria-selected', true );

        sections.attr('aria-hidden', true );
        target.attr('aria-hidden', false );

    });

})( jQuery );