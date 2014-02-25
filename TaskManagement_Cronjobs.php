<?php
global $smwgIP;
$IP = realpath( dirname( __FILE__ ) . "/../.." );
require_once( "$IP/maintenance/commandLine.inc" );
require_once( $smwgIP . '/includes/Factbox.php' );
require_once( dirname( __FILE__ ) . '/includes/TaskManagementUtils.php' );

print("START TM REMINDER & DEADLINE EMAILS\n");
TaskManagementUtils::remindAssignees();
print("DONE TM REMINDER & DEADLINE EMAIL\nS");
print("START TM TASKBOX DELETE\n");
TaskManagementUtils::deleteUnneededTaskBoxTemplates();
print("DONE TM TASKBOX DELETE\n");
