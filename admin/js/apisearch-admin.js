(function( $ ) {
	'use strict';

	$(document).ready(function(){
		$('button.apisearch-index-all').on('click', function() {
			var $button = $(this);
			$button.attr('disabled', true);
			$.ajax({
				type: "POST",
				url: $(this).attr('data-url'),
				dataType: "json",
				success: function(data){
					$button.attr('disabled', false);
					var notice = `
						<div class="notice notice-success is-dismissible">
                        	<p>`+data.data+`</p>
                    	</div>
					`;

					$button
						.parents('.wrap').first()
						.find('h2').first()
						.after(notice);
				},
				async: true
			});
		});
	});

})( jQuery );