<?php


abstract class DbRecord{
    /**
     * @var
     */
    public $id;

    private $_isNewRecord;
    private $_errors = [];

    /**
     * @return mixed
     */
    abstract protected function tableName();

    /**
     * DbRecord constructor.
     */
    public function __construct(){
        $this->_isNewRecord = true;
    }


    /**
     * @param $error
     */
    public function addError($error){
        $this->_errors[] = $error;
    }


    /**
     * @return mixed
     */
    public function getErrors(){

        $data = '';

        foreach($this->_errors as $error){
            $data .= '<li>'.$error.'</li>';
        }

        return $data;

    }

    /**
     * @return bool
     */
    public function hasErrors(){
        return count($this->_errors) > 0;
    }


    /**
     * @return bool
     */
    public function isNewRecord(){
        return $this->_isNewRecord;
    }

    /**
     * @param $id
     * @return User
     */
    public static function findOne($id){
        $db = Database::getInstance();
        $rawData = $db->selectAll(self::tableName(),
            ['where' => 'id = '.$id]
        );
        if($rawData === null){
            return null;
        }

        if(count($rawData) == 0){
            return null;
        }

        $data = [];
        foreach($rawData as $item){
            $model = new User();
            $model->_isNewRecord = false;
            foreach($item as $field => $value){
                $model->$field = $value;
            }
            $data[] = $model;
        }
        if(count($data) > 0){
            return $data[0];
        }

        return null;
    }

    /**
     * @return int
     */
    public function save(){
        $db = Database::getInstance();
        $fields = [];

        if($this->isNewRecord()){
            $this->creation_date = date('Y-m-d H:i:s', time());
            foreach($this as $key => $value){
                $fields[$key] = $value;
            }

            $result = $db->insert($this->tableName(), $fields);

            $this->id = $db->pdo->lastInsertId();
            if($result){
                $this->_isNewRecord = false;
            }

            return $result;

        } else{
            foreach($this as $key => $value){
                $fields[$key] = $value;
            }

            return $db->update($this->tableName(), $this->id, $fields);
        }
    }
}