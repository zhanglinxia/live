<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LiveOuts */

$this->title = Yii::t('app', '发布内容');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Live Outs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<form class="form-horizontal" action="index.php?r=live-out/create" method="post" >
    <input type="hidden" id="_csrf" name="_csrf" value="<? \Yii::$app->request->csrfToken ?>"/>
    <div class="form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">直播名称</label>
        <div class="col-sm-10">
            <span class="form-control">马刺vs火箭</span>
        </div>
    </div>
    <div class="form-group">
        <label for="inputPassword3" class="col-sm-2 control-label">内容</label>
        <div class="col-sm-10">
            <textarea class="form-control" rows="3" name="content"></textarea>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default">提交</button>
        </div>
    </div>
</form>

