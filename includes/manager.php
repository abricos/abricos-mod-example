<?php
/**
 * Управляющий менеджер модуля
 * @version $Id: module.php 1168 2011-10-28 04:51:52Z roosit $
 * @package Example 
 * @subpackage 
 * @author Alexander Kuzmin <roosit@abricos.org>
 * @link http://abricos.org/mods/example Страница модуля
 * @copyright Copyright (C) 2008-2011 Abricos All rights reserved.
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
		}
		return null;
	}
}

?>