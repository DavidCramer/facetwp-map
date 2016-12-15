(function() {

    jQuery( document ).ready( function( $ ) {
        $(document).on('facetwp.init', function( e ) {
            var simplemde = new SimpleMDE({ element: $(".markdown")[0] });
        });
    });
});