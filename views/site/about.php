<?php

use yii\helpers\Html;

/** @var yii\web\View $this */

$this->title = 'О сайте';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        Это страница "О сайте". Вы можете изменить содержимое этого файла, чтобы настроить его:
    </p>

    <code><?= __FILE__ ?></code>
</div>