<?php
/**
 * @package Abricos
 * @subpackage Example
 * @copyright 2008-2015 Alexander Kuzmin
 * @license http://opensource.org/licenses/mit-license.php MIT License
 * @author Alexander Kuzmin <roosit@abricos.org>
 */

$brick = Brick::$builder->brick;
$v = &$brick->param->var;

/** @var ExampleApp $exampleApp */
$exampleApp = Abricos::GetApp('example');

$recordList = $exampleApp->RecordList();

if (AbricosResponse::IsError($recordList)){
    $brick->content = '';
    return;
}

$exampleModule = Abricos::GetModule('example');

$lst = "";
$count = $recordList->Count();
for ($i = 0; $i < $count; $i++){
    $record = $recordList->GetByIndex($i);

    $lst .= Brick::ReplaceVarByData($v['row'], array(
        "id" => $record->id,
        "title" => $record->title,
        "date" => date("Y-m-d", $record->date),
    ));
}

$brick->content = Brick::ReplaceVarByData($brick->content, array(
    "list" => $lst
));