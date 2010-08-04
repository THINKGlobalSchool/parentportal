<?php
	/**
	 * Parent Portal Child latest activity
	 *
	 * @package ParentPortal
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Jeff Tilson
	 * @copyright THINK Global School 2010
	 * @link http://www.thinkglobalschool.com/
	 * 
	 */
?>
<div id='child_activity'>
	<h3 class="pp"><?php echo elgg_echo("parentportal:title:childactivity"); ?></h3>
	<?php

		$limit = 10;
		$offset = (int) get_input('offset', 0);
		$limit = (int) $limit;
		$offset = (int) $offset;

		$river_items = elgg_view_river_items($vars['entity']->getGuid(), 0, '', '', '', 'create', $limit,0,0,false,false);

	    if (count($items) > 0) {
			$river_items = elgg_view('river/item/list',array(
									'limit' => $limit,
									'offset' => $offset,
									'items' => $items
									));
		}
		echo $river_items;

	?>
</div>