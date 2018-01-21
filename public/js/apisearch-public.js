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

    /**
	 * Result list template string
     * @type {string}
     */
	var resultTemplate = '<ul class="apisearch-results-list">{{#items}} ' +
			'<li class="apisearch-results-list-item">' +
				'{{#highlights.title}}<a href="{{metadata.guid}}">{{{highlights.title}}}</a>{{/highlights.title}}' +
				'{{^highlights.title}}<a href="{{metadata.guid}}">{{metadata.title}}</a>{{/highlights.title}}' +
			'</li>' +
		'{{/items}}</ul>'
	;

	$.getScript('https://cdn.jsdelivr.net/npm/apisearch-ui@0.1.22/dist/apisearch-ui.min.js', function() {
		var ui = apisearchUI({
			appId: php_vars.app_id,
			indexId: php_vars.index_id,
			token: php_vars.admin_token,
			options: {
				endpoint: 'http://localhost:8999'
			}
		});

        $('.search-form').append('<div class="apisearch-results" hidden></div>');

        // Append widgets
		ui.addWidgets(
			ui.widgets.simpleSearch({
				target: 'input.search-field'
			}),
			ui.widgets.result({
				target: '.apisearch-results',
                highlightsEnabled: true,
				template: {
					itemsList: resultTemplate
				}
			})
		);

		ui.store.on('render', function() {
			if (this.dirty) {
				return;
			}

			if (this.data.total_hits > 0) {
				$('.apisearch-results').show();
			}

            if (this.data.query.q === '') {
                $('.apisearch-results').hide();
			}
		});

		// Initialize it
		ui.init();
	});

})( jQuery );
