TaskManagement
==============


Requirements
Besides MediaWiki (Version 1.22+) the extension requires the following extensions to be installed:
 Semantic MediaWiki (Version 1.9+)
 Semantic Forms (Version 2.6+)
 ParsterFunctions (Version 1.5+)
 GetUserName (Version 1.0+)

Installation
 Download and extract the files in a directory called TaskManagement in your extensions/ folder. If you're a developer and this extension is in a Git repository, then instead you should clone the repository.
 Add the following code at the bottom of your LocalSettings.php:
    
    require_once ( "$IP/extensions/TaskManagement/TaskManagement.php" );

 During the first step you can ignore the following files: create.jpg, Form-Task.txt, Template-Task.txt, Template-TaskBox.txt
 The extension requires that specific semantic properties exist. Please check the section Semantic Properties and make sure that they indeed do exist otherwise the extension may not work properly because for some functionality in the templates the data types of the properties must be specified.
 Create Form:Task and copy the code from the file Form-Task.txt into it
 Create Template:Task and  copy the code from the file Template-Task.txt into it
 Create Template:TaskBox and  copy the code from the file Template-TaskBox.txt into it
 Finally run a cron job once a day to execute the reminder script. Edit your crontab file:
    
    $ crontab -e
 
 And add the following line to execute the script every day at 12: 
 
    * 0 12 * * * php extensions/TaskManagement/TaskManagement_Cronjobs.php
 
 Done – Navigate to "Special:Version" on your wiki to verify that the extension is successfully installed.

Semantic Properties
The following semantic properties have to exist with the specified data type:



 Property -> Data type
 Title -> Text
 Status -> Text
 Percent -> Number
 Priority -> Number
 Created -> Date
 Reminder -> Date
 Deadline -> Date
 Creator -> Page
 Assignee -> Page
 Entity -> Page


Usage

1. Create Tasks
Creating tasks is very easy. Just use the Form. Fill in the necessary information and save.

Description: Just fill in text, optional.
Creator: Pre filled by your username.
Assignee: Fill in the username of the one supposed to do the task, you can use a 
comma-separated list or if there is no specific user use ALL
Created: Pre filled by the date.
Reminder: Fill in a date for a reminder email, optional.
Deadline: Fill in a date for another reminder email, optional.
Notes: Any additional notes for the task.
Priority: 1 is the lowest, 3 the highest.
Entities: Fill in an ask-query specifying Use any category or semantic property you want with the following format:
{{#ask: [[Category:Example]] [[Attribute::this]] | format=list | link=none | headers=hide | sep=, }}
	
2. Edit Tasks
You can edit tasks very easily with the form you used to create it. There is a link on every task page below the information table.

3. Complete Tasks
On the entity pages there is a small box which shows the tasks corresponding to this page. It shows just the title which links the page of this task. If the task is assigned to you or free for everybody to do there is a button you can click if you completed the task. The information is stored as a semantic subobject with the task.

4. SpecialPage Tasks
There is a special page listing all tasks. It is listed under the Lists of pages header. You can personalize this list by passing on the GET parameter user. Just add "&user=USERNAME" to the end of the url.
	
5. Emails sent by the extension
When a task is created every assignee receives an email. On the reminder day every assignee receives an email. On the deadline day every assignee receives an email.
