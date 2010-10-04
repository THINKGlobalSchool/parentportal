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
ul.childlisting {
	list-style: none;
	margin:0;
	padding:0;
}

ul.childlisting li {
	border-bottom:1px solid #CCCCCC;
	clear:both;
	height:25px;
	margin-top:5px;
	padding:5px;
}

ul.childlisting li:first-child {
	border-top:1px solid #cccccc;
}

.pp_top_two_column {
	padding-right: 40px !important;
}

.pp_top_two_column #pp_top {
	width: 100%;
	padding: 10px;
}

.pp_top_two_column #pp_left_column {
	min-width: 47%;
	max-width: 47%;
	margin: 0;
	padding: 10px;	
	float: left;
}

.pp_top_two_column #pp_right_column {
	width: 47%;
	max-width: 47%;
	margin: 0;
	padding: 10px;
	float: right;
}

#child_block {
	margin-top: 5px;
	padding: 8px 6px 6px 6px;
	background: #ddd;
	-webkit-border-radius: 8px; 
	-moz-border-radius: 8px;
	-moz-box-shadow: 1px 1px 0px #999;
	-webkit-box-shadow: 1px 1px 0px #999;
}

#child_activity {
	/*margin-top: 10px;*/
}

#child_groups {
	margin-top: 10px;
}

#child_todo {
	margin-top: 10px;
}

h3.pp {
	background: #E4E4E4;
	border-top-left-radius: 4px 4px;
	-webkit-border-radius: 4px;
	-moz-border-radius: 4px;
	-moz-box-shadow: 1px 1px 0px #999;
	-webkit-box-shadow: 1px 1px 0px #999;
	color: #333;
	padding: 5px 5px 3px;
}

.child_block_icon {
	margin-right: 10px;
	width: 200px;
}

.child_block_contents {
}

.child_profile_info.briefdescription {
	font-size: 90%;
	line-height:1.2em;
	font-style: italic;
}

.child_profile_info.location {
	font-size: 90%;
}

.child_profile_info {
	margin:0;
	padding:0;
	color: #666666;
}


#parent_announcements {
	margin-top: 10px;
}

#parent_infocenter {
	margin-top: 10px;
}

#parent_questions {
	margin-bottom: 10px;
}

#parent_questions #question_link:hover, #question_link:selected {
	text-decoration: underline;
	color: #555555;
}

#parent_questions #question_link h3 {
	text-decoration: none;
	color: #9D1520
}

#parent_info_block {
	height: 200px;
	margin-top: 10px;
	background: #ddd;
	padding: 10px;
	-webkit-border-radius: 8px; 
	-moz-border-radius: 8px;
	-moz-box-shadow: 1px 1px 0px #999;
	-webkit-box-shadow: 1px 1px 0px #999;
}

#parent_question_form {
	margin-top: 10px;	
}

#parent_question_form input textarea table {
	width: 98% !important;
}

#parent_question_form td {
	width: 100%;
}

/** Stats **/
.child_stats table#stats_table {
	width: 75%;
	margin-top: 10px;
	border-top: 1px solid #CCCCCC;
	border-left: 1px solid #CCCCCC;
	border-right: 1px solid #CCCCCC;
}
.child_stats table#stats_table td {
	font-weight: bold;
	font-size: 100%;
	color: #555555;
	padding: 4px;
}

.child_stats table#stats_table td.label {
	width: 80%;
	text-shadow: 1px 1px 1px #AAAAAA;
}

.child_stats table#stats_table td.stat {
	color: #800518;
	width: 20%;
}

.child_stats table#stats_table tr.odd {
	background: #EEEEEE;
	border-bottom: 1px solid #CCCCCC;
}
.child_stats table#stats_table tr.even {
	background: #DDDDDD;
	border-bottom: 1px solid #CCCCCC;
}


