<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Мой Блог';
?>
<div class="site-index">
    <div class="jumbotron">
        <h1>Добро пожаловать в мой блог!</h1>
        <p class="lead">Это простой блог, созданный на Yii2 и SQLite.</p>
    </div>

    <div class="body-content">
        <h2>Последние записи</h2>

        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => '../post/_post',
            'layout' => "{items}\n{pager}",
            'options' => ['class' => 'post-list'],
            'itemOptions' => ['class' => 'post-item'],
        ]) ?>
    </div>
</div>