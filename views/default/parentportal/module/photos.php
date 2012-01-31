<?php
/**
 * Parent Portal Child Groups info
 *
 * @package ParentPortal
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010
 * @link http://www.thinkglobalschool.com/
 * 
 */

elgg_push_context('ajaxmodule');
$content .= elgg_list_entities_from_relationship(array(
	'relationship' => 'phototag', 
	'relationship_guid' => $vars['guid'], 
	'inverse_relationship' => false,
	'types' => 'object', 
	'subtypes' => 'image', 
	'full_view'=> false,
	'list_type' => 'gallery',
	'limit' => 9,
)); 	

if (!$content) {
	echo "<h3 class='center'>" . elgg_echo('parentportal:label:noresults') . "</h3>"; 
} else {
	echo $content;
}
elgg_pop_context();