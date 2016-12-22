(function($){
    
    var facetwp_mapBackdrop = null,
        facetwp_mapModals   = {},
        activeModals    = [],
        activeSticky    = [],
        pageHTML,
        pageBody,
        mainWindow;

    var positionModals = function(){

        if( !activeModals.length && !activeSticky.length ){
            return;
        }


        var modalId  = ( activeModals.length ? activeModals[ ( activeModals.length - 1 ) ] : activeSticky[ ( activeSticky.length - 1 ) ] ),
            windowWidth  = mainWindow.width(),
            windowHeight = mainWindow.height(),
            //modalHeight  = facetwp_mapModals[ modalId ].body.outerHeight(),
            modalHeight  = facetwp_mapModals[ modalId ].config.height,
            modalOuterHeight  = modalHeight,
            modalWidth  = facetwp_mapModals[ modalId ].config.width,
            top          = 0,
            flickerBD    = false,
            modalReduced = false;

        facetwp_mapModals[ modalId ].body.css( {
            height      : ''
        } );


        if( facetwp_mapBackdrop ){ pageHTML.addClass('has-facetwp_map-modal'); }




        // check modals for %
        if( typeof modalWidth === 'string' ){
            modalWidth = parseInt( modalWidth );
            modalWidth = windowWidth / 100 * parseInt( modalWidth );
        }
        if( typeof modalHeight === 'string' ){
            modalHeight = parseInt( modalHeight );
            modalHeight = windowHeight / 100 * parseInt( modalHeight );
        }       
        // top
        top = (windowHeight - modalHeight ) / 2.2;

        if( top < 0 ){
            top = 0;
        }

        if( modalHeight + ( facetwp_mapModals[ modalId ].config.padding * 2 ) > windowHeight && facetwp_mapBackdrop ){
            modalHeight = windowHeight;// - ( facetwp_mapModals[ modalId ].config.padding * 2 );
            modalOuterHeight = '100%';
            if( facetwp_mapBackdrop ){
                facetwp_mapBackdrop.css( {
                    //paddingTop: facetwp_mapModals[ modalId ].config.padding,
                    //paddingBottom: facetwp_mapModals[ modalId ].config.padding,
                });
            }
            modalReduced = true;
        }
        if( modalWidth + ( facetwp_mapModals[ modalId ].config.padding * 2 ) >= windowWidth ){
            modalWidth = '100%';
            if( facetwp_mapBackdrop ){
                facetwp_mapBackdrop.css( {
                    //paddingLeft: facetwp_mapModals[ modalId ].config.padding,
                    //paddingRight: facetwp_mapModals[ modalId ].config.padding,
                });
            }
            modalReduced = true;
        }

        if( true === modalReduced ){
            if( windowWidth <= 700 && windowWidth > 600 ){
                if( facetwp_mapBackdrop ){
                    modalHeight = windowHeight - ( facetwp_mapModals[ modalId ].config.padding * 2 );
                }
                modalWidth = windowWidth;
                modalOuterHeight = modalHeight - ( facetwp_mapModals[ modalId ].config.padding * 2 );
                modalWidth = '100%';
                top = 0;
                if( facetwp_mapBackdrop ){ facetwp_mapBackdrop.css( { padding : facetwp_mapModals[ modalId ].config.padding } ); }
            }else if( windowWidth <= 600 ){
                if( facetwp_mapBackdrop ){ modalHeight = windowHeight; }
                modalWidth = windowWidth;
                modalOuterHeight = '100%';
                top = 0;
                if( facetwp_mapBackdrop ){ facetwp_mapBackdrop.css( { padding : 0 } ); }
            }
        }
        // set backdrop
        if( facetwp_mapBackdrop && facetwp_mapBackdrop.is(':hidden') ){
            flickerBD = true;
            facetwp_mapBackdrop.show();
        }

        // title?
        if( facetwp_mapModals[ modalId ].header ){
            if( facetwp_mapBackdrop ){ facetwp_mapBackdrop.show(); }
            modalHeight -= facetwp_mapModals[ modalId ].header.outerHeight();
            facetwp_mapModals[ modalId ].closer.css( {
                padding     : ( facetwp_mapModals[ modalId ].header.outerHeight() / 2 ) - 3.8
            } );
            facetwp_mapModals[ modalId ].title.css({ paddingRight: facetwp_mapModals[ modalId ].closer.outerWidth() } );
        }
        // footer?
        if( facetwp_mapModals[ modalId ].footer ){
            if( facetwp_mapBackdrop ){ facetwp_mapBackdrop.show(); }
            modalHeight -= facetwp_mapModals[ modalId ].footer.outerHeight();
        }

        if( facetwp_mapBackdrop && flickerBD === true ){
            facetwp_mapBackdrop.hide();
            flickerBD = false;
        }

        // set final height
        if( modalHeight != modalOuterHeight ){
            facetwp_mapModals[ modalId ].body.css( {
                height      : modalHeight
            } );
        }
        facetwp_mapModals[ modalId ].modal.css( {
            width       : modalWidth    
        } );
        if( facetwp_mapModals[ modalId ].config.sticky && facetwp_mapModals[ modalId ].config.minimized ){
            var toggle = {},
                minimizedPosition = facetwp_mapModals[ modalId ].title.outerHeight() - facetwp_mapModals[ modalId ].modal.outerHeight();
            if( facetwp_mapModals[ modalId ].config.sticky.indexOf( 'bottom' ) > -1 ){
                toggle['margin-bottom'] = minimizedPosition;
            }else if( facetwp_mapModals[ modalId ].config.sticky.indexOf( 'top' ) > -1 ){
                toggle['margin-top'] = minimizedPosition;
            }
            facetwp_mapModals[ modalId ].modal.css( toggle );
            if( facetwp_mapModals[ modalId ].config.sticky.length >= 3 ){
                pageBody.css( "margin-" + facetwp_mapModals[ modalId ].config.sticky[0] , facetwp_mapModals[ modalId ].title.outerHeight() );
                if( modalReduced ){
                    facetwp_mapModals[ modalId ].modal.css( facetwp_mapModals[ modalId ].config.sticky[1] , 0 );
                }else{
                    facetwp_mapModals[ modalId ].modal.css( facetwp_mapModals[ modalId ].config.sticky[1] , parseFloat( facetwp_mapModals[ modalId ].config.sticky[2] ) );
                }
            }
        }
        if( facetwp_mapBackdrop ){
            facetwp_mapBackdrop.fadeIn( facetwp_mapModals[ modalId ].config.speed );

            facetwp_mapModals[ modalId ].modal.css( {
                top   : 'calc( 50% - ' + ( facetwp_mapModals[ modalId ].modal.outerHeight() / 2 ) + 'px)',
                left   : 'calc( 50% - ' + ( facetwp_mapModals[ modalId ].modal.outerWidth() / 2 ) + 'px)',
            } );
            setTimeout( function(){
                facetwp_mapModals[ modalId ].modal.addClass( 'facetwp_map-animate' );
            }, 10);

        }

        return facetwp_mapModals;
    }

    var closeModal = function( lastModal ){


        if( activeModals.length ){
            if( !lastModal ) {
                lastModal = activeModals.pop();
            }else{
                activeModals.splice( lastModal.indexOf( activeModals ), 1 );
            }

            if( facetwp_mapModals[ lastModal ].modal.hasClass( 'facetwp_map-animate' ) && !activeModals.length ){
                facetwp_mapModals[ lastModal ].modal.removeClass( 'facetwp_map-animate' );
                setTimeout( function(){
                    var current_modal = facetwp_mapModals[ lastModal ];
                    current_modal.modal.fadeOut( 200, function(){
                        current_modal.modal.remove();
                    } )

                    if( facetwp_mapModals[ lastModal ].flush ){
                        delete facetwp_mapModals[ lastModal ];
                    }
                }, 500 );
            }else{
                if( facetwp_mapBackdrop ){
                    var current_modal = facetwp_mapModals[ lastModal ];
                    current_modal.modal.fadeOut( 200, function(){
                        current_modal.modal.remove();
                    } )

                    if( facetwp_mapModals[ lastModal ].flush ){
                        delete facetwp_mapModals[ lastModal ];
                    }

                }
            }

        }

        if( !activeModals.length ){
            if( facetwp_mapBackdrop ){
                facetwp_mapBackdrop.fadeOut( 250 , function(){
                    $( this ).remove();
                    facetwp_mapBackdrop = null;
                });
            }
            pageHTML.removeClass('has-facetwp_map-modal');
            $(window).trigger( 'modals.closed' );
        }else{
            facetwp_mapModals[ activeModals[ ( activeModals.length - 1 ) ] ].modal.find('.facetwp_map-modal-blocker').remove();
            facetwp_mapModals[ activeModals[ ( activeModals.length - 1 ) ] ].modal.animate( {opacity : 1 }, 100 );
        }
        $(window).trigger( 'modal.close' );
    }
    $.facetwp_mapModal = function(opts,trigger){

        pageHTML        = $('html');
        pageBody        = $('body');
        mainWindow      = $(window);

        var defaults    = $.extend(true, {
            element             :   'form',
            height              :   550,
            width               :   620,
            padding             :   12,
            speed               :   250,
            content             :   ''
        }, opts );
        defaults.trigger = trigger;
        if( !facetwp_mapBackdrop && ! defaults.sticky ){
            facetwp_mapBackdrop = $('<div>', {"class" : "facetwp_map-backdrop"});

            pageBody.append( facetwp_mapBackdrop );
            facetwp_mapBackdrop.hide();
        }

        // create modal element
        var modalElement = defaults.element,
            modalId = defaults.modal;


        if( typeof facetwp_mapModals[ modalId ] === 'undefined' ){
            if( defaults.sticky ){
                defaults.sticky = defaults.sticky.split(' ');
                if( defaults.sticky.length < 2 ){
                    defaults.sticky = null;
                }
                activeSticky.push( modalId );
            }
            facetwp_mapModals[ modalId ] = {
                config  :   defaults
            };

            facetwp_mapModals[ modalId ].body = $('<div>', {"class" : "facetwp_map-modal-body",id: modalId + '_facetwp_mapModalBody'});
            facetwp_mapModals[modalId].content = $('<div>', {"class": "facetwp_map-modal-content", id: modalId + '_facetwp_mapModalContent'});


        }else{
            facetwp_mapModals[ modalId ].config = defaults;
        }



        var options = {
            id                  : modalId + '_facetwp_mapModal',
            tabIndex            : -1,
            "ariaLabelled-by"   : modalId + '_facetwp_mapModalLable',
            "method"            : 'post',
            "enctype"           : 'multipart/form-data',
            "class"             : "facetwp_map-modal-wrap " + ( defaults.sticky ? ' facetwp_map-sticky-modal ' + defaults.sticky[0] + '-' + defaults.sticky[1] : '' )
        };

        if( opts.config ){
            $.extend( options, opts.config );
        }
        //add in wrapper
        facetwp_mapModals[ modalId ].modal = $('<' + modalElement + '>', options );


        // push active
        if( !defaults.sticky ){ activeModals.push( modalId ); }

        // add animate      
        if( defaults.animate && facetwp_mapBackdrop ){
            var animate         = defaults.animate.split( ' ' ),
                animateSpeed    = defaults.speed + 'ms',
                animateEase     = ( defaults.animateEase ? defaults.animateEase : 'ease' );

            if( animate.length === 1){
                animate[1] = 0;
            }

            facetwp_mapModals[ modalId ].modal.css( {
                transform               : 'translate(' + animate[0] + ', ' + animate[1] + ')',
                '-web-kit-transition'   : 'transform ' + animateSpeed + ' ' + animateEase,
                '-moz-transition'       : 'transform ' + animateSpeed + ' ' + animateEase,
                transition              : 'transform ' + animateSpeed + ' ' + animateEase
            } );

        }




        // padd content
        facetwp_mapModals[ modalId ].content.css( {
            //padding : defaults.padding
        } );
        facetwp_mapModals[ modalId ].body.append( facetwp_mapModals[ modalId ].content ).appendTo( facetwp_mapModals[ modalId ].modal );
        if( facetwp_mapBackdrop ){ facetwp_mapBackdrop.append( facetwp_mapModals[ modalId ].modal ); }else{
            facetwp_mapModals[ modalId ].modal . appendTo( $( 'body' ) );
        }


        if( defaults.footer ){
            if( !facetwp_mapModals[ modalId ].footer ) {
                facetwp_mapModals[modalId].footer = $('<div>', {"class": "facetwp_map-modal-footer", id: modalId + '_facetwp_mapModalFooter'});
                facetwp_mapModals[ modalId ].footer.css({ padding: defaults.padding });

                // function?
                if( typeof window[defaults.footer] === 'function' ){
                    facetwp_mapModals[ modalId ].footer.append( window[defaults.footer]( defaults, facetwp_mapModals[ modalId ] ) );
                }else if( typeof defaults.footer === 'string' ){
                    // is jquery selector?
                    try {
                        var footerElement = $( defaults.footer );
                        facetwp_mapModals[ modalId ].footer.html( footerElement.html() );
                    } catch (err) {
                        facetwp_mapModals[ modalId ].footer.html( defaults.footer );
                    }
                }
            }

            facetwp_mapModals[ modalId ].footer.appendTo( facetwp_mapModals[ modalId ].modal );
        }

        if( defaults.title ){
            var headerAppend = 'prependTo';
            facetwp_mapModals[ modalId ].header = $('<div>', {"class" : "facetwp_map-modal-title", id : modalId + '_facetwp_mapModalTitle'});
            facetwp_mapModals[ modalId ].closer = $('<a>', { "href" : "#close", "class":"facetwp_map-modal-closer", "data-dismiss":"modal", "aria-hidden":"true",id: modalId + '_facetwp_mapModalCloser'}).html('&times;');
            facetwp_mapModals[ modalId ].title = $('<h3>', {"class" : "modal-label", id : modalId + '_facetwp_mapModalLable'});

            facetwp_mapModals[ modalId ].title.html( defaults.title ).appendTo( facetwp_mapModals[ modalId ].header );
            facetwp_mapModals[ modalId ].title.css({ padding: defaults.padding });
            facetwp_mapModals[ modalId ].title.append( facetwp_mapModals[ modalId ].closer );
            if( facetwp_mapModals[ modalId ].config.sticky ){
                if( facetwp_mapModals[ modalId ].config.minimized && true !== facetwp_mapModals[ modalId ].config.minimized ){
                    setTimeout( function(){
                        facetwp_mapModals[ modalId ].title.trigger('click');
                    }, parseInt( facetwp_mapModals[ modalId ].config.minimized ) );
                    facetwp_mapModals[ modalId ].config.minimized = false;
                }
                facetwp_mapModals[ modalId ].closer.hide();
                facetwp_mapModals[ modalId ].title.addClass( 'facetwp_map-modal-closer' ).data('modal', modalId).appendTo( facetwp_mapModals[ modalId ].header );
                if( facetwp_mapModals[ modalId ].config.sticky.indexOf( 'top' ) > -1 ){
                    headerAppend = 'appendTo';
                }
            }else{
                facetwp_mapModals[ modalId ].closer.data('modal', modalId).appendTo( facetwp_mapModals[ modalId ].header );
            }
            facetwp_mapModals[ modalId ].header[headerAppend]( facetwp_mapModals[ modalId ].modal );
        }
        // hide modal
        //facetwp_mapModals[ modalId ].modal.outerHeight( defaults.height );
        facetwp_mapModals[ modalId ].modal.outerWidth( defaults.width );

        if( defaults.content && !facetwp_mapModals[ modalId ].content.children().length ){
            // function?
            if( typeof defaults.content === 'function' ){
                facetwp_mapModals[ modalId ].content.append( defaults.content( defaults, facetwp_mapModals[ modalId ] ) );
            }else if( typeof defaults.content === 'string' ){

                if( typeof window[ defaults.content ] === 'function' ){
                    facetwp_mapModals[modalId].content.html( window[ defaults.content ]( defaults ) );
                }else {

                    // is jquery selector?
                    try {
                        var contentElement = $(defaults.content);
                        if (contentElement.length) {
                            facetwp_mapModals[modalId].content.append(contentElement.html());
                            contentElement.show();
                        } else {
                            throw new Error;
                        }
                        facetwp_mapModals[modalId].modal.removeClass('processing');
                    } catch (err) {
                        facetwp_mapModals[modalId].footer.hide();
                        setTimeout(function () {
                            facetwp_mapModals[modalId].modal.addClass('processing');
                            $.post(defaults.content, trigger.data(), function (res) {
                                facetwp_mapModals[modalId].content.html(res);
                                facetwp_mapModals[modalId].modal.removeClass('processing');
                                facetwp_mapModals[modalId].footer.show();
                            });
                        }, 250);
                    }
                }
            }
        }else{
            facetwp_mapModals[ modalId ].modal.removeClass('processing');
        }

        // others in place?
        if( activeModals.length > 1 ){
            if( activeModals[ ( activeModals.length - 2 ) ] !== modalId ){
                facetwp_mapModals[ activeModals[ ( activeModals.length - 2 ) ] ].modal.prepend( '<div class="facetwp_map-modal-blocker"></div>' ).animate( {opacity : 1 }, 100 );
                facetwp_mapModals[ modalId ].modal.hide().fadeIn( 200 );
                //facetwp_mapModals[ activeModals[ ( activeModals.length - 2 ) ] ].modal.fadeOut( 200, function(){
                  //  facetwp_mapModals[ modalId ].modal.fadeIn( 2200 );
                //} );
            }
        }

        // set position;
        positionModals();
        // return main object
        $( window ).trigger('modal.open');

        if( opts.master && activeModals ){
            delete facetwp_mapModals[ activeModals.shift() ];
        }


        facetwp_mapModals[ modalId ].positionModals = positionModals;
        facetwp_mapModals[ modalId ].closeModal = function(){
            closeModal( modalId );
        }
        var submit = facetwp_mapModals[ modalId ].modal.find('button[type="submit"]');

        if( !submit.length ){
            facetwp_mapModals[ modalId ].modal.find('input').on('change', function(){
                facetwp_mapModals[ modalId ].modal.submit();
            })
        }else{
            facetwp_mapModals[ modalId ].flush = true;
        }

        var notice = $('<div class="notice error"></div>'),
            message = $('<p></p>'),
            dismiss = $( '<button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>' );

        message.appendTo( notice );
        dismiss.appendTo( notice );

        dismiss.on('click', function(){
            notice.animate( { height: 0 }, 100, function(){
                notice.css('height', '');
                message.html();
                notice.detach();
            });
        });

        facetwp_mapModals[ modalId ].modal.attr('data-load-element', '_parent' ).baldrick({
            request : window.location.href,
            before : function( el, e ){
                $(document).trigger('facetwp_map.itemsubmit');
                submit = facetwp_mapModals[ modalId ].modal.find('button[type="submit"]');
                if( submit.length ){
                    submit.prop( 'disabled', true );
                    facetwp_mapModals[ modalId ].modal.addClass('processing');
                }
                notice.detach();
            },
            callback : function( obj ){

                obj.params.trigger.find( '[type="submit"],button' ).prop( 'disabled', false );
                facetwp_mapModals[ modalId ].modal.removeClass('processing');
                facetwp_mapModals[ modalId ].data = obj.rawData.data;
                if ( typeof obj.rawData === 'object' ) {
                    if( obj.rawData.success ) {
                        if( typeof obj.rawData.data === 'string' ){
                            obj.rawData = obj.rawData.data;
                        }else if( typeof obj.rawData.data === 'object' ){
                            if( obj.rawData.data.redirect ){
                                window.location = obj.rawData.data.redirect;
                            }
                            facetwp_mapModals[ modalId ].modal.trigger('modal.complete');
                        }else if( typeof obj.rawData.data === 'boolean' && obj.rawData.data === true ){

                            if( submit.length ) {
                                facetwp_mapModals[ modalId ].flush = false;
                            }
                        }
                        closeModal();
                    }else{
                        obj.params.target = false;
                        if( typeof obj.rawData.data === 'string' ){
                            message.html( obj.rawData.data );
                            notice.appendTo( facetwp_mapModals[ modalId ].body );
                            var height = notice.height();
                            notice.height(0).animate( { height: height }, 100 );
                        }else{
                            closeModal();
                        }
                    }
                }else{
                    closeModal();
                }
            },
            complete : function () {
                $(document).trigger('facetwp_map.init');
            }
        });
        return facetwp_mapModals[ modalId ];
    }

    $.fn.facetwp_mapModal = function( opts ){

        if( !opts ){ opts = {}; }
        opts = $.extend( {}, this.data(), opts );
        return $.facetwp_mapModal( opts, this );
    }

    // setup resize positioning and keypresses
    if ( window.addEventListener ) {
        window.addEventListener( "resize", positionModals, false );
        window.addEventListener( "keypress", function(e){
            if( e.keyCode === 27 && facetwp_mapBackdrop !== null ){
                facetwp_mapBackdrop.trigger('click');
            }
        }, false );

    } else if ( window.attachEvent ) {
        window.attachEvent( "onresize", positionModals );
    } else {
        window["onresize"] = positionModals;
    }

    $(document).on('click', '[data-modal]:not(.facetwp_map-modal-closer)', function( e ){
        e.preventDefault();
        return $(this).facetwp_mapModal();
    });

    $(document).on( 'click', '.facetwp_map-modal-closer', function( e ) {
        e.preventDefault();
        $(window).trigger('close.modal');
    })

    $(window).on( 'close.modal', function( e ) {
        closeModal();
    })
    $(window).on( 'modal.init', function( e ) {
        $('[data-modal][data-autoload]').each( function(){
            $( this ).facetwp_mapModal();
        });
    })
    $(window).on( 'modal.open', function( e ) {
        $(document).trigger('facetwp_map.init');
    });
    $(window).load( function(){
        $(window).trigger('modal.init');
    });



})(jQuery);
