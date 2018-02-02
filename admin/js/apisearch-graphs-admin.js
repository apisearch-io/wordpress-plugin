(function( $ ) {
	'use strict';

	$.getScript('https://cdn.jsdelivr.net/npm/apisearch-events-ui/dist/apisearch-events-ui.js', function() {
		const dashboard = apisearchEventsUI({
			appId: php_vars.app_id,
			indexId: php_vars.index_id,
			token: php_vars.admin_token
		});

		dashboard.addWidget(
            dashboard.widgets.rawEvents({
                target: '.raw-events .inside'
            })
        );
        dashboard.addWidget(
            dashboard.widgets.lastQueries({
                target: '.last-events .inside'
            })
        );
        dashboard.addWidget(
            dashboard.widgets.searchEffectiveness({
                target: '.found-vs-not-found .inside'
            })
        );
        dashboard.init();
	});

})( jQuery );