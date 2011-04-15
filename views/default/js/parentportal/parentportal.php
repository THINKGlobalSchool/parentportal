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
}

elgg.register_hook_handler('init', 'system', elgg.parentportal.init);
//</script>
