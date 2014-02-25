<?php
/**
 * Internationalisation for TaskManagement
 *
 * @file
 * @ingroup Extensions
 */
$messages = array();
 
/** English
 * @author rnddude
 */
$messages[ 'en' ] = array(
        'tm' => 'Task Management',
        'tm-desc' => 'Allows to create, edit and manage tasks',
        'tasks' => 'Tasks',
        'tm-reminder' => 'Reminder:',
		'tm-mail-reminder' => 'Just to remind you that the task \'$1\' has set its reminder today
$2',
		'tm-mail-deadline' => 'Just to remind you that the task \'$1\' ends today
$2',
		'tm-created' => 'New task:',
		'tm-mail-created' => 'Just to inform you that a new task \'$1\' has been created for you
$2',
		'tm-special-text' => 'This is a list of all tasks!',
		'tm-special-text-personal' => 'Welcome to your personal task overview!',
		'tm-special-text-personal-asignee' => 'An overview of all task assigned to you:',
		'tm-special-text-personal-creator' => 'An overview of all task created by you:',
		'tm-error-title' => 'no valid title',
		'tm-tasbox-added' => 'Tasbox-Template added',
		'tm-taskbox-removed' => 'Taskox-Template removed'
);
 
/** German
 * @author rnddude
 */
$messages[ 'de' ] = array(
        'tm' => 'Aufgabenverwaltung',
        'tm-desc' => 'Eine Erweiterung für SMW zur Aufgabenverwaltung',
        'tasks' => 'Aufgaben',
        'tm-reminder' => 'Erinnerung:',
		'tm-mail-reminder' => 'Dies ist eine Erinnerung an die Aufgabe „$1“.
$2',	
		'tm-mail-deadline' => 'Dies ist eine Erinnerung an die Aufgabe „$1“, die heute endet.
$2',
		'tm-created' => 'Neue Aufgabe:',
		'tm-mail-created' => 'Es wurde ein neuer Task \'$1\' für dich erstellt
$2',
		'tm-special-text' => 'Hier findest du eine Liste aller Aufgaben.',
		'tm-special-text-personal' => 'Willkommen zu deiner persönlichen Aufgabenübersicht.',
		'tm-special-text-personal-asignee' => 'Eine Übersicht aller Tasks, die dir zugeordnet sind:',
		'tm-special-text-personal-creator' => 'Eine Übersicht aller Tasks, die du erstellt hast:',
		'tm-error-title' => 'kein gültiger Titel',
		'tm-tasbox-added' => 'Tasbox-Template hinzugefügt',
		'tm-taskbox-removed' => 'Taskox-Template entfernt'
);

/** Message documentation
 * @author rnddude
 */
$messages[ 'qqq' ] = array(
        'tm' => 'the name of the extension',
        'tm-desc' => 'description',
        'tasks' => 'translation for classs',
        'tm-reminder' => 'part of subject for reminder email',
		'tm-mail-reminder' => 'message for reminder email',	
		'tm-mail-deadline' => 'message for deadline email',
		'tm-created' => 'part of the subject for created email',
		'tm-mail-created' => 'message for created email',
		'tm-special-text' => 'text for special page',
		'tm-special-text-personal' => 'text for personalized special page',
		'tm-special-text-personal-asignee' => 'text for tasklist assigend to one',
		'tm-special-text-personal-creator' => 'text for tasklist created by one',
		'tm-error-title' => 'text for error message due to missing or invald title',
		'tm-tasbox-added' => 'text for version history when tasbox template is added',
		'tm-taskbox-removed' => 'text for version history when tasbox template is removed'
);