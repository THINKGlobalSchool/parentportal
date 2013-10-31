<?php
/**
 * Parent portal question widget
 * 
 * @package ParentPortal
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010 - 2013
 * @link http://www.thinkglobalschool.com/
 *
 */
elgg_load_js('elgg.parentportal');
elgg_load_css('elgg.parentportal');

$questions = elgg_echo('parentportal:label:havequestions');

$form_vars = array(
	'id' => 'parentportal_question',
	'name' => 'parentportal_question',
);

$form .=  elgg_view_form('parentportal/submitquestion', $form_vars);

$body = <<<HTML
	<div id="parentportal-question-form">
		<strong>$questions</strong>
		<br /><br />
		$form
	</div>
HTML;

echo $body;