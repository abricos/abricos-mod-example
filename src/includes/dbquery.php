<?php
/**
 * @package Abricos
 * @subpackage Example
 * @copyright 2008-2015 Alexander Kuzmin
 * @license http://opensource.org/licenses/mit-license.php MIT License
 * @author Alexander Kuzmin <roosit@abricos.org>
 */

/**
 * Class ExampleQuery
 */
class ExampleQuery {

    /**
     * Получить запись по идентификатору
     *
     * @param Ab_Database $db
     * @param int $recordid идентификатор записи
     * @return array|null
     */
    public static function Record(Ab_Database $db, $recordid){
        $sql = "
			SELECT *
			FROM ".$db->prefix."example_record
            WHERE recordid=".bkint($recordid)."
			LIMIT 1
		";
        return $db->query_first($sql);
    }

    /**
     * @param Ab_Database $db
     * @return int
     */
    public static function RecordList(Ab_Database $db){
        $sql = "
			SELECT *
			FROM ".$db->prefix."example_record
			ORDER BY dateline DESC
		";
        return $db->query_read($sql);
    }

    /**
     * Добавить запись
     *
     * @param Ab_Database $db
     * @param ExampleRecordSave $save
     */
    public static function RecordAppend(Ab_Database $db, ExampleRecordSave $save){
        /** @var ExampleRecordSaveArgs $args */
        $args = $save->GetArgs();
        $sql = "
			INSERT INTO ".$db->prefix."example_record 
            (title, dateline) VALUES (
				'".bkstr($args->title)."',
				".bkstr(TIMENOW)."
			)
		";
        $db->query_write($sql);
        return $db->insert_id();
    }

    /**
     * Обновить запись
     *
     * @param Ab_Database $db
     * @param ExampleRecordSave $save
     */
    public static function RecordUpdate(Ab_Database $db, ExampleRecordSave $save){
        /** @var ExampleRecordSaveArgs $args */
        $args = $save->GetArgs();
        $sql = "
			UPDATE ".$db->prefix."example_record
			SET 
			    title='".bkstr($args->title)."'
			WHERE recordid=".bkint($args->recordid)."
			LIMIT 1
		";
        $db->query_write($sql);
    }

    /**
     * Удалить запись
     *
     * @param Ab_Database $db
     * @param $recordid
     */
    public static function RecordRemove(Ab_Database $db, $recordid){
        $sql = "
			DELETE FROM ".$db->prefix."example_record
			WHERE recordid=".bkint($recordid)."
			LIMIT 1
		";
        $db->query_write($sql);
    }
}
