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
$incomplete_todos = get_users_todos($vars['entity']->getGUID());
$complete_todos = array();

$selected = get_input('selected', 'complete');
									
foreach ($incomplete_todos as $idx => $todo) {
	if (have_assignees_completed_todo($todo->getGUID())) {
		$complete_todos[] = $todo;
		unset($incomplete_todos[$idx]);
	} 
}

//Content for tabs
if ($complete_todos) {
	$complete_todos_content = elgg_view('parentportal/todo_simple_listing', array('todos' => $complete_todos, 'count' => 10)) . "<br /><span class='parentportal-view-all-link'><a href='{$vars['url']}todo/{$vars['entity']->username}?status=complete'>View all complete</a></span>";
} else {
	$complete_todos_content = "<center>No " . elgg_echo('parentportal:label:todo:complete') . "</center>";
}

if ($incomplete_todos) {
	$incomplete_todos_content = elgg_view('parentportal/todo_simple_listing', array('todos' => $incomplete_todos, 'count' => 10)) . "<br /><span class='parentportal-view-all-link'><a href='{$vars['url']}todo/{$vars['entity']->username}?status=incomplete'>View all incomplete</a></span>";
} else {
	$incomplete_todos_content = "<center>No " . elgg_echo('parentportal:label:todo:incomplete') . "</center>";
}

// Build up tab array with id's, labels, and content	
$tabs = array(array('id' => 'tab_complete', 
					'label' => elgg_echo('parentportal:label:todo:complete'), 
					'content' => $complete_todos_content
			  ),
			  array('id' => 'tab_incomplete', 
					'label' => elgg_echo('parentportal:label:todo:incomplete'), 
					'content' => $incomplete_todos_content
			  )
		);
 		
// Set default tab	  
foreach ($tabs as $tab) {
	if ($vars['tab'] == $tab['id'])
		$selected_tab = $vars['tab'];
}
if (!$selected_tab)
	$selected_tab = 'tab_complete';
	

// Build tab nav and content
for ($i = 0; $i < count($tabs); $i++) {
	// Tab Nav
	$selected = ($selected_tab == $tabs[$i]['id']) ? "selected" : ""; 
	$tab_items .= "<li id='{$tabs[$i]['id']}' class='$selected edt_tab_nav'><a href=\"javascript:ppChildTodoSwitchTab('{$tabs[$i]['id']}')\">{$tabs[$i]['label']}</a></li>";
	// Tab Content
	$tabcontent .= "<div class='child_todo_listing' id='{$tabs[$i]['id']}'>{$tabs[$i]['content']}</div>";
}

$content = <<<HTML
	$entities
	<div id='parentportal-module-child-todo'>
		<h3 class="pp">$title</h3>
		<div class="elgg_horizontal_tabbed_nav margin_top">
			<ul>
				$tab_items
			</ul>
		</div>
		<br />
		$tabcontent
	</div>
HTML;

$script = <<<HTML
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
HTML;

echo $script . $content;
