<?php

namespace app\controllers;

use Yii;
use app\models\LiveOuts;
use app\searches\LiveOutsSearch;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LiveOutController implements the CRUD actions for LiveOuts model.
 */
class LiveOutController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all LiveOuts models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LiveOutsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single LiveOuts model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new LiveOuts model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new LiveOuts();
        if (strtolower(\Yii::$app->request->method) == 'post') {
            if(empty($_POST) || empty($_POST['content'])){
                error_log("内容不能为空");
                return $this->render('create');
            }
            $model = new LiveOuts();
            $model->game_id = 1;
            $model->team_id = 1;
            $model->type = 1;
            $model->content = $_POST['content'];
            if(!$model->save()){
                error_log(print_r($model->errors, true));
            }
            $data = [
                'message'=>$model->content
            ];
            if($model->save()){
                $http_server = $_POST['http_server'];
                foreach ($http_server->connections as $fd) {
                    if ($http_server->isEstablished($fd)) {
                        $http_server->push($fd, json_encode($data));
                    }
                }
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        return $this->render('create');
    }

    /**
     * Updates an existing LiveOuts model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing LiveOuts model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the LiveOuts model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return LiveOuts the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = LiveOuts::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function actionChart()
    {
        return $this->render('');
    }
}
