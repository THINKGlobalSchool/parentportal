<?php
	/**
	 * Parent Portal Child ToDo list
	 * 
	 * @package ParentPortal
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Jeff Tilson
	 * @copyright THINK Global School 2010
	 * @link http://www.thinkglobalschool.com/
	 * 
	 */
			
	$title = elgg_echo('parentportal:title:childtodos');		
			
	// get the user's todos, will be seperating complete/incomplete
	global $CONFIG;

	$test_id = get_metastring_id('manual_complete');
	$one_id = get_metastring_id(1);
	$wheres = array();

	$user_guid = $vars['entity']->getGUID();		
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
	);

	// Complete
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

	$complete_todos = elgg_get_entities_from_relationship($options);

	$wheres = array();
	
	// Incomplete
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
	
	$incomplete_todos = elgg_get_entities_from_relationship($options);

	
	//Content for tabs
	if ($complete_todos) {
		$complete_todos_content = elgg_view('parentportal/todo_simple_listing', array('todos' => $complete_todos, 'count' => 10)) . "<br /><span class='pp_see_all'><a href='{$vars['url']}pg/todo/{$vars['entity']->username}?status=complete'>View all complete</a></span>";
	} else {
		$complete_todos_content = "<center>No " . elgg_echo('parentportal:label:todo:complete') . "</center>";
	}
	
	if ($incomplete_todos) {
		$incomplete_todos_content = elgg_view('parentportal/todo_simple_listing', array('todos' => $incomplete_todos, 'count' => 10)) . "<br /><span class='pp_see_all'><a href='{$vars['url']}pg/todo/{$vars['entity']->username}?status=incomplete'>View all incomplete</a></span>";
	} else {
		$incomplete_todos_content = "<center>No " . elgg_echo('parentportal:label:todo:incomplete') . "</center>";
	}
	
	// Build up tab array with id's, labels, and content	
	$tabs = array(
				array(
					'id' => 'tab_incomplete', 
					'label' => elgg_echo('parentportal:label:todo:incomplete'), 
					'content' => $incomplete_todos_content
				),
				array(
					'id' => 'tab_complete', 
					'label' => elgg_echo('parentportal:label:todo:complete'), 
					'content' => $complete_todos_content
				 )
			);
	 		
	// Set default tab	  
	foreach ($tabs as $tab) {
		if ($vars['tab'] == $tab['id'])
			$selected_tab = $vars['tab'];
	}
	if (!$selected_tab) {
		$selected_tab = 'tab_incomplete';
	}
		
	
	// Build tab nav and content
	for ($i = 0; $i < count($tabs); $i++) {
		// Tab Nav
		$selected = ($selected_tab == $tabs[$i]['id']) ? "selected" : ""; 
		$tab_items .= "<li id='{$tabs[$i]['id']}' class='$selected edt_tab_nav'><a href=\"javascript:ppChildTodoSwitchTab('{$tabs[$i]['id']}')\">{$tabs[$i]['label']}</a></li>";
		// Tab Content
		$tabcontent .= "<div class='child_todo_listing' id='{$tabs[$i]['id']}'>{$tabs[$i]['content']}</div>";
	}
	
	$content = <<<EOT
		$entities
		<div id='child_todo'>
			<h3 class="pp">$title</h3>
			<div class="elgg_horizontal_tabbed_nav margin_top">
				<ul>
					$tab_items
				</ul>
			</div>
			<br />
			$tabcontent
		</div>
EOT;

	$script = <<<EOT
	<script type="text/javascript">
	
	$(document).ready(function() {
		$(".child_todo_listing").hide();
		$("div#$selected_tab").show();
	});

	function ppChildTodoSwitchTab(tab_id)
	{
		var nav_name = "li#" + tab_id;
		var tab_name = "div#" + tab_id;

		$(".child_todo_listing").hide();
		$(tab_name).show();
		$(".edt_tab_nav").removeClass("selected");
		$(nav_name).addClass("selected");
	}
	</script>
EOT;

	echo $script . $content;
	
	
?>