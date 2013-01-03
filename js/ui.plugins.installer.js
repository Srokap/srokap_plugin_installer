elgg.provide('elgg.ui.plugins.installer');

elgg.ui.plugins.installer.init = function() {
	var repF = elgg.ui.plugins.installer.replaceResults;
	
	//TODO simplify this
	//autocomplete text input
	$('.elgg-form-plugins-install-search input[name="q"][type="text"]').autocomplete({
		delay: 1000,
		source: function(request, response) {
			elgg.ui.plugins.installer.search({q:request.term}, function(err, data){
				repF(data);
				response([]);
			});
		}
	});
	//block normal submit and run via ajax
	$('.elgg-form-plugins-install-search').submit(function(evt){
		elgg.ui.plugins.installer.search({}, function(err, data){
			repF(data);
		});
		return false;
	});
	//run search on category change
	$('.elgg-form-plugins-install-search select[name="category"]').change(function(){
		elgg.ui.plugins.installer.search({}, function(err, data){
			repF(data);
		});
	});
	//run search on sort change
	$('.elgg-form-plugins-install-search select[name="sort"]').change(function(){
		elgg.ui.plugins.installer.search({}, function(err, data){
			repF(data);
		});
	});
	
	//load and append next pages of results
	$('.list-load-more').live('click', function(){
		var data = $(this).data('params') || {};
		data.no_stats = true;
		var $loader = elgg.ui.plugins.installer.getLoader();
		$(this).replaceWith($loader);
		elgg.ui.plugins.installer.getResults(data, function(err, data){
			//button is wrapped with div
			$loader.parent().replaceWith(data);
		});
		return false;
	});
	
	//load and insert plugin details
	$('.plugin-show-details').live('click', function(){
		var $self = $(this);
		
		if (!$self.hasClass('link-clicked')) {
			var href = $self.data('url');
			var $loader = $('#plugins-install-search-loader').clone();
			$loader.removeClass('hidden');
			
			$self.replaceWith($loader);
			$self.addClass('link-clicked');
			//$(self).replace();
			elgg.get('ajax/default/object/remote_plugin_project/details', {
				data: {
					url: href
				},
				success: function(data) {
					data = $(data);
					$loader.replaceWith(data);
					$(".elgg-lightbox-image", data).fancybox({
						type: 'image'
					});
				}
			});
		}
		return false;
	});
}

elgg.ui.plugins.installer.getLoader = function() {
	var $loader = $('#plugins-install-search-loader').clone();
	$loader.removeClass('hidden');
	return $loader;
}

elgg.ui.plugins.installer.replaceResults = function(data) {
	var $moduleContent = $('#plugins-install-search-results > .elgg-body');
	data = $(data);
	$(".elgg-lightbox", data).fancybox({});
	$moduleContent.html(data);
}

elgg.ui.plugins.installer.search = function(data, callback) {
	elgg.ui.plugins.installer.replaceResults(elgg.ui.plugins.installer.getLoader());
	elgg.ui.plugins.installer.getResults(data, callback);
}

elgg.ui.plugins.installer.getResults = function(data, callback) {	

	data = data || {};
	if (data.q===undefined) {
		data.q = $('.elgg-form-plugins-install-search input[name="q"][type="text"]').val();
	}
	if (data.category===undefined) {
		data.category = $('.elgg-form-plugins-install-search select[name="category"] option:selected').val();
	}
	if (data.sort===undefined) {
		data.sort = $('.elgg-form-plugins-install-search select[name="sort"] option:selected').val();
	}
	
	elgg.get('ajax/default/plugins/install/search/results', {
		data: data,
		success: function(data) {
			callback(null, data);
		},
		error: function() {
			callback("Error loading results");
		}
	});
}

elgg.register_hook_handler('init', 'system', elgg.ui.plugins.installer.init);
