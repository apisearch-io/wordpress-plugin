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

	$.getScript('https://cdn.jsdelivr.net/npm/apisearch-ui/dist/apisearch-ui.min.js', function() {
		const ui = apisearchUI({
			appId: php_vars.app_id,
			indexId: php_vars.index_id,
			token: php_vars.admin_token,
			options: {
				endpoint: 'http://localhost:8999'
			}
		});

		// Append widgets
		ui.addWidgets(
			ui.widgets.simpleSearch({
				target: '#search-2'
			}),
			ui.widgets.result({
				target: '#recent-posts-2',
				template: {
					itemsList: '<ul>{{#items}} <li>{{metadata.name}}</li> {{/items}}</ul>',
				}
			})
		);

		// Initialize it
		ui.init();
	});

})( jQuery );
