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
	
	$false_sql = "FALSE";
	
	if ($options['container_guid']) {
		$container_sql = "e.container_guid IN ({$options['container_guid']})";
	} else {
		$container_sql = "FALSE";
	}
	
	if ($options['tag']) {
		$access_sql = get_access_sql_suffix('tag_meta_table');
		$tag_sql = "
			(
				(tag_msn.string IN ('tags')) AND ( BINARY tag_msv.string IN ('{$options['tag']}')) 
				AND
				$access_sql
			)
		";
	} else {
		$tag_sql = "FALSE";
	}
		
	$subtypes		= (is_array($options['subtypes'])) ? $options['subtypes'] : array();
	$limit			= ($options['limit'] === NULL) ? 10 : $options['limit']; 
	$offset			= ($options['offset'] === NULL) ? 0 : $options['offset'];
	$title 			= ($options['title'] === NULL) ? 'Custom Module' : $options['title'];
	
	global $CONFIG;

	$joins[] = "JOIN {$CONFIG->dbprefix}metadata tag_meta_table on e.guid = tag_meta_table.entity_guid";
	$joins[] = "JOIN {$CONFIG->dbprefix}metastrings tag_msn on tag_meta_table.name_id = tag_msn.id";
	$joins[] = "JOIN {$CONFIG->dbprefix}metastrings tag_msv on tag_meta_table.value_id = tag_msv.id";

	// As long as we have either a container_guid or a tag, use the $wheres
	if ($container_sql != $false_sql || $tag_sql != $false_sql) {
		// Need to watch the brackets here.. 
		$wheres[] = "
			(
				$container_sql
				OR
				$tag_sql
			)
		";
	}
	
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
	
	if ($entities) {
		return $entities;
	} else {
		return "<div style='width: 100%; text-align: center; margin: 10px;'><strong>No results</strong></div>";
	}
}