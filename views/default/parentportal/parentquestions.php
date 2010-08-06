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
	
?>
<div id="parent_questions">
	<h3 class="pp"><?php echo elgg_echo('parentportal:title:parentquestions') ?></h3>
	<div id="parent_question_form">
	<?php
		// Display form 
		echo elgg_echo('parentportal:label:havequestions');
		echo "<br /><br />";
		echo elgg_view('parentportal/forms/questions');
	?>
	</div>
</div><!-- <input type="text" class="feedbackText"  size="30" id="feedback_text" value="Title" name="feedback_title"> -->