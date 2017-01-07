var FWP_MAP = {};

(function () {

    jQuery(document).ready(function ($) {

        var source_type = $('#fwp_map-source-source_grid-0-0-source_type-control'),
            single_type = $('#fwp_map-location_field_single'),
            selectors = $('.fwpm-src'),
            order = $('#fwp_map-source-source_grid-0-0-single_order'),
            single = $('.facetwp_map-single-source'),
            lat = $('.facetwp_map-lat-source'),
            lng = $('.facetwp_map-lng-source');

        $(document).on('facetwp_map.init', function () {
            $('[data-default]').each(function () {
                var field = $(this);
                field.val(field.data('default'));
            });

            // Initialize fSelect
            $('.fselect').fSelect();

            fwpm_toggle_sources();

        });

        function fwpm_toggle_sources() {
            selectors.hide();

            if (source_type.val() === 'single') {
                single.show();
            } else if (source_type.val() === 'split') {
                lat.show();
                lng.show();
            }
        }

        function fwpm_toggle_type(){
            if( single_type.val().indexOf('acf/') === 0 ){
                order.hide();
            }else{
                order.show();
            }
        }

        source_type.on('change', fwpm_toggle_sources);
        single_type.on('change', fwpm_toggle_type);

        $(window).load(function () {
            // main init
            $(document).trigger('facetwp_map.init');
        });
    });

})(window);