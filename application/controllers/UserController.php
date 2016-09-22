<?php

class UserController extends Controller{
    public function actionIndex(){
        $model = new User();
        if(isset($_POST['User'])){
            $post = $_POST['User'];
            $model->email = $post['email'];
            $model->name = $post['name'];
            $model->phone = $post['phone'];
            $model->email = trim(strtolower($model->email));
            $model->creation_date = date('Y-m-d H:i:s', time());

            if($model->validate()){
                if(!$model->save()){
                    $model->addError('Ошибка записи в базу данных');
                } else{
                    if(isset($_FILES['User'])){
                        if(!$model->uploadFile()){
                            throw new ErrorException('Ошибка загрузки файла');
                        }
                        $model->save();
                    }
                    header('Location: '.'view?id='.$model->id, true);
                }
            }
        }
        $this->render('index', ['model' => $model]);
    }

    public function actionView(){
        if(!isset($_GET['id'])){
            throw new ErrorException('Ошибочный запрос', 400);
        }
        $id = (int)$_GET['id'];
        /** @var User $user */
        $user = User::findByPk($id);
        if($user === null){
            throw new ErrorException('Запись не найдена', 404);
        }
        $this->render('view', ['model' => $user]);
    }
}