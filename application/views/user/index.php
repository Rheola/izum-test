<?php
/**
 *
 * @var ReviewController $this
 * @var User[] $reviews
 * @var User $model
 */


$language = App::getLanguage();
$formName = 'Регистрация';
if($language == 'en'){
    $formName = 'Registration';
}

?>

<h4 class="text-primary"><?= $formName; ?></h4>


<form class="form-horizontal jumbotron" enctype="multipart/form-data" action="/user/index" method="post">

    <?
    $attribute = 'name';
    ?>
    <div class="form-group">
        <label for="name" class="col-sm-2 control-label"><?= $model->getLabel($attribute); ?></label>
        <div class="col-sm-6">
            <input type="text" class="form-control" id="<?= $attribute; ?>" name='User[<?= $attribute ?>]'
                   placeholder="Имя" value="<?= $model->$attribute; ?>">
        </div>
    </div>

    <?
    $attribute = 'email';
    ?>
    <div class="form-group">
        <label for="email" class="col-sm-2 control-label"><?= $model->getLabel($attribute); ?></label>
        <div class="col-sm-6">
            <input type="email" class="form-control" id="<?= $attribute; ?>" name='User[<?= $attribute; ?>]'
                   placeholder="Email" value="<?= $model->$attribute; ?>">
        </div>
    </div>

    <?
    $attribute = 'phone';
    ?>
    <div class="form-group">
        <label for="phone" class="col-sm-2 control-label"><?= $model->getLabel($attribute); ?></label>
        <div class="col-sm-6">
            <input type="tel" class="form-control" id="<?=$attribute;?>" name='User[<?= $attribute; ?>]' placeholder="Телефон"
                   value="<?= $model->$attribute; ?>">
        </div>
    </div>


    <div class="form-group">
        <label for="file" class="col-sm-2 control-label"><?= $model->getLabel('file'); ?></label>
        <div class="col-sm-6">
            <input type="file" id="file" name='User[file]'>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-6 col-sm-push-2">
            <?
            if($model->hasErrors()){
                ?>
                <div class='alert alert-danger'>
                    <ul>
                        <? echo $model->getErrors(); ?>
                    </ul>
                </div>
                <?
            }
            ?>
        </div>
    </div>


    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
        </div>
    </div>

    <div id="result">
    </div>
</form>


<script src="/js/preview.js"></script>
