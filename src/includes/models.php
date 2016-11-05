<?php
/**
 * @package Abricos
 * @subpackage Example
 * @copyright 2008-2015 Alexander Kuzmin
 * @license http://opensource.org/licenses/mit-license.php MIT License
 * @author Alexander Kuzmin <roosit@abricos.org>
 */

/**
 * Class ExampleRecord
 *
 * @property int $id
 * @property string $title
 * @property int $date
 */
class ExampleRecord extends AbricosModel {
    protected $_structModule = 'example';
    protected $_structName = 'Record';
}

/**
 * Class ExampleRecordList
 *
 * @method ExampleRecord Get(int $id)
 * @method ExampleRecord GetByIndex(int $i)
 */
class ExampleRecordList extends AbricosModelList {
}

/**
 * Interface ExampleRecordSaveVars
 *
 * @property int $recordid
 * @property string $title
 */
interface ExampleRecordSaveVars {
}

/**
 * Class ExampleRecordSave
 *
 * @property ExampleRecordSaveVars $vars
 * @property int $recordid
 */
class ExampleRecordSave extends AbricosResponse {
    const CODE_OK = 1;
    const CODE_EMPTY_TITLE = 2;

    protected $_structModule = 'example';
    protected $_structName = 'RecordSave';
}
