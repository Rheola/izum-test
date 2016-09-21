<?php

class UserController extends Controller{

    public function actionIndex(){
        $model = new User();
        if(isset($_POST['User'])){
            $post = $_POST['User'];
            $model->email = $post['email'];
            $model->name = $post['name'];
            $model->phone = $post['phone'];
            if($model->validate()){
                if(!$model->save()){
                    $model->addError('Ошибка записи в базу данных');
                } else{
                    if(isset($_FILES['User'])){
                        if(!$model->uploadFile()){
                            throw  new ErrorException('Ошибка загрузки файла');
                        }
                        $model->save();
                    }
                    header('Location: '.'index', true, 302);
                }
            }
        }
        $this->render('index', ['model' => $model]);
    }
}