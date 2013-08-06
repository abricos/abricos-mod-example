<?php 
/**
 * Пример модуля для платформы Абрикос
 * 
 * Данный модуль создан в качестве примера разработки модуля
 * для платформы Абрикос
 * 
 * @package Example 
 * @author Alexander Kuzmin <roosit@abricos.org>
 * @link http://abricos.org/mods/example Страница модуля
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * @filesource
 */

/**
 * Модуль Example для платформы Абрикос
 * 
 * @package Example
 */
class ExampleModule extends Ab_Module {
	
	// экземпляр менеджера модуля
	private $_manager = null;
	
	/**
	 * Конструктор
	 */
	public function __construct(){

		// Версия модуля
		$this->version = "0.1.2";
		
		// Идентификатор модуля
		$this->name = "example";
		
		/*
		 * Идентификатор части в URI. Определяет, по какому идентификатору 
		 * модулю Example передается управление.
		 * 
		 * В данном случае при запросе http://имя_сайта/example/ 
		 * управление будет передано этому модулю для формирования 
		 * ответа сервера
		 */
		$this->takelink = "example";

		/*
		 * Зависимость модуля от других модулей и их версий в платформе Абрикос
		 */
		$this->depends = array('core');
		
		/*
		 * Инициализировать роли пользователей в этом модуле
		 */
		$this->permission = new ExamplePermission($this);
	}
	
	/**
	 * Получить менеджер модуля
	 * 
	 * @see Ab_Module::GetManager()
	 */
	public function GetManager(){
		if (is_null($this->_manager)){
			require_once 'includes/manager.php';
			$this->_manager = new ExampleManager($this);
		}
		return $this->_manager;
	}
	
	/**
	 * Когда управление по формированию ответа сервера переходит модулю,
	 * происходит вызов этого метода, который должен вернуть имя 
	 * контент файла (стартового кирпича).
	 * 
	 * Стартовые кирпичи находяться в папке модуля content и содержат в себе
	 * всю необходимую информацию для формирования ответа.
	 * 
	 * Если метод возвращает пустую строку, платформа выдает 404 ошибку.
	 * 
	 * Если файл контент не найден, то платформа выдает 500 ошибку.
	 * 
	 * Так как все страницы этого модуля статичные, то по определенному
	 * запросу должнен находиться соответсвующий файл контент.
	 * 
	 * Например, для запроса http://имя_сайта/example/srv/modstruct.html
	 * должен быть файл стартового кирпича в модуле Example - content/srv/modstruct.html
	 * 
	 * @see Ab_Module::GetContentName()
	 */
	public function GetContentName(){
		
		// по умолчанию имя файл контента (стартового кирпича) 
		// будет "index" (файл в папке модуля example/content/index.html)
		 
		// адрес запрашиваемого скрипта
		$adr = Abricos::$adress;
		$cname = $adr->contentName;
		for ($i=1; $i<count($adr->dir); $i++){
			$cname = $adr->dir[$i]."/".$cname;
		}
		return $cname;
	}
	
}

/**
 * Права (идентификаторы действий) пользователя в модуле
 * 
 * Используется для разграничения прав в модуле Example
 */
class ExampleAction {
	
	/**
	 * Право просмотра
	 */
	const VIEW	= 10;
	
	/**
	 * Право записи
	 */
	const WRITE	= 30;
}

/**
 * Класс управления правами пользователей в модуле Example
 * 
 * @package Example
 */
class ExamplePermission extends Ab_UserPermission {

	/**
	 * Конструктор
	 * 
	 * @param ExampleModule $module
	 */
	public function __construct(ExampleModule $module){
		// используется при инсталяции модуля в платформе
		$defRoles = array(
			
			// Право на просмотр доступно группам пользователей: 
			// гости, авторизованные, администраторы 
			new Ab_UserRole(ExampleAction::VIEW, Ab_UserGroup::GUEST),
			new Ab_UserRole(ExampleAction::VIEW, Ab_UserGroup::REGISTERED),
			new Ab_UserRole(ExampleAction::VIEW, Ab_UserGroup::ADMIN),
			
			// Право на запись доступно группам: авторизованные, администраторы
			new Ab_UserRole(ExampleAction::WRITE, Ab_UserGroup::REGISTERED),
			new Ab_UserRole(ExampleAction::WRITE, Ab_UserGroup::ADMIN)
		);
		parent::__construct($module, $defRoles);
	}

	/**
	 * Получить роли пользователя
	 */
	public function GetRoles(){
		return array(
			ExampleAction::VIEW => $this->CheckAction(ExampleAction::VIEW),
			ExampleAction::WRITE => $this->CheckAction(ExampleAction::WRITE)
		);
	}
}

// Зарегистрировать экзепляр класса модуля Example в ядре платформы Абрикос
Abricos::ModuleRegister(new ExampleModule()) 

?>