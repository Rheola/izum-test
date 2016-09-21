<?php

class SiteController extends Controller{

    public function actionError(SiteError $error){
        $this->render('error', ['error' => $error]);
    }

    public function actionLanguage(){
        $val = 'ru';
        if(App::getLanguage() === 'ru'){
            $val = 'en';
        }
        $site = $_SERVER['HTTP_HOST'];
        setcookie('language', $val, time() + App::SecondInDay, '/', $site);
        header('Location: /', true);
        exit;
    }

}