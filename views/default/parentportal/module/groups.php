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

$title = elgg_echo("parentportal:title:childgroups");

$body = elgg_list_entities_from_relationship_count(array(
	'type' => 'group',
	'relationship' => 'member',
	'relationship_guid' => $vars['entity']->getGUID(),
	'inverse_relationship' => false,
	'full_view' => false,
	'pagination' => false,
	'limit' => 0,
	'offset' => 0,
));

$options = array(
	'id' => 'parentportal-module-child-groups',
	'class' => 'parentportal-module',
);

echo elgg_view_module('featured', $title, $body, $options);
