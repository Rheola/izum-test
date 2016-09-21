<?php

/**
 * Class Controller
 */
class Controller{

    public $model;
    public $view;
    public $layout = 'main';
    public $pageTitle = 'Тестовое задание';
    public $menu = [];

    private $_id;

    /**
     * Controller constructor.
     */
    public function __construct(){
        $name = get_class($this);
        $this->_id = strtolower(substr($name, 0, -strlen('Controller')));
    }

    /**
     *
     */
    public function actionIndex(){
        $this->render($this->_id.'/index');
    }

    /**
     * @param $view
     * @param null $data
     */
    public function render($view, $data = null){
        $this->generate($this->_id.'/'.$view, $data);
    }

    /**
     * @param $template
     * @param null $data
     */
    private function generate($template, $data = null){

        if(is_array($data)){
            extract($data, EXTR_SKIP);
        }

        include 'application/views/'.$this->layout.'.php';
        exit;
    }

    /**
     * @return string
     */
    public function getId(){
        return $this->_id;
    }
}