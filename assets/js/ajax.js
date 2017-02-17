var facetwp_map_edit_state = false;

(function($){

    $( document ).on( 'facetwp_map.init', init_facetwp_map_ajax );

    function init_facetwp_map_ajax(){
        var spinner;
        $('.facetwp_map-ajax').baldrick({
            'request': window.location.href,
            before : function( el, ev ){
                if( spinner ){
                    spinner.remove();
                }
                spinner = $( '<span class="facetwp_map-ajax spinner"></span>' );
                if( ev.originalEvent && ev.originalEvent.explicitOriginalTarget ){
                    //$( ev.originalEvent.explicitOriginalTarget ).prop('disabled', 'disabled' ).addClass('disabled');
                    spinner.addClass('inline');
                }
                $(el).find('.facetwp_map-title').append( spinner );
            },
            callback : function( obj, ev ){

                if( ev && ev.originalEvent && ev.originalEvent.explicitOriginalTarget ) {
                    spinner.removeClass( 'spinner' ).addClass('dashicons dashicons-yes');
                    setTimeout( function(){
                        spinner.fadeOut( 1000, function(){
                            spinner.remove();
                        });
                    }, 1000 );

                    $(ev.originalEvent.explicitOriginalTarget).prop('disabled', false).removeClass('disabled');
                }else{
                    spinner.removeClass( 'spinner' ).addClass('dashicons dashicons-yes');
                    setTimeout( function(){
                        spinner.fadeOut( 1000, function(){
                            spinner.remove();
                        });
                    }, 1000 );
                    obj.params.trigger.find('.ajax-triggered').removeClass('ajax-triggered');
                }
                facetwp_map_edit_state = false;
            }
        });
    };

    jQuery( document ).ready( function() {



        $('form.facetwp_map-ajax').each( function(){
            var form = $( this );
            if( form.data('autosave') ){
                $( document ).on('facetwp_map.save', function(){
                    form.trigger( 'submit' );
                })
                form.on('change', '[name]', function( e ){
                    $(this).addClass('ajax-triggered');
                    $( document ).trigger('facetwp_map.save');
                })
            }else{
                form.on( 'change', '[name]', function(){
                    facetwp_map_edit_state = true;
                });
            }

        });
    })

    // check for a button




    window.onbeforeunload = function(e) {

        if( false === facetwp_map_edit_state ){ return; }

        var dialogText = 'confirm';
        e.returnValue = dialogText;
        return dialogText;
    };

})(jQuery);
