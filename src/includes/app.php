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
class ExampleApp extends AbricosApplication {

    protected function GetClasses(){
        return array(
            "Record" => "ExampleRecord",
            "RecordList" => "ExampleRecordList",
            "RecordSave" => "ExampleRecordSave",
        );
    }

    protected function GetStructures(){
        $ret = 'Record';

        if ($this->IsAdminRole()){
            $ret .= ',RecordSave';
        }
        return $ret;
    }

    public function ResponseToJSON($d){
        switch ($d->do){
            case 'record':
                return $this->RecordToJSON($d->recordid);
            case 'recordList':
                return $this->RecordListToJSON();
            case "recordSave":
                return $this->RecordSaveToJSON($d->data);
            case 'recordRemove':
                return $this->RecordRemoveToJSON($d->recordid);
        }
        return null;
    }

    public function IsAdminRole(){
        return $this->manager->IsAdminRole();
    }

    public function IsWriteRole(){
        return $this->manager->IsWriteRole();
    }

    public function IsViewRole(){
        return $this->manager->IsViewRole();
    }

    public function RecordListToJSON(){
        $ret = $this->RecordList();
        return $this->ResultToJSON('recordList', $ret);
    }

    /**
     * @return ExampleRecordList|int
     */
    public function RecordList(){
        if (!$this->IsViewRole()){
            return AbricosResponse::ERR_FORBIDDEN;
        }

        /** @var ExampleRecordList $list */
        $list = $this->InstanceClass('RecordList');

        $rows = ExampleQuery::RecordList($this->db);
        while (($d = $this->db->fetch_array($rows))){
            /** @var ExampleRecord $record */
            $record = $this->InstanceClass('Record', $d);
            $list->Add($record);
        }

        return $list;
    }

    public function RecordSaveToJSON($d){
        $ret = $this->RecordSave($d);
        return $this->ResultToJSON('recordSave', $ret);
    }

    public function RecordSave($d){
        /** @var ExampleRecordSave $ret */
        $ret = $this->InstanceClass('RecordSave', $d);

        if (!$this->IsAdminRole()){
            return $ret->SetError(AbricosResponse::ERR_FORBIDDEN);
        }

        $vars = $ret->vars;

        if (empty($vars->title)){
            return $ret->SetError(
                AbricosResponse::ERR_BAD_REQUEST,
                ExampleRecordSave::CODE_EMPTY_TITLE
            );
        }

        if ($ret->vars->recordid === 0){
            $ret->recordid = ExampleQuery::RecordAppend($this->db, $ret);
        } else {
            $ret->recordid = $vars->recordid;
            ExampleQuery::RecordUpdate($this->db, $ret);
        }

        $ret->AddCode(ExampleRecordSave::CODE_OK);
        
        return $ret;
    }

    public function RecordToJSON($recordid){
        $ret = $this->Record($recordid);
        return $this->ResultToJSON('record', $ret);
    }

    public function Record($recordid){
        if (!$this->IsViewRole()){
            return AbricosResponse::ERR_FORBIDDEN;
        }

        $recordid = intval($recordid);

        if ($this->CacheExists('Record', $recordid)){
            return $this->Cache('Record', $recordid);
        }

        $d = ExampleQuery::Record($this->db, $recordid);
        if (empty($d)){
            return AbricosResponse::ERR_NOT_FOUND;
        }

        /** @var ExampleRecord $record */
        $record = $this->InstanceClass('Record', $d);

        $this->SetCache('Record', $recordid, $record);

        return $record;
    }

    public function RecordRemoveToJSON($recordid){
        $ret = $this->RecordRemove($recordid);
        return $this->ResultToJSON('recordRemove', $ret);
    }

    public function RecordRemove($recordid){
        if (!$this->IsAdminRole()){
            return AbricosResponse::ERR_FORBIDDEN;
        }

        ExampleQuery::RecordRemove($this->db, $recordid);

        $this->CacheClear();

        $ret = new stdClass();
        $ret->recordid = $recordid;
        return $ret;
    }

}
