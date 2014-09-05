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

/**
 * Main entry point for the Task Management Extension
 */

if ( !defined( 'MEDIAWIKI' ) ) {
        echo <<<EOT
To install TM, put the following line in LocalSettings.php:
require_once( "\$IP/extensions/TaskManagement/TaskManagement.php" );
EOT;
        exit( 1 );
}

if ( !defined( 'SMW_VERSION' ) ) {
       echo 'This extension requires Semantic MediaWiki to be installed.';
       exit( 1 );
}

global $smwgIP;

$wgExtensionCredits['other'][] = array(
    'path' => __FILE__,
    'name' => 'Task Management Extension',
    'author' => 'David Kleinmann', 
    'url' => 'https://www.mediawiki.org/wiki/Extension:TaskManagement', 
    'description' => 'This extension is for managing tasks.',
    'descriptionmsg' => 'tm-desc',
    'version'  => 0.1,
);

$tmIP = dirname( __FILE__ );

// register all special pages and other classes
$wgSpecialPages['Tasks'] = 'Tasks';
$wgAutoloadClasses['Tasks'] = $tmIP . '/specials/Tasks.php';
$wgSpecialPageGroups['Tasks'] = 'pages';

// Utils
$wgAutoloadClasses['TaskManagementUtils'] = $tmIP . '/includes/TaskManagementUtils.php';

// Hooks
$wgHooks[ 'sfWritePageData' ][] = 'TaskManagementUtils::insertTaskBoxTemplate';
$wgHooks[ 'sfWritePageData' ][] = 'TaskManagementtils::notifyAssignees';

// Languages & Aliases
$wgExtensionMessagesFiles[ 'TaskManagement' ] = $tmIP . '/TaskManagement.i18n.php';
$wgExtensionMessagesFiles[ 'TaskManagementAlias' ] = $tmIP . '/TaskManagement.alias.php';

