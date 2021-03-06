<?php
/**
 * @package Abricos
 * @subpackage Example
 * @copyright 2008-2017 Alexander Kuzmin
 * @license http://opensource.org/licenses/mit-license.php MIT License
 * @author Alexander Kuzmin <roosit@abricos.org>
 */

/**
 * Class ExampleAPI
 *
 * @property ExampleApp $app
 */
class ExampleAPI extends Ab_API {

    protected $_versions = array(
        'v1' => 'ExampleAPIMethodsV1'
    );

    protected function OnRequestRoot(){
        if (!$this->app->IsViewRole()){
            return Ab_Response::ERR_FORBIDDEN;
        }

        return $this->ToJSON();
    }
}

/**
 * Class ExampleAPIMethodsV1
 *
 * @property ExampleApp $app
 */
class ExampleAPIMethodsV1 extends Ab_APIMethods {

    public $methods = array(
        'record' => 'Record',
        'recordList' => 'RecordList',
        'recordSave' => 'RecordSave',
        'recordRemove' => 'RecordRemove'
    );

    protected function GetStructures(){
        $ret = array(
            'Record',
            'RecordList'
        );

        if ($this->app->IsAdminRole()){
            $ret[] = 'RecordSave';
        }

        return $ret;
    }

    /**
     * @api {get} /api/example/v1/record/:recordid
     * @apiName GetRecord
     * @apiGroup Example
     *
     * @apiParam {Number} recordid Record ID
     *
     * @apiSuccess {Integer} id Record ID
     * @apiSuccess {String} title Record Title
     * @apiSuccess {UnixTimeStamp} date Date of record created
     *
     * @apiSuccessExample {json} Success Response Example:
     *  HTTP/1.1 200 OK
     *  {
     *      "id": 32,
     *      "title": "This is a example record",
     *      "date": 1423213899
     *  }
     */
    public function Record($recordid){
        return $this->app->Record($recordid);
    }

    public function RecordList(){
        return $this->app->RecordList();
    }

    public function RecordSave(){
        $d = $this->POSTParamToObject('data');

        return $this->app->RecordSave($d);
    }

    public function RecordRemove($recordid){
        return $this->app->RecordRemove($recordid);
    }

}