elgg.provide('elgg.ui.plugins.installer');

elgg.ui.plugins.installer.init = function() {
	$('.elgg-form-plugins-install-search input[name="q"][type="text"]').autocomplete({
		source: function(request, response) {
			elgg.ui.plugins.installer.search(request.term, function(err, res){
				response([]);
			});
		}
	});
	$('.elgg-form-plugins-install-search').submit(function(evt){
		return false;
	});
	$('.elgg-form-plugins-install-search select[name="sort"]').change(function(){
		var q = $('.elgg-form-plugins-install-search input[name="q"][type="text"]').val();
		elgg.ui.plugins.installer.search(q, function(){});
	});
}

elgg.ui.plugins.installer.search = function(term, callback) {
	var $moduleContent = $('#plugins-install-search-results > .elgg-body');
	var $loader = $('#plugins-install-search-loader').clone();
	$loader.removeClass('hidden');
	$moduleContent.html($loader);
	
	var sort = $('.elgg-form-plugins-install-search select[name="sort"] option:selected').val();
	
	elgg.get('ajax/default/plugins/install/search/results', {
		data: {
			q: term,
			sort: sort
		},
		success: function(data) {
			$moduleContent.html(data);
		},
		complete: function() {
			callback(null, true);
		}
	});
}

elgg.register_hook_handler('init', 'system', elgg.ui.plugins.installer.init);
