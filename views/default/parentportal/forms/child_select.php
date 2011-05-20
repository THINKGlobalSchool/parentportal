<?php
	/**
	 * ParentPortal Child Select Form
	 * 
	 * @package ParentPortal
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Jeff Tilson
	 * @copyright THINK Global School 2010
	 * @link http://www.thinkglobalschool.com/
	 * 
	 */
	
	$script = "<script type='text/javascript'>
					$(document).ready(function() {							
						// Submit form on change event
						$('#select_child').change(function() {
						    this.submit();
						});
					});			
				</script>";
	
	$children = $vars['children'];
	
	
	$children_array = array();
	foreach ($children as $child) {
		$children_array[$child->getGUID()] = $child->name;
	}
		
	// Form labels/inputs
	$select_label = elgg_echo('parentportal:label:selectchild');
	$select_input = elgg_view('input/pulldown', array(
											'internalname' => 'child_select',  
											'options_values' => $children_array,
											'value' => $_SESSION['child_select'],
											));
			
	// Form content
	$form_body = <<<EOT
		$select_label</b> $select_input 
		$send_button
EOT;
	
	echo '<br />' . $script . elgg_view('input/form', array(
		'internalid' => 'select_child',
		'internalname' => 'select_child',
		'action' => "{$vars['url']}pg/parentportal?tab=student",
		'body' => $form_body
	));
?>