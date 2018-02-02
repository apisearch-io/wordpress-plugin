(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
	$.getScript('https://cdn.jsdelivr.net/npm/apisearch-autocomplete/dist/apisearch-autocomplete.min.js', function() {
		var autocomplete = apisearchAutocomplete({
            appId: php_vars.app_id,
            indexId: php_vars.index_id,
            token: php_vars.admin_token
        });
		autocomplete({
            inputTarget: '.widget-area .widget_search .search-field',
            poweredBy: true,
            datasets: [{
				type: 'post',
				template: {
                    item: '' +
					'<a href="{{metadata.guid}}">' +
						'<span class="as-result__datasetItemTitle">' +
							'{{#highlights.title}}{{{highlights.title}}}{{/highlights.title}}' +
							'{{^highlights.title}}{{metadata.title}}{{/highlights.title}}' +
						'</span>' +
						'<span class="as-result__datasetItemContent">' +
                            '{{#highlights.content}}{{{highlights.content}}}{{/highlights.content}}' +
                            '{{^highlights.content}}{{searchable_metadata.content}}{{/highlights.content}}' +
						'</span>' +
                    '</a>'
				}
			}]
		})
	});

})( jQuery );
