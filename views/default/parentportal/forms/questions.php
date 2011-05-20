<?php
	/**
	 * ParentPortal Question Form
	 * 
	 * @package ParentPortal
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Jeff Tilson
	 * @copyright THINK Global School 2010
	 * @link http://www.thinkglobalschool.com/
	 * 
	 */
	
	// Get contacts from plugin settings
	$contacts = get_plugin_setting('parentcontacts','parentportal');
	$contacts = explode("\n", $contacts);
	$contacts_array = array();
	foreach ($contacts as $idx => $contact) {
		$contacts[$idx] = explode("-", $contact);
		foreach ($contacts[$idx] as $key => $info) {
				$contacts[$idx][$key]= trim($info);
		}
		$user = get_user_by_username($contacts[$idx][0]);
		$contacts_array[$contacts[$idx][0]] = $user->name . ' - ' . $contacts[$idx][1]; 
	} 	
	
	// Load cached data (result of an error)
	if ($vars['user']->is_question_cached) {
		$to 		= $vars['user']->question_to;
		$subject 	= $vars['user']->question_subject;
		$body 		= $vars['user']->question_body;
	}
	
	// Form labels/inputs
	$to_label = elgg_echo('parentportal:label:questionto');
	$to_input = elgg_view('input/pulldown', array(
											'internalname' => 'question_to',  
											'options_values' => $contacts_array,
											'value' => $to,
											));
										
	$from_input = elgg_view('input/hidden', array(
											'internalname' => 'from_guid',
											'value' => get_loggedin_userid(),
											));

	$subject_label = elgg_echo('parentportal:label:questionsubject');
	$subject_input = elgg_view('input/text', array(
											'internalname' => 'question_subject', 
											'value' => $subject ? $subject : $subject_label,
											'js' => "onblur=\"if (this.value == '') {this.value = '$subject_label';}\" onfocus=\"if (this.value == '$subject_label') {this.value = '';}\""
											));
	
	$body_label = elgg_echo('parentportal:label:questionbody');
	$body_input = elgg_view('input/plaintext', array(
											'internalname' => 'question_body',
											'value' => $body ? $body : $body_label,
											'js' => "style='height: 100px' onblur=\"if (this.value == '') {this.value = '$body_label';}\" onfocus=\"if (this.value == '$body_label') {this.value = '';}\""
											));
											
	$send_button = elgg_view('input/submit', array('value' => elgg_echo('Submit'), 'class' => 'submit_button'));

	// Form content
	$form_body = <<<EOT
		<table>
			<tr>
				<td style='vertical-align: middle;'><label>$to_label</label> $to_input</td>
				<td style='vertical-align: middle;'>$send_button</td>
			</tr>
			<tr>
				<td colspan='2'>$subject_input</td>
			</tr>
			<tr>
				<td colspan='2'>$body_input</td>
			</tr>
		</table>
		$from_input
EOT;
	
	echo elgg_view('input/form', array(
		'internalid' => 'manage_parent',
		'internalname' => 'manage_parent',
		'action' => "{$vars['url']}action/parentportal/submitquestion",
		'body' => $form_body
	));
?>