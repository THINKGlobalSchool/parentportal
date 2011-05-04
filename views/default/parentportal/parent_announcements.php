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
		$offset = get_input('offset', 0);
		
		$group = get_entity(get_plugin_setting('parentgroup','parentportal'));
				
		$tag = get_plugin_setting('parenttag', 'parentportal');
		
		// Check to make sure the group is setup
		if ($group) {
			$entities = elgg_get_entities(array(
				'type' => 'object',
				'subtypes' => array('blog', 'thewire'),
				'container_guid' => $group->getGUID(),
				//'group_by' => 'e.guid', ...why??
				'limit' => 0,
			));
		} else {
			register_error('No parent group');
		}
	
		
		if ($tag) {
			$tag_entities = elgg_get_entities_from_metadata(array(
				'type' => 'object',
				'subtypes' => array('blog', 'thewire'),
				'metadata_name_value_pairs' => array(	'name' => 'tags', 
														'value' => $tag, 
														'operand' => '=',
														'case_sensitive' => FALSE),
				'limit' => $limit
			));
		}
		
		// Make sure we have something 
		if (!$entities) {
			$entities = array();
		}
		
		if (!$tag_entities) {
			$tag_entities = array();
		}

		$entities = array_merge($entities, $tag_entities);
		usort($entities, "compare_entities_updated_dates");	
		
		$entities = array_slice($entities, $offset, $limit);
		
		foreach ($entities as $idx => $entity) {
			if ($entity->getSubtype() == 'blog') {
				$body .=  elgg_view('parentportal/announcement_blog', array('entity' => $entity));
			} else if ($entity->getSubtype() == 'thewire') {
				$body .= elgg_view('parentportal/announcement_wire', array('entity' => $entity));
			} else {
				unset($entities[$idx]);
				continue;
			} 
		}
		
		if (!$body) {
			$body .= '<center>' . elgg_echo('parentportal:label:noannouncements') . '</center>';
		} 
		
		echo $body;
?>
</div>