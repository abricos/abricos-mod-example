<?php
/**
 * Пример модуля для платформы Абрикос
 *
 * Данный модуль создан в качестве примера разработки модуля
 *
 * @package Abricos
 * @subpackage Example
 * @copyright 2008-2015 Alexander Kuzmin
 * @license http://opensource.org/licenses/mit-license.php MIT License
 * @author Alexander Kuzmin <roosit@abricos.org>
 */

/**
 * Модуль Example
 *
 * @package Example
 *
 * @method ExampleManager GetManager()
 */
class ExampleModule extends Ab_Module {

    /**
     * Конструктор
     */
    public function __construct(){

        // Версия модуля
        $this->version = "0.1.0";

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
         * Инициализировать роли пользователей в этом модуле
         */
        $this->permission = new ExamplePermission($this);
    }

    /**
     * Когда управление по формированию ответа сервера переходит модулю,
     * происходит вызов этого метода, который должен вернуть имя
     * контент-файла (стартового кирпича).
     *
     * Стартовые кирпичи находяться в папке модуля content и содержат в себе
     * всю необходимую информацию для построении страницы.
     *
     * Если метод возвращает пустую строку, платформа выдает 404 ошибку.
     *
     * Если файл контент не найден, то платформа выдает 500 ошибку.
     *
     *
     * Например, для запроса http://имя_сайта/example/
     * будет сформирована страница стартового кирпича content/index.html
     *
     * @see Ab_Module::GetContentName()
     */
    public function GetContentName(){
        return 'index';
    }

    /**
     * Сообщить модулю BosUI что этот модуль участвует в построении меню
     *
     * @return bool
     */
    public function Bos_IsMenu(){
        return true;
    }
}

/**
 * Права (идентификаторы действий) пользователя в модуле
 *
 * Используется для разграничения прав в модуле Example
 *
 * Редактирование прав доступны администратору в панели управления:
 * Пользователи -> Группы пользователей
 *
 * Так как прав может быть много и они бывают разными, необходимо описать
 * название этих прав для редактора.
 */
class ExampleAction {

    /**
     * Право просмотра
     */
    const VIEW = 10;

    /**
     * Право записи
     */
    const WRITE = 30;

    /**
     * Право администратора
     */
    const ADMIN = 50;
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
        // Права пользователей по умолчанию
        // используется при инсталяции модуля в платформе
        $defRoles = array(

            // Право на просмотр доступно группам пользователей:
            // гости, авторизованные, администраторы
            new Ab_UserRole(ExampleAction::VIEW, Ab_UserGroup::GUEST),
            new Ab_UserRole(ExampleAction::VIEW, Ab_UserGroup::REGISTERED),
            new Ab_UserRole(ExampleAction::VIEW, Ab_UserGroup::ADMIN),

            // Право на запись доступно группам: авторизованные, администраторы
            new Ab_UserRole(ExampleAction::WRITE, Ab_UserGroup::ADMIN),

            // Право администратора доступно группам пользователей:
            // администраторы
            new Ab_UserRole(ExampleAction::ADMIN, Ab_UserGroup::ADMIN)
        );
        parent::__construct($module, $defRoles);
    }

    /**
     * Получить роли пользователя
     */
    public function GetRoles(){
        return array(
            ExampleAction::VIEW => $this->CheckAction(ExampleAction::VIEW),
            ExampleAction::WRITE => $this->CheckAction(ExampleAction::WRITE),
            ExampleAction::ADMIN => $this->CheckAction(ExampleAction::ADMIN)
        );
    }
}

// Зарегистрировать экзепляр класса модуля Example в ядре платформы Абрикос
Abricos::ModuleRegister(new ExampleModule());
