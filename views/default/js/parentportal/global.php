<?php
/**
 * ParentPortal Global JS
 * 
 * @package ParentPortal
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010
 * @link http://www.thinkglobalschool.com/
 * 
 */
?>
elgg.provide('elgg.parentportalglobal');

elgg.parentportalglobal.init = function() {
	// Click handler for 'tag for parents' menu item
	$(document).delegate('.tag-for-parents', 'click', elgg.parentportalglobal.tagForParentsClick);
}

// Click handler for 'tag for parents' menu item
elgg.parentportalglobal.tagForParentsClick = function(event) {
	if (!$(this).hasClass('disabled')) {
		// href will be #{guid}
		var entity_guid = $(this).attr('href').substring(1);
		elgg.portfolio.tagEntity($(this), entity_guid, 'forparents');
	}
	event.preventDefault();
}

elgg.register_hook_handler('init', 'system', elgg.parentportalglobal.init);