<?php

$cms = CMSRegistry::$instance;
$charset = "CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'";
$svers = $cms->modules->moduleUpdateShema->serverVersion;
$db = $cms->db;
$pfx = $db->prefix;

if (version_compare($svers, "1.0.0", "<")){
	
	// таблица сообщений
	$db->query_write("
		CREATE TABLE IF NOT EXISTS ".$pfx."ex_message (
		  `messageid` int(10) unsigned NOT NULL auto_increment,
		  `message` TEXT NOT NULL COMMENT 'Сообщение',
		  PRIMARY KEY  (`messageid`)
		 )".$charset
	);
	
}
?>