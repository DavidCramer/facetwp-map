var FWP_MAP = {};

(function() {

    jQuery( document ).ready( function( $ ){

       $( document ).on('facetwp_map.init', function() {
           $('[data-default]').each(function () {
                var field = $(this);
                field.val(field.data('default'));
            });
        });

       $( window ).load( function() {
            // main init
            $(document).trigger('facetwp_map.init');
        });
    });

})( window );