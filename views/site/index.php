<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\City $detectedCity */
/** @var string $detectedCityName */
/** @var app\models\City[] $cities */

$this->title = 'Система отзывов о городах';
?>
<div class="site-index">
    <div class="jumbotron">
        <h1>Добро пожаловать!</h1>
        <p class="lead">Система отзывов о городах России</p>
    </div>

    <div class="body-content">
        <?php if ($detectedCityName && $detectedCity && !Yii::$app->session->get('city_detection_refused')): ?>
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">Определен ваш город</h3>
                        </div>
                        <div class="panel-body text-center">
                            <h4>"<?= Html::encode($detectedCityName) ?>" - это ваш город?</h4>
                            <div class="btn-group" style="margin-top: 20px;">
                                <?= Html::a('Да', ['select-city', 'id' => $detectedCity->id], [
                                    'class' => 'btn btn-success btn-lg'
                                ]) ?>
                                <?= Html::a('Нет', ['select-city', 'confirm' => 'no'], [
                                    'class' => 'btn btn-default btn-lg'
                                ]) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Выберите город для просмотра отзывов</h3>
                    </div>
                    <div class="panel-body">
                        <?php if (empty($cities)): ?>
                            <p class="text-muted">Пока нет городов с отзывами.</p>
                        <?php else: ?>
                            <div class="list-group">
                                <?php foreach ($cities as $city): ?>
                                    <a href="<?= Url::to(['select-city', 'id' => $city->id]) ?>"
                                        class="list-group-item">
                                        <h4 class="list-group-item-heading"><?= Html::encode($city->name) ?></h4>
                                        <p class="list-group-item-text">
                                            Отзывов: <?= count($city->reviews) ?>
                                        </p>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>