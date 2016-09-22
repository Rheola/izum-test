<?php


class User extends DbRecord{

    public $name;
    public $email;
    public $phone;

    public $show;
    public $edited;
    public $file_name;
    public $creation_date;

    public $file;

    private static $labels_ru = [
        'id' => 'ID',
        'name' => 'Имя',
        'email' => 'Email',
        'phone' => 'Телефон',
        'create_date' => 'Дата создания',
    ];

    private static $labels_en = [
        'id' => 'ID',
        'name' => 'Name',
        'email' => 'Email',
        'phone' => 'Phone',
        'file' => 'File',
        'create_date' => 'Дата создания',
    ];

    protected function tableName(){
        return 'User';
    }

    public static $statuses = [
        'Новый',
        'Зарегистрироване',
        'Заблокирован',
    ];

    /**
     * @return mixed
     */
    public function statusName(){
        return self::$statuses[$this->show];
    }

    /**
     * @param $attribute
     * @return mixed
     */
    public function getLabel($attribute){
        $language = App::getLanguage();
        if($language === 'ru'){
            if(isset(self::$labels_ru[$attribute])){
                return self::$labels_ru[$attribute];
            }
        }
        if($language === 'en'){
            if(isset(self::$labels_en[$attribute])){
                return self::$labels_en[$attribute];
            }
        }

        return $attribute;
    }

    /**
     * @param $attribute
     */
    private function required($attribute){
        if($this->$attribute === ''){
            $message = 'Заполните поле  <b>%s</b>.';
            if(App::getLanguage() === 'en'){
                $message = 'Field <b>%s</b> cannot be blank.';
            }
            $this->addError(sprintf($message, $this->getLabel($attribute)));
        }
    }

    /**
     * @param $attribute
     */
    private function emailFormat($attribute){
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL) !== FALSE){
            $message = '<b>%s</b> не является правильным E-Mail адресом.';
            if(App::getLanguage() === 'en'){
                $message = '<b>%s</b> is not a valid email address.';
            }
            $this->addError(sprintf($message, $this->getLabel($attribute)));
        }
    }

    /**
     * @param $attribute
     * @param $length
     */
    private function maxLengthValidator($attribute, $length){
        if(strlen($this->$attribute) > $length){
            $message = 'Поле <b>%s</b> слишком длинное (максимум %d символов).';
            if(App::getLanguage() === 'en'){
                $message = 'Field <b>%s</b> is too long (maximum is %d characters).';
            }
            $this->addError(sprintf($message, $this->getLabel($attribute), $length));
        }
    }

    /**
     * @param $attribute
     * @param $length
     */
    private function minLengthValidator($attribute, $length){
        if(strlen($this->$attribute) > $length){
            $message = 'Поле <b>%s</b> слишком короткое (минимум %d символов).';
            if(App::getLanguage() === 'en'){
                $message = 'Field <b>%s</b> is too short (minimum is %d characters).';
            }
            $this->addError(sprintf($message, $this->getLabel($attribute), $length));
        }
    }

    /**
     * @param $attribute
     */
    private function unique($attribute){
        $this->$attribute = strtolower($this->$attribute);
        $user = User::findOneByAttribute(__CLASS__, $attribute, $this->$attribute);
        if($user !== null){
            $message = 'Поле <b>%s</b>  - %s уже занят.';
            if(App::getLanguage() === 'en'){
                $message = 'Field <b>%s</b> %s has already been taken.';
            }
            $this->addError(sprintf($message, $this->getLabel($attribute), $this->$attribute));
        }
    }

    /**
     * @param $attribute
     * @param $regexp
     * @param $format
     */
    private function match($attribute, $regexp, $format){
        $matches = [];
        preg_match($regexp, $this->$attribute, $matches);
        if(count($matches) == 0){
            $message = 'Неверный формат поля <b>%s</b>  - %s. Пример %s';
            if(App::getLanguage() === 'en'){
                $message = 'Field <b>%s</b> %s is not a valid format. Good %s';
            }
            $this->addError(sprintf($message, $this->getLabel($attribute), $this->$attribute, $format));
        }
    }

    /**
     * @return bool
     */
    public function validate(){
        $this->required('email');
        $this->required('name');
        $this->required('phone');
        $this->emailFormat('email');
        $this->maxLengthValidator('email', 50);
        $this->maxLengthValidator('name', 50);
        $this->maxLengthValidator('phone', 11);
        $this->minLengthValidator('phone', 11);
        $this->unique('phone');
        $this->unique('email');
        $this->match('phone', '/^[78]\d{10}$/', '79871234567');


        if(isset($_FILES['User'])){
            $uFile = $_FILES['User'];
            if(strlen($uFile['tmp_name']['file']) > 0){
                $path_parts = pathinfo($uFile['name']['file']);
                if(!isset($path_parts['extension'])){
                    $this->addError('Неизвестное расшиерние файла');
                } else{
                    $ext = mb_strtolower($path_parts['extension']);
                    if(!in_array($ext, ['jpg', 'gif', 'png'])){
                        $error = sprintf('Неверный  формат файла - "%s". Доступные форматы JPG, GIF, PNG', $ext);
                        $this->addError($error);
                    }
                }
            }
        }

        return !$this->hasErrors();
    }


    /**
     * @return bool
     */
    public function uploadFile(){
        $uploadDir = __DIR__.'/../../files/';
        $uFile = $_FILES['User'];

        if($uFile['error']['file'] == 4){
            return true;
        }

        $path_info = pathinfo($uFile['name']['file']);
        $ext = strtolower($path_info['extension']);

        $name = sprintf('%d.%s', $this->id, $ext);
        $newFile = $uploadDir.$name;

        $this->file_name = $name;

        return move_uploaded_file($uFile['tmp_name']['file'], $newFile);
    }
}