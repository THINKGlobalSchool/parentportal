<?php
/**
 * ParentPortal Question Form
 * 
 * @package ParentPortal
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010 - 2015
 * @link http://www.thinkglobalschool.org/
 * 
 */

// Get contacts from plugin settings
$contacts = elgg_get_plugin_setting('parentcontacts','parentportal');
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

// Get values from sticky form, if any
if (elgg_is_sticky_form('parentportal_question')) {
	$values = elgg_get_sticky_values('parentportal_question');
	elgg_clear_sticky_form('parentportal_question');

	$to = elgg_extract('question_to', $values);
	$from = elgg_extract('question_from', $values);
	$subject = elgg_extract('question_subject', $values);
	$body = elgg_extract('question_body', $values);
}

// Form labels/inputs
$to_label = elgg_echo('parentportal:label:questionto');
$to_input = elgg_view('input/dropdown', array(
	'name' => 'question_to',  
	'options_values' => $contacts_array,
	'value' => $to,
));
									
$from_input = elgg_view('input/hidden', array(
	'name' => 'from_guid',
	'value' => elgg_get_logged_in_user_guid(),
));

$subject_label = elgg_echo('parentportal:label:questionsubject');
$subject_input = elgg_view('input/text', array(
	'name' => 'question_subject', 
	'value' => $subject ? $subject : $subject_label,
	'onblur' => "if (this.value == '') {this.value = '$subject_label';}",
	'onfocus' => "if (this.value == '$subject_label') {this.value = '';}"
));

$body_label = elgg_echo('parentportal:label:questionbody');
$body_input = elgg_view('input/plaintext', array(
	'style' => 'height: 100px;',
	'name' => 'question_body',
	'value' => $body ? $body : $body_label,
	'onblur' => "if (this.value == '') {this.value = '$body_label';}",
	'onfocus' => "if (this.value == '$body_label') {this.value = '';}"
));
										
$send_button = elgg_view('input/submit', array(
	'value' => elgg_echo('Submit')
));

// Form content
$form_body = <<<HTML
	<table>
		<tr>
			<td style='vertical-align: middle;'><label>$to_label</label> $to_input</td>
			<td style='vertical-align: middle;'>$send_button</td>
		</tr>
		<tr>
			<td colspan='2'><br />$subject_input</td>
		</tr>
		<tr>
			<td colspan='2'>$body_input</td>
		</tr>
	</table>
	$from_input
HTML;

echo $form_body;
