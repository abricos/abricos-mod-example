<?php
/**
 * Когда производится инсталляция или обновление модуля в платформе Абрикос, 
 * то всегда происходит вызов этого скрипта shema.php
 * 
 * Эта технология существенно упрощает механизм сопровождения новой 
 * версии модулей, так как все необходимы действия по инсталляции и 
 * обновления таблиц и т.п. прописываются в этом скрипте.
 * 
 * @see Ab_UpdateManager
 * @package Example 
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * @author Alexander Kuzmin <roosit@abricos.org>
 * @filesource
 */

$charset = "CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'";
$db = Abricos::$db;
$pfx = $db->prefix;

/*
 * Менеджер обновлений в этот момент содержит всю необходимую
 * информацию о текущем состоянии версии модуля в платформе
 */
$updateManager = Ab_UpdateManager::$current;

if ($updateManager->isInstall()){
	
	/*
	 * Менеджер обновления определи что модуль производит инсталляцию
	 * модуля в платформе Абрикос
	 */

	// Создать таблицу необходимую для работы модуля Example
	$db->query_write("
		CREATE TABLE IF NOT EXISTS ".$pfx."exp_example (
		  `exampleid` int(10) unsigned NOT NULL auto_increment COMMENT 'Идентификатор',
		  `title` varchar(250) NOT NULL DEFAULT '' COMMENT 'Название',
		  PRIMARY KEY  (`exampleid`)
		)".$charset
	);

	$db->query_write("
		INSERT ".$pfx."exp_example (title) VALUES 
			('Запись добавлена во время инсталляции модуля Example')
	");
	
}

/*
 * Спустя некоторое время модуль Example был доработан до версии 0.1.1
 * В этой новой версии были произведены изменения в структуре таблиц модуля,
 * а именно было добавлено поле descript.
 * Для того, чтобы эти изменения в таблице были произведены на тех серверах,
 * где уже установлена версия 0.1 модуля Example, необходимо код модификации
 * разместить под условием проверки версии  
 */
if ($updateManager->isUpdate('0.1.1')){
	
	/*
	 * Этот код будет выполнен в двух случае, если модуль производит первую 
	 * инсталляцию на данном сервере или текущая версия этого модуля на сервере 
	 * меньше версии 0.1.1
	 */
	
	// добавить поле descript в таблицу exp_example 
	$db->query_write("
		ALTER TABLE ".$pfx."exp_example ADD `descript` TEXT COMMENT 'Подробное описание'
	");
}

?>