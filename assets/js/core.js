var fwp_map = {};

(function() {

    jQuery( document ).ready( function( $ ){

       $( document ).on('facetwp.init', function() {
           $('[data-default]').each(function () {
                var field = $(this);
                field.val(field.data('default'));
            });
        });

       $( window ).load( function() {
            // main init
            $(document).trigger('facetwp.init');
        });
    });


})( window );