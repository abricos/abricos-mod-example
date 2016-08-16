<?php
/**
 * Этот скрипт вызывает кирпич testbrick (/modules/example/brick/testbrick.html)
 * 
 * @package Example 
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * @author Alexander Kuzmin <roosit@abricos.org>
 * @filesource
 */

// кирпич, который вызывает этот скрипт
$brick = Brick::$builder->brick;

// заменить в теле кирпича идентификатор {v#myparamresult} на значение из 
// переменной параметра кирпича myparam
$brick->content = Brick::ReplaceVarByData($brick->content, array(
	'myparamresult' => $brick->param->param['myparam']
));
