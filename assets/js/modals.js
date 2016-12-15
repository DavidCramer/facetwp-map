(function($){
    
    var facetwpBackdrop = null,
        facetwpModals   = {},
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
            //modalHeight  = facetwpModals[ modalId ].body.outerHeight(),
            modalHeight  = facetwpModals[ modalId ].config.height,
            modalOuterHeight  = modalHeight,
            modalWidth  = facetwpModals[ modalId ].config.width,
            top          = 0,
            flickerBD    = false,
            modalReduced = false;

        facetwpModals[ modalId ].body.css( {
            height      : ''
        } );


        if( facetwpBackdrop ){ pageHTML.addClass('has-facetwp-modal'); }




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

        if( modalHeight + ( facetwpModals[ modalId ].config.padding * 2 ) > windowHeight && facetwpBackdrop ){
            modalHeight = windowHeight;// - ( facetwpModals[ modalId ].config.padding * 2 );
            modalOuterHeight = '100%';
            if( facetwpBackdrop ){
                facetwpBackdrop.css( {
                    //paddingTop: facetwpModals[ modalId ].config.padding,
                    //paddingBottom: facetwpModals[ modalId ].config.padding,
                });
            }
            modalReduced = true;
        }
        if( modalWidth + ( facetwpModals[ modalId ].config.padding * 2 ) >= windowWidth ){
            modalWidth = '100%';
            if( facetwpBackdrop ){
                facetwpBackdrop.css( {
                    //paddingLeft: facetwpModals[ modalId ].config.padding,
                    //paddingRight: facetwpModals[ modalId ].config.padding,
                });
            }
            modalReduced = true;
        }

        if( true === modalReduced ){
            if( windowWidth <= 700 && windowWidth > 600 ){
                if( facetwpBackdrop ){
                    modalHeight = windowHeight - ( facetwpModals[ modalId ].config.padding * 2 );
                }
                modalWidth = windowWidth;
                modalOuterHeight = modalHeight - ( facetwpModals[ modalId ].config.padding * 2 );
                modalWidth = '100%';
                top = 0;
                if( facetwpBackdrop ){ facetwpBackdrop.css( { padding : facetwpModals[ modalId ].config.padding } ); }
            }else if( windowWidth <= 600 ){
                if( facetwpBackdrop ){ modalHeight = windowHeight; }
                modalWidth = windowWidth;
                modalOuterHeight = '100%';
                top = 0;
                if( facetwpBackdrop ){ facetwpBackdrop.css( { padding : 0 } ); }
            }
        }
        // set backdrop
        if( facetwpBackdrop && facetwpBackdrop.is(':hidden') ){
            flickerBD = true;
            facetwpBackdrop.show();
        }

        // title?
        if( facetwpModals[ modalId ].header ){
            if( facetwpBackdrop ){ facetwpBackdrop.show(); }
            modalHeight -= facetwpModals[ modalId ].header.outerHeight();
            facetwpModals[ modalId ].closer.css( {
                padding     : ( facetwpModals[ modalId ].header.outerHeight() / 2 ) - 3.8
            } );
            facetwpModals[ modalId ].title.css({ paddingRight: facetwpModals[ modalId ].closer.outerWidth() } );
        }
        // footer?
        if( facetwpModals[ modalId ].footer ){
            if( facetwpBackdrop ){ facetwpBackdrop.show(); }
            modalHeight -= facetwpModals[ modalId ].footer.outerHeight();
        }

        if( facetwpBackdrop && flickerBD === true ){
            facetwpBackdrop.hide();
            flickerBD = false;
        }

        // set final height
        if( modalHeight != modalOuterHeight ){
            facetwpModals[ modalId ].body.css( {
                height      : modalHeight
            } );
        }
        facetwpModals[ modalId ].modal.css( {
            width       : modalWidth    
        } );
        if( facetwpModals[ modalId ].config.sticky && facetwpModals[ modalId ].config.minimized ){
            var toggle = {},
                minimizedPosition = facetwpModals[ modalId ].title.outerHeight() - facetwpModals[ modalId ].modal.outerHeight();
            if( facetwpModals[ modalId ].config.sticky.indexOf( 'bottom' ) > -1 ){
                toggle['margin-bottom'] = minimizedPosition;
            }else if( facetwpModals[ modalId ].config.sticky.indexOf( 'top' ) > -1 ){
                toggle['margin-top'] = minimizedPosition;
            }
            facetwpModals[ modalId ].modal.css( toggle );
            if( facetwpModals[ modalId ].config.sticky.length >= 3 ){
                pageBody.css( "margin-" + facetwpModals[ modalId ].config.sticky[0] , facetwpModals[ modalId ].title.outerHeight() );
                if( modalReduced ){
                    facetwpModals[ modalId ].modal.css( facetwpModals[ modalId ].config.sticky[1] , 0 );
                }else{
                    facetwpModals[ modalId ].modal.css( facetwpModals[ modalId ].config.sticky[1] , parseFloat( facetwpModals[ modalId ].config.sticky[2] ) );
                }
            }
        }
        if( facetwpBackdrop ){
            facetwpBackdrop.fadeIn( facetwpModals[ modalId ].config.speed );

            facetwpModals[ modalId ].modal.css( {
                top   : 'calc( 50% - ' + ( facetwpModals[ modalId ].modal.outerHeight() / 2 ) + 'px)',
                left   : 'calc( 50% - ' + ( facetwpModals[ modalId ].modal.outerWidth() / 2 ) + 'px)',
            } );
            setTimeout( function(){
                facetwpModals[ modalId ].modal.addClass( 'facetwp-animate' );
            }, 10);

        }

        return facetwpModals;
    }

    var closeModal = function( lastModal ){


        if( activeModals.length ){
            if( !lastModal ) {
                lastModal = activeModals.pop();
            }else{
                activeModals.splice( lastModal.indexOf( activeModals ), 1 );
            }

            if( facetwpModals[ lastModal ].modal.hasClass( 'facetwp-animate' ) && !activeModals.length ){
                facetwpModals[ lastModal ].modal.removeClass( 'facetwp-animate' );
                setTimeout( function(){
                    var current_modal = facetwpModals[ lastModal ];
                    current_modal.modal.fadeOut( 200, function(){
                        current_modal.modal.remove();
                    } )

                    if( facetwpModals[ lastModal ].flush ){
                        delete facetwpModals[ lastModal ];
                    }
                }, 500 );
            }else{
                if( facetwpBackdrop ){
                    var current_modal = facetwpModals[ lastModal ];
                    current_modal.modal.fadeOut( 200, function(){
                        current_modal.modal.remove();
                    } )

                    if( facetwpModals[ lastModal ].flush ){
                        delete facetwpModals[ lastModal ];
                    }

                }
            }

        }

        if( !activeModals.length ){
            if( facetwpBackdrop ){
                facetwpBackdrop.fadeOut( 250 , function(){
                    $( this ).remove();
                    facetwpBackdrop = null;
                });
            }
            pageHTML.removeClass('has-facetwp-modal');
            $(window).trigger( 'modals.closed' );
        }else{
            facetwpModals[ activeModals[ ( activeModals.length - 1 ) ] ].modal.find('.facetwp-modal-blocker').remove();
            facetwpModals[ activeModals[ ( activeModals.length - 1 ) ] ].modal.animate( {opacity : 1 }, 100 );
        }
        $(window).trigger( 'modal.close' );
    }
    $.facetwpModal = function(opts,trigger){

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
        if( !facetwpBackdrop && ! defaults.sticky ){
            facetwpBackdrop = $('<div>', {"class" : "facetwp-backdrop"});

            pageBody.append( facetwpBackdrop );
            facetwpBackdrop.hide();
        }

        // create modal element
        var modalElement = defaults.element,
            modalId = defaults.modal;


        if( typeof facetwpModals[ modalId ] === 'undefined' ){
            if( defaults.sticky ){
                defaults.sticky = defaults.sticky.split(' ');
                if( defaults.sticky.length < 2 ){
                    defaults.sticky = null;
                }
                activeSticky.push( modalId );
            }
            facetwpModals[ modalId ] = {
                config  :   defaults
            };

            facetwpModals[ modalId ].body = $('<div>', {"class" : "facetwp-modal-body",id: modalId + '_facetwpModalBody'});
            facetwpModals[modalId].content = $('<div>', {"class": "facetwp-modal-content", id: modalId + '_facetwpModalContent'});


        }else{
            facetwpModals[ modalId ].config = defaults;
        }



        var options = {
            id                  : modalId + '_facetwpModal',
            tabIndex            : -1,
            "ariaLabelled-by"   : modalId + '_facetwpModalLable',
            "method"            : 'post',
            "enctype"           : 'multipart/form-data',
            "class"             : "facetwp-modal-wrap " + ( defaults.sticky ? ' facetwp-sticky-modal ' + defaults.sticky[0] + '-' + defaults.sticky[1] : '' )
        };

        if( opts.config ){
            $.extend( options, opts.config );
        }
        //add in wrapper
        facetwpModals[ modalId ].modal = $('<' + modalElement + '>', options );


        // push active
        if( !defaults.sticky ){ activeModals.push( modalId ); }

        // add animate      
        if( defaults.animate && facetwpBackdrop ){
            var animate         = defaults.animate.split( ' ' ),
                animateSpeed    = defaults.speed + 'ms',
                animateEase     = ( defaults.animateEase ? defaults.animateEase : 'ease' );

            if( animate.length === 1){
                animate[1] = 0;
            }

            facetwpModals[ modalId ].modal.css( {
                transform               : 'translate(' + animate[0] + ', ' + animate[1] + ')',
                '-web-kit-transition'   : 'transform ' + animateSpeed + ' ' + animateEase,
                '-moz-transition'       : 'transform ' + animateSpeed + ' ' + animateEase,
                transition              : 'transform ' + animateSpeed + ' ' + animateEase
            } );

        }




        // padd content
        facetwpModals[ modalId ].content.css( {
            //padding : defaults.padding
        } );
        facetwpModals[ modalId ].body.append( facetwpModals[ modalId ].content ).appendTo( facetwpModals[ modalId ].modal );
        if( facetwpBackdrop ){ facetwpBackdrop.append( facetwpModals[ modalId ].modal ); }else{
            facetwpModals[ modalId ].modal . appendTo( $( 'body' ) );
        }


        if( defaults.footer ){
            if( !facetwpModals[ modalId ].footer ) {
                facetwpModals[modalId].footer = $('<div>', {"class": "facetwp-modal-footer", id: modalId + '_facetwpModalFooter'});
                facetwpModals[ modalId ].footer.css({ padding: defaults.padding });

                // function?
                if( typeof window[defaults.footer] === 'function' ){
                    facetwpModals[ modalId ].footer.append( window[defaults.footer]( defaults, facetwpModals[ modalId ] ) );
                }else if( typeof defaults.footer === 'string' ){
                    // is jquery selector?
                    try {
                        var footerElement = $( defaults.footer );
                        facetwpModals[ modalId ].footer.html( footerElement.html() );
                    } catch (err) {
                        facetwpModals[ modalId ].footer.html( defaults.footer );
                    }
                }
            }

            facetwpModals[ modalId ].footer.appendTo( facetwpModals[ modalId ].modal );
        }

        if( defaults.title ){
            var headerAppend = 'prependTo';
            facetwpModals[ modalId ].header = $('<div>', {"class" : "facetwp-modal-title", id : modalId + '_facetwpModalTitle'});
            facetwpModals[ modalId ].closer = $('<a>', { "href" : "#close", "class":"facetwp-modal-closer", "data-dismiss":"modal", "aria-hidden":"true",id: modalId + '_facetwpModalCloser'}).html('&times;');
            facetwpModals[ modalId ].title = $('<h3>', {"class" : "modal-label", id : modalId + '_facetwpModalLable'});

            facetwpModals[ modalId ].title.html( defaults.title ).appendTo( facetwpModals[ modalId ].header );
            facetwpModals[ modalId ].title.css({ padding: defaults.padding });
            facetwpModals[ modalId ].title.append( facetwpModals[ modalId ].closer );
            if( facetwpModals[ modalId ].config.sticky ){
                if( facetwpModals[ modalId ].config.minimized && true !== facetwpModals[ modalId ].config.minimized ){
                    setTimeout( function(){
                        facetwpModals[ modalId ].title.trigger('click');
                    }, parseInt( facetwpModals[ modalId ].config.minimized ) );
                    facetwpModals[ modalId ].config.minimized = false;
                }
                facetwpModals[ modalId ].closer.hide();
                facetwpModals[ modalId ].title.addClass( 'facetwp-modal-closer' ).data('modal', modalId).appendTo( facetwpModals[ modalId ].header );
                if( facetwpModals[ modalId ].config.sticky.indexOf( 'top' ) > -1 ){
                    headerAppend = 'appendTo';
                }
            }else{
                facetwpModals[ modalId ].closer.data('modal', modalId).appendTo( facetwpModals[ modalId ].header );
            }
            facetwpModals[ modalId ].header[headerAppend]( facetwpModals[ modalId ].modal );
        }
        // hide modal
        //facetwpModals[ modalId ].modal.outerHeight( defaults.height );
        facetwpModals[ modalId ].modal.outerWidth( defaults.width );

        if( defaults.content && !facetwpModals[ modalId ].content.children().length ){
            // function?
            if( typeof defaults.content === 'function' ){
                facetwpModals[ modalId ].content.append( defaults.content( defaults, facetwpModals[ modalId ] ) );
            }else if( typeof defaults.content === 'string' ){

                if( typeof window[ defaults.content ] === 'function' ){
                    facetwpModals[modalId].content.html( window[ defaults.content ]( defaults ) );
                }else {

                    // is jquery selector?
                    try {
                        var contentElement = $(defaults.content);
                        if (contentElement.length) {
                            facetwpModals[modalId].content.append(contentElement.html());
                            contentElement.show();
                        } else {
                            throw new Error;
                        }
                        facetwpModals[modalId].modal.removeClass('processing');
                    } catch (err) {
                        facetwpModals[modalId].footer.hide();
                        setTimeout(function () {
                            facetwpModals[modalId].modal.addClass('processing');
                            $.post(defaults.content, trigger.data(), function (res) {
                                facetwpModals[modalId].content.html(res);
                                facetwpModals[modalId].modal.removeClass('processing');
                                facetwpModals[modalId].footer.show();
                            });
                        }, 250);
                    }
                }
            }
        }else{
            facetwpModals[ modalId ].modal.removeClass('processing');
        }

        // others in place?
        if( activeModals.length > 1 ){
            if( activeModals[ ( activeModals.length - 2 ) ] !== modalId ){
                facetwpModals[ activeModals[ ( activeModals.length - 2 ) ] ].modal.prepend( '<div class="facetwp-modal-blocker"></div>' ).animate( {opacity : 1 }, 100 );
                facetwpModals[ modalId ].modal.hide().fadeIn( 200 );
                //facetwpModals[ activeModals[ ( activeModals.length - 2 ) ] ].modal.fadeOut( 200, function(){
                  //  facetwpModals[ modalId ].modal.fadeIn( 2200 );
                //} );
            }
        }

        // set position;
        positionModals();
        // return main object
        $( window ).trigger('modal.open');

        if( opts.master && activeModals ){
            delete facetwpModals[ activeModals.shift() ];
        }


        facetwpModals[ modalId ].positionModals = positionModals;
        facetwpModals[ modalId ].closeModal = function(){
            closeModal( modalId );
        }
        var submit = facetwpModals[ modalId ].modal.find('button[type="submit"]');

        if( !submit.length ){
            facetwpModals[ modalId ].modal.find('input').on('change', function(){
                facetwpModals[ modalId ].modal.submit();
            })
        }else{
            facetwpModals[ modalId ].flush = true;
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

        facetwpModals[ modalId ].modal.attr('data-load-element', '_parent' ).baldrick({
            request : window.location.href,
            before : function( el, e ){
                $(document).trigger('facetwp.itemsubmit');
                submit = facetwpModals[ modalId ].modal.find('button[type="submit"]');
                if( submit.length ){
                    submit.prop( 'disabled', true );
                    facetwpModals[ modalId ].modal.addClass('processing');
                }
                notice.detach();
            },
            callback : function( obj ){

                obj.params.trigger.find( '[type="submit"],button' ).prop( 'disabled', false );
                facetwpModals[ modalId ].modal.removeClass('processing');
                facetwpModals[ modalId ].data = obj.rawData.data;
                if ( typeof obj.rawData === 'object' ) {
                    if( obj.rawData.success ) {
                        if( typeof obj.rawData.data === 'string' ){
                            obj.rawData = obj.rawData.data;
                        }else if( typeof obj.rawData.data === 'object' ){
                            if( obj.rawData.data.redirect ){
                                window.location = obj.rawData.data.redirect;
                            }
                            facetwpModals[ modalId ].modal.trigger('modal.complete');
                        }else if( typeof obj.rawData.data === 'boolean' && obj.rawData.data === true ){

                            if( submit.length ) {
                                facetwpModals[ modalId ].flush = false;
                            }
                        }
                        closeModal();
                    }else{
                        obj.params.target = false;
                        if( typeof obj.rawData.data === 'string' ){
                            message.html( obj.rawData.data );
                            notice.appendTo( facetwpModals[ modalId ].body );
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
                $(document).trigger('facetwp.init');
            }
        });
        return facetwpModals[ modalId ];
    }

    $.fn.facetwpModal = function( opts ){

        if( !opts ){ opts = {}; }
        opts = $.extend( {}, this.data(), opts );
        return $.facetwpModal( opts, this );
    }

    // setup resize positioning and keypresses
    if ( window.addEventListener ) {
        window.addEventListener( "resize", positionModals, false );
        window.addEventListener( "keypress", function(e){
            if( e.keyCode === 27 && facetwpBackdrop !== null ){
                facetwpBackdrop.trigger('click');
            }
        }, false );

    } else if ( window.attachEvent ) {
        window.attachEvent( "onresize", positionModals );
    } else {
        window["onresize"] = positionModals;
    }

    $(document).on('click', '[data-modal]:not(.facetwp-modal-closer)', function( e ){
        e.preventDefault();
        return $(this).facetwpModal();
    });

    $(document).on( 'click', '.facetwp-modal-closer', function( e ) {
        e.preventDefault();
        $(window).trigger('close.modal');
    })

    $(window).on( 'close.modal', function( e ) {
        closeModal();
    })
    $(window).on( 'modal.init', function( e ) {
        $('[data-modal][data-autoload]').each( function(){
            $( this ).facetwpModal();
        });
    })
    $(window).on( 'modal.open', function( e ) {
        $(document).trigger('facetwp.init');
    });
    $(window).load( function(){
        $(window).trigger('modal.init');
    });



})(jQuery);
