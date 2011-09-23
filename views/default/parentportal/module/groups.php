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

echo elgg_list_entities_from_relationship_count(array(
	'type' => 'group',
	'relationship' => 'member',
	'relationship_guid' => $vars['guid'],
	'inverse_relationship' => false,
	'full_view' => false,
	'limit' => get_input('limit', 8),
	'offset' => get_input('offset', 0),
));

