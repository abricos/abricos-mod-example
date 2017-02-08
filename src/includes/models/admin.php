<?php
/**
 * @package Abricos
 * @subpackage Example
 * @copyright 2008-2017 Alexander Kuzmin
 * @license http://opensource.org/licenses/mit-license.php MIT License
 * @author Alexander Kuzmin <roosit@abricos.org>
 */


/**
 * Interface ExampleRecordSaveArgs
 *
 * @property int $recordid
 * @property string $title
 */
interface ExampleRecordSaveArgs extends Ab_IAttrsData {
}

/**
 * Class ExampleRecordSave
 *
 * @property ExampleRecordSaveArgs $vars
 * @property int $recordid
 */
class ExampleRecordSave extends Ab_Model {
    const CODE_OK = 1;
    const CODE_EMPTY_TITLE = 2;

    protected $_structModule = 'example';
    protected $_structName = 'RecordSave';

    /**
     * @param ExampleApp $app
     * @param mixed $d
     * @return void
     */
    public function Fill($app, $d){
        if (!$app->IsAdminRole()){
            $this->SetError(AbricosResponse::ERR_FORBIDDEN);
            return;
        }

        /** @var ExampleRecordSaveArgs $args */
        $args = $this->SetArgs($d);

        if ($args->IsEmptyValue('title')){
            $this->SetError(
                AbricosResponse::ERR_BAD_REQUEST,
                ExampleRecordSave::CODE_EMPTY_TITLE
            );
            return;
        }

        if ($args->recordid === 0){
            $this->recordid = ExampleQuery::RecordAppend($app->db, $this);
        } else {
            $this->recordid = $args->recordid;
            ExampleQuery::RecordUpdate($app->db, $this);
        }

        $this->AddCode(ExampleRecordSave::CODE_OK);
    }
}


/**
 * Class ExampleRecordRemove
 *
 * @property ExampleRecordRemoveArgs $vars
 * @property int $recordid
 */
class ExampleRecordRemove extends Ab_Model {
    const CODE_OK = 1;

    protected $_structModule = 'example';
    protected $_structName = 'RecordRemove';

    /**
     * @param ExampleApp $app
     * @param int $recordid
     */
    public function Fill($app, $recordid){
        if (!$app->IsAdminRole()){
            $this->SetError(AbricosResponse::ERR_FORBIDDEN);
            return;
        }

        $record = $app->Record($recordid);
        if ($record->IsError()){
            $this->SetError($record->GetError());
            return;
        }

        ExampleQuery::RecordRemove($app->db, $recordid);


        $this->AddCode(ExampleRecordRemove::CODE_OK);
    }
}
