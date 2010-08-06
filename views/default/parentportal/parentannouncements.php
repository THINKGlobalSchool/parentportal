<?php
	/**
	 * Parent Portal Announcement list
	 * 
	 * @package ParentPortal
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Jeff Tilson
	 * @copyright THINK Global School 2010
	 * @link http://www.thinkglobalschool.com/
	 * 
	 */
	
?>
<div id="parent_announcements">
	<h3 class="pp"><?php echo elgg_echo('parentportal:title:parentannouncements') ?></h3>
	<?php	
		$limit = get_input('limit', 20);
		$channel = get_entity(get_plugin_setting('parentchannel','parentportal'));
		$entities = elgg_get_entities_from_access_id(array(
			'access_id' => $channel->acl_id,
			'group_by' => 'e.guid',
		));
		$entity_guids = array();
		foreach ($entities as $entity) {
			if ($entity->getSubtype() == 'blog' || $entity->getSubtype() == 'thewire') {
				$entity_guids[] = $entity->getGUID();
			}
		}

		if (count($entity_guids) > 0) {
			$body = elgg_view_river_items('', $entity_guids, '', '', '', '', $limit);
		} else {
			$body .= '<center>' . elgg_echo('parentportal:label:noannouncements') . '</center>';
		}
		
		echo $body;
?>
</div>