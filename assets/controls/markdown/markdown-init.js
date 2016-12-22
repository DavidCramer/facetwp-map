(function() {

    jQuery( document ).ready( function( $ ) {
        $(document).on('facetwp_map.init', function( e ) {
            var simplemde = new SimpleMDE({ element: $(".markdown")[0] });
        });
    });
});