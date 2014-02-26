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
 
class Tasks extends SpecialPage {
        function __construct() {
                parent::__construct( 'Tasks' );
        }
        
        function execute( $par ) {
                $request = $this->getRequest();
                $output = $this->getOutput();
                $this->setHeaders();
 
                # Get request data from, e.g.
                $param = $request->getText( 'user' );
 
 				if(empty($param)) {
                $output->addWikiText(wfMessage('tm-special-text'));
				$table = '{{#ask: [[Category:Task(s)]]
				| ?title 
				| ?assignee
				| ?creator				
				| ?deadline
				| ?reminder
				| ?entity
				}}
				';
                $output->addWikiText( $table );
                } else {
                $output->addWikiText(wfMessage('tm-special-text-personal'));
                $output->addWikiText(wfMessage('tm-special-text-personal-asignee'));
                $table = '{{#ask: [[Category:Task(s)]] [[Asignee::{{#USERNAME:}}]]
				| ?title 
				| ?assignee
				| ?creator				
				| ?deadline
				| ?reminder
				| ?entity
				| sort=priority
				| order=descending
				}}
				';
				$output->addWikiText( $table );
				$output->addWikiText(wfMessage('tm-special-text-personal-creator'));
                $table = '{{#ask: [[Category:Task(s)]] [[Creator::{{#USERNAME:}}]]
				| ?title 
				| ?assignee
				| ?creator				
				| ?deadline
				| ?reminder
				| ?entity
				| sort=priority
				| order=descending
				}}
				';
				$output->addWikiText( $table );
                }
        }
}