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
	<h3 class="pp"><a id='question_link' href='#'><?php echo elgg_echo('parentportal:title:parentquestions') ?></a></h3>
	<div id="parent_question_form">
<?php
	// Display form 
	echo elgg_echo('parentportal:label:havequestions');
	echo "<br /><br />";
	
	$form_vars = array(
		'id' => 'parentportal-submit-question-form',
		'name' => 'parentportal_submit_question_form',
	);
	
	echo elgg_view_form('parentportal/submitquestion', $form_vars);
?>
	</div>
</div><!-- <input type="text" class="feedbackText"  size="30" id="feedback_text" value="Title" name="feedback_title"> -->
<script>
$(document).ready(
	function() {	
		// Hide the question form
		$("#parent_question_form").hide();
			
		$("#question_link").click(
			function () {
				if ($("#parent_question_form").is(":hidden")) {
					$("#parent_question_form").slideDown("fast");
				} else {
					$("#parent_question_form").hide();
				}
				return false;
			}
		);
	}
);
</script>
