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
	
	// Logged in users only
	gatekeeper();
	
	// must have security token 
	action_gatekeeper();
	
	// get input
	$to = get_input('question_to');
	$from_guid = get_input('from_guid');
	$subject = get_input('question_subject');
	$body = get_input('question_body');
	
	// Cache to session
	$_SESSION['user']->is_question_cached = true;
	$_SESSION['user']->question_to = $to;
	$_SESSION['user']->question_subject = $subject;
	$_SESSION['user']->question_body = $body;

	// Check inputs
	if (empty($to)) {
		register_error(elgg_echo('parentportal:error:to'));
		forward($_SERVER['HTTP_REFERER']);
	} 
	if (empty($subject) || $subject == elgg_echo('parentportal:label:questionsubject')) {
		register_error(elgg_echo('parentportal:error:subject'));
		forward($_SERVER['HTTP_REFERER']);
	} 
	if (empty($body) || $body == elgg_echo('parentportal:label:questionbody')) {
		register_error(elgg_echo('parentportal:error:body'));
		forward($_SERVER['HTTP_REFERER']);
	}
	
	$user = get_user_by_username($to);
	$from = get_user($from_guid);
	
	$success = elgg_send_email($from->email, $user->email, $subject, $body);
		
	if ($success) {
		// Clear Cached Data
		remove_metadata($_SESSION['user']->guid, 'is_question_cached');
		remove_metadata($_SESSION['user']->guid,'question_to');
		remove_metadata($_SESSION['user']->guid,'question_subject');
		remove_metadata($_SESSION['user']->guid,'question_message');
		
		// Save successful, forward to index
		system_message(elgg_echo("parentportal:confirm:questionsent"));
		forward($_SERVER['HTTP_REFERER']);
	} else {
		register_error(elgg_echo('parentportal:error:questionsent'));
		forward($_SERVER['HTTP_REFERER']);
	}
?>