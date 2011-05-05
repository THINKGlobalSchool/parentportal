<?php
/**
 * Ajax module JS
 * 
 * @package Ajaxmodule
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010
 * @link http://www.thinkglobalschool.com/
 * 
 */
?>
//<script>

elgg.provide('elgg.ajaxmodule');

elgg.ajaxmodule.getURL = 'pg/ajaxmodule/load'

elgg.ajaxmodule.init = function() {
	
	$('.ajaxmodule-content-container').each(function() {
		elgg.ajaxmodule.populateContainer($(this));
	});
}

elgg.ajaxmodule.populateContainer = function(container, offset) {
	var data = {};
	$(container).find('div.options').find('input').each(function() {
		data[$(this).attr('id')] = $(this).val();
	});
	
	// If supplied with an offset, use it
	if (offset) {
		data['offset'] = offset;
	}
	
	// Load
	elgg.get(elgg.ajaxmodule.getURL, {
		data: data, 
		success: function(data) {
			$(container).find('div.content').html(data);
			// Forcefully remove the metadata divs, don't need to see these
			$(container).find('.entity_metadata').remove();
			// Transform pagination links
			$(container).find('div.pagination').each(function() {
				$(this).find('a').each(function() {
					$(this).click(function() {
						// Get the href so we can strip out the offset
						var href = $(this).attr('href');
						var qs_array = href.split('&');
						for (pair in qs_array) {
							var param = qs_array[pair].split('=');
							// Find the offset
							if (param[0] == 'offset') {
								var offset = param[1];
							}
						}
						elgg.ajaxmodule.populateContainer(container, offset);
						return false;
					});
				});
			});
		},
	})
}


elgg.register_event_handler('init', 'system', elgg.ajaxmodule.init);
//</script>
