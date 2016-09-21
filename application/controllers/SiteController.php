<?php

class SiteController extends Controller{
    public function actionError(SiteError $error){
        $this->render('error', ['error' => $error]);
    }
}