<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\searches\LiveChartSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Live Charts');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="live-chart-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', '发布聊天'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'game_id',
            'user_id',
            'content',
            'status',
            //'create_time:datetime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
<script>
    var ws = new WebSocket('ws://127.0.0.1:6988');
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