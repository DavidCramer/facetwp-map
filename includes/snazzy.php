<?php
/**
 * FWP_MAP Snazzy Maps integration / selector
 *
 * @package   facetwp_map
 * @author    David Cramer
 * @license   GPL-2.0+
 * @copyright 2016 David Cramer
 */

//echo '<img class="facetwp-snazzy-img" src="' . esc_attr( $style['imageUrl'] ) . '">';
$value = $this->get_value();
//if ( empty( $value['api_key'] ) ) {
    $value['api_key'] = 'f8e179db-a2e1-467f-89ce-edd1fe21e06b';
//}
?>
<div class="facetwp_map-control">
    <?php /*<label for="fwp_map-general-config-map-api_key-control"><span
            class="facetwp_map-control-label"><?php esc_html_e( 'Snazzy Maps API Key', 'facetwp' ); ?></span></label>*/ ?>
    <input type="hidden" name="<?php echo esc_attr( $this->name() ); ?>[api_key]"
           value="<?php echo $value['api_key']; ?>" <?php echo $this->build_attributes(); ?>>
    <?php /*<span
        class="facetwp_map-control-description"><?php echo __( 'Login / Register at <a href="https://snazzymaps.com" target="_blank">https://snazzymaps.com</a>. Click on your email address in the top right, and then the Developer tab. Just generate an API key and you\'ll be good to go! ', 'facetwp' ); ?></span> */ ?>
</div>
<div class="facetwp_map-snazzy">
    <div id="facetwp_map-snazzy-filters"></div>
    <div id="facetwp_map-snazzy-results"></div>
</div>
<script type="text/html" id="snazzy-filters-tmpl">
    {{#if message}}
    <div id="message" class="notice notice-error"><p>{{message}}</p></div>
    {{else}}
    <select id="snazzy-order">
        <option value=""><?php esc_html_e( 'Order by', 'facetwp' ); ?>&hellip;</option>
        {{#each sortOrders}}
        <option value="{{slug}}">{{name}}</option>
        {{/each}}
    </select>
    <select id="snazzy-tags">
        <option value=""><?php esc_html_e( 'Filter by Tag', 'facetwp' ); ?></option>
        {{#each tags}}
        <option value="{{slug}}">{{name}}</option>
        {{/each}}
    </select>
    <select id="snazzy-colors">
        <option value=""><?php esc_html_e( 'Filter by Color', 'facetwp' ); ?></option>
        {{#each colors}}
        <option value="{{slug}}">{{name}}</option>
        {{/each}}
    </select>
    <input type="text" id="snazzy-search" placeholder="<?php esc_html_e( 'Keyword Search', 'facetwp' ); ?>">
    {{/if}}
</script>
<script type="text/html" id="snazzy-item-tmpl">
    {{#if pagination.totalItems}}
    <div class="tablenav top clearfix">
        <div class="tablenav-pages">
            <span class="displaying-num">{{pagination.totalItems}} <?php esc_html_e( 'items', 'facetwp' ); ?></span>
            <span class="pagination-links">
                    <a class="first-page" title="<?php esc_attr_e( 'Go to the first page', 'facetwp' ); ?>"
                       href="#">&laquo;</a>
                    <a class="prev-page" title="<?php esc_attr_e( 'Go to the previous page', 'facetwp' ); ?>"
                       href="#">&lsaquo;</a>
                    <span class="paging-input">
                        <label for="current-page-selector-top"
                               class="screen-reader-text"><?php esc_html_e( 'Select Page', 'facetwp' ); ?></label>
                        <input class="current-page" id="current-page-selector-top"
                               title="<?php esc_attr_e( 'Current page', 'facetwp' ); ?>"
                               value="{{pagination.currentPage}}" size="1" type="text">
                        of
                        <span class="total-pages">{{pagination.totalPages}}</span>
                    </span>
                    <a class="next-page" title="<?php esc_attr_e( 'Go to the next page', 'facetwp' ); ?>"
                       href="#">&rsaquo;</a>
                    <a class="last-page" title="<?php esc_attr_e( 'Go to the last page', 'facetwp' ); ?>"
                       href="#">&raquo;</a>
                </span>
        </div>
    </div>
    {{/if}}
    {{#each styles}}
    <div class="facetwp_map-snazzy-item snazzy-id-{{id}}" style="background-image: url({{imageUrl}});">
        <div class="facetwp-snazzy-content">
            <h4><a href="{{url}}" target="_blank">{{name}}</a></h4>
            <div class="facetwp-snazzy-author"><?php esc_html_e( 'By' ); ?> {{#if createdBy.url}}<a
                    href="{{createdBy.url}}" target="_blank">{{createdBy.name}}</a>{{else}}{{createdBy.name}}{{/if}}
            </div>
        </div>
        <div class="facetwp-snazzy-footer">
            <button type="button" data-json="{{json}}" data-preview="{{json}}" data-id="{{id}}"
                    class="button button-small facetwp-snazzy-apply" data-text="<?php echo esc_attr( 'Style Added to Map Style', 'facetwp' ); ?>"><?php echo esc_html__( 'Use Style', 'facetwp' ); ?></button>
        </div>

    </div>
    {{/each}}
    {{#if pagination.totalItems}}
    <div class="tablenav top clearfix">
        <div class="tablenav-pages">
            <span class="displaying-num">{{pagination.totalItems}} <?php esc_html_e( 'items', 'facetwp' ); ?></span>
            <span class="pagination-links">
                    <a class="first-page" title="<?php esc_attr_e( 'Go to the first page', 'facetwp' ); ?>"
                       href="#">&laquo;</a>
                    <a class="prev-page" title="<?php esc_attr_e( 'Go to the previous page', 'facetwp' ); ?>"
                       href="#">&lsaquo;</a>
                    <span class="paging-input">
                        <label for="current-page-selector"
                               class="screen-reader-text"><?php esc_html_e( 'Select Page', 'facetwp' ); ?></label>
                        <input class="current-page" id="current-page-selector"
                               title="<?php esc_attr_e( 'Current page', 'facetwp' ); ?>"
                               value="{{pagination.currentPage}}" size="1" type="text">
                        of
                        <span class="total-pages">{{pagination.totalPages}}</span>
                    </span>
                    <a class="next-page" title="<?php esc_attr_e( 'Go to the next page', 'facetwp' ); ?>"
                       href="#">&rsaquo;</a>
                    <a class="last-page" title="<?php esc_attr_e( 'Go to the last page', 'facetwp' ); ?>"
                       href="#">&raquo;</a>
                </span>
        </div>
    </div>
    {{else}}
    <div id="message" class="notice notice-warning"><p><?php echo esc_html__('No styles found.', 'facetwp'); ?></p></div>
    {{/if}}
</script>