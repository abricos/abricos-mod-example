<?php
/**
 * @package Abricos
 * @subpackage Example
 * @copyright 2008-2015 Alexander Kuzmin
 * @license http://opensource.org/licenses/mit-license.php MIT License
 * @author Alexander Kuzmin <roosit@abricos.org>
 */

/**
 * Class ExampleApp
 *
 * @property ExampleManager $manager
 */
class ExampleApp extends Ab_App {

    protected $_aliases = array(
        "record" => array(
            "Record" => "ExampleRecord",
            "RecordList" => "ExampleRecordList",
        ),
        "admin" => array(
            "RecordSave" => "ExampleRecordSave",
            "RecordRemove" => "ExampleRecordRemove",
        )
    );

    public function IsAdminRole(){
        return $this->manager->IsAdminRole();
    }

    public function IsWriteRole(){
        return $this->manager->IsWriteRole();
    }

    public function IsViewRole(){
        return $this->manager->IsViewRole();
    }

    /**
     * @param int $recordid
     * @return ExampleRecord
     */
    public function Record($recordid){
        $recordid = intval($recordid);

        if ($this->CacheExists('Record', $recordid)){
            return $this->Cache('Record', $recordid);
        }

        /** @var ExampleRecord $record */
        $record = $this->CreateFilled('Record', $recordid);

        $this->SetCache('Record', $recordid, $record);

        return $record;
    }

    /**
     * @return ExampleRecordList
     */
    public function RecordList(){
        /** @var ExampleRecordList $list */
        $list = $this->CreateFilled('RecordList');

        return $list;
    }

    public function RecordSave($d){
        /** @var ExampleRecordSave $ret */
        $ret = $this->CreateFilled('RecordSave', $d);

        return $ret;
    }

    public function RecordRemove($recordid){
        $remove = $this->CreateFilled('RecordRemove', $recordid);

        $this->CacheClear();

        return $remove;
    }

}
