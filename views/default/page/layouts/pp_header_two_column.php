<?php
/**
 * ParentPortal header, two column layout
 *
 * @package ParentPortal
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010
 * @link http://www.thinkglobalschool.com/
 * 
 */

$params = $vars;

?>
<div id="elgg_content" class="clearfix parentportal-header-two-column" style='margin-bottom: 20px;'>
	
	<div id="pp_top">
		<?php
			if (isset($params['header'])) {
				echo $params['header'];
			}
		?>
	</div>
	
	<div id="pp_left_column" class="clearfix">
		<?php
			if (isset($params['left_column'])) {
				echo $params['left_column'];
			}
		?>
	</div>
	
	<div id="pp_right_column" class="clearfix">
		<?php 
			if (isset($params['right_column'])) {
				echo $params['right_column'];
			}
		?>
	</div>
</div>
