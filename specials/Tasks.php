<?php
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