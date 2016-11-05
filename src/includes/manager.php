<?php
/**
 * Управляющий менеджер модуля
 *
 * @package Abricos
 * @subpackage Example
 * @copyright 2008-2015 Alexander Kuzmin
 * @license http://opensource.org/licenses/mit-license.php MIT License
 * @author Alexander Kuzmin <roosit@abricos.org>
 * @filesource
 */

/**
 * Class ExampleManager
 *
 * @method ExampleApp GetApp()
 */
class ExampleManager extends Ab_ModuleManager {

    /**
     * Проверка роли администратора текущего пользователя
     */
    public function IsAdminRole(){
        return $this->IsRoleEnable(ExampleAction::ADMIN);
    }

    /**
     * Проверка роли на запись текущего пользователя
     */
    public function IsWriteRole(){
        return $this->IsRoleEnable(ExampleAction::WRITE);
    }

    /**
	 * Проверка роли на чтение текущего пользователя
	 */
	public function IsViewRole(){
		return $this->IsRoleEnable(ExampleAction::VIEW);
	}

	public function AJAX($d){
        return $this->GetApp()->AJAX($d);
	}

    public function Bos_MenuData(){
        if (!$this->IsViewRole()){
            return null;
        }
        $i18n = $this->module->I18n();
        return array(
            array(
                "name" => "example",
                "title" => $i18n->Translate('title'),
                "icon" => "/modules/example/img/logo-24x24.png",
                "url" => "example/wspace/ws",
            )
        );
    }
}
