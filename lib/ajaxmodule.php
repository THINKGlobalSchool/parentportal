<?php
/**
 * Ajaxmodule lib
 * 
 * @package ???
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010
 * @link http://www.thinkglobalschool.com/
 * 
 */

function am_list_entities_by_group_or_tag($options) {
	
	// Get and check vars
	$container_guid = ($options['container_guid'] === NULL) ? 0 : $options['container_guid'];
	$tag			= ($options['tag'] === NULL) ? '' : $options['tag'];
	$subtypes		= (is_array($options['subtypes'])) ? $options['subtypes'] : array();
	$limit			= ($options['limit'] === NULL) ? 10 : $options['limit']; 
	$offset			= ($options['offset'] === NULL) ? 0 : $options['offset'];
	$title 			= ($options['title'] === NULL) ? 'Custom Module' : $options['title'];

	global $CONFIG;

	$joins[] = "JOIN {$CONFIG->dbprefix}metadata tag_meta_table on e.guid = tag_meta_table.entity_guid";
	$joins[] = "JOIN {$CONFIG->dbprefix}metastrings tag_msn on tag_meta_table.name_id = tag_msn.id";
	$joins[] = "JOIN {$CONFIG->dbprefix}metastrings tag_msv on tag_meta_table.value_id = tag_msv.id";

	$access_sql = get_access_sql_suffix('tag_meta_table');

	// Need to watch the brackets here.. 
	$wheres[] = "
		(
			e.container_guid IN ({$container_guid})
			OR
			(
				(tag_msn.string IN ('tags')) AND ( BINARY tag_msv.string IN ('{$tag}')) 
				AND
				$access_sql
			)
		)
	";
	
	set_context('search');

	$entities = elgg_list_entities_from_metadata(array(
		'type' => 'object',
		'subtypes' => $subtypes,
		'joins' => $joins,
		'wheres' => $wheres,
		'full_view' => FALSE,
		'limit' => $limit,
		'offset' => $offset,
	));
	
	return $entities;
}