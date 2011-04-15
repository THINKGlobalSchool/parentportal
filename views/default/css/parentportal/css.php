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

.parentportal-header-two-column {
	padding-right: 40px !important;
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

.parentportal-child-profile-contents {
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

#parentportal-module-parent-questions {
	margin-bottom: 10px;
}

#parentportal-module-parent-questions #question-link:hover, #question-link:selected {
	text-decoration: underline;
	color: #555555;
}

#parentportal-module-parent-questions #question-link h3 {
	text-decoration: none;
	color: #9D1520
}

#parentportal-question-form {
	display: none;
}

#parentportal-question-form input textarea table {
	width: 98% !important;
}

#parentportal-question-form td {
	width: 100%;
}

.parentportal-view-all-link {
	width: auto;
	padding: 4px;
	background: #ddd;
	-webkit-border-radius: 8px; 
	-moz-border-radius: 8px;
	font-size: 11px;
}

.elgg-announcement-access-display { 
	display: none;
}

/** Stats **/
#parentportal-child-stats table#stats_table {
	width: 75%;
	margin-top: 10px;
	border-top: 1px solid #CCCCCC;
	border-left: 1px solid #CCCCCC;
	border-right: 1px solid #CCCCCC;
}
#parentportal-child-stats table#stats_table td {
	font-weight: bold;
	font-size: 100%;
	color: #555555;
	padding: 4px;
}

#parentportal-child-stats table#stats_table td.label {
	width: 80%;
	text-shadow: 1px 1px 1px #AAAAAA;
}

#parentportal-child-stats table#stats_table td.stat {
	color: #800518;
	width: 20%;
}

#parentportal-child-stats table#stats_table tr:nth-child(odd) {
	background: #EEEEEE;
	border-bottom: 1px solid #CCCCCC;
}
#parentportal-child-stats table#stats_table tr:nth-child(even) {
	background: #DDDDDD;
	border-bottom: 1px solid #CCCCCC;
}
