<?php
/**
 * Управляющий менеджер модуля
 * 
 * @package Example 
 * @subpackage 
 * @author Alexander Kuzmin <roosit@abricos.org>
 * @link http://abricos.org/mods/example Страница модуля
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * @filesource
 */

require_once 'dbquery.php';

class ExampleManager extends Ab_ModuleManager {
	
	/**
	 * @var ExampleModule
	 */
	public $module = null;
	
	/**
	 * @var ExampleManager
	 */
	public static $instance = null; 
	
	/**
	 * Конструктор
	 * @param ExampleModule $module
	 */
	public function __construct(ExampleModule $module){
		parent::__construct($module);
		
		ExampleManager::$instance = $this;
	}
	
	/**
	 * Проверка роли доступа текущего пользователя на доступ к записи стикеров
	 */
	public function IsWriteRole(){
		return $this->module->permission->CheckAction(ExampleAction::WRITE) > 0;
	}
	
	/**
	 * Обработчик AJAX запросов
	 * @param object $d данные запроса
	 */
	public function AJAX($d){
		switch($d->do){
			case 'simplevalueload': return $this->SimpleValueLoad();
			case 'simplevaluesave': return $this->SimpleValueSave($d->value);
		}
		return null;
	}
	
	/**
	 * Получить значение первой записи из таблицы exp_example
	 */
	public function SimpleValueLoad(){
		$row = ExampleQuery::SimpleValueLoad($this->db);
		if (empty($row)){ return ""; }
		
		return $row['title'];
	}
	
	/**
	 * Сохранить значение в первую запись таблицы exp_example
	 * @param object $savedata
	 */
	public function SimpleValueSave($value){
		
		// получить первую строку таблицы exp_example
		$row = ExampleQuery::SimpleValueLoad($this->db);
		if (empty($row)){
			// записей в таблицы exp_example нет, значит нужно создать запись
			ExampleQuery::SimpleValueAppend($this->db, $value);
		}else{
			// обновить существующую запись
			ExampleQuery::SimpleValueUpdate($this->db, $row['exampleid'], $value);
		}
		
	}
}

?>