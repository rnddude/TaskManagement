<?php
/**
 * Copyright (C) 2014  David Kleinmann
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software Foundation,
 * Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301  USA
 */
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
