<?php
/**
 * Когда производится установка или обновление модуля (увеличение версии)
 * в платформе Абрикос, то всегда происходит вызов этого скрипта shema.php
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
    // Установка прав пользователя по умолчанию в платформу
    Abricos::GetModule('example')->permission->Install();

	// Создать таблицу необходимую для работы модуля Example
    $db->query_write("
        CREATE TABLE IF NOT EXISTS ".$pfx."example_record (
            recordid INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Идентификатор',
            title VARCHAR(250) NOT NULL DEFAULT '' COMMENT 'Заголовок',
            dateline INT(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Create Date',
            PRIMARY KEY (recordid),
            KEY dateline (dateline)
        )".$charset
    );
}
