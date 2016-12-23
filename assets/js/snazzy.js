;(function ($) {

    var currentStyle = 0, filters, key, tag, color, template, container, stylebox, query = [], pagination, page;

    function snazzy_handler() {
        tag = $('#snazzy-tags');
        color = $('#snazzy-colors');
        sort = $('#snazzy-order');
        text = $('#snazzy-search');
        page = $('#current-page-selector-top');
        // build query
        query = [];
        if (color.val()) {
            query.push('color=' + color.val());
        }
        if (tag.val()) {
            query.push('tag=' + tag.val());
        }
        if (sort.val()) {
            query.push('sort=' + sort.val());
        }
        if (text.val()) {
            query.push('text=' + text.val());
        }
        if (page.val()) {
            query.push('page=' + page.val());
        }
        $('.facetwp_map-snazzy-item').animate({opacity: 0.6}, 500);
        // get json
        $.getJSON('https://snazzymaps.com/explore.json?key=' + key.val() + '&pageSize=6&' + query.join('&'), function (r) {
            container.html(template(r));
            if (r.pagination) {
                pagination = r.pagination;
                if (pagination.currentPage === pagination.totalPages) {
                    $('.next-page, .last-page').hide();
                } else {
                    $('.next-page, .last-page').show();
                }
                if (pagination.currentPage === 1) {
                    $('.prev-page, .first-page').hide();
                } else {
                    $('.prev-page, .first-page').show();
                }

            }
        });
    }
    function init_handlers(){
        if (key.val().length) {
            snazzy_filters();
        } else {
            filters.html('');
            container.html('');
        }
    }
    function snazzy_filters() {
        var filter_template = Handlebars.compile($('#snazzy-filters-tmpl').html());

        // get json
        $.getJSON('https://snazzymaps.com/types.json?key=' + key.val(), function (r) {
            filters.html(filter_template(r));
            snazzy_handler();
            query = [];
            if( !r.message ) {
                $(document).off('facetwp_map.save', init_handlers);
                $(document).off('facetwp_map.init', init_snazzy_nav);
            }
        });
    }

    $(document).on('facetwp_map.init', init_snazzy_nav);
    function init_snazzy_nav() {
        filters = $('#facetwp_map-snazzy-filters');
        key = $('#fwp_map-map_style-snazzy-control');
        stylebox = $('#fwp_map-map_style-styles-control');
        template = Handlebars.compile($('#snazzy-item-tmpl').html());
        container = $('#facetwp_map-snazzy-results');
        if (key.val().length) {
            snazzy_filters();
        }
    }

    $(document).on('change', '.facetwp_map-snazzy select, .facetwp_map-snazzy input', function () {
        $('.current-page').val(1);
        snazzy_handler();
    });
    $(document).on('facetwp_map.save', init_handlers );
    $(document).on('click', '.facetwp-snazzy-apply', function () {
        var clicked = $(this),
            style = clicked.data('json');

        currentStyle = clicked.data('id');

        if (typeof style === 'object') {
            style = JSON.stringify(style);
        }
        clicked.html(clicked.data('text')).addClass('button-primary');
        stylebox.val(style).trigger('change');
        $('.current-style').removeClass('current-style').find('.facetwp-snazzy-apply').removeClass('button-primary').html('Use Style').prop('disabled', false )
        $('.snazzy-id-' + currentStyle).addClass('current-style').find('.facetwp-snazzy-apply').html('Current Style').prop('disabled', true );
    });
    $(document).on('click', '.pagination-links > a', function (e) {
        var clicked = $(this);
        e.preventDefault();
        if (clicked.hasClass('first-page') && pagination.currentPage > 1) {
            $('.current-page').val(1);
        } else if (clicked.hasClass('prev-page') && pagination.currentPage > 1) {
            $('.current-page').val(( pagination.currentPage - 1 ));
        } else if (clicked.hasClass('next-page') && pagination.currentPage < pagination.totalPages) {
            $('.current-page').val(( pagination.currentPage + 1 ));
        } else if (clicked.hasClass('last-page') && pagination.currentPage < pagination.totalPages) {
            $('.current-page').val(pagination.totalPages);
        } else {
            return;
        }
        snazzy_handler();
    });


})
(jQuery);