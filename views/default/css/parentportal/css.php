<?php
/**
 * ParentPortal CSS
 * 
 * @package ParentPortal
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010
 * @link http://www.thinkglobalschool.com/
 * 
 */
?>
ul.parentportal-child-list {
	list-style: none;
	margin:0;
	padding:0;
}

ul.parentportal-child-list li {
	border-bottom:1px solid #CCCCCC;
	clear:both;
	height:25px;
	margin-top:5px;
	padding:5px;
}

ul.parentportal-child-list li:first-child {
	border-top:1px solid #cccccc;
}

.parentportal-header {
	
}

.parentportal-header-two-column #pp_top {
	width: 98%;
	padding: 10px;
	padding-right: 50px;
}

.parentportal-header-two-column #pp_left_column {
	min-width: 47%;
	max-width: 47%;
	margin: 0;
	padding: 10px;	
	float: left;
}

.parentportal-header-two-column #pp_right_column {
	width: 47%;
	max-width: 47%;
	margin: 0;
	padding: 10px;
	float: right;
}

.parentportal-child-profile-icon {
	margin-right: 10px;
	width: 200px;
}

.parentportal-child-profile-info.briefdescription {
	font-size: 90%;
	line-height:1.2em;
	font-style: italic;
}

.parentportal-child-profile-info.location {
	font-size: 90%;
}

.parentportal-child-profile-info {
	margin:0;
	padding:0;
	color: #666666;
}

#parentportal-question-form input textarea table {
	width: 98% !important;
}

#parentportal-question-form td {
	width: 100%;
}

.parentportal-view-all-link {
	width: auto;
	font-size: 11px;
	float: right;
}

.elgg-announcement-access-display { 
	display: none;
}

/** Todo Module **/
#parentportal-todos-complete, #parentportal-todos-pastdue {
	display: none;
}

a.parentportal-submissions-filter {
	text-transform: uppercase;
	color: #666;
}

a.parentportal-submissions-filter.selected {
	color: #000;
}

div.parentportal-submissions-filter-container {
	float: right;
	font-size: 11px;
	font-weight: bold;
    margin-right: 10px;
}

/** Child photos **/
#pp-photos-module ul.elgg-gallery li {
	margin: 6px;
}

/** Stats **/
#parentportal-child-stats table#parentportal-stats-table {
	margin-top: 10px;
}

#parentportal-child-stats table#parentportal-stats-table td {
	font-weight: bold;
}

#parentportal-child-stats table#parentportal-stats-table td.label {
	color: #333333;
}

#parentportal-child-stats table#parentportal-stats-table td.stat {
	color: #800518;
}

/** Columns **/
#pp_right_column > div.elgg-output, #pp_left_column > div.elgg-output {
	margin-top: 0;
}

/** What's this popup **/
.parentportal-small {
	font-size: 85% !important; 
}

.parentportal-popup { 
	position: absolute;
	border: 1px solid #bbb;
    background-color: #fff;
    width: 200px;
	padding: 5px;
	height: auto;
	top: -2em;
	text-align: left;
	display: block;
}

/** Tag for parents **/
.elgg-menu-item-tag-for-parents {
	background-position: 0 -1044px !important;
}

.elgg-widget-instance-parentportal_forparentsactivity ul.elgg-menu-widget {
	float: right;
}
