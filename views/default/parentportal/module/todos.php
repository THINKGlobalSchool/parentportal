<?php
/**
 * Parent Portal Child todo content
 * 
 * @package ParentPortal
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010
 * @link http://www.thinkglobalschool.com/
 * 
 */
// How are we viewing these todos? 
$view_filter = $vars['view_filter'];
$user_guid = $vars['guid'];

// Use modules' simpleicon view here
set_input('ajaxmodule_listing_type', 'simpleicon');


// get the user's todos, will be seperating complete/incomplete
global $CONFIG;

$test_id = get_metastring_id('manual_complete');
$one_id = get_metastring_id(1);
$wheres = array();

		
$relationship = COMPLETED_RELATIONSHIP;

$options = array(
	'type' => 'object',
	'subtype' => 'todo',
	'relationship' => TODO_ASSIGNEE_RELATIONSHIP, 
	'relationship_guid' => $user_guid, 
	'inverse_relationship' => FALSE,
	'metadata_name' => 'status',
	'metadata_value' => TODO_STATUS_PUBLISHED,
	'order_by_metadata' => array('name' => 'due_date', 'as' => 'int', 'direction' => 'DESC'),
	'full_view' => FALSE,
	'pagination' => TRUE,
	'limit' => get_input('limit', 8),
	'offset' => get_input('offset', 0),
);

switch($view_filter) {
	case 'complete':
	default:
		// COMPLETE
		$wheres = array();
		$wheres[] = "(EXISTS (
				SELECT 1 FROM {$CONFIG->dbprefix}entity_relationships r2 
				WHERE r2.guid_one = '$user_guid'
				AND r2.relationship = '$relationship'
				AND r2.guid_two = e.guid) OR 
					EXISTS (
				SELECT 1 FROM {$CONFIG->dbprefix}metadata md
				WHERE md.entity_guid = e.guid
					AND md.name_id = $test_id
					AND md.value_id = $one_id))";

		$options['wheres'] = $wheres;
		break;
	case 'past_due':
		// Past Due
		$options['metadata_name_value_pairs'] = array(
			array(
				'name' => 'status',
				'value' => TODO_STATUS_PUBLISHED, 
				'operand' => '='),
			array(
				'name' => 'due_date',
				'value' => time(),
				'operand' => '<',
		));
		$options['metadata_name_value_pairs_operator'] = 'AND';
		// Past Due
		$wheres[] = "NOT EXISTS (
				SELECT 1 FROM {$CONFIG->dbprefix}metadata md
				WHERE md.entity_guid = e.guid
					AND md.name_id = $test_id
					AND md.value_id = $one_id)";

		$wheres[] = "NOT EXISTS (
				SELECT 1 FROM {$CONFIG->dbprefix}entity_relationships r2 
				WHERE r2.guid_one = '$user_guid'
				AND r2.relationship = '$relationship'
				AND r2.guid_two = e.guid)";

		$options['wheres'] = $wheres;
		break;
	case 'incomplete':
		// Incomplete
		$wheres = array();
		$wheres[] = "NOT EXISTS (
				SELECT 1 FROM {$CONFIG->dbprefix}metadata md
				WHERE md.entity_guid = e.guid
					AND md.name_id = $test_id
					AND md.value_id = $one_id)";

		$wheres[] = "NOT EXISTS (
				SELECT 1 FROM {$CONFIG->dbprefix}entity_relationships r2 
				WHERE r2.guid_one = '$user_guid'
				AND r2.relationship = '$relationship'
				AND r2.guid_two = e.guid)";

		$options['wheres'] = $wheres;
		break;
}

echo elgg_list_entities_from_relationship($options);

