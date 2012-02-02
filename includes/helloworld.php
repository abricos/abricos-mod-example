<?php
/**
 * Этот скрипт вызывает кирпич helloworld (/modules/example/brick/helloworld.html)
 * 
 * Задача этого скрипта заполнить переменную кирпича coreversion информацией о 
 * версии платформы Абрикос
 * 
 * @package Example 
 * @version $Id$
 * @copyright Copyright (C) 2008-2011 Abricos All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * @author Alexander Kuzmin <roosit@abricos.org>
 * @filesource
 */

// кирпич, который вызывает этот скрипт
$brick = Brick::$builder->brick;

// установить значение переменным кирпича
$brick->param->var['coreversion'] = Abricos::GetModule('sys')->version;
$brick->param->var['exampleversion'] = Abricos::GetModule('example')->version;

?>