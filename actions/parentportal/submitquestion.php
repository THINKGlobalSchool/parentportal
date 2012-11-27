<?php
/**
 * ParentPortal Submit Question
 * 
 * @package ParentPortal
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010
 * @link http://www.thinkglobalschool.com/
 * 
 */

// get input
$to = get_input('question_to');
$from_guid = get_input('from_guid');
$subject = get_input('question_subject');
$body = get_input('question_body');

// Make form sticky
elgg_make_sticky_form('parentportal_question');

// Check inputs
if (empty($to)) {
	register_error(elgg_echo('parentportal:error:to'));
	forward(REFERER);
} 
if (empty($subject) || $subject == elgg_echo('parentportal:label:questionsubject')) {
	register_error(elgg_echo('parentportal:error:subject'));
	forward(REFERER);
} 
if (empty($body) || $body == elgg_echo('parentportal:label:questionbody')) {
	register_error(elgg_echo('parentportal:error:body'));
	forward(REFERER);
}

// Get to/from users
$user = get_user_by_username($to);
$from = get_user($from_guid);

// Double check from user
if (!$from) {
	$from = elgg_get_logged_in_user_entity();
}

// Make sure we have a valid to user
if (!elgg_instanceof($user, 'user')) {
	register_error(elgg_echo('parentportal:error:invaliduser'));
	forward(REFERER);
}

// Append text to identify that this email came from Spot
$subject = elgg_echo('parentportal:label:spotquestion', array($subject));

// Before we try sending an email, save a log entity
$question_log = new ElggObject();
$question_log->subtype = "pp_question_log";
$question_log->owner_guid = $from->guid;
$question_log->access_id = ACCESS_PRIVATE;
$question_log->title = $subject;
$question_log->description = $body;
$question_log->to_email = $user->email;

// Make sure log entity saved
if (!$question_log->save()) {
	register_error(elgg_echo('parentportal:error:questionlog'));
	forward(REFERER);
}

try {
	$success = elgg_send_email($from->email, $user->email, $subject, $body);	
} catch (Exception $e) {
	register_error($e->getMessage());
	// Set failed status
	$question_log->status = 0;
	$question_log->status_message = $e->getMessage();
	forward(REFERER);
}

if ($success) {
	// Set success status
	$msg = elgg_echo("parentportal:confirm:questionsent");
	$question_log->status = 1;
	$question_log->status_message = $msg;

	// Clear sticky form
	elgg_clear_sticky_form('parentportal_question');

	// Send successful, forward to index
	system_message($msg);
	forward(REFERER);
} else {
	// Set failed status
	$msg = elgg_echo('parentportal:error:questionsent');
	$question_log->status = 0;
	$question_log->status_message = $msg;\

	register_error($msg);
	forward(REFERER);
}