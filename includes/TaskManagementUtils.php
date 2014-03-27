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
 * Helper functions for the Task Management extension.
 *
 * @author rnddude
 * @file
 */
 
 if ( !defined( 'MEDIAWIKI' ) ) {
       echo 'Not a valid entry point';
       exit( 1 );
}

if ( !defined( 'SMW_VERSION' ) ) {
       echo 'This extension requires Semantic MediaWiki to be installed.';
       exit( 1 );
}

class TaskManagementUtils {

	static function insertTaskBoxTemplate($form, $title, $targetContent) {

		$teile = explode("ask:", $targetContent);
		$temp = explode("| format=list",$teile[1]);

		$results = self::getQueryResults( $temp[0], array('title'), true );
        if ( $results->getCount()===0 ) {
        	return FALSE;
        }
        
		while ($row = $results->getNext()) {
			$entityTitle = $row[0]->getNextObject();
			$targetTitle = Title::newFromText($entityTitle->getLongWikiText());
			if ( !$targetTitle instanceof Title ) {
                                throw new MWException(wfMessage('tm-error-title'));
                        }
                        $page = new WikiPage( $targetTitle );
                        $content = $page->getContent();
                        if (strpos($page->getText(),'{{TaskBox}}') === false) {
                                $page->doEditContent(new WikitextContent('{{TaskBox}}'.$content->getNativeData()),wfMessage('tm-tasbox-added'),EDIT_MINOR);
			}
                }
                return TRUE;
        }

	function deleteUnneededTaskBoxTemplates() {
    	$results = self::getQueryResults( "[[Category:Page with Task]]", array('title'), true );
        if ( $results->getCount()===0 ) {
        	return FALSE;
        }
		
		while ($row = $results->getNext()) {
			$pageTitle = $row[0]->getNextObject();
			$targetTitle = Title::newFromText($pageTitle->getLongWikiText());
                        if ( !$targetTitle instanceof Title ) {
                                throw new MWException(wfMessage('tm-error-title'));
                        }
                        $page = new WikiPage( $targetTitle );
                        $content = $page->getContent();
                        if (strpos($content->getNativeData(),'{{TaskBox}}') !== false) {
							$resultsTasks = self::getQueryResults( "[[Category:Task(s)]] [[Entity::".$pageTitle->getLongWikiText()."]]", array('title'), true );
							if ( $resultsTasks->getCount()===0) {
               					$newContent = new WikitextContent(str_replace('{{TaskBox}}','',$content->getNativeData()));
								$page->doEditContent($newContent,wfMessage('tm-tasbox-removed'),EDIT_MINOR);
							}
                        }
		}
                return TRUE;
    }

	/**
	* The following two functions are based on code frome the extension Semantic Tasks by Steren Giannini & Ryan Lane
	* released under GNU GPLv2 (or later)
	* http://www.mediawiki.org/wiki/Extension:Semantic_Tasks
	*/
	function remindAssignees() {
		global $wgSitename, $wgServer, $wgScriptPath, $wgNoReplyAddress;

		$user_mailer = new UserMailer();

		$t = getdate();
		$today = date( 'd F Y', $t[0] );

		$query_string = "[[reminder::".$today."]][[deadline::>".$today."]]";
		
		$properties_to_display = array( 'reminder', 'assignee', 'deadline' );

		$results = self::getQueryResults( $query_string, $properties_to_display, true );
		if ( $results->getCount()===0 ) {
			return FALSE;
		}

		$sender = new MailAddress( $wgNoReplyAddress, $wgSitename );
		
		while ( $row = $results->getNext() ) {
			$task_name = $row[0]->getNextObject()->getTitle();
			
			$subject = '[' . $wgSitename . '] ' . wfMsg( 'tm-reminder' ) . ' ' . $task_name;
			$link = $wgServer. $wgScriptPath . '/index.php?title=' . $task_name->getPartialURL();

			$target_date = $row[3]->getNextObject();
			$tg_date = new DateTime( $target_date->getShortHTMLText() );

 			while ( $reminder = $row[1]->getNextObject() ) {
					global $wgLang;
					while ( $task_assignee = $row[2]->getNextObject() ) {
						$assignee_username = $task_assignee->getTitle();
						$assignee = User::newFromName( $assignee_username,false );
						$assignee_mail = new MailAddress( $assignee->getEmail(), $assignee_username );
						$body = wfMsgExt( 'tm-mail-reminder', 'parsemag', $task_name, $link );
						$user_mailer->send( $assignee_mail, $sender, $subject, $body );
					}
				}
		}
		
		$query_string = "[[deadline::".$today."]]";
		
		$properties_to_display = array( 'reminder', 'assignee', 'deadline' );

		$results = self::getQueryResults( $query_string, $properties_to_display, true );
		if ( $results->getCount()===0 ) {
			return FALSE;
		}

		$sender = new MailAddress( $wgNoReplyAddress, $wgSitename );
		
		while ( $row = $results->getNext() ) {
			$task_name = $row[0]->getNextObject()->getTitle();
			
			$subject = '[' . $wgSitename . '] ' . wfMsg( 'tm-reminder' ) . ' ' . $task_name;
			$link = $wgServer . $wgScriptPath . '/index.php?title=' . $task_name->getPartialURL();

			$target_date = $row[3]->getNextObject();
			$tg_date = new DateTime( $target_date->getShortHTMLText() );

 			while ( $reminder = $row[1]->getNextObject() ) {
					global $wgLang;
					while ( $task_assignee = $row[2]->getNextObject() ) {
						$assignee_username = $task_assignee->getTitle();
						$assignee = User::newFromName( $assignee_username,false );
						$assignee_mail = new MailAddress( $assignee->getEmail(), $assignee_username );
						$body = wfMsgExt( 'tm-mail-deadline', 'parsemag', $task_name, $link );
						$user_mailer->send( $assignee_mail, $sender, $subject, $body );
					}
				}
		}
		return TRUE;
	}
	
	/**
	* The following two functions are based on code frome the extension Semantic Tasks by Steren Giannini & Ryan Lane
	* released under GNU GPLv2 (or later)
	* http://www.mediawiki.org/wiki/Extension:Semantic_Tasks
	*/
	static function notifyAssignees($form, $title, $targetContent) {
		global $wgSitename, $wgServer, $wgScriptPath, $wgNoReplyAddress, $wgLang;
		
		$titleParts = explode("[[title::", $targetContent);
		$title = explode("]]",$titleParts[1]);
		$results = self::getQueryResults( "[[title::".$title[0]."]]", array('title'), true );
        	if ( $results->getCount()===0 ) {
            	return FALSE;
            }
		
		$createdParts = explode("[[created::", $targetContent);
		$created = explode("]]",$createdParts[1]);
		$created = date( 'd F Y', strtotime($created[0]) );

		$user_mailer = new UserMailer();
		$sender = new MailAddress( $wgNoReplyAddress, $wgSitename );
		$subject = '[' . $wgSitename . '] ' . wfMsg( 'tm-created' ) . ' ' . $title;
		$link = $wgServer. $wgScriptPath . '/index.php?title=' . $title;

		$t = getdate();
		$today = date( 'd F Y', $t[0] );

		if($created===$today) {
			preg_match_all ('#\\[\\[Assignee::(.+)\\]\\]#U', $targetContent, $matches); 
        	for ($i = 0; $i < count($matches[1]); ++$i)
        	{
            	$assignee_username = $matches[1][$i];
				$assignee = User::newFromName( $assignee_username,false );
				$assignee_mail = new MailAddress( $assignee->getEmail(), $assignee_username );
				$body = wfMsgExt( 'tm-mail-created', 'parsemag', $title, $link );
				$user_mailer->send( $assignee_mail, $sender, $subject, $body );
        	}
    	}
		return TRUE;
	}
	
	/**
	 * This function returns to results of a certain query
	 * This functions is part of the extension Semantic Tasks by Steren Giannini & Ryan Lane
	 * released under GNU GPLv2 (or later)
	 * http://www.mediawiki.org/wiki/Extension:Semantic_Tasks
	 * @param $query_string String : the query
	 * @param $properties_to_display array(String): array of property names to display
	 * @param $display_title Boolean : add the page title in the result
	 * @return TODO
	 */
	static function getQueryResults( $query_string, $properties_to_display, $display_title ) {
		// We use the Semantic MediaWiki Processor
		// $smwgIP is defined by Semantic MediaWiki, and we don't allow
		// this file to be sourced unless Semantic MediaWiki is included.
		global $smwgIP;
		include_once( $smwgIP . "/includes/query/SMW_QueryProcessor.php" );

		$params = array();
		$inline = true;
		$printlabel = "";
		$printouts = array();

		// add the page name to the printouts
		if ( $display_title ) {
			if( version_compare( SMW_VERSION, '1.7', '>' ) ) {
				SMWQueryProcessor::addThisPrintout( $printouts, $params );
			} else {
				$to_push = new SMWPrintRequest( SMWPrintRequest::PRINT_THIS, $printlabel );
				array_push( $printouts, $to_push );
			}
		}

		// Push the properties to display in the printout array.
		foreach ( $properties_to_display as $property ) {
			if ( class_exists( 'SMWPropertyValue' ) ) { // SMW 1.4
				$to_push = new SMWPrintRequest( SMWPrintRequest::PRINT_PROP, $property, SMWPropertyValue::makeUserProperty( $property ) );
			} else {
				$to_push = new SMWPrintRequest( SMWPrintRequest::PRINT_PROP, $property, Title::newFromText( $property, SMW_NS_PROPERTY ) );
			}
			array_push( $printouts, $to_push );
		}

		if ( version_compare( SMW_VERSION, '1.6.1', '>' ) ) {
			$params = SMWQueryProcessor::getProcessedParams( $params, $printouts );
			$format = null;
		}
		else {
			$format = 'auto';
		}
		
		$query = SMWQueryProcessor::createQuery( $query_string, $params, $inline, $format, $printouts );
		$results = smwfGetStore()->getQueryResult( $query );

		return $results;
	}
}
