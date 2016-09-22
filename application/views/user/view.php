<?php
/**
 *
 * @var UserController $this
 * @var \User $model
 */

?>

<div class="panel panel-info">
    <!-- Default panel contents -->
    <div class="panel-heading">Пользователь <?= $model->id; ?></div>


    <!-- Table -->
    <table class="table">
        <tbody>
        <tr>
            <td><?= $model->getLabel('name') ?></td>
            <td><?= $model->name; ?></td>
        </tr>
        <tr>
            <td><?= $model->getLabel('email') ?></td>
            <td><?= $model->email; ?></td>
        </tr>
        <tr>
            <td><?= $model->getLabel('phone') ?></td>
            <td><?= $model->phone; ?></td>
        </tr>
        <tr>
            <td><?= $model->getLabel('creation_date') ?></td>
            <td><?= $model->creation_date; ?></td>
        </tr>
        <?
        if($model->file_name !== null){
            ?>
            <tr>
                <td></td>
                <td>
                    <img src="/files/<?= $model->file_name; ?>" alt="">
                </td>
            </tr>
            <?
        }
        ?>
        </tbody>
    </table>
</div>
