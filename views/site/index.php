<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'My Blog';
?>
<div class="site-index">
    <div class="jumbotron">
        <h1>Welcome to My Blog!</h1>
        <p class="lead">This is a simple blog built with Yii2 and SQLite.</p>
    </div>

    <div class="body-content">
        <h2>Latest Posts</h2>
        
        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => '../post/_post',
            'layout' => "{items}\n{pager}",
            'options' => ['class' => 'post-list'],
            'itemOptions' => ['class' => 'post-item'],
        ]) ?>
    </div>
</div>