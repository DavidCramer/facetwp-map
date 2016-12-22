var facetwp_map_related_post_handler,
    facetwp_map_related_post_before;
( function( $ ){
    jQuery( function( $ ){


        facetwp_map_related_post_before = function( el, ev ){
            var search = $( el ),
                items = [],
                page = 1,
                wrap = search.closest('.facetwp_map-control-input').find('.facetwp_map-post-relation');

            if( ev.type === 'paginate' ){
                page = search.data('paginate');
            }
            wrap.find('.facetwp_map-post-relation-id' ).each( function(){
                items.push( this.value );
            });

            search.data({ selected : items, page : page });
        }

        facetwp_map_related_post_handler = function( obj ){
            var wrapper = obj.params.trigger.parent().find('.facetwp_map-post-relation-results');
            wrapper.html( obj.data.html );
        };


        $( document ).on('click', '.facetwp_map-add-relation', function( e ) {
            var clicked = $(this),
                panel = clicked.closest('.facetwp_map-control-input').find('.facetwp_map-post-relation-panel'),
                input = panel.find('.facetwp_map-ajax');

            panel.toggle();
            if( panel.is(':visible') ) {
                input.val('').trigger('input').focus();
            }else{
                input.parent().find('.facetwp_map-post-relation-results').html('');
            }


        });
        $( document ).on('click', '.facetwp_map-post-relation-page', function( e ){
            var clicked = $( this ),
                search = clicked.closest('.facetwp_map-post-relation-panel').find('.facetwp_map-ajax');

            search.data('paginate', clicked.data('page') ).trigger('paginate');

        });

        $( document ).on('click', '.facetwp_map-post-relation-add', function(){

            var clicked = $( this ),
                oitem = clicked.parent(),
                wrap = clicked.closest('.facetwp_map-control-input').find('.facetwp_map-post-relation'),
                limit = parseFloat( wrap.data('limit') ),
                items,
                panel = wrap.parent().find('.facetwp_map-post-relation-footer, .facetwp_map-post-relation-panel'),
                item;


            clicked.removeClass('facetwp_map-post-relation-add dashicons-plus').addClass('facetwp_map-post-relation-remover dashicons-no-alt');
            item = oitem.clone();
            item.appendTo( wrap ).hide();
            item.find('.facetwp_map-post-relation-id').prop( 'disabled', false );
            item.show();
            oitem.remove();


            if( wrap.parent().find( '.facetwp_map-post-relation-results > .facetwp_map-post-relation-item' ).length <= 0 ){
                wrap.parent().find( '.facetwp_map-ajax' ).trigger('input');
            }

            items = wrap.children().length;

            if( items >= limit && limit > 0 ){
                panel.hide();
            }else{
                panel.show();
            }

        });

        $( document ).on('click', '.facetwp_map-post-relation-remover', function(){

            var clicked = $( this ),
                item = clicked.parent(),
                wrap = clicked.closest('.facetwp_map-control-input').find('.facetwp_map-post-relation'),
                limit = parseFloat( wrap.data('limit') ),
                items,
                panel = wrap.parent().find('.facetwp_map-post-relation-footer, .facetwp_map-post-relation-panel');

            item.remove();

            items = wrap.children().length;

            if( items >= limit && limit > 0 ){
                panel.hide();
            }else{
                if( !panel.is(':visible') ){
                    panel.show();
                    panel.find('.facetwp_map-ajax').val('').trigger('input').focus();
                }

            }
        });

        $( document ).on('facetwp_map.init', function(){
            var relations = $( '.facetwp_map-post-relation' );
            relations.each( function(){
                var input = $( this ),
                    limit = input.data('limit'),
                    panel = input.parent().find('.facetwp_map-post-relation-footer'),
                    items;

                if( limit ){
                    limit = parseFloat( limit );
                    items = input.find('.facetwp_map-post-relation-item');

                    if( items.length >= limit && limit > 0 ){
                        panel.hide();
                    }else{
                        panel.show();
                    }
                }
            });
        });

    });
})( jQuery )