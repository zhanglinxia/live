<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\searches\LiveOutsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Live Outs');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="live-outs-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', '发布内容'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'game_id',
            'team_id',
            'content',
            'image',
            //'type',
            //'status',
            //'create_time:datetime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
<script>
    var ws = new WebSocket('ws://127.0.0.1:8888');
    ws.onopen = function () {
        console.log("连接")
        ws.send('from client: hello');
    };

    ws.onmessage = function (e) {
        console.log('from server: ' + e.data);
    };
    ws.onerror = function (evt, e) {
        console.log('Error occured: ' + evt.data);
    };
</script>