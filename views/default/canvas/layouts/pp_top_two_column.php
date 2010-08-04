<?php
/**
 * ParentPortal top 2 column canvas layout
 *
 * @package ParentPortal
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010
 * @link http://www.thinkglobalschool.com/
 * 
 */
?>
<div id="elgg_content" class="clearfloat pp_top_two_column">
	
	<div id="pp_top">
		<?php
			if (isset($vars['area1'])) {
				echo $vars['area1'];
			}
		?>
	</div>
	
	<div id="pp_left_column" class="clearfloat">
		<?php
			if (isset($vars['area2'])) {
				echo $vars['area2'];
			}
		?>
	</div>
	
	<div id="pp_right_column" class="clearfloat">
		<?php 
			if (isset($vars['area3'])) {
				echo $vars['area3'];
			}
		?>
	</div>
</div>
