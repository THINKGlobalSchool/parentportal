<?php
/**
 * ParentPortal Custom Header
 * This file holds the header output that a user will see
 * 
 * Customizations:
 * - No login box
 *
 * @package ParentPortal
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010
 * @link http://www.thinkglobalschool.com
 */

// link back to main site.
echo elgg_view('page/elements/header_logo', $vars);

// insert site-wide navigation
echo elgg_view_menu('site');
