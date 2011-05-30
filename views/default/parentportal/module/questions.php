<?php
/**
 * Parent Portal Question Form Content
 * 
 * @package ParentPortal
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010
 * @link http://www.thinkglobalschool.com/
 * 
 */

$title = elgg_echo('parentportal:title:parentquestions');

$questions = elgg_echo('parentportal:label:havequestions');

$form_vars = array(
	'id' => 'parentportal-submit-question-form',
	'name' => 'parentportal_submit_question_form',
);

$form .=  elgg_view_form('parentportal/submitquestion', $form_vars);

$body = <<<HTML
	<div id="parentportal-question-form">
		<strong>$questions</strong>
		<br /><br />
		$form
	</div>
HTML;

$options = array(
	'id' => 'parentportal-module-parent-questions',
	'class' => 'parentportal-module',
);

echo elgg_view_module('featured', $title, $body, $options);
