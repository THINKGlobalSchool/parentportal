<?php
/**
 * Parent Portal Custom Module
 *
 * @package ParentPortal
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010
 * @link http://www.thinkglobalschool.com/
 *
 * @uses $vars['container_guid'] 	Container guid for content
 * @uses $vars['tag']				Tag to match
 * @uses $vars['subtypes'] 			Subtypes
 * @uses $vars['limit'] 			Limit to list
 */


// Get and check vars
$container_guid = ($vars['container_guid'] === NULL) ? 0 : $vars['container_guid'];
$tag			= ($vars['tag'] === NULL) ? '' : $vars['tag'];
$subtypes		= (is_array($vars['subtypes'])) ? $vars['subtypes'] : array();
$limit			= ($vars['limit'] === NULL) ? 10 : $vars['limit']; 


global $CONFIG;

$joins[] = "JOIN {$CONFIG->dbprefix}metadata tag_meta_table on e.guid = tag_meta_table.entity_guid";
$joins[] = "JOIN {$CONFIG->dbprefix}metastrings tag_msn on tag_meta_table.name_id = tag_msn.id";
$joins[] = "JOIN {$CONFIG->dbprefix}metastrings tag_msv on tag_meta_table.value_id = tag_msv.id";

$access_sql = get_access_sql_suffix('tag_meta_table');

$wheres[] = "
		e.container_guid IN ({$container_guid})
		OR
		(
			(tag_msn.string IN ('tags')) AND ( BINARY tag_msv.string IN ('{$tag}')) 
			AND
			$access_sql
		)
";


$entities = elgg_list_entities_from_metadata(array(
	'type' => 'object',
	'subtypes' => $subtypes,
	'joins' => $joins,
	'wheres' => $wheres,
	'full_view' => FALSE,
	'limit' => $limit
));

echo $entities;
