<?php
/**
 * @package Abricos
 * @subpackage Example
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * @author Alexander Kuzmin <roosit@abricos.org>
 */

class ExampleQuery {
	
	public static function SimpleValueLoad(Ab_Database $db){
		$sql = "
			SELECT *
			FROM ".$db->prefix."exp_example
			ORDER BY exampleid
			LIMIT 1
		";
		return $db->query_first($sql);
	}
	
	public static function SimpleValueAppend(Ab_Database $db, $value){
		$sql = "
			INSET INTO ".$db->prefix."exp_example (title) VALUES (
				'".bkstr($value)."'
			)
		";
		$db->query_write($sql);
	}
	
	public static function SimpleValueUpdate(Ab_Database $db, $exampleid, $value){
		$sql = "
			UPDATE  ".$db->prefix."exp_example
			SET title='".bkstr($value)."'
			WHERE exampleid=".bkint($exampleid)."
		";
		$db->query_write($sql);
	}
	
	
}

?>