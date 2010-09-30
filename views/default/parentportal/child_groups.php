<?php
	/**
	 * Parent Portal Child Groups info
	 *
	 * @package ParentPortal
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Jeff Tilson
	 * @copyright THINK Global School 2010
	 * @link http://www.thinkglobalschool.com/
	 * 
	 */
?>
<div id='child_groups'>
	<h3 class="pp" style='margin-bottom: 2px;'><?php echo elgg_echo("parentportal:title:childgroups"); ?></h3>
	<?php

		$groups = get_users_membership($vars['entity']->getGUID());		
		foreach ($groups as $group) {
			echo elgg_view('parentportal/child_group_listing', array('entity' => $group));
		}

	?>
</div>