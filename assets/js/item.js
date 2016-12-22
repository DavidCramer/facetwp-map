var facetwp_map_item_control_modal, facetwp_map_item_control_modal_handler;
(function ($) {

    var current_items = {}
    flush_current = false;

    facetwp_map_item_control_modal = function (obj) {
        var template_ele = $('#' + obj.modal + '-tmpl'),
            template = Handlebars.compile(template_ele.html()),
            data = {},
            state,
            html;

        if ( current_items[ obj.modal ] && flush_current === false) {
            data = {config: current_items[ obj.modal ].data('config')};
            state = 'add';
        } else {
            flush_current = false;
            state = 'update';
            data = obj.trigger.data('default');
        }

        html = $(template(data));
        html.find('[data-default]').each(function () {
            var field = $(this);
            field.val(field.data('default'));
        });
        $('#' + obj.modal + '_facetwp_mapModal .facetwp_map-modal-footer [data-state="' + state + '"]').remove();

        return html;
    }

    facetwp_map_item_control_modal_handler = function (data, obj) {

        var item = create_item(obj.params.requestData.control, data.data),
            target;

        if ( current_items[ obj.params.requestData.control + '-config' ] ) {
            target = current_items[ obj.params.requestData.control + '-config' ];
            current_items[ obj.params.requestData.control + '-config' ] = null;
            target.replaceWith(item);
        } else {
            target = $('#' + obj.params.requestData.control);
            item.appendTo(target);
        }

        save_current_edit($('#' + obj.params.requestData.control));
    }

    var create_item = function (target, data) {

        var template_ele = $('#' + target + '-tmpl'),
            template = Handlebars.compile(template_ele.html()),
            item = $(template(data));
        item.data('config', data);
        $(document).trigger('facetwp_map.init');
        return item;
    }

    var save_current_edit = function (parent) {
        var holders;
        if (parent) {
            holders = $(parent);
        } else {
            holders = $('.facetwp_map-control-item');
        }

        for (var i = 0; i < holders.length; i++) {

            var holder = $(holders[i]),
                input = $('#' + holder.prop('id') + '-control'),
                items = holder.find('.facetwp_map-item'),
                configs = [];

            for (var c = 0; c < items.length; c++) {
                var item = $(items[c]);
                configs.push(item.data('config'));
            }
            input.val(JSON.stringify(configs)).trigger('change');
        }
        $(document).trigger('facetwp_map.save');
    }

    $(document).on('click', '.facetwp_map-item-edit', function () {
        var clicked = $(this),
            control = clicked.closest('.facetwp_map-control-item'),
            id = control.prop('id') + '-config',
            trigger = $('button[data-modal="' + id + '"]');


        current_items[ id ] = clicked.closest('.facetwp_map-item');
        flush_current = false;

        trigger.trigger('click');
    });

    $(document).on('click', '.facetwp_map-item-remove', function () {
        var clicked = $(this),
            control = clicked.closest('.facetwp_map-control-item'),
            id = control.prop('id') + '-config',
            trigger = $('button[data-modal="' + id + '"]'),
            item = clicked.closest('.facetwp_map-item');

        if (clicked.data('confirm')) {
            if (!confirm(clicked.data('confirm'))) {
                return;
            }
        }

        current_items[ id ] = null;

        item.fadeOut(200, function () {
            item.remove();
            save_current_edit(control);
        });
    });

    // clear edit
    $(window).on('modals.closed', function () {
        flush_current = true;
    });

    // init
    $(window).load(function () {
        $(document).on('facetwp_map.init', function () {
            $('.facetwp_map-control-item').not('._facetwp_map_item_init').each(function () {

                var holder = $(this),
                    input = $('#' + holder.prop('id') + '-control'),
                    data;
                if( holder.hasClass('_facetwp_map_item_init') ){
                    return;
                }
                holder.addClass('_facetwp_map_item_init');
                try {
                    data = JSON.parse(input.val());

                } catch (err) {

                }
                holder.addClass('_facetwp_map_item_init');

                if (typeof data === 'object' && data.length) {
                    for (var i = 0; i < data.length; i++) {
                        var item = create_item(holder.prop('id'), data[i]);
                        item.appendTo(holder);
                    }
                }
                holder.removeClass('processing');
            });
        });
    });
})(jQuery);
