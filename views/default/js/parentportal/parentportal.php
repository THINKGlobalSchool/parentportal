<?php
/**
 * ParentPortal JS
 * 
 * @package ParentPortal
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010
 * @link http://www.thinkglobalschool.com/
 * 
 */
?>
//<script>
elgg.provide('elgg.parentportal');

elgg.parentportal.init = function() {
	// Submit child select form on change event
	$('#parentportal-select-child-form').change(function() {
	    this.submit();
	});
	
	// Make todo nav menu items clickable
	$(".parentportal-todos-nav").live('click', elgg.parentportal.todoNavClick);

	$(".parentportal-submissions-filter").live('click', elgg.parentportal.todoSubmissionFilterClick);
}

/**
 * Todo nav menu item click handler
 */
elgg.parentportal.todoNavClick = function(event) {	
	// Remove selected states
	$(this).parent().parent().find('li').removeClass('elgg-state-selected');
	
	// Add selected state to this item
	$(this).parent().addClass('elgg-state-selected');
	
	// Hide all content
	$('.parentportal-todos-content').hide();
	
	// The id to show is supplied as the items href
	$($(this).attr('href')).show();
	
	event.preventDefault();
}

/** 
 * Handle todo submission filter click
 */
elgg.parentportal.todoSubmissionFilterClick = function(event) {

	$(".parentportal-submissions-filter").removeClass('selected');
	$(this).addClass('selected');

	$(this).parent().parent().html("<div class='elgg-ajax-loader'></div>").load($(this).attr('href'));;

	event.preventDefault();
}




elgg.register_hook_handler('init', 'system', elgg.parentportal.init);