(function( $ ) {

    // Add Color Picker to all inputs that have 'color-field' class
    $(function() {
        $(document).on('facetwp.init', function () {
            $( '.flatpickr' ).each( function(){
                this.flatpickr( $( this ).data() );
                console.log( $( this ).data() );
            });

        });
    });

})( jQuery );