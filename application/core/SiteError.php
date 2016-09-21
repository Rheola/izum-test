<?php


class SiteError{

    public $code;
    public $message;

    /**
     * SiteError constructor.
     * @param $code
     */
    public function __construct($code){
        $this->code = $code;
    }

}