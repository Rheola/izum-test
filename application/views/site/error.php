<?php
/**
 * @var UserController $this
 * @var SiteError $error
 */
?>

<div class="site-index">

    <div class="jumbotron">
        <h1>Ошибка <?= $error->code; ?></h1>
        <p class="lead"><?= $error->message; ?></p>
    </div>

</div>
