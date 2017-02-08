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
class ExampleRecord extends Ab_Model {
    protected $_structModule = 'example';
    protected $_structName = 'Record';

    /**
     * @param ExampleApp $app
     * @param int $recordid
     * @return void
     */
    public function Fill($app, $recordid){
        if (!$app->IsViewRole()){
            $this->SetError(Ab_Response::ERR_FORBIDDEN);
            return;
        }

        $recordid = intval($recordid);

        $d = ExampleQuery::Record($app->db, $recordid);
        if (empty($d)){
            $this->SetError(Ab_Response::ERR_NOT_FOUND);
            return;
        }

        $this->Update($d);
    }
}

/**
 * Class ExampleRecordList
 *
 * @method ExampleRecord Get(int $id)
 * @method ExampleRecord GetByIndex(int $i)
 */
class ExampleRecordList extends Ab_ModelList {
    protected $_structModule = 'example';
    protected $_structName = 'RecordList';

    /**
     * @param ExampleApp $app
     */
    public function Fill($app){
        if (!$app->IsViewRole()){
            $this->SetError(Ab_Response::ERR_FORBIDDEN);
            return;
        }

        $rows = ExampleQuery::RecordList($app->db);
        while (($d = $app->db->fetch_array($rows))){
            /** @var ExampleRecord $record */
            $record = $app->Create('Record', $d);
            $this->Add($record);
        }
    }
}
