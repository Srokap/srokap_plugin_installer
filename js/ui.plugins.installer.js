elgg.provide('elgg.ui.plugins.installer');

elgg.ui.plugins.installer.init = function() {
	$('.elgg-form-plugins-install-search input[name="q"][type="text"]').autocomplete({
		source: function(request, response) {
			var $moduleContent = $('#plugins-install-search-results > .elgg-body');
			var $loader = $('#plugins-install-search-loader').clone();
			$loader.removeClass('hidden');
			$moduleContent.html($loader);
			
			elgg.get('ajax/default/plugins/install/search/results', {
				data: {
					q: request.term
				},
				success: function(data) {
					$moduleContent.html(data);
				},
				complete: function() {
					response([]);
				}
			});
		}
	});
	$('.elgg-form-plugins-install-search').submit(function(evt){
		return false;
	});
}

elgg.register_hook_handler('init', 'system', elgg.ui.plugins.installer.init);
