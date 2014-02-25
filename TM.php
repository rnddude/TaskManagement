<?php

/**
 * Main entry point for the Task Management (TM) Extension
 */

if ( !defined( 'MEDIAWIKI' ) ) {
        echo <<<EOT
To install TM, put the following line in LocalSettings.php:
require_once( "\$IP/extensions/TM/TM.php" );
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
    'name' => 'Task Management (TM) Extension',
    'author' => 'David Kleinmann', 
    'url' => 'https://www.mediawiki.org/wiki/Extension:TM', 
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
$wgAutoloadClasses['TMUtils'] = $tmIP . '/includes/TMUtils.php';

// Hooks
$wgHooks[ 'sfWritePageData' ][] = 'TMUtils::insertTaskBoxTemplate';
$wgHooks[ 'sfWritePageData' ][] = 'TMUtils::notifyAssignees';

// Languages & Aliases
$wgExtensionMessagesFiles[ 'TM' ] = $tmIP . '/TM.i18n.php';
$wgExtensionMessagesFiles[ 'TMAlias' ] = $tmIP . '/TM.alias.php';

/*
* The following code is part of the GetUserName extension (https://www.mediawiki.org/wiki/Extension%3aGetUserName) by Ejcaputot
* and is distributed under the GPL license. For convenience it has been integrated.
*/
$wgHooks[ 'ParserFirstCallInit' ][] = 'ExtGetUserName::setup';
$wgHooks[ 'LanguageGetMagic' ][]  = 'ExtGetUserName::languageGetMagic';
class ExtGetUserName {
    private static $parserFunctions = array(
        'USERNAME' => 'getUserName',
    );
 
    public static function setup( &$parser ) {
        // register each hook
        foreach( self::$parserFunctions as $hook => $function )
            $parser->setFunctionHook( $hook,
                array( __CLASS__, $function ), SFH_OBJECT_ARGS );
 
        return true;
    }
 
    public static function languageGetMagic( &$magicWords, $langCode ) {
        $magicWords[ 'USERNAME' ] = array( 0, 'USERNAME' ); 
        return true;
    }
 
    public static function getUserName( &$parser, $frame, $args ) {
        $parser->disableCache();
	global $wgUser;
        return trim( $wgUser->getName() );
    }
}
