var FWP_MAP = {};

(function () {

    jQuery(document).ready(function ($) {

        var source_type = $('#fwp_map-source-source_grid-0-0-source_type-control'),
            selectors = $('.fwpm-src'),
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

        source_type.on('change', fwpm_toggle_sources);

        $(window).load(function () {
            // main init
            $(document).trigger('facetwp_map.init');
        });
    });

})(window);