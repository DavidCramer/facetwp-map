(function($){

    jQuery( document ).ready( function(){

        function reseset_attributes(el, name, index, id_parts, type) {
            $(el).find("[" + name + "]").each(function () {
                $(this)[type]( name, function (idx, attr) {
                    var parts = attr.split('-'),
                        old_attr = parts.join('-');
                    parts[ id_parts.length - 1 ] = index;
                    attr = parts.join('-');
                    if( name == 'id') {
                        var classnames = $('.' + old_attr );
                        classnames.removeClass( old_attr ).addClass( attr.replace( /\d+/g, 0 ) );
                    }
                    return attr;
                });
            });
        }

        function reset_repeatable_index( id ){
            var wrapper = $('[data-facetwp_map-template="'+ id + '"'),
                id_parts = id.split('-');

            wrapper.children().each( function( index, el ){
                id_parts[id_parts.length - 1 ] = index;
                var new_id = id_parts.join('-');
                reseset_attributes(el, 'name', index, id_parts, 'attr');
                reseset_attributes(el, 'data-facetwp_map-template', index, id_parts, 'attr');
                reseset_attributes(el, 'id', index, id_parts, 'prop');
                reseset_attributes(el, 'for', index, id_parts, 'attr');
                //reseset_attributes(el, 'data-for', index, id_parts, 'attr');
            })
        }

        $( document ).on('click', '[data-facetwp_map-repeat]', function( e ){
            var clicked = $( this ),
                id = clicked.data('facetwp_mapRepeat'),
                template = '';
            template = $( '#' + id + '-tmpl' ).html();
            template = $( template.replace(/{{_inst_}}/g, 0 ) ).hide();
            clicked.parent().prev().append( template );
            template.slideDown(100);
            //reset_repeatable_index( id );


            $( document ).trigger('facetwp_map.init');
        });

        $( document ).on('click', '.facetwp_map-remover', function( e ){
            var clicked = $( this ),
                template = clicked.closest('[data-facetwp_map-template]'),
                id = template.data('facetwp_mapTemplate');
                $( this ).parent().slideUp( 100, function(){
                    $(this).remove();
                });

            $( document ).trigger('facetwp_map.init');
            //reset_repeatable_index( id );

        })

        $( document ).on('facetwp_map.init', function(){
            var wrappers = $( '[data-facetwp_map-template]');
            wrappers.each( function(){
                var id = $( this ).attr('data-facetwp_map-template');
                reset_repeatable_index( id );

            })
        });

        $('[data-facetwp_map-repeat]').each( function(){
            var id  = $( this ).attr( 'data-facetwp_map-repeat' ),
                elesclass = $('.' + id );

            elesclass.removeClass( id );

            id = id.replace( /\d+/g, 0 );
            elesclass.addClass( id );
            $( this ).attr( 'data-facetwp_map-repeat', id );

        });

        $( document ).trigger('facetwp_map.init');

    })


})(jQuery);
